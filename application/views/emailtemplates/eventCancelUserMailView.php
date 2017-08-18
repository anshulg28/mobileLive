<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0056)file:///C:/Users/user1/Desktop/Emails/welcome-email.html -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Event Canceled</title>
</head>

<body>
    <p>Dear <?php echo trim($mailData[0]['creatorName'])?>,</p>
    <p>
        We will send your cancellation request to the venue's Community Manager.
        The final call on cancelling the event will be decided by the Community Manager.
        Once cancelled, all the fees collected will be refunded to the attendees.<br><br>

        Thanks,<br>
        <?php echo ucfirst($mailData['senderName']); ?>
    </p>

</body>
</html>