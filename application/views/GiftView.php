<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <title>Gift A Beer</title>
    <meta name="description" content="Gift a Beer, buy mug club or gift a mug" />
    <meta itemprop="name" content="Gift A Beer">
    <meta itemprop="description" content="Gift a Beer, buy mug club or gift a mug">
    <meta itemprop="image" content="<?php echo base_url();?>asset/images/doolally-app-icon.png">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@godoolally">
    <meta name="twitter:title" content="Gift A Beer">
    <meta name="twitter:description" content="Gift a Beer, buy mug club or gift a mug">
    <meta name="twitter:creator" content="@godoolally">
    <!-- Twitter summary card with large image must be at least 280x150px -->
    <meta name="twitter:image:src" content="<?php echo base_url();?>asset/images/doolally-app-icon.png">

    <!-- Open Graph data -->
    <meta property="og:title" content="Gift A Beer" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="<?php echo base_url();?>asset/images/doolally-app-icon.png" />
    <meta property="og:description" content="Gift a Beer, buy mug club or gift a mug" />
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/animate.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans|Averia+Serif+Libre' rel='stylesheet' type='text/css'>
    <link rel="icon" sizes="76x76" href="<?php echo base_url();?>asset/images/doolally-app-icon.png"/>
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url();?>asset/images/doolally-app-icon-apple.png"/>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-86757534-1', 'auto');
        ga('send', 'pageview');
    </script>
</head>
<body>
<div class="bgimg">
    <div class="topleft">
        <p></p>
    </div>
    <div class="middle">
        <div class="row">
            <div class="col-sm-4 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <i class="fa fa-beer fa-3x"></i>
                        <br>
                        <p>Buy Mug Membership</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <i class="fa fa-gift fa-3x"></i>
                        <br>
                        <p>Gift Mug Membership</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <i class="fa fa-beer fa-3x"></i>
                        <br>
                        <p>Gift Beer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottomleft">
        <p></p>
    </div>
</div>

</body>
<script type="application/javascript" src="<?php echo base_url(); ?>asset/js/jquery-2.2.4.min.js"></script>
<script type="application/javascript" src="<?php echo base_url(); ?>asset/js/bootstrap.min.js"></script>
</html>