<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0056)file:///C:/Users/user1/Desktop/Emails/welcome-email.html -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Welcome Member</title>
</head>

<body>
    <p>Dear <?php echo trim(ucfirst($mailData['hostName']));?>,</p>
    <p><?php echo trim(ucfirst($mailData['creatorName']));?> has signed up for <?php echo $mailData['eventName'];?> happening on
    <?php $d = date_create($mailData['eventDate']); echo date_format($d,DATE_FORMAT_UI);?></p>

    <p>Here are their contact details.<br><br>
        <?php echo trim(ucfirst($mailData['creatorName']));?><br>
        <?php echo trim(ucfirst($mailData['creatorEmail']));?><br>
        <?php echo trim(ucfirst($mailData['creatorPhone']));?><br><br>
        You can also access your events from <a href="<?php echo base_url();?>?page/event_dash" target="_blank">My Events</a>.
        This is your dashboard where information on the number of sign ups, fees collected, payout details will be available to you. You can also edit your event or cancel your event from this dashboard.<br><br>

        In case you have any questions/queries please don't hesitate to write to me at this mail address<br><br>
        <!--or you can reach me at
        --><?php /*echo $commNum;*/?>

        Cheers!<br>
        <?php echo ucfirst($commName);?>
    </p>

</body>
</html>