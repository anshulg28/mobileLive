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

</head>
<body>
<main>
	<!-- Initial markup -->
	<p>For twitter</p>
</main>

</body>
</html>