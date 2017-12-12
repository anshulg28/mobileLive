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
       at <a href="<?php echo $locInfo['mapLink'];?>" target="_blank">Doolally Taproom, <?php echo trim($locInfo['locName']);?></a<?php
        if(isset($mailData['buyQuantity']))
        {
            $remaining = ((int)$mailData['buyQuantity']-1);
            if($remaining>0)
            {
                if($remaining == 1)
                {
                    echo '>, along with a friend.';
                }
                else
                {
                    echo '>, along with '.$remaining.' friends.';
                }
            }
            else
            {

                echo '>.';
            }
        }
        ?>
            <br><br>
        <?php
        if(isset($mailData['customEmailText']))
        {
            echo $mailData['customEmailText'];
        }
        else
        {
            ?>
            This mail is to let you know what your <?php echo date('l',strtotime($mailData['eventDate']));?>
            is going to look like. The event will run from <?php echo date('h:i a',strtotime($mailData['startTime'])).'-'.date('h:i a',strtotime($mailData['endTime']));?>.<br><br>
            <?php
        }
        ?>

        <?php
            if(isset($mailData['eveOfferCode']) && $mailData['eveOfferCode'] != '')
            {
                if(isset($mailData['customEmailText']))
                {
                    echo '<br><br>';
                }
                if((int)$mailData['eventPrice'] == 500)
                {
                    ?>
                    As part of the pass, you will be entitled to one quiz and also as a part of the fee for the event,
                    you can redeem Rs 300 on F&B at any of our Doolally Taprooms.
                    Just show this code(s) <?php echo implode(',',$mailData['eveOfferCode']);?> to the waiter who is serving you.
                    <?php
                }
                else
                {
                    ?>
                    As part of  the All Day Pass, you will be entitled to attend all three quizzes and also as a part of the fee for the event, you can redeem Rs 300 on F&B at any of our Doolally Taprooms.
                    Just show this code(s) <?php echo implode(',',$mailData['eveOfferCode']);?> to the waiter who is serving you.
                    <?php
                }
                ?>
                <br><br>
                <?php
            }
        ?>You can access your events from the <a href="<?php echo base_url();?>?page/event_dash" target="_blank">My Events</a> section.
        This is a place where information on date, timings, organiser will be available to you. You can also cancel your attendance from this dashboard.<br><br>

        Username: <?php echo $mailData['creatorEmail'];?><br>
        Password: Your Mobile Number<br><br>

        See you!<br>
        <?php echo ucfirst($commName);?>, Doolally
    </p>

</body>
</html>