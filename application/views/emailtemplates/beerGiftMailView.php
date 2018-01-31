<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0056)file:///C:/Users/user1/Desktop/Emails/welcome-email.html -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Beer Gift</title>
</head>

<body>
<p>Hi <?php echo trim(ucfirst($mailData['receiverName']));?>,</p>
<p>Your friend, <?php echo trim(ucfirst($mailData['buyerName']));?> just bought you something awesome, the gift of good beer!<br><br>
    <?php
        if(isset($mailData['receiverOccasion']) && isStringSet($mailData['receiverOccasion']))
        {
            ?>
            As your <?php echo $mailData['receiverOccasion'];?> present,
            <?php
        }
        else
        {
            ?>
            As your present,
            <?php
        }
        if((int)$mailData['totalPints'] == 1)
        {
            ?>
            you've been gifted <?php echo $mailData['totalPints'];?> pint of our finest beers.<br><br>
            <?php
        }
        else
        {
            ?>
            you've been gifted <?php echo $mailData['totalPints'];?> pints of our finest beers.<br><br>
            <?php
        }
    ?>
    Anytime you are in the mood for a pint, or <?php echo $mailData['totalPints'];?>, drop into any Doolally Taproom, show the person serving you this email and enjoy your thoughtful present.<br><br>
    In case you don't want to drink all at one go, that's perfectly fine. Just redeem one code for each pint.<br><br>
    <?php
        if(isset($mailData['specialMsg']) && isStringSet($mailData['specialMsg']))
        {
            ?>
            Here are the codes for each Pint along with a short note from <?php echo trim(ucfirst($mailData['buyerName']));?>.<br>
            <?php
        }
        else
        {
            ?>
            Here are the codes for each Pint.<br>
            <?php
        }
    ?>
    <?php
        $allCodes = explode(',',$mailData['allCodes']);
        foreach($allCodes as $key)
        {
            echo $key.'<br>';
        }
    ?><br><br>

    <?php
        if(isset($mailData['specialMsg']) && isStringSet($mailData['specialMsg']))
        {
            ?>
            <blockquote><?php echo $mailData['specialMsg'];?></blockquote><br><br>
            <?php
        }
    ?>
    Cheers!<br>
    Doolally
</p>

</body>
</html>