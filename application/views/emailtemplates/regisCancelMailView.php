<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0056)file:///C:/Users/user1/Desktop/Emails/welcome-email.html -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Registration Cancel</title>
</head>

<body>
    <p>
        Dear <?php echo $mailData['creatorName']; ?><br><br>

        <?php echo $mailData['firstName'].' '.$mailData['lastName']; ?> has withdrawn from <?php echo trim($mailData['eventName']); ?>.
        We are processing his/her refund. Please note that <?php echo $mailData['firstName'].' '.$mailData['lastName']; ?> will be removed from your list of attendees.<br><br>

        Thanks,<br>
        Doolally
    </p>

</body>
</html>