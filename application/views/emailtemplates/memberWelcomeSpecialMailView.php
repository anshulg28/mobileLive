<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0056)file:///C:/Users/user1/Desktop/Emails/welcome-email.html -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Welcome Member</title>
</head>

<body>
    <p>Hi <?php echo trim(ucfirst($mailData['creatorName']));?>,</p>
    <p>Rumour has it that you have signed up for <b><?php echo $mailData['eventName'];?></b> happening on
        <a href="<?php echo $calendar_url;?>" target="_blank"><?php $d = date_create($mailData['eventDate']); echo date_format($d,DATE_MAIL_FORMAT_UI);?></a>,
    <?php echo date('h:i a',strtotime($mailData['startTime'])).'-'.date('h:i a',strtotime($mailData['endTime']));?>
       at <a href="<?php echo $locInfo['mapLink'];?>" target="_blank">Doolally Taproom, <?php echo $locInfo['locName'];?></a>
        <?php
        if(isset($mailData['buyQuantity']))
        {
            $remaining = ((int)$mailData['buyQuantity']-1);
            if($remaining>0)
            {
                if($remaining == 1)
                {
                    echo ', along with a friend';
                }
                else
                {
                    echo ', along with '.$remaining.' friends';
                }
            }
            else
            {

                echo '.';
            }
        }
        ?>
    </p>

    <p>This mail is to let you know what your <?php echo date('l',strtotime($mailData['eventDate']));?>
        is going to look like. The event will run from <?php echo date('h:i a',strtotime($mailData['startTime'])).'-'.date('h:i a',strtotime($mailData['endTime']));?>.<br><br>

        <?php
            if(isset($mailData['eveOfferCode']) && $mailData['eveOfferCode'] != '')
            {
                if((int)$mailData['doolallyFee'] == 3000)
                {
                    ?>
                    All you need to do is show up and show this code(s) <?php echo implode(',',$mailData['eveOfferCode']);?> to the waiter serving you.
                    As a part of your fee for the event, you drink unlimited beer during the pop-up.
                    <?php
                }
                else
                {
                    ?>
                    All you need to do is show up and show this code(s) <?php echo implode(',',$mailData['eveOfferCode']);?> to the waiter serving you.
                    <?php
                }
                ?>
                <br><br>
                <?php
            }
        ?>

        You can access your events from the <a href="<?php echo base_url();?>?page/event_dash" target="_blank">My Events</a> section.
        This is a place where information on date, timings, organiser will be available to you. You can also cancel your attendance from this dashboard.<br><br>

        Username: <?php echo $mailData['creatorEmail'];?><br>
        Password: Your Mobile Number<br><br>

        See you!<br>
        <?php echo ucfirst($commName);?>, Doolally
    </>

</body>
</html>