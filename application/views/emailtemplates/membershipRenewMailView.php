<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0056)file:///C:/Users/user1/Desktop/Emails/welcome-email.html -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Renewal Mug Mail</title>
</head>

<body>
    <p>Hi <?php echo ucfirst($mailData['firstName']);?>,</p>
    <p>We have received the payment for your mug #<?php echo $mailData['mugId'];?><br><br>
        We will be extending your expiry date to one year from now i.e <?php $d = date_create($mailData['newEndDate']); echo date_format($d,DATE_MAIL_FORMAT_UI);?><br><br>

        Thank you once again for keeping the faith. :)<br><br>

        Cheers,<br>
        <?php echo trim(ucfirst($this->userFirstName));?>, Doolally
    </p>

</body>
</html>