<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0056)file:///C:/Users/user1/Desktop/Emails/welcome-email.html -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

</head>

<body>
    <p>
        Hi,<br><br>

        To book or not to book the event, that was the question. Here's a reminder to book <?php echo $mailData['eventName'];?> which will be
            held on <?php $d = date_create($mailData['eventDate']); echo date_format($d,DATE_MAIL_FORMAT_UI);?>, <?php echo date('h:i a',strtotime($mailData['startTime']));?>, Doolally Taproom, <?php echo trim($locInfo['locName']);?>.
         If you are still interested, register using this link <?php echo $mailData['shortUrl'];?><br><br>
        Thanks,<br>
        <?php echo ucfirst($commName);?>, Doolally
    </p>

</body>
</html>