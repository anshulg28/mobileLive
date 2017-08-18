<?php

/**
 * Class Cron_Model
 * @property Mydatafetch_library $mydatafetch_library
 * @property Generalfunction_library $generalfunction_library
 */
class Cron_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

        $this->load->library('mydatafetch_library');
	}

    public function checkFeedByType($feedType)
    {
        $query = "SELECT * "
            ."FROM socialfeedmaster "
            ."where feedType = '".$feedType."' ";

        $result = $this->db->query($query)->row_array();

        $data = $result;
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
    public function getAllFeeds()
    {
        $query = "SELECT * "
            ."FROM socialfeedmaster";

        $result = $this->db->query($query)->result_array();

        $data['feedData'] = $result;
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

    public function getAllSortedFeeds()
    {
        $query = "SELECT feedText "
            ."FROM socialviewmaster";

        $result = $this->db->query($query)->result_array();

        return $result;
    }

    public function getTopFeedCount()
    {
        $query = "SELECT postsCount FROM socialfeedmaster
                  WHERE feedType =0
                  ORDER BY updateDateTime DESC LIMIT 0 , 1";
        $result = $this->db->query($query)->row_array();

        return $result;

    }
    public function getMoreLatestFeeds($count)
    {
        if($count == 0)
        {
            $query = "SELECT feedText FROM socialfeedmaster
                  WHERE feedType = 0 ORDER BY updateDateTime DESC LIMIT ".$count.",".($count+1);
        }
        else
        {
            $query = "SELECT feedText FROM socialfeedmaster
                  WHERE feedType = 0 ORDER BY updateDateTime DESC LIMIT ".$count.",".$count;
        }
        $result = $this->db->query($query)->row_array();

        return $result;
    }

    public function updateFeedByType($post,$feedType)
    {
        $post['updateDateTime'] = date('Y-m-d H:i:s');

        $this->db->where('feedType', $feedType);
        $this->db->update('socialfeedmaster', $post);
        return true;
    }
    public function insertFeedByType($post)
    {
        $post['updateDateTime'] = date('Y-m-d H:i:s');

        $this->db->insert('socialfeedmaster', $post);
        return true;
    }

    public function findCompletedEvents()
    {
        $query = "SELECT * "
            ."FROM eventmaster "
            ."where eventDate < CURRENT_DATE()";

        $result = $this->db->query($query)->result_array();
        return $result;
    }

    public function updateEventRegis($eventId)
    {
        $post['eventDone'] = '1';

        $this->db->where('eventId', $eventId);
        $this->db->update('eventregistermaster', $post);
        return true;
    }

    public function updateEventShortLink($eventId, $details)
    {
        $this->db->where('eventId', $eventId);
        $this->db->update('eventmaster', $details);
        return true;
    }
    public function updateCompletedEvent($eventId, $details)
    {
        $this->db->where('eventId', $eventId);
        $this->db->update('eventcompletedmaster', $details);
        return true;
    }

    public function updatefnbShortLink($fnbId, $details)
    {
        $this->db->where('fnbId', $fnbId);
        $this->db->update('fnbmaster', $details);
        return true;
    }

    public function transferEventRecord($eventId)
    {
        $query = "INSERT INTO eventcompletedmaster "
            ."SELECT * FROM eventmaster "
            ."where eventId = ".$eventId;

        $this->db->query($query);

        $this->db->where('eventId', $eventId);
        $this->db->delete('eventmaster');
        return true;
    }
    public function insertWeeklyFeedback($post)
    {
        $this->db->insert('feedbackweekscore', $post);
        return true;
    }

    public function updateSongs($restId, $post)
    {
        $post['updateDateTime'] = date('Y-m-d H:i:s');

        $this->db->where('tapId',$restId);
        $this->db->update('jukeboxmaster', $post);
        return true;
    }

    public function insertSongs($post)
    {
        $post['updateDateTime'] = date('Y-m-d H:i:s');

        $this->db->insert('jukeboxmaster', $post);
        return true;
    }

    public function checkTapSongs($resId)
    {
        $query = "SELECT * "
            ."FROM jukeboxmaster "
            ."where tapId = '".$resId."' ";

        $result = $this->db->query($query)->row_array();

        $data = $result;
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

    public function getIntaRecords()
    {
        $query = "SELECT um.firstName, um.lastName,
                    CASE WHEN lm.locName IS NULL THEN lm1.locName ELSE lm.locName END AS 'locName', erm.paymentId,
                    CASE WHEN em.eventName IS NULL THEN ecm.eventName ELSE em.eventName END AS 'eveName',
                    erm.quantity, erm.createdDT, ehm.highId, em.eventPrice 
                    FROM eventregistermaster erm
                    LEFT JOIN eventmaster em ON erm.eventId = em.eventId
                    LEFT JOIN eventcompletedmaster ecm ON erm.eventId = ecm.eventId
                    LEFT JOIN doolally_usersmaster um ON erm.bookerUserId = um.userId
                    LEFT JOIN locationmaster lm1 ON ecm.eventPlace = lm1.id
                    LEFT JOIN locationmaster lm ON em.eventPlace = lm.id
                    LEFT JOIN eventshighmaster ehm ON erm.eventId = ehm.eventId AND ehm.highStatus = 1
                    WHERE DATE(erm.createdDT) = CURRENT_DATE() - INTERVAL 1 DAY";

        $result = $this->db->query($query)->result_array();
        return $result;

    }

    public function getTomorrowEvents()
    {
        $query = "SELECT em.eventId, em.eventName, em.startTime, l.locName
                    FROM eventmaster em
                    LEFT JOIN locationmaster l ON em.eventPlace = l.id
                    where em.eventDate = (CURRENT_DATE() + INTERVAL 1 DAY) 
                    AND em.isEventCancel = 0 AND em.ifActive = ".ACTIVE." AND em.ifApproved = ".EVENT_APPROVED;

        $result = $this->db->query($query)->result_array();
        return $result;
    }
    public function getEventSignups($eventId)
    {
        $query = "SELECT um.mobNum
                    FROM eventregistermaster erm
                    LEFT JOIN doolally_usersmaster um ON erm.bookerUserId = um.userId
                    WHERE erm.eventId = ".$eventId." AND eventDone != 1 AND isUserCancel != 1";

        $result = $this->db->query($query)->result_array();
        return $result;
    }

    public function getMusicWeeklyReport()
    {
        $query = "SELECT ms.searchText as 'Searched Text',ms.userEmail as 'Email', 
                    ms.insertedDateTime as 'Logged Date/Time', l.locName as 'Location' 
                    FROM musicsearchmaster ms LEFT JOIN locationmaster l ON ms.taproomId = l.jukeboxId 
                    WHERE DATE(ms.insertedDateTime) >= (CURRENT_DATE() - INTERVAL 1 WEEK) AND DATE(ms.insertedDateTime) <= CURRENT_DATE()
                     ORDER BY l.locName";
        $result = $this->db->query($query)->result_array();
        return $result;
    }
}
