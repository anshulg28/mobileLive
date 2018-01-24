<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0056)file:///C:/Users/user1/Desktop/Emails/welcome-email.html -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Welcome Member</title>
</head>

<body>
<p>Hi <?php echo trim(ucfirst($mailData['firstName']));?>,</p>
<p>Your friend, <?php echo trim(ucfirst($mailData['gifterName']));?> just bought you something awesome, the gift of good beer!<br><br>
    <?php
        if(isset($mailData['gifterOccasion']) && isStringSet(trim($mailData['gifterOccasion'])))
        {
            ?>
            As a present for your <?php echo $mailData['gifterOccasion'];?>, you are now part of Doolally's Mug Club.<br><br>
            <?php
        }
        else
        {
            ?>
            As a present, you are now part of Doolally's Mug Club.<br><br>
            <?php
        }
    ?>
    Anytime you are in the mood for a mug, drop into Doolally Taproom (Andheri, Bandra, Khar, Kemps Corner, Colaba), ask for your mug and enjoy your thoughtful present.<br><br>
    Here are your mug club details:<br><br>
    Name of Member: <?php echo trim(ucfirst($mailData['firstName'])).' '.trim(ucfirst($mailData['lastName']));?><br>
    Mug Number: <?php echo $mailData['mugId'];?><br>
    Home Base: <?php echo $mailData['locName'];?> Taproom<br>
    Name on Dog Tag: <?php echo $mailData['mugTag'];?><br>
    <?php
        if($mailData['birthDate'] != '0000-00-00')
        {
            ?>
            Date of Birth: <?php $d = date_create($mailData['birthDate']); echo date_format($d,'jS M');?><br>
            <?php
        }
        else
        {
            ?>
            Date of Birth: NA
            <?php
        }
    ?>
    Date of Joining: <?php $d = date_create($mailData['membershipStart']); echo date_format($d,'jS F Y');?><br>
    Date of Expiry: <?php $d = date_create($mailData['membershipEnd']); echo date_format($d,'jS F Y');?><br>
    E Mail Address: <?php echo $mailData['emailId'];?><br>
    Mobile Number: <?php echo $mailData['mobileNo'];?><br><br>

    For any queries, reach out to me on this email address.<br><br>

    Cheers!<br>
    <?php echo $fromName;?>, Doolally
</p>

</body>
</html>