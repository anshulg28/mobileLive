<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0056)file:///C:/Users/user1/Desktop/Emails/welcome-email.html -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Refund Failed On EventsHigh</title>
</head>

<body>
    <p>
        Refund Fail Details:<br><br>
        <?php echo 'Event name: '.htmlspecialchars($mailData['eventName']);?><br>
        <?php echo 'Booking Id: '.$mailData['bookingId'];?><br>
        <?php echo 'Failure Reason: '.$mailData['errorTxt'];?><br>
        <?php echo 'Refund Date Time: '.$mailData['refundDateTime'];?><br>
    </p>

</body>
</html>