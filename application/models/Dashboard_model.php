<?php

/**
 * Class Dashboard_Model
 * @property Mydatafetch_library $mydatafetch_library
 * @property Generalfunction_library $generalfunction_library
 */
class Dashboard_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

        $this->load->library('mydatafetch_library');
	}

    public function getAvgCheckins($dateStart, $dateEnd, $locations)
    {
        $query = "SELECT DISTINCT (SELECT count(DISTINCT mugId, location) "
                ."FROM  mugcheckinmaster "
                ."WHERE checkinDateTime BETWEEN '$dateStart' AND '$dateEnd' AND location != 0) as overall";

            if(isset($locations))
            {
                $length = count($locations)-1;
                $counter = 0;
                foreach($locations as $key => $row)
                {
                    if(isset($row['id']))
                    {
                        $counter++;
                        if($counter <= $length)
                        {
                            $query .= ",";
                        }
                        $query .= "(SELECT count(DISTINCT mugId, location)"
                            ." FROM  mugcheckinmaster "
                            ."WHERE checkinDateTime BETWEEN '$dateStart' AND '$dateEnd' AND location =". $row['id'].")"
                            ." as '".$row['locUniqueLink']."'";

                    }
                }
            }
        $query .= " FROM mugcheckinmaster";


        $result = $this->db->query($query)->row_array();

        $data['checkInList'] = $result;
        if(myIsArray($result))
        {
            $data['status'] = true;
        }
        else
        {
            $data['status'] = false;
        }

        return $data;
    }

    public function getRegulars($dateStart, $dateEnd, $locations)
    {
        $query = "SELECT DISTINCT (SELECT count(*) FROM (SELECT m.mugId,homeBase FROM  mugmaster m
                LEFT JOIN mugcheckinmaster mc ON m.mugId = mc.mugId
                Where date(mc.checkinDateTime) BETWEEN '$dateStart' AND '$dateEnd'
				GROUP BY mc.mugId HAVING count(*) > 2) as tbl) as overall";

        if(isset($locations))
        {
            $length = count($locations)-1;
            $counter = 0;
            foreach($locations as $key => $row)
            {
                if(isset($row['id']))
                {
                    $counter++;
                    if($counter <= $length)
                    {
                        $query .= ",";
                    }
                    $query .= "(SELECT count(*) FROM (SELECT m.mugId,homeBase FROM  mugmaster m
                                LEFT JOIN mugcheckinmaster mc ON m.mugId = mc.mugId
                                Where homeBase = ".$row['id']." AND date(mc.checkinDateTime) BETWEEN '$dateStart' AND '$dateEnd'
                                GROUP BY mc.mugId HAVING count(*) > 2) as tbl) as '".$row['locUniqueLink']."'";
                }
            }
        }
        $query .= " FROM mugcheckinmaster";

        $result = $this->db->query($query)->row_array();

        $data['regularCheckins'] = $result;
        if(myIsArray($result))
        {
            $data['status'] = true;
        }
        else
        {
            $data['status'] = false;
        }

        return $data;
    }

    public function getIrregulars($dateStart, $dateEnd, $locations)
    {
        $query = "SELECT DISTINCT (SELECT count(*) FROM (SELECT m.mugId,homeBase FROM  mugmaster m
                LEFT JOIN mugcheckinmaster mc ON m.mugId = mc.mugId
                Where date(mc.checkinDateTime) BETWEEN '$dateStart' AND '$dateEnd'
				GROUP BY mc.mugId HAVING count(*) <= 1) as tbl) as overall";

        if(isset($locations))
        {
            $length = count($locations)-1;
            $counter = 0;
            foreach($locations as $key => $row)
            {
                if(isset($row['id']))
                {
                    $counter++;
                    if($counter <= $length)
                    {
                        $query .= ",";
                    }
                    $query .= "(SELECT count(*) FROM (SELECT m.mugId,homeBase FROM  mugmaster m
                                LEFT JOIN mugcheckinmaster mc ON m.mugId = mc.mugId
                                Where homeBase = ".$row['id']." AND date(mc.checkinDateTime) BETWEEN '$dateStart' AND '$dateEnd'
                                GROUP BY mc.mugId HAVING count(*) <= 1) as tbl) as '".$row['locUniqueLink']."'";
                }
            }
        }

        $query .= " FROM mugcheckinmaster";

        $result = $this->db->query($query)->row_array();

        $data['irregularCheckins'] = $result;
        if(myIsArray($result))
        {
            $data['status'] = true;
        }
        else
        {
            $data['status'] = false;
        }

        return $data;
    }

    public function getLapsers($dateStart, $dateEnd, $locations)
    {
        $query = "SELECT DISTINCT (SELECT count(*) FROM mugmaster 
                 WHERE membershipEnd BETWEEN '$dateStart' AND '$dateEnd' AND membershipEnd != '0000-00-00') as overall";

        if(isset($locations))
        {
            $length = count($locations)-1;
            $counter = 0;
            foreach($locations as $key => $row)
            {
                if(isset($row['id']))
                {
                    $counter++;
                    if($counter <= $length)
                    {
                        $query .= ",";
                    }
                    $query .= "(SELECT count(*) FROM mugmaster 
                             WHERE homeBase = ".$row['id']." AND membershipEnd BETWEEN '$dateStart' AND '$dateEnd'
                              AND membershipEnd != '0000-00-00') as '".$row['locUniqueLink']."'";
                }
            }
        }
        $query .= " FROM mugmaster";

        $result = $this->db->query($query)->row_array();

        $data['lapsers'] = $result;
        if(myIsArray($result))
        {
            $data['status'] = true;
        }
        else
        {
            $data['status'] = false;
        }

        return $data;
    }

    public function saveDashboardRecord($details)
    {
        $details['insertedDate'] = date('Y-m-d');

        $this->db->insert('dashboardmaster', $details);
        return true;
    }
    public function getDashboardRecord()
    {
        $query = "SELECT * "
                ." FROM dashboardmaster WHERE insertedDate = CURRENT_DATE()";

        $result = $this->db->query($query)->result_array();
        $data['todayStat'] = $result;
        if(myIsArray($result))
        {
            $data['status'] = true;
        }
        else
        {
            $data['status'] = false;
        }

        return $data;
    }
    public function getAllDashboardRecord()
    {
        $query = "SELECT * "
            ." FROM dashboardmaster ORDER BY insertedDate DESC LIMIT 30";

        $result = $this->db->query($query)->result_array();
        $data['dashboardPoints'] = array_reverse($result);
        if(myIsArray($result))
        {
            $data['status'] = true;
        }
        else
        {
            $data['status'] = false;
        }

        return $data;
    }

    public function saveInstaMojoRecord($details)
    {
        $this->db->insert('instamojomaster', $details);
        return true;
    }
    public function updateInstaMojoRecord($id,$details)
    {
        $this->db->where('id', $id);
        $this->db->update('instamojomaster', $details);
        return true;
    }

    public function getAllInstamojoRecord()
    {
        $query = "SELECT * "
            ." FROM instamojomaster"
            ." WHERE status = 1 AND isApproved = 0";

        $result = $this->db->query($query)->result_array();
        $data['instaRecords'] = $result;
        if(myIsArray($result))
        {
            $data['status'] = true;
        }
        else
        {
            $data['status'] = false;
        }

        return $data;
    }
    public function getAllFeedbacks($locations)
    {
        $query = "SELECT DISTINCT (SELECT COUNT(overallRating) FROM usersfeedbackmaster 
                 WHERE feedbackLoc != 0) as 'total_overall',
                 (SELECT COUNT(overallRating) FROM usersfeedbackmaster 
                 WHERE feedbackLoc = 1) as 'total_bandra',
                 (SELECT COUNT(overallRating) FROM usersfeedbackmaster 
                 WHERE feedbackLoc = 2) as 'total_andheri',
                 (SELECT COUNT(overallRating) FROM usersfeedbackmaster 
                 WHERE feedbackLoc = 3) as 'total_kemps-corner',
                 (SELECT COUNT(overallRating) FROM usersfeedbackmaster 
                 WHERE feedbackLoc != 0 AND overallRating >= 9) as 'promo_overall',
                 (SELECT COUNT(overallRating) FROM usersfeedbackmaster 
                 WHERE feedbackLoc != 0 AND overallRating < 7) as 'de_overall'";
        if(isset($locations))
        {
            $length = count($locations)-1;
            $counter = 0;
            foreach($locations as $key => $row)
            {
                if(isset($row['id']))
                {
                    $counter++;
                    if($counter <= $length)
                    {
                        $query .= ",";
                    }
                    $query .= "(SELECT COUNT(overallRating) FROM usersfeedbackmaster 
                              WHERE feedbackLoc = ".$row['id']." AND overallRating >= 9) as 'promo_".$row['locUniqueLink']."',";
                    $query .= "(SELECT COUNT(overallRating) FROM usersfeedbackmaster 
                              WHERE feedbackLoc = ".$row['id']." AND overallRating < 7) as 'de_".$row['locUniqueLink']."'";
                }
            }
        }

        $result = $this->db->query($query)->result_array();
        $data['feedbacks'] = $result;
        if(myIsArray($result))
        {
            $data['status'] = true;
        }
        else
        {
            $data['status'] = false;
        }

        return $data;
    }
    public function getWeeklyFeedBack()
    {
        $query = "SELECT *
                  FROM feedbackweekscore";

        $result = $this->db->query($query)->result_array();
        return $result;
    }

    public function insertFeedBack($details)
    {
        $this->db->insert_batch('usersfeedbackmaster', $details);
        return true;
    }

    public function saveFnbRecord($details)
    {
        $details['updateDateTime'] = date('Y-m-d H:i:s');
        $details['insertedDateTime'] = date('Y-m-d H:i:s');
        $details['ifActive'] = '1';

        $this->db->insert('fnbmaster', $details);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function saveFnbAttachment($details)
    {
        $details['insertedDateTime'] = date('Y-m-d H:i:s');

        $this->db->insert('fnbattachment', $details);
        return true;
    }

    public function getAllFnB()
    {
        $query = "SELECT fnbId,itemType,itemName,itemHeadline,itemDescription,priceFull,priceHalf,fnbShareLink, shortUrl,ifActive
                  FROM fnbmaster ORDER BY fnbId DESC";

        $result = $this->db->query($query)->result_array();
        $data['fnbItems'] = $result;
        if(myIsArray($result))
        {
            $data['status'] = true;
        }
        else
        {
            $data['status'] = false;
        }

        return $data;
    }
    public function getAllActiveFnB()
    {
        $query = "SELECT fm.fnbId,fm.itemType,fm.taggedLoc,fm.itemName,fm.itemHeadline,fm.itemDescription,fm.priceFull,fm.priceHalf,
                  fm.ifActive,fm.sortOrder, fm.fnbShareLink,fm.shortUrl,fa.id,fa.filename
                  FROM fnbmaster fm
                  LEFT JOIN fnbattachment fa ON fa.fnbId = fm.fnbId
                  WHERE fm.ifActive = 1 
                  GROUP BY fm.fnbId
                  ORDER BY fm.itemType DESC, fm.sortOrder ASC";

        $result = $this->db->query($query)->result_array();
        return $result;
    }
    public function getBeersCount()
    {
        $query = "SELECT count(*) as 'beers' FROM fnbmaster WHERE itemType = 2";

        $result = $this->db->query($query)->row_array();
        return $result;
    }
    public function getFnBById($fnbId)
    {
        $query = "SELECT fnbId,itemType,itemName,itemHeadline,itemDescription,priceFull,
                  priceHalf,fnbShareLink, sortOrder, shortUrl, ifActive
                  FROM fnbmaster WHERE ifActive = 1 AND fnbId = ".$fnbId;

        $result = $this->db->query($query)->result_array();

        return $result;
    }

    public function getTagLocsFnb($fnbId)
    {
        $query = "SELECT fm.taggedLoc,lm.locName, lm.id
                  FROM fnbmaster fm
                  LEFT JOIN locationmaster lm ON FIND_IN_SET(lm.id,fm.taggedLoc)
                  WHERE fm.taggedLoc IS NOT NULL AND fm.fnbId = ".$fnbId;

        $result = $this->db->query($query)->result_array();

        return $result;
    }
    public function updateBeerLocTag($details, $fnbId)
    {
        $this->db->where('fnbId',$fnbId);
        $this->db->update('fnbmaster', $details);
        return true;
    }

    public function getFnbAttById($id)
    {
        $query = "SELECT id,fnbId,filename,attachmentType
                  FROM fnbattachment WHERE fnbId = ".$id;

        $result = $this->db->query($query)->result_array();

        return $result;
    }

    //Event Related Functions

    public function saveEventRecord($details)
    {
        $details['createdDateTime'] = date('Y-m-d H:i:s');
        $details['ifActive'] = '0';
        $details['ifApproved'] = '0';

        $this->db->insert('eventmaster', $details);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function updateEventRecord($details, $eventId)
    {
        $this->db->where('eventId',$eventId);
        $this->db->update('eventmaster', $details);
        return true;
    }
    public function saveEventAttachment($details)
    {
        $details['insertedDateTime'] = date('Y-m-d H:i:s');

        $this->db->insert('eventattachment', $details);
        return true;
    }
    public function updateEventAttachment($details, $eventId)
    {
        $this->db->where('eventId',$eventId);
        $this->db->update('eventattachment', $details);
        return true;
    }
    public function getAllEvents()
    {
        $query = "SELECT *
                  FROM eventmaster ORDER BY eventId DESC";

        $result = $this->db->query($query)->result_array();

        return $result;
    }
    public function getAllCompletedEvents()
    {
        $query = "SELECT *
                  FROM eventcompletedmaster ORDER BY eventId DESC";

        $result = $this->db->query($query)->result_array();

        return $result;
    }

    public function getEventsByUserId($userId)
    {
        $query = "SELECT em.*, ea.filename, l.locName
                  FROM `eventmaster` em
                  LEFT JOIN eventattachment ea ON ea.eventId = em.eventId
                  LEFT JOIN locationmaster l ON eventPlace = l.id
                  WHERE userId = ".$userId." GROUP BY em.eventId";

        $result = $this->db->query($query)->result_array();

        return $result;
    }
    public function getEventsRegisteredByUser($userId)
    {
        $query = "SELECT erm.bookerId,erm.bookerUserId,erm.eventId,erm.quantity,erm.createdDT,erm.isUserCancel, em.*, ea.filename, l.locName
                  FROM eventregistermaster erm
                  LEFT JOIN eventmaster em ON em.eventId = erm.eventId
                  LEFT JOIN eventattachment ea ON ea.eventId = erm.eventId
                  LEFT JOIN locationmaster l ON l.id = em.eventPlace
                  WHERE erm.eventDone != 1 AND bookerUserId = ".$userId;

        $result = $this->db->query($query)->result_array();

        return $result;
    }
    public function getEventById($eventId)
    {
        $query = "SELECT *
                  FROM eventmaster WHERE eventId = ".$eventId;

        $result = $this->db->query($query)->result_array();

        return $result;
    }
    public function getWeeklyEvents()
    {
        $this->db->simple_query('SET SESSION group_concat_max_len=1000000');
        $query = "SELECT GROUP_CONCAT(eventName SEPARATOR ';') as eventNames,
                  GROUP_CONCAT(eventPlace SEPARATOR ',') as eventPlaces,
                  GROUP_CONCAT(endTime SEPARATOR ',') as eventEndTimes,
                  GROUP_CONCAT(eventSlug SEPARATOR ',') as eventSlugs,
                  eventDate,GROUP_CONCAT(eventId SEPARATOR ',') as eventIds FROM eventmaster
                  WHERE eventDate BETWEEN CURRENT_DATE() AND (CURRENT_DATE() + INTERVAL 1 WEEK) 
                  AND ifActive  = ".ACTIVE." AND ifApproved = ".EVENT_APPROVED." GROUP BY eventDate 
                  ORDER BY eventDate ASC";

        $result = $this->db->query($query)->result_array();

        return $result;
    }
    public function getAllApprovedEvents()
    {
        $query = "SELECT em.eventId, em.eventName, em.eventDescription, em.eventType, em.eventDate, em.startTime, em.endTime, em.costType, 
                  em.eventPrice, em.priceFreeStuff, em.eventPlace, em.eventCapacity, em.ifMicRequired, em.ifProjectorRequired, 
                  em.creatorName, em.creatorPhone, em.creatorEmail, em.aboutCreator, em.userId, em.eventShareLink, em.shortUrl, em.eventSlug,
                  em.eventPaymentLink,em.isEventEverywhere, em.showEventDate,em.showEventTime,em.showEventPrice,
                   em.isRegFull, em.ifActive, em.ifApproved, em.ifAutoCreated,em.isSpecialEvent, ea.filename, l.locName, l.mapLink, l.locAddress
                  FROM `eventmaster` em
                  LEFT JOIN eventattachment ea ON ea.eventId = em.eventId
                  LEFT JOIN locationmaster l ON eventPlace = l.id
                  WHERE em.ifActive = ".ACTIVE." AND em.ifApproved = ".EVENT_APPROVED." AND eventDate >= CURRENT_DATE() GROUP BY em.eventId";

        /*$query = "SELECT * FROM eventmaster where ifActive = ".ACTIVE."
         AND eventDate >= CURRENT_DATE()";*/
        $result = $this->db->query($query)->result_array();

        return $result;
    }
    public function getDashboardEventDetails($eventSlug)
    {
        $query = "SELECT em.eventId, em.eventName,em.eventPlace, em.costType,em.eventPrice,em.eventShareLink,em.shortUrl, em.eventSlug,
                  em.ifActive, em.ifApproved, em.isEventCancel, SUM(erm.quantity) as 'totalQuant'
                  FROM eventmaster em
                  LEFT JOIN eventregistermaster erm ON erm.eventId = em.eventId
                  WHERE erm.isUserCancel != 1 AND em.eventId = 
                  (SELECT eventId FROM eventslugmaster WHERE eventSlug LIKE '".$eventSlug."')";

        $result = $this->db->query($query)->result_array();

        return $result;
    }
    public function getCommDetails($locId)
    {
        $query = "SELECT * "
            ."FROM doolally_usersmaster "
            ."WHERE FIND_IN_SET('".$locId."', assignedLoc) ORDER BY userId ASC";

        $result = $this->db->query($query)->row_array();
        return $result;
    }
    public function fetchEhSignupList($eventSlug)
    {
        $query = "SELECT um.firstName, um.lastName, um.emailId, erm.quantity, erm.createdDT, erm.paymentId
                  FROM eventregistermaster erm
                  LEFT JOIN doolally_usersmaster um ON um.userId = erm.bookerUserId
                  WHERE erm.isUserCancel != 1 AND erm.isDirectlyRegistered = 0 AND erm.eventId = 
                  (SELECT eventId FROM eventslugmaster WHERE eventSlug LIKE '".$eventSlug."') 
                   ORDER BY erm.createdDT DESC";

        $result = $this->db->query($query)->result_array();

        return $result;
    }
    public function fetchDoolallySignupList($eventSlug)
    {
        $query = "SELECT um.firstName, um.lastName, um.emailId, erm.quantity, erm.createdDT, erm.paymentId
                  FROM eventregistermaster erm
                  LEFT JOIN doolally_usersmaster um ON um.userId = erm.bookerUserId
                  WHERE erm.isUserCancel != 1 AND erm.isDirectlyRegistered = 1 AND erm.eventId = 
                  (SELECT eventId FROM eventslugmaster WHERE eventSlug LIKE '".$eventSlug."') 
                   ORDER BY erm.createdDT DESC";

        $result = $this->db->query($query)->result_array();

        return $result;
    }
    public function getDoolallyJoinersInfo($eventId)
    {
        $query = "SELECT um.firstName, um.lastName, um.emailId, erm.quantity, erm.createdDT
                  FROM eventregistermaster erm
                  LEFT JOIN doolally_usersmaster um ON um.userId = erm.bookerUserId
                  WHERE erm.eventId = $eventId AND erm.isDirectlyRegistered = 1 AND erm.isUserCancel != 1 ORDER BY erm.createdDT DESC";

        $result = $this->db->query($query)->result_array();

        return $result;
    }
    public function getEhJoinersInfo($eventId)
    {
        $query = "SELECT um.firstName, um.lastName, um.emailId, erm.quantity, erm.createdDT
                  FROM eventregistermaster erm
                  LEFT JOIN doolally_usersmaster um ON um.userId = erm.bookerUserId
                  WHERE erm.eventId = $eventId AND erm.isDirectlyRegistered = 0 AND erm.isUserCancel != 1 ORDER BY erm.createdDT DESC";

        $result = $this->db->query($query)->result_array();

        return $result;
    }
    public function ApproveEvent($eventId)
    {
        $data['ifActive'] = 1;
        $data['ifApproved'] = 1;

        $this->db->where('eventId', $eventId);
        $this->db->update('eventmaster', $data);
        return true;
    }
    public function DeclineEvent($eventId)
    {
        $data['ifActive'] = 0;
        $data['ifApproved'] = 2;

        $this->db->where('eventId', $eventId);
        $this->db->update('eventmaster', $data);
        return true;
    }
    public function findCompletedEvents()
    {
        $query = "SELECT em.eventId, em.eventName, em.eventDescription, em.eventType, em.eventDate, em.startTime, em.endTime, em.costType, 
                  em.eventPrice, em.priceFreeStuff, em.eventPlace, em.eventCapacity, em.ifMicRequired, em.ifProjectorRequired, 
                  em.creatorName, em.creatorPhone, em.creatorEmail, em.aboutCreator, em.userId, em.eventShareLink, em.shortUrl,
                  em.eventPaymentLink, em.ifActive, em.ifApproved, ea.filename, l.locName
                  FROM `eventcompletedmaster` em
                  LEFT JOIN eventattachment ea ON ea.eventId = em.eventId
                  LEFT JOIN locationmaster l ON eventPlace = l.id
                  GROUP BY em.eventId";

        $result = $this->db->query($query)->result_array();
        return $result;
    }
    public function checkUserBooked($userId, $eventId)
    {
        $query = "SELECT * FROM eventregistermaster
                  WHERE isUserCancel != 1 AND bookerUserId = ".$userId." AND eventId = ".$eventId;
        $result = $this->db->query($query)->result_array();

        if(myIsArray($result))
        {
            $data['status'] = true;
        }
        else
        {
            $data['status'] = false;
        }
        return $data;
    }
    public function checkUserBookedWithMojo($userId, $eventId,$mojoId)
    {
        $query = "SELECT * FROM eventregistermaster
                  WHERE isUserCancel != 1 AND paymentId = '".$mojoId."' AND bookerUserId = ".$userId." AND eventId = ".$eventId;
        $result = $this->db->query($query)->result_array();

        if(myIsArray($result))
        {
            $data['status'] = true;
        }
        else
        {
            $data['status'] = false;
        }
        return $data;
    }
    public function checkUserCreated($userId, $eventId)
    {
        $query = "SELECT * FROM eventmaster
                  WHERE userId = ".$userId." AND eventId = ".$eventId;
        $result = $this->db->query($query)->result_array();

        if(myIsArray($result))
        {
            $data['status'] = true;
        }
        else
        {
            $data['status'] = false;
        }
        return $data;
    }
    public function checkEventSpace($details)
    {
        $data['status'] = false;
        return $data;
        $query = "SELECT * FROM eventmaster
                  WHERE eventPlace = '".$details['eventPlace']."' AND eventDate = '".$details['eventDate']."' AND 
                  ((TIME(startTime) >= TIME('".$details['startTime']."') AND TIME(startTime) < TIME('".$details['endTime']."')) OR 
                   (TIME(endTime) > TIME('".$details['startTime']."') AND TIME(endTime) <= TIME('".$details['endTime']."')) OR
                   (TIME(startTime) > TIME('".$details['startTime']."') AND TIME(startTime) < TIME('".$details['endTime']."')))";

        $result = $this->db->query($query)->result_array();
        if(myIsArray($result))
        {
            $data['status'] = true;
        }
        else
        {
            $data['status'] = false;
        }
        return $data;

    }

    public function isExistingEvent($details)
    {
        $query = "SELECT GROUP_CONCAT(eventName SEPARATOR ';') as eventNames FROM eventmaster
                  WHERE eventPlace = '".$details['eventPlace']."' AND eventDate = '".$details['eventDate']."' AND ifApproved != ".EVENT_DECLINED." AND 
                  (TIME(startTime) < TIME('".$details['endTime']."') AND TIME(endTime) > TIME('".$details['startTime']."'))";

        $result = $this->db->query($query)->result_array();
        $data['eveData'] = $result;
        if(myIsArray($result) && isset($result[0]['eventNames']))
        {
            $data['status'] = true;
        }
        else
        {
            $data['status'] = false;
        }
        return $data;

    }
    public function activateEventRecord($eventId)
    {
        $data['ifActive'] = 1;

        $this->db->where('eventId', $eventId);
        $this->db->update('eventmaster', $data);
        return true;
    }
    public function deActivateEventRecord($eventId)
    {
        $data['ifActive'] = 0;

        $this->db->where('eventId', $eventId);
        $this->db->update('eventmaster', $data);
        return true;
    }
    public function eventDelete($eventId)
    {
        $this->db->where('eventId', $eventId);
        $this->db->delete('eventmaster');
        return true;
    }
    public function eventRegisDelete($eventId)
    {
        $this->db->where('eventId', $eventId);
        $this->db->delete('eventregistermaster');
        return true;
    }
    public function eventCompDelete($eventId)
    {
        $this->db->where('eventId', $eventId);
        $this->db->delete('eventcompletedmaster');
        return true;
    }
    public function eventAttDeleteById($eventId)
    {
        $this->db->where('eventId', $eventId);
        $this->db->delete('eventattachment');
        return true;
    }
    public function eventAttDelete($attId)
    {
        $this->db->where('id', $attId);
        $this->db->delete('eventattachment');
        return true;
    }
    public function fnbAttDelete($attId)
    {
        $this->db->where('id', $attId);
        $this->db->delete('fnbattachment');
        return true;
    }
    public function getEventAttById($id)
    {
        $query = "SELECT id, filename
                  FROM eventattachment WHERE eventId = ".$id;

        $result = $this->db->query($query)->result_array();

        return $result;
    }

    public function getFullEventInfoById($eventId)
    {
        $query = "SELECT em.*, ea.filename, l.locName, l.locAddress, l.mapLink, l.meetupVenueId, um.mobNum
                  FROM `eventmaster` em
                  LEFT JOIN eventattachment ea ON ea.eventId = em.eventId
                  LEFT JOIN locationmaster l ON eventPlace = l.id
                  LEFT JOIN doolally_usersmaster um ON FIND_IN_SET(l.id,um.assignedLoc)
                  WHERE em.eventId = ".$eventId." GROUP BY em.eventId";

        $result = $this->db->query($query)->result_array();

        return $result;
    }
    public function getCompEventInfoById($eventId)
    {
        $query = "SELECT em.*, ea.filename, l.locName, l.mapLink
                  FROM `eventcompletedmaster` em
                  LEFT JOIN eventattachment ea ON ea.eventId = em.eventId
                  LEFT JOIN locationmaster l ON eventPlace = l.id
                  WHERE em.eventId = ".$eventId." GROUP BY em.eventId";

        $result = $this->db->query($query)->result_array();

        return $result;
    }
    public function getFullEventInfoBySlug($eventSlug)
    {
        $query = "SELECT em.*, ea.filename, l.locName, l.mapLink, eh.highId
                  FROM eventmaster em
                  LEFT JOIN eventattachment ea ON ea.eventId = em.eventId
                  LEFT JOIN locationmaster l ON eventPlace = l.id
                  LEFT JOIN eventslugmaster esm ON em.eventId = esm.eventId
                  LEFT JOIN eventshighmaster eh ON em.eventId = eh.eventId
                  WHERE esm.eventSlug LIKE '".$eventSlug."' GROUP BY em.eventId";

        $result = $this->db->query($query)->result_array();

        return $result;
    }

    public function getCompEventInfoBySlug($eventSlug)
    {
        $query = "SELECT em.*, ea.filename, l.locName, l.mapLink, eh.highId
                  FROM eventcompletedmaster em
                  LEFT JOIN eventattachment ea ON ea.eventId = em.eventId
                  LEFT JOIN locationmaster l ON eventPlace = l.id
                  LEFT JOIN eventslugmaster esm ON em.eventId = esm.eventId
                  LEFT JOIN eventshighmaster eh ON em.eventId = eh.eventId
                  WHERE esm.eventSlug LIKE '".$eventSlug."' GROUP BY em.eventId";

        $result = $this->db->query($query)->result_array();

        return $result;
    }
    public function saveEventRegis($details)
    {
        $details['createdDT'] = date('Y-m-d H:i:s');

        $this->db->insert('eventregistermaster', $details);
        return true;
    }

    public function getEventHighRecord($eventId)
    {
        $query = "SELECT highId FROM eventshighmaster WHERE highStatus = 1 AND eventId = ".$eventId;

        $result = $this->db->query($query)->row_array();

        return $result;
    }
    public function getEventInfoByEhId($ehId)
    {
        $query = "SELECT * FROM eventshighmaster WHERE highId = '".$ehId."'";

        $result = $this->db->query($query)->row_array();

        return $result;
    }
    public function getMeetupRecord($eventId)
    {
        $query = "SELECT meetupId FROM meetupmaster WHERE meetupStatus = 1 AND eventId = ".$eventId;

        $result = $this->db->query($query)->row_array();

        return $result;
    }

    //For Fnb
    public function activateFnbRecord($fnbId)
    {
        $data['ifActive'] = 1;

        $this->db->where('fnbId', $fnbId);
        $this->db->update('fnbmaster', $data);
        return true;
    }
    public function DeActivateFnbRecord($fnbId)
    {
        $data['ifActive'] = 0;

        $this->db->where('fnbId', $fnbId);
        $this->db->update('fnbmaster', $data);
        return true;
    }
    public function fnbDelete($fnbId)
    {
        $this->db->where('fnbId', $fnbId);
        $this->db->delete('fnbmaster');
        return true;
    }

    public function updateFnbRecord($details, $fnbId)
    {
        $this->db->where('fnbId',$fnbId);
        $this->db->update('fnbmaster', $details);
        return true;
    }

    public function getTapSongs($tapId)
    {
        $query = 'SELECT * 
                  FROM jukeboxmaster
                  WHERE tapId = '.$tapId;

        $result = $this->db->query($query)->result_array();

        return $result;
    }

    public function cancelUserEventBooking($bId)
    {
        $data['isUserCancel'] = '1';
        $this->db->where('bookerId', $bId);
        $this->db->update('eventregistermaster', $data);
        return true;
    }

    public function getEventCancelInfo($bId)
    {
        $query = 'SELECT erm.paymentId, erm.quantity, erm.isDirectlyRegistered, em.eventId, em.eventPlace, em.eventPrice,
                  em.eventName, em.creatorName, em.creatorEmail, um.firstName, um.lastName,
                  um.emailId, ehm.highId, om.isRedeemed, om.offerType
                  FROM `eventregistermaster` erm
                  LEFT JOIN eventmaster em ON em.eventId = erm.eventId
                  LEFT JOIN doolally_usersmaster um ON um.userId = erm.bookerUserId
                  LEFT JOIN eventshighmaster ehm ON erm.eventId = ehm.eventId
                  LEFT JOIN offersmaster om ON (erm.eventId = om.offerEvent) AND (om.bookerPaymentId = erm.paymentId) 
                  WHERE ehm.highStatus = 1 AND erm.bookerId = '.$bId;

        $result = $this->db->query($query)->row_array();

        return $result;
    }

    public function getEventCouponInfo($eventId, $payId)
    {
        $query = "SELECT isRedeemed, offerType
                  FROM offersmaster  
                  WHERE offerEvent = ".$eventId." AND bookerPaymentId = '".$payId."'";

        $result = $this->db->query($query)->result_array();

        return $result;
    }

    public function getRecentMeta()
    {
        $query = "SELECT *"
            ." FROM custommetatags"
            ." ORDER BY id DESC LIMIT 0,1";

        $result = $this->db->query($query)->row_array();

        return $result;
    }

    public function saveInstamojoMug($details)
    {
        $this->db->insert('instamojomugmaster', $details);
        return true;
    }

    public function getMugInstaByReqId($payReqId)
    {
        $query = "SELECT id, mugId FROM instamojomugmaster WHERE paymentId LIKE '".$payReqId."'";

        $result = $this->db->query($query)->row_array();
        return $result;
    }

    public function updateInstaMug($details,$id)
    {
        $this->db->where('id', $id);
        $this->db->update('instamojomugmaster', $details);
        return true;
    }

    public function saveSwiftMailLog($post)
    {
        $this->db->insert('swiftmailerlogs', $post);
        return true;
    }

    public function saveEventSlug($details)
    {
        $this->db->insert('eventslugmaster', $details);
        return true;
    }

    public function cancelEventOffers($eventId,$paymentId, $offerType)
    {
        $details = array(
            'ifActive' => '0'
        );
        $this->db->where('offerEvent',$eventId);
        $this->db->where('offerType',$offerType);
        $this->db->where('bookerPaymentId',$paymentId);
        $this->db->update('offersmaster', $details);
        return true;
    }
    public function saveErrorLog($details)
    {
        $details['insertedDateTime'] = date('Y-m-d H:i:s');
        $details['fromWhere'] = 'Mobile';
        $this->db->insert('errorlogger', $details);
        return true;
    }
    public function saveAPIErrorLog($details)
    {
        $details['insertedDateTime'] = date('Y-m-d H:i:s');
        $this->db->insert('errorlogger', $details);
        return true;
    }
    public function saveMusicSearch($details)
    {
        $this->db->insert('musicsearchmaster', $details);
        return true;
    }
    public function saveEventChangeRecord($details)
    {
        $this->db->insert('eventchangesmaster', $details);
        return true;
    }
    public function getEditRecord($eventId)
    {
        $query = "SELECT * FROM eventchangesmaster WHERE isPending = 0 AND eventId = ".$eventId." ORDER BY insertedDT DESC";

        $result = $this->db->query($query)->row_array();
        return $result;
    }
    function getShareImg($eventId)
    {
        $query = "SELECT filename FROM eventimgsharemaster WHERE ifUsing = 1 AND eventId = ".$eventId;
        $result = $this->db->query($query)->row_array();
        return $result;
    }
    public function saveUpiDump($details)
    {
        $this->db->insert('upidumpingtable', $details);
        return true;
    }
    function saveEhRefundDetails($details)
    {
        $this->db->insert('ehrefundmaster',$details);
        return true;
    }
}
