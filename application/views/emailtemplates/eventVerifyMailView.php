<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0056)file:///C:/Users/user1/Desktop/Emails/welcome-email.html -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Event Creation</title>
</head>

<body>
    <p>Event Detail:</p>
        <!--Event Image:
        <img src="<?php /*echo base_url().EVENT_PATH_THUMB.$mailData[0]['attachment'];*/?>"/><br>-->
    <table border="0" style="border-collapse:collapse;">
        <tbody>
            <tr>
                <td width="208">Event Name :</td>
                <td><?php echo $mailData[0]['eventName'];?></td>
            </tr>
            <tr height="20"><td width="208"></td><td></td></tr>
            <tr>
                <td width="208">Event description :</td>
                <td><?php echo $mailData[0]['eventDescription'];?></td>
            </tr>
            <tr height="20"><td width="208"></td><td></td></tr>
            <tr>
                <td width="208">Event Date :</td>
                <td>
                    <?php
                    $d = date_create($mailData[0]['eventDate']);
                    echo date_format($d,'l, jS F');;
                    ?>
                </td>
            </tr>
            <tr height="20"><td width="208"></td><td></td></tr>
            <tr>
                <td width="208">Event Time :</td>
                <td>
                    <?php
                    if($mailData['isEventExists'] === true)
                    {
                        echo '<span style="background-color:red;color:white;padding:5px">'.$mailData[0]['startTime'] .' - '.$mailData[0]['endTime'].'</span>';
                        echo '(Conflict With Event(s): '.$mailData['eveNames'].')';
                    }
                    else
                    {
                        echo $mailData[0]['startTime'] .' - '.$mailData[0]['endTime'];
                    }
                    ?>
                </td>
            </tr>
            <tr height="20"><td width="208"></td><td></td></tr>
            <tr>
                <td width="208">Event Price :</td>
                <td>
                    <?php
                    if($mailData[0]['costType'] == '1')
                    {
                        echo 'Free';
                    }
                    else
                    {
                        echo $mailData[0]['eventPrice'];
                    }
                    ?>
                </td>
            </tr>
            <tr height="20"><td width="208"></td><td></td></tr>
            <tr>
                <td width="208">Event Place :</td>
                <td><?php echo $mailData[0]['locData'][0]['locName'];?></td>
            </tr>
            <tr height="20"><td width="208"></td><td></td></tr>
            <tr>
                <td width="208">Event Capacity :</td>
                <td><?php echo $mailData[0]['eventCapacity'];?></td>
            </tr>
            <tr height="20"><td width="208"></td><td></td></tr>
            <tr>
                <td width="208">Mic Required :</td>
                <td>
                    <?php
                    if($mailData[0]['ifMicRequired'] == '1')
                    {
                        echo 'Yes';
                    }
                    else
                    {
                        echo 'No';
                    }

                    ?>
                </td>
            </tr>
            <tr height="20"><td width="208"></td><td></td></tr>
            <tr>
                <td width="208">Projector Required :</td>
                <td>
                    <?php
                    if($mailData[0]['ifProjectorRequired'] == '1')
                    {
                        echo 'Yes';
                    }
                    else
                    {
                        echo 'No';
                    }

                    ?>
                </td>
            </tr>
            <tr height="20"><td width="208"></td><td></td></tr>
            <tr>
                <td width="208">Organiser Name :</td>
                <td><?php echo $mailData[0]['creatorName'];?></td>
            </tr>
            <tr height="20"><td width="208"></td><td></td></tr>
            <tr>
                <td width="208">Organiser Phone :</td>
                <td><?php echo $mailData[0]['creatorPhone'];?></td>
            </tr>
            <tr height="20"><td width="208"></td><td></td></tr>
            <tr>
                <td width="208">Organiser Email :</td>
                <td><?php echo $mailData[0]['creatorEmail'];?></td>
            </tr>
            <tr height="20"><td width="208"></td><td></td></tr>
            <tr>
                <td width="208">About Organiser :</td>
                <td><?php echo $mailData[0]['aboutCreator'];?></td>
            </tr>
            <tr height="20"><td width="208"></td><td></td></tr>
            <tr>
                <td>
                    <a href="<?php echo DASHBOARD_URL.'dashboard#events';?>"
                       style="text-decoration: none;border: 2px solid #000;padding: 5px;border-radius: 5px;color:green;">Go To Dashboard</a>
                </td>
            </tr>
            <tr height="20"><td width="208"></td><td></td></tr>
        </tbody>
    </table>
        <!--<a href="<?php /*echo base_url().'dashboard/eventEmailApprove/'.$mailData['senderUser'].'/'.$mailData[0]['eventId'];*/?>"
        style="text-decoration: none;border: 2px solid #000;padding: 5px;border-radius: 5px;color:green;">Approve Event</a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?php /*echo base_url().'dashboard/eventEmailDecline/'.$mailData['senderUser'].'/'.$mailData[0]['eventId'];*/?>"
           style="text-decoration: none;border: 2px solid #000;padding: 5px;border-radius: 5px;color:red;">Decline Event</a>-->

</body>
</html>