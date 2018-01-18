<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $desktopStyle ;?>
</head>
    <body class="mainHome">
    <div class="mdl-grid">
        <div class="mdl-cell--1-col"></div>
        <div class="mdl-cell--10-col">
            <div class="demo-card-square mdl-shadow--2dp text-center">
                <div class="mdl-custom-login-title">
                    <br>
                    <?php
                        if(isset($errorMsg))
                        {
                            ?>
                            <h4 class="mdl-card__title-text my-error-text" style="font-size:20px">Purchase failed!<br><?php echo $errorMsg;?></h4>
                            <br>
                            <?php
                        }
                        else
                        {
                            ?>
                            <h4 class="mdl-card__title-text my-success-text" style="font-size:20px">Thank you for purchasing Doolally Beers.<br>We'll send a confirmation email and beer codes.</h4>
                            <br>
                            <?php
                        }
                        if(isset($isTriggered) && $isTriggered)
                        {
                            echo '<h5 class="text-center">Gift of Beer has been scheduled!</h5>';
                        }
                    ?>
                    <a href="<?php echo base_url();?>" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent bookNow-event-btn" style="text-transform: capitalize;">
                        Visit Doolally
                    </a>
                </div>
                <br>
            </div>
        </div>
        <div class="mdl-cell--1-col"></div>
    </div>
    <div id="demo-toast" class="mdl-js-snackbar mdl-snackbar">
        <div class="mdl-snackbar__text"></div>
        <button class="mdl-snackbar__action" type="button"></button>
    </div>
    </body>
<?php echo $desktopJs ;?>
</html>

