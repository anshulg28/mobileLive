<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0056)file:///C:/Users/user1/Desktop/Emails/welcome-email.html -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Event Cancel</title>
</head>

<body>
    <p>
        <?php echo $mailData[0]['creatorName'];?> wants to cancel the event '<?php echo $mailData[0]['eventName'];?>' on
        <?php $d = date_create($mailData[0]['eventDate']); echo date_format($d,DATE_MAIL_FORMAT_UI);?> at <?php echo $mailData[0]['locName'];?>,
        Taproom. Please call them on <?php echo $mailData[0]['creatorPhone'];?> or email <?php echo $mailData[0]['creatorEmail'];?>.<br><br>
        Thank you
    </p>

</body>
</html>