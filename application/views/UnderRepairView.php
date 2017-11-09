<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<style>
    body, html {
        height: 100%;
        margin: 0;
    }

    .bgimg {
        background-image: url('../../asset/images/Belgian_Wit-min.jpg');
        height: 100%;
        background-position: center;
        background-size: cover;
        position: relative;
        color: white;
        font-family: "Courier New", Courier, monospace;
        font-size: 25px;
    }

    .topleft {
        position: absolute;
        top: 0;
        left: 16px;
    }

    .bottomleft {
        position: absolute;
        bottom: 0;
        left: 16px;
    }

    .middle {
        position: absolute;
        top: 20%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }
    .middle h1
    {
        /*color:#000;*/
    }

    hr {
        margin: auto;
        width: 40%;
    }
</style>
<body>

<div class="bgimg">
    <div class="topleft">
        <p></p>
    </div>
    <div class="middle">
        <h1>OUR WEBSITE IS GETTING SOME EXTRA BUZZ</h1>
        <hr>
        <p>We'll be back in a few hours</p>
    </div>
    <div class="bottomleft">
        <p></p>
    </div>
</div>

</body>
</html>
