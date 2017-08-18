<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <?php
    if(isset($meta) && myIsArray($meta))
    {
        ?>
        <title><?php echo $meta['title'];?></title>
        <meta name="description" content="<?php echo $meta['description'];?>" />

        <!-- Schema.org markup for Google+ -->
        <meta itemprop="name" content="<?php echo $meta['title'];?>">
        <meta itemprop="description" content="<?php echo $meta['description'];?>">
        <meta itemprop="image" content="<?php echo $meta['img'];?>">

        <!-- Twitter Card data -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@godoolally">
        <meta name="twitter:title" content="<?php echo $meta['title'];?>">
        <meta name="twitter:description" content="<?php echo $meta['description'];?>">
        <meta name="twitter:creator" content="@godoolally">
        <!-- Twitter summary card with large image must be at least 280x150px -->
        <meta name="twitter:image:src" content="<?php echo $meta['img'];?>">

        <!-- Open Graph data -->
        <meta property="og:title" content="<?php echo $meta['title'];?>" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="<?php echo $meta['link'];?>" />
        <meta property="og:image" content="<?php echo $meta['img'];?>" />
        <meta property="og:description" content="<?php echo $meta['description'];?>" />
        <?php
    }
    elseif(isset($meta1) && myIsArray($meta1))
    {
        ?>
        <title><?php echo $meta1['title'];?></title>
        <meta name="description" content="<?php echo $meta1['description'];?>" />
        <meta itemprop="name" content="<?php echo $meta1['title'];?>">
        <meta itemprop="description" content="<?php echo $meta1['description'];?>">
        <meta itemprop="image" content="<?php echo $meta1['img'];?>">

        <!-- Twitter Card data -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@godoolally">
        <meta name="twitter:title" content="<?php echo $meta1['title'];?>">
        <meta name="twitter:description" content="<?php echo $meta1['description'];?>">
        <meta name="twitter:creator" content="@godoolally">
        <!-- Twitter summary card with large image must be at least 280x150px -->
        <meta name="twitter:image:src" content="<?php echo $meta1['img'];?>">

        <!-- Open Graph data -->
        <meta property="og:title" content="<?php echo $meta1['title'];?>" />
        <meta property="og:type" content="website" />
        <meta property="og:image" content="<?php echo $meta1['img'];?>" />
        <meta property="og:description" content="<?php echo $meta1['description'];?>" />
        <?php
    }
    else
    {
        ?>
        <title>Doolally</title>
        <?php
    }
    ?>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/temp/component-coming.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans|Averia+Serif+Libre' rel='stylesheet' type='text/css'>
    <link rel="icon" sizes="76x76" href="<?php echo base_url();?>asset/images/doolally-app-icon.png"/>
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url();?>asset/images/doolally-app-icon-apple.png"/>
    <style>
        img
        {
            width:50px;
        }
        .trigger-headline { color: burlywood;}
        .trigger-headline {
            font-family: 'Averia Serif Libre';
            top: 0;
            left: 0;
            position: absolute;
            font-size: 3em;
            text-transform: capitalize;
            pointer-events: none;
            line-height: 1;
            width: 100%;
            height: 100%;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .trigger-headline span {
            display: inline-block;
            position: relative;
            padding: 0 5vw;
            -webkit-transition: opacity 2s, -webkit-transform 2s;
            transition: opacity 2s, transform 2s;
            -webkit-transition-timing-function: cubic-bezier(0.2,1,0.3,1);
            transition-timing-function: cubic-bezier(0.2,1,0.3,1);
            -webkit-transition-delay: 0.7s;
            transition-delay: 0.7s;
        }

        .js .trigger-headline--hidden span {
            pointer-events: none;
            opacity: 0;
        }

        .js .trigger-headline--hidden span:nth-child(1) {
            -webkit-transform: translate3d(-100px,0,0);
            transform: translate3d(-100px,0,0);
        }

        .js .trigger-headline--hidden span:nth-child(2) {
            -webkit-transform: translate3d(-50px,0,0);
            transform: translate3d(-50px,0,0);
        }

        .js .trigger-headline--hidden span:nth-child(3) {
            -webkit-transform: translate3d(-25px,0,0);
            transform: translate3d(-25px,0,0);
        }

        .js .trigger-headline--hidden span:nth-child(4) {
            -webkit-transform: translate3d(25px,0,0);
            transform: translate3d(25px,0,0);
        }

        .js .trigger-headline--hidden span:nth-child(5) {
            -webkit-transform: translate3d(50px,0,0);
            transform: translate3d(50px,0,0);
        }

        .js .trigger-headline--hidden span:nth-child(6) {
            -webkit-transform: translate3d(100px,0,0);
            transform: translate3d(100px,0,0);
        }
    </style>
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
<main>
	<!-- Initial markup -->
	<div class="segmenter" ></div>
	<h2 class="trigger-headline trigger-headline--hidden"><span>
            <label style="color:crimson">Desktop website has gone for a beer. Check us out on mobile in meantime.</label>
        </span>
    </h2>
    <?php
    if(isset($eventDetails) && myIsMultiArray($eventDetails))
    {
        foreach($eventDetails as $key => $row)
        {
            ?>
            <div class="event-wrapper" itemscope itemtype="http://schema.org/Event" style="opacity:0 !important;position:absolute">
                <h1 itemprop="name"> <?php echo $row['eventName'];?></h1>
                <p itemprop="description"><?php echo $row['eventDescription'];?></p>
                <a itemprop="url" href="<?php echo base_url().'?page/events/'.$row['eventSlug'];?>" class="color-black"><?php echo $row['eventName'];?></a>
                <img itemprop="image" src="<?php echo base_url().EVENT_PATH_THUMB.$row['filename'];?>"/>
                <meta itemprop="startDate" content="<?php echo $row['eventDate'].'T'.$row['startTime'];?>" />
                <meta itemprop="endDate" content="<?php echo $row['eventDate'].'T'.$row['endTime'];?>" />
                <?php
                if($row['isEventEverywhere'] == STATUS_NO)
                {
                    $mapSplit = explode('/',$row['mapLink']);
                    $cords = explode(',',$mapSplit[count($mapSplit)-1]);
                    ?>
                    <div style="opacity:0" itemprop="location" itemscope itemtype="http://schema.org/Place">
                        <span itemprop="name"><?php echo 'Doolally Taproom '.$row['locName'];?></span>
                        <div itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
                            <meta itemprop="latitude" content="<?php echo $cords[0];?>" />
                            <meta itemprop="longitude" content="<?php echo $cords[1];?>" />
                        </div>
                        <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                            <span itemprop="streetAddress">
                                <?php echo $row['locAddress'];?>
                            </span>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
    }
    ?>
</main>
<script src="<?php echo base_url(); ?>asset/js/temp/anime.min.js"></script>
<script src="<?php echo base_url(); ?>asset/js/temp/imagesloaded.pkgd.min.js"></script>
<script src="<?php echo base_url(); ?>asset/js/temp/main-coming.js"></script>
<script>
	(function() {
		var headline = document.querySelector('.trigger-headline'),
			trigger = document.querySelector('.btn--trigger'),
			segmenter = new Segmenter(document.querySelector('.segmenter'), {
				pieces: 8,
				positions: [
					{top: 0, left: 0, width: 100, height: 100},
					{top: 0, left: 0, width: 100, height: 100},
					{top: 0, left: 0, width: 100, height: 100},
					{top: 0, left: 0, width: 100, height: 100},
					{top: 0, left: 0, width: 100, height: 100},
					{top: 0, left: 0, width: 100, height: 100},
					{top: 0, left: 0, width: 100, height: 100},
					{top: 0, left: 0, width: 100, height: 100}
				],
				shadows: false,
				parallax: true,
				parallaxMovement: {min: 10, max: 30},
				animation: {
					duration: 2500,
					easing: 'easeOutExpo',
					delay: 0,
					opacity: .1,
					translateZ: {min: 10, max: 25}
				},
				onReady: function() {
					//trigger.classList.remove('btn--hidden');
                    segmenter.animate();
                    headline.classList.remove('trigger-headline--hidden');
					/*trigger.addEventListener('click', function() {
						segmenter.animate();
						headline.classList.remove('trigger-headline--hidden');
						this.classList.add('btn--hidden');
					});*/
				}
			});
	})();

</script>

</body>
</html>