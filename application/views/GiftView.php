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
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/general_style.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/animate.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/vex.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/vex-theme-plain.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/css/material.min.css">
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
    <style>
        html
        {
            height:100%;
            margin:0;
        }
        #custom-progressBar
        {
            margin: 0 auto;
            width: 100%;
            position: fixed;
            top: 0;
            z-index: 1000;
        }
        .vex.vex-theme-plain .vex-dialog-button.vex-dialog-button-primary
        {
            background:rgba(27, 21, 15, 0.87);
        }
        .vex.vex-theme-plain
        {
            padding-left: 35px;
            padding-right: 20px;
            padding-top: 50px;
        }
        .vex {
            z-index: 11111;
        }
        .vex.vex-theme-plain .vex-content, .mdl-list__item {
            font-family: 'Averia Serif Libre' !important;
        }
        @-moz-document url-prefix() {
            .vex.vex-theme-plain
            {
                padding-left:20px !important;
            }
        }
        @supports (-ms-ime-align:auto) {
            .vex.vex-theme-plain
            {
                padding-left:20px !important;
            }
        }
    </style>
    <script type="application/javascript" src="<?php echo base_url(); ?>asset/js/jquery-2.2.4.min.js"></script>
    <script type="application/javascript" src="<?php echo base_url(); ?>asset/js/bootstrap.min.js"></script>
    <script type="application/javascript" src="<?php echo base_url(); ?>asset/js/material.min.js"></script>
    <script type="application/javascript" src="<?php echo base_url(); ?>asset/js/vex.combined.min.js"></script>
    <script>
        window.base_url = '<?php echo base_url(); ?>';
        vex.defaultOptions.className = 'vex-theme-plain';
        function showProgressLoader()
        {
            $('#custom-progressBar').removeClass('hide');
        }
        function hideProgressLoader()
        {
            $('#custom-progressBar').addClass('hide');
        }
        function mySnackTime(txt)
        {
            var snackbarContainer = document.querySelector('#demo-toast');
            var data = {message: txt};
            snackbarContainer.MaterialSnackbar.showSnackbar(data);
        }
        function isValidDate(s)
        {
            var bits = s.split('/');
            var d = new Date(bits[2] + '/' + bits[1] + '/' + bits[0]);
            return !!(d && (d.getMonth() + 1) == bits[1] && d.getDate() == Number(bits[0]));
        }
        function validateEmail($email) {
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            return emailReg.test( $email );
        }

        function readjustHeight()
        {
            var contentHeight = $('.giftABeer .middle').height() + 20;
            if($(window).height() > contentHeight)
            {
                $('.giftABeer .bgimg').css("height",$(window).height());
            }
            else
            {
                $('.giftABeer .bgimg').css("height",contentHeight);
            }
        }
        var selectedChoice = 0;
        $(document).on('click','.middle .main-selection .choice-card .panel',function(){
            //console.log('in');
            var choice = $(this).attr('data-choice');
            selectedChoice = choice;
            //console.log(choice);
            switch(choice)
            {
                case '1':
                    $('.middle .main-selection').animateCss('fadeOutUp', function () {
                        // Do somthing after animation
                        $('.middle .main-selection').addClass('hide');
                        $('.middle').removeClass('push-el-down');
                        $('.middle .form-wrapper').removeClass('hide').animateCss("fadeInDown",function(){
                            //readjustHeight();
                        });
                    });
                    break;
                case '2':
                    $('.middle .main-selection').animateCss('fadeOutUp', function () {
                        // Do somthing after animation
                        $('.middle .main-selection').addClass('hide');
                        $('.middle').removeClass('push-el-down');
                        $('.middle .form-wrapper-gift-mug').removeClass('hide').animateCss("fadeInDown",function(){
                            //readjustHeight();
                        });
                    });
                    break;
                case '3':
                    $('.middle .main-selection').animateCss('fadeOutUp', function () {
                        // Do somthing after animation
                        $('.middle .main-selection').addClass('hide');
                        $('.middle').removeClass('push-el-down');
                        $('.middle .form-wrapper-gift-beer').removeClass('hide').animateCss("fadeInDown",function(){
                            //readjustHeight();
                        });
                    });
                    break;
            }
        });
        $(document).on('click','.middle .get-back-choice', function(){
            switch(selectedChoice)
            {
                case "1":
                    $('.middle .form-wrapper').animateCss('fadeOutUp',function(){
                        $('.middle .form-wrapper').addClass('hide');
                        $('.middle').addClass('push-el-down');
                        $('.middle .main-selection').removeClass('hide').animateCss("fadeInDown");
                    });
                    break;
                case "2":
                    $('.middle .form-wrapper-gift-mug').animateCss('fadeOutUp',function(){
                        $('.middle .form-wrapper-gift-mug').addClass('hide');
                        $('.middle').addClass('push-el-down');
                        $('.middle .main-selection').removeClass('hide').animateCss("fadeInDown");
                    });
                    break;
                case "3":
                    $('.middle .form-wrapper-gift-beer').animateCss('fadeOutUp',function(){
                        $('.middle .form-wrapper-gift-beer').addClass('hide');
                        $('.middle').addClass('push-el-down');
                        $('.middle .main-selection').removeClass('hide').animateCss("fadeInDown");
                    });
                    break;
                default:
                    $('.middle .form-wrapper').animateCss('fadeOutUp',function(){
                        $('.middle .form-wrapper').addClass('hide');
                        $('.middle').addClass('push-el-down');
                        $('.middle .main-selection').removeClass('hide').animateCss("fadeInDown");
                    });
                    break;
            }
        });
        $.fn.extend({
            animateCss: function (animationName, callback) {
                var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
                this.addClass('animated ' + animationName).one(animationEnd, function() {
                    $(this).removeClass('animated ' + animationName);
                    if (callback) {
                        callback();
                    }
                });
                return this;
            }
        });

        var giftMugData = {};

        $(document).on('click','#proceedMugForm', function(){
            if($('#bFullName').val() == '')
            {
                mySnackTime('Please provide your Name!');
                return false;
            }
            var nameReg = new RegExp("^[a-zA-Z\\s]+$");
            if(!nameReg.test($('#bFullName').val()))
            {
                mySnackTime("Enter valid name!");
                return false;
            }
            if($('#buyerEmail').val() == '')
            {
                mySnackTime('Please provide your Email!');
                return false;
            }
            if(!validateEmail($('#buyerEmail').val()))
            {
                mySnackTime('Please provide valid Email!');
                return false;
            }
            if($('#buyerPhone').val() == '')
            {
                mySnackTime('Please provide valid Mobile number!');
                return false;
            }
            if($('#buyerPhone').val().length != 10)
            {
                mySnackTime('Please provide valid Mobile number!');
                return false;
            }
            if($('#buyerOccasion').val() == '')
            {
                mySnackTime('Occasion is required!');
                return false;
            }
            var curDate = $('#buyerDate').val()+"/"+$('#buyerMonth').val()+"/"+$('#buyerYear').val();
            if(!isValidDate(curDate))
            {
                mySnackTime("Please Provide a Valid Date");
                return false;
            }
            giftMugData['gifterName'] = $('#bFullName').val();
            giftMugData['gifterEmail'] = $('#buyerEmail').val();
            giftMugData['gifterPhone'] = $('#buyerPhone').val();
            giftMugData['gifterOccasion'] = $('#buyerOccasion').val();
            giftMugData['giftScheduleDate'] = curDate;

            $('.buyer-form').animateCss("slideOutLeft",function(){
                $('.buyer-form').addClass('hide');
                $('#main-mug-gift-form').removeClass('hide').animateCss("slideInRight");
            });
        });
        $(document).on('click','.middle .go-back-gift-form', function(){
            $('#main-mug-gift-form').animateCss("slideOutRight",function(){
                $('#main-mug-gift-form').addClass('hide');
                $('.buyer-form').removeClass('hide').animateCss("slideInLeft");
            });
        });
        $(document).on('focusout','.middle .form-wrapper-gift-mug #mugId', function(){
            if($(this).val() != '')
            {
                var mugNum = $(this).val();
                $.ajax({
                    type:"GET",
                    dataType:"json",
                    url:base_url+'main/MugAvailability/'+mugNum,
                    success: function(data)
                    {
                        if(data.status === true)
                        {
                            $('.middle .form-wrapper-gift-mug .mug-suggestions').addClass('my-success-text').html('Mug Number is Available');
                            $('.middle .form-wrapper-gift-mug button[type="submit"]').removeAttr('disabled');
                        }
                        else
                        {
                            $('.middle .form-wrapper-gift-mug button[type="submit"]').attr('disabled','disabled');
                            var suggHtml = '<span class="my-danger-text">Mug Number is Not Available!</span><br>';
                            if(typeof data.availMugs != 'undefined')
                            {
                                suggHtml += '<p>Select anyone from below:</p>';
                                var mugHtml = '';
                                var i = 1;
                                for(var index in data.availMugs)
                                {
                                    if(i == 5)
                                    {
                                        $('.middle .form-wrapper-gift-mug .mug-suggestions').html(suggHtml);
                                        return false;
                                    }
                                    suggHtml += '<span class="mdl-chip avail-mugs"><span class="mdl-chip__text">'+data.availMugs[index]+'</span></span>';
                                    i++;
                                }
                            }
                            $('.middle .form-wrapper-gift-mug .mug-suggestions').addClass('my-danger-text').html(suggHtml);
                        }
                    },
                    error: function(xhr, status, error)
                    {
                        $('.middle .form-wrapper-gift-mug .mug-suggestions').addClass('my-danger-text').html('Unable To Connect To Server!');
                        var err = '<pre>'+xhr.responseText+'</pre>';
                        saveErrorLog(err);
                    }
                });
            }
        });
        $(document).on('click','.middle #main-mug-gift-form .avail-mugs',function(){
            var e = this;
            console.log(e);
            $('.middle #main-mug-gift-form #mugId').val($(e).find('.mdl-chip__text').html());
            $('.middle #main-mug-gift-form #mugId').trigger('focusout');
        });

        $(document).on('submit','.middle .form-wrapper-gift-mug #main-mug-gift-form',function(e){
            e.preventDefault();

            var curDate = $('.middle #main-mug-gift-form #buyerDate').val()+"/"+$('.middle #main-mug-gift-form #buyerMonth').val()+"/"+$('.middle #main-mug-gift-form #buyerYear').val();

            if($('.middle #main-mug-gift-form #firstName').val() == '')
            {
                mySnackTime('Please Provide First Name');
                return false;
            }
            if($('.middle #main-mug-gift-form #lastName').val() == '')
            {
                mySnackTime('Please Provide Last Name');
                return false;
            }

            if($('.middle #main-mug-gift-form #email').val() == '')
            {
                mySnackTime('Please Provide Email');
                return false;
            }
            if($('.middle #main-mug-gift-form #mobNum').val() == '')
            {
                mySnackTime('Mobile Number Required!');
                return false;
            }

            if($('.middle #main-mug-gift-form #mobNum').val().length != 10)
            {
                mySnackTime('Valid Mobile number required!');
                return false;
            }

            if(!isValidDate(curDate))
            {
                mySnackTime('Invalid Date');
                return false;
            }

            if(getAge(curDate) < 21)
            {
                mySnackTime('Not a Legal Drinking Age(21 yrs)');
                return false;
            }
            if($('.middle #main-mug-gift-form #homebase').val() == '')
            {
                mySnackTime('Please Select The Homebase!');
                return false;
            }

            if($('.middle #main-mug-gift-form #mugId').val() == '')
            {
                mySnackTime('Mug Number is Required!');
                return false;
            }

            showProgressLoader();
            $('.middle #main-mug-gift-form button[type="submit"]').attr('disabled','disabled');

            giftMugData['firstName'] = $('.middle #main-mug-gift-form #firstName').val();
            giftMugData['lastName'] = $('.middle #main-mug-gift-form #lastName').val();
            giftMugData['email'] = $('.middle #main-mug-gift-form #email').val();
            giftMugData['mobNum'] = $('.middle #main-mug-gift-form #mobNum').val();
            giftMugData['tagName'] = $('.middle #main-mug-gift-form #tagName').val();
            giftMugData['mugId'] = $('.middle #main-mug-gift-form #mugId').val();
            giftMugData['homebase'] = $('.middle #main-mug-gift-form #homebase').val();
            giftMugData['buyerMonth'] = $('.middle #main-mug-gift-form #buyerMonth').val();
            giftMugData['buyerDate'] = $('.middle #main-mug-gift-form #buyerDate').val();
            giftMugData['buyerYear'] = $('.middle #main-mug-gift-form #buyerYear').val();

            $.ajax({
                type:'POST',
                dataType:'json',
                url:$(this).attr('action'),
                data:giftMugData,
                success: function(data){
                    hideProgressLoader();

                    if(data.status === true)
                    {
                        if(typeof data.payUrl != 'undefined')
                        {
                            window.location.href=data.payUrl;
                        }
                        else
                        {
                            $('.middle #main-mug-gift-form button[type="submit"]').removeAttr('disabled');
                            vex.dialog.buttons.YES.text = 'Close';
                            vex.dialog.alert({
                                unsafeMessage: '<label class="head-title">Error!</label><br><br>Failed To Process Request, Please Try Again!'
                            });
                        }
                    }
                    else
                    {
                        $('.middle #main-mug-gift-form button[type="submit"]').removeAttr('disabled');
                        vex.dialog.buttons.YES.text = 'Close';
                        vex.dialog.alert({
                            unsafeMessage: '<label class="head-title">Error!</label><br><br>'+data.errorMsg
                        });
                    }

                },
                error: function(xhr, status, error){
                    hideProgressLoader();
                    $('.middle #main-mug-gift-form button[type="submit"]').removeAttr('disabled');
                    vex.dialog.buttons.YES.text = 'Close';
                    vex.dialog.alert({
                        unsafeMessage: '<label class="head-title">Error!</label><br><br>'+'Some Error Occurred!'
                    });
                    var err = '<pre>'+xhr.responseText+'</pre>';
                    saveErrorLog(err);
                }
            });

        });


        $(document).on('focusout','.middle .form-wrapper #mugId', function(){
            if($(this).val() != '')
            {
                var mugNum = $(this).val();
                $.ajax({
                    type:"GET",
                    dataType:"json",
                    url:base_url+'main/MugAvailability/'+mugNum,
                    success: function(data)
                    {
                        if(data.status === true)
                        {
                            $('.middle .form-wrapper .mug-suggestions').addClass('my-success-text').html('Mug Number is Available');
                            $('.middle .form-wrapper button[type="submit"]').removeAttr('disabled');
                        }
                        else
                        {
                            $('.middle .form-wrapper button[type="submit"]').attr('disabled','disabled');
                            var suggHtml = '<span class="my-danger-text">Mug Number is Not Available!</span><br>';
                            if(typeof data.availMugs != 'undefined')
                            {
                                suggHtml += '<p>Select anyone from below:</p>';
                                var mugHtml = '';
                                var i = 1;
                                for(var index in data.availMugs)
                                {
                                    if(i == 5)
                                    {
                                        $('.middle .form-wrapper .mug-suggestions').html(suggHtml);
                                        return false;
                                    }
                                    suggHtml += '<span class="mdl-chip avail-mugs"><span class="mdl-chip__text">'+data.availMugs[index]+'</span></span>';
                                    i++;
                                }
                            }
                            $('.middle .form-wrapper .mug-suggestions').addClass('my-danger-text').html(suggHtml);
                        }
                    },
                    error: function(xhr, status, error)
                    {
                        $('.middle .form-wrapper .mug-suggestions').addClass('my-danger-text').html('Unable To Connect To Server!');
                        var err = '<pre>'+xhr.responseText+'</pre>';
                        saveErrorLog(err);
                    }
                });
            }
        });
        $(document).on('click','.middle .form-wrapper .avail-mugs',function(){
            $('.middle .form-wrapper #mugId').val($(this).find('.mdl-chip__text').html());
            $('.middle .form-wrapper #mugId').trigger('focusout');
        });
        function getAge(dateString)
        {
            var today = new Date();
            var birthDate = new Date(dateString);
            var age = today.getFullYear() - birthDate.getFullYear();
            var m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate()))
            {
                age--;
            }
            return age;
        }
        $(document).on('submit','.middle .form-wrapper #main-mug-form',function(e){
            e.preventDefault();

            var curDate = $('.middle .form-wrapper #buyerDate').val()+"/"+$('.middle .form-wrapper #buyerMonth').val()+"/"+$('.middle .form-wrapper #buyerYear').val();

            if($('.middle .form-wrapper #firstName').val() == '')
            {
                mySnackTime('Please Provide First Name');
                return false;
            }
            if($('.middle .form-wrapper #lastName').val() == '')
            {
                mySnackTime('Please Provide Last Name');
                return false;
            }

            if($('.middle .form-wrapper #email').val() == '')
            {
                mySnackTime('Please Provide Email');
                return false;
            }
            if($('.middle .form-wrapper #mobNum').val() == '')
            {
                mySnackTime('Mobile Number Required!');
                return false;
            }
            if($('.middle .form-wrapper #mobNum').val().length != 10)
            {
                mySnackTime('Valid Mobile number required!');
                return false;
            }

            if(!isValidDate(curDate))
            {
                mySnackTime('Invalid Date');
                return false;
            }

            if(getAge(curDate) < 21)
            {
                mySnackTime('Not a Legal Drinking Age(21 yrs)');
                return false;
            }
            if($('.middle .form-wrapper #homebase').val() == '')
            {
                mySnackTime('Please Select The Homebase!');
                return false;
            }

            if($('.middle .form-wrapper #mugId').val() == '')
            {
                mySnackTime('Mug Number is Required!');
                return false;
            }

            showProgressLoader();
            $('.middle .form-wrapper button[type="submit"]').attr('disabled','disabled');


            $.ajax({
                type:'POST',
                dataType:'json',
                url:$(this).attr('action'),
                data:$(this).serialize(),
                success: function(data){
                    hideProgressLoader();

                    if(data.status === true)
                    {
                        if(typeof data.payUrl != 'undefined')
                        {
                            window.location.href=data.payUrl;
                        }
                        else
                        {
                            $('.middle .form-wrapper button[type="submit"]').removeAttr('disabled');
                            vex.dialog.buttons.YES.text = 'Close';
                            vex.dialog.alert({
                                unsafeMessage: '<label class="head-title">Error!</label><br><br>Failed To Process Request, Please Try Again!'
                            });
                        }
                    }
                    else
                    {
                        $('.middle .form-wrapper button[type="submit"]').removeAttr('disabled');
                        vex.dialog.buttons.YES.text = 'Close';
                        vex.dialog.alert({
                            unsafeMessage: '<label class="head-title">Error!</label><br><br>'+data.errorMsg
                        });
                    }

                },
                error: function(xhr, status, error){
                    hideProgressLoader();
                    $('.middle .form-wrapper button[type="submit"]').removeAttr('disabled');
                    vex.dialog.buttons.YES.text = 'Close';
                    vex.dialog.alert({
                        unsafeMessage: '<label class="head-title">Error!</label><br><br>'+'Some Error Occurred!'
                    });
                    var err = '<pre>'+xhr.responseText+'</pre>';
                    saveErrorLog(err);
                }
            });

        });

        $(document).on('submit','.middle .form-wrapper-gift-beer #main-beer-form', function(e){
            e.preventDefault();

            if($('.middle .form-wrapper-gift-beer #main-beer-form #buyerFName').val() == '')
            {
                mySnackTime("First Name is Required!");
                return false;
            }
            if($('.middle .form-wrapper-gift-beer #main-beer-form #buyerLName').val() == '')
            {
                mySnackTime("Last Name is Required!");
                return false;
            }
            if($('.middle .form-wrapper-gift-beer #main-beer-form #buyerEmail').val() == '')
            {
                mySnackTime("Your Email is Required!");
                return false;
            }
            if($('.middle .form-wrapper-gift-beer #main-beer-form #buyerPhone').val() == '')
            {
                mySnackTime("Your Phone Number is Required!");
                return false;
            }
            if($('.middle .form-wrapper-gift-beer #main-beer-form #buyerPhone').val().length != 10)
            {
                mySnackTime("Valid Phone Number is required!");
                return false;
            }
            if($('.middle .form-wrapper-gift-beer #main-beer-form #buyerPints').val() == '')
            {
                mySnackTime("Pints quantity is Required!");
                return false;
            }
            if($('.middle .form-wrapper-gift-beer #main-beer-form #receiverName').val() == '')
            {
                mySnackTime("Giftee Name is Required!");
                return false;
            }
            if($('.middle .form-wrapper-gift-beer #main-beer-form #receiverEmail').val() == '')
            {
                mySnackTime("Giftee Email is Required!");
                return false;
            }
            if($('.middle .form-wrapper-gift-beer #main-beer-form #receiverOccasion').val() == '')
            {
                mySnackTime("Occasion is Required!");
                return false;
            }
            var sendDate = $('.middle .form-wrapper-gift-beer #main-beer-form #receiverDay').val()+'/'+
                $('.middle .form-wrapper-gift-beer #main-beer-form #receiverMonth').val()+'/'+
                $('.middle .form-wrapper-gift-beer #main-beer-form #receiverYear').val();

            if(!isValidDate(sendDate))
            {
                mySnackTime("Schedule Date is not proper!");
                return false;
            }

            showProgressLoader();
            $('.middle .form-wrapper-gift-beer #main-beer-form button[type="submit"]').attr('disabled','disabled');

            $.ajax({
                type:'POST',
                dataType:'json',
                url:$(this).attr('action'),
                data:$(this).serialize(),
                success: function(data){
                    hideProgressLoader();

                    if(data.status === true)
                    {
                        if(typeof data.payUrl != 'undefined')
                        {
                            window.location.href=data.payUrl;
                        }
                        else
                        {
                            $('.middle .form-wrapper-gift-beer button[type="submit"]').removeAttr('disabled');
                            vex.dialog.buttons.YES.text = 'Close';
                            vex.dialog.alert({
                                unsafeMessage: '<label class="head-title">Error!</label><br><br>Failed To Process Request, Please Try Again!'
                            });
                        }
                    }
                    else
                    {
                        $('.middle .form-wrapper-gift-beer button[type="submit"]').removeAttr('disabled');
                        vex.dialog.buttons.YES.text = 'Close';
                        vex.dialog.alert({
                            unsafeMessage: '<label class="head-title">Error!</label><br><br>'+data.errorMsg
                        });
                    }

                },
                error: function(xhr, status, error){
                    hideProgressLoader();
                    $('.middle .form-wrapper-gift-beer button[type="submit"]').removeAttr('disabled');
                    vex.dialog.buttons.YES.text = 'Close';
                    vex.dialog.alert({
                        unsafeMessage: '<label class="head-title">Error!</label><br><br>'+'Some Error Occurred!'
                    });
                    var err = '<pre>'+xhr.responseText+'</pre>';
                    saveErrorLog(err);
                }
            });
        });
        $(window).load(function(){
            componentHandler.upgradeDom();
        });
        function maxLengthCheck(object)
        {
            if (object.value.length > object.maxLength)
                object.value = object.value.slice(0, object.maxLength)
        }
    </script>
</head>
<body class="giftABeer">
    <div id="custom-progressBar" class="mdl-progress mdl-js-progress mdl-progress__indeterminate hide"></div>
    <div class="bgimg">
        <div class="middle push-el-down">
            <div class="row main-selection">
                <div class="col-sm-2 col-xs-0"></div>
                <div class="col-sm-2 col-xs-12 choice-card">
                    <div class="panel panel-default" data-choice="1">
                        <div class="panel-body">
                            <i class="fa fa-beer fa-3x"></i>
                            <br>
                            <p>Buy Mug</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-1 col-xs-0 hide-from-tab"></div>
                <div class="col-sm-2 col-xs-12 choice-card">
                    <div class="panel panel-default" data-choice="2">
                        <div class="panel-body">
                            <i class="fa fa-gift fa-3x"></i>
                            <br>
                            <p>Gift Mug</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-1 col-xs-0 hide-from-tab"></div>
                <div class="col-sm-2 col-xs-12 choice-card">
                    <div class="panel panel-default" data-choice="3">
                        <div class="panel-body">
                            <i class="fa fa-beer fa-3x"></i>
                            <br>
                            <p>Gift Beer</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2 col-xs-0"></div>
            </div>
            <div class="form-wrapper hide">
                <div class="mdl-grid">
                    <div class="mdl-cell--1-col hide-on-mdl-mobile"></div>
                    <div class="mdl-cell--10-col margin-center">
                        <div class="demo-card-square mdl-shadow--2dp text-center">
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent get-back-choice common-btn pull-left">
                                <i class="fa fa-home"></i> Home
                            </button>
                            <h3 class="form-title">Doolally New Mug Membership</h3>
                            <br>
                            <form action="<?php echo base_url().'main/verifyMember';?>" method="POST" id="main-mug-form">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="number" id="mugId" name="mugId" placeholder="Enter number more than 100">
                                    <label class="mdl-textfield__label" for="mugId">Mug Number</label>
                                </div>&nbsp;
                                <br>
                                <div class="mug-suggestions"></div>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="text" pattern="^[a-zA-Z\s]+$" id="firstName" name="firstName">
                                    <label class="mdl-textfield__label" for="firstName">First Name</label>
                                </div>
                                <br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="text" pattern="^[a-zA-Z\s]+$" id="lastName" name="lastName">
                                    <label class="mdl-textfield__label" for="lastName">Last Name</label>
                                </div>
                                <br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="email" id="email" name="email">
                                    <label class="mdl-textfield__label" for="email">Email</label>
                                </div>
                                <br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="number" id="mobNum" name="mobNum" minlength="10" maxlength="10" oninput="maxLengthCheck(this)">
                                    <label class="mdl-textfield__label" for="mobNum">Mobile Number</label>
                                </div>
                                <br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="text" id="tagName" name="tagName" maxlength="8">
                                    <label class="mdl-textfield__label" for="tagName">Name On Tag (if any)</label>
                                </div>
                                <br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <select id="homebase" name="homebase" class="mdl-textfield__input" style="font-family: 'Averia Serif Libre' !important;">
                                        <option value=""></option>
                                        <?php
                                        if(isset($locData))
                                        {
                                            foreach($locData as $key => $row)
                                            {
                                                if(isset($row['id']))
                                                {
                                                    ?>
                                                    <option value="<?php echo $row['id'];?>"><?php echo $row['locName'];?></option>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                    <label class="mdl-textfield__label" for="homebase">Taproom Preference:</label>
                                </div>
                                <br>
                                <label class="birth-label">BirthDate: </label><br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label custom-month-selection">
                                    <select id="buyerMonth" name="buyerMonth" class="mdl-textfield__input" style="font-family: 'Averia Serif Libre' !important;">
                                        <?php
                                        $monthList = $this->config->item('monthList');
                                        $i=1;
                                        foreach($monthList as $key)
                                        {
                                            ?>
                                            <option value="<?php echo $i;?>" <?php if($i == date('n')){echo 'Selected';} ?>><?php echo $key;?></option>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </select>
                                    <label class="mdl-textfield__label" for="buyerMonth">Month</label>
                                </div>&nbsp;
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label custom-date-selection">
                                    <select id="buyerDate" name="buyerDate" class="mdl-textfield__input" style="font-family: 'Averia Serif Libre' !important;">
                                        <?php
                                        for($i=1;$i<32;$i++)
                                        {
                                            ?>
                                            <option value="<?php echo $i;?>" <?php if($i == date('j')){echo 'Selected';} ?>><?php echo $i;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <!--<input class="mdl-textfield__input" type="number" id="buyerDate" name="buyerDate" value="<?php /*echo date('d'); */?>">-->
                                    <label class="mdl-textfield__label" for="buyerDate">Date</label>
                                </div>&nbsp;
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label custom-year-selection">
                                    <select id="buyerYear" name="buyerYear" class="mdl-textfield__input" style="font-family: 'Averia Serif Libre' !important;">
                                        <?php
                                        for($i=1920;$i<(int)date('Y');$i++)
                                        {
                                            ?>
                                            <option value="<?php echo $i;?>" <?php if($i == date('Y')){echo 'Selected';} ?>><?php echo $i;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <!--<input class="mdl-textfield__input" type="number" id="buyerYear" name="buyerYear" value="<?php /*echo date('Y'); */?>">-->
                                    <label class="mdl-textfield__label" for="buyerYear">Year</label>
                                </div>
                                <br>
                                <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent bookNow-event-btn common-btn" style="text-transform: capitalize;" disabled>
                                    Submit
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="mdl-cell--1-col hide-on-mdl-mobile"></div>
                </div>
            </div>
            <div class="form-wrapper-gift-mug hide">
                <div class="mdl-grid">
                    <div class="mdl-cell--1-col hide-on-mdl-mobile"></div>
                    <div class="mdl-cell--10-col margin-center">
                        <div class="demo-card-square mdl-shadow--2dp text-center">
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent get-back-choice common-btn pull-left">
                                <i class="fa fa-home"></i> Home
                            </button>
                            <h3 class="form-title">Doolally Gift Mug Membership</h3>
                            <br>
                            <div class="buyer-form">
                                <h4>Your Details:</h4>
                                <br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" pattern="^[a-zA-Z\s]+$" type="text" id="bFullName">
                                    <label class="mdl-textfield__label" for="bFullName">Your Name</label>
                                </div>
                                <br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="email" id="buyerEmail">
                                    <label class="mdl-textfield__label" for="buyerEmail">Your Email</label>
                                </div>
                                <br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="number" id="buyerPhone" minlength="10" maxlength="10" oninput="maxLengthCheck(this)">
                                    <label class="mdl-textfield__label" for="buyerPhone">Your Mobile number</label>
                                </div>
                                <br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="text" id="buyerOccasion">
                                    <label class="mdl-textfield__label" for="buyerOccasion">Occasion (eg. just a gift, birthday)</label>
                                </div>
                                <br>
                                <label class="schedule-label">Schedule Date:</label><br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label custom-month-selection">
                                    <select id="buyerMonth" class="mdl-textfield__input" style="font-family: 'Averia Serif Libre' !important;">
                                        <?php
                                        $monthList = $this->config->item('monthList');
                                        $i=1;
                                        foreach($monthList as $key)
                                        {
                                            ?>
                                            <option value="<?php echo $i;?>" <?php if($i == date('n')){echo 'Selected';} ?>><?php echo $key;?></option>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </select>
                                    <label class="mdl-textfield__label" for="buyerMonth">Month</label>
                                </div>&nbsp;
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label custom-date-selection">
                                    <select id="buyerDate" class="mdl-textfield__input" style="font-family: 'Averia Serif Libre' !important;">
                                        <?php
                                        for($i=1;$i<32;$i++)
                                        {
                                            ?>
                                            <option value="<?php echo $i;?>" <?php if($i == date('j')){echo 'Selected';} ?>><?php echo $i;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <!--<input class="mdl-textfield__input" type="number" id="buyerDate" value="<?php /*echo date('d'); */?>">-->
                                    <label class="mdl-textfield__label" for="buyerDate">Date</label>
                                </div>&nbsp;
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label custom-year-selection">
                                    <select id="buyerYear" class="mdl-textfield__input" style="font-family: 'Averia Serif Libre' !important;">
                                        <?php
                                        for($i=2018;$i<2025;$i++)
                                        {
                                            ?>
                                            <option value="<?php echo $i;?>" <?php if($i == date('Y')){echo 'Selected';} ?>><?php echo $i;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <!--<input class="mdl-textfield__input" type="number" id="buyerYear" value="<?php /*echo date('Y'); */?>">-->
                                    <label class="mdl-textfield__label" for="buyerYear">Year</label>
                                </div>
                                <br>
                                <button id="proceedMugForm" type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent bookNow-event-btn common-btn" style="text-transform: capitalize;">
                                    Fill Mug Details <i class="fa fa-arrow-right"></i>
                                </button>
                            </div>
                            <form action="<?php echo base_url().'main/verifyMember';?>" method="POST" class="hide" id="main-mug-gift-form">
                                <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent common-btn go-back-gift-form">
                                    <i class="fa fa-chevron-left"></i> Go Back
                                </button>
                                <br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="number" id="mugId" name="mugId" placeholder="Enter number more than 100">
                                    <label class="mdl-textfield__label" for="mugId">Mug Number</label>
                                </div>&nbsp;
                                <br>
                                <div class="mug-suggestions"></div>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="text" pattern="^[a-zA-Z\s]+$" id="firstName" name="firstName">
                                    <label class="mdl-textfield__label" for="firstName">First Name</label>
                                </div>
                                <br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="text" pattern="^[a-zA-Z\s]+$" id="lastName" name="lastName">
                                    <label class="mdl-textfield__label" for="lastName">Last Name</label>
                                </div>
                                <br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="email" id="email" name="email">
                                    <label class="mdl-textfield__label" for="email">Email</label>
                                </div>
                                <br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="number" id="mobNum" name="mobNum" minlength="10" maxlength="10" oninput="maxLengthCheck(this)">
                                    <label class="mdl-textfield__label" for="mobNum">Mobile Number</label>
                                </div>
                                <br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="text" id="tagName" name="tagName" maxlength="8">
                                    <label class="mdl-textfield__label" for="tagName">Name On Tag (if any)</label>
                                </div>
                                <br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <select id="homebase" name="homebase" class="mdl-textfield__input" style="font-family: 'Averia Serif Libre' !important;">
                                        <option value=""></option>
                                        <?php
                                        if(isset($locData))
                                        {
                                            foreach($locData as $key => $row)
                                            {
                                                if(isset($row['id']))
                                                {
                                                    ?>
                                                    <option value="<?php echo $row['id'];?>"><?php echo $row['locName'];?></option>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                    <label class="mdl-textfield__label" for="homebase">Taproom Preference</label>
                                </div>
                                <br>
                                <label class="birth-label">BirthDate: </label><br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label custom-month-selection">
                                    <select id="buyerMonth" class="mdl-textfield__input" style="font-family: 'Averia Serif Libre' !important;">
                                        <?php
                                        $monthList = $this->config->item('monthList');
                                        $i=1;
                                        foreach($monthList as $key)
                                        {
                                            ?>
                                            <option value="<?php echo $i;?>" <?php if($i == date('n')){echo 'Selected';} ?>><?php echo $key;?></option>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </select>
                                    <label class="mdl-textfield__label" for="buyerMonth">Month</label>
                                </div>&nbsp;
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label custom-date-selection">
                                    <select id="buyerDate" class="mdl-textfield__input" style="font-family: 'Averia Serif Libre' !important;">
                                        <?php
                                        for($i=1;$i<32;$i++)
                                        {
                                            ?>
                                            <option value="<?php echo $i;?>" <?php if($i == date('j')){echo 'Selected';} ?>><?php echo $i;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <!--<input class="mdl-textfield__input" type="number" id="buyerDate" value="<?php /*echo date('d'); */?>">-->
                                    <label class="mdl-textfield__label" for="buyerDate">Date</label>
                                </div>&nbsp;
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label custom-year-selection">
                                    <select id="buyerYear" name="buyerYear" class="mdl-textfield__input" style="font-family: 'Averia Serif Libre' !important;">
                                        <?php
                                        for($i=1920;$i<(int)date('Y');$i++)
                                        {
                                            ?>
                                            <option value="<?php echo $i;?>" <?php if($i == date('Y')){echo 'Selected';} ?>><?php echo $i;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <!--<input class="mdl-textfield__input" type="number" id="buyerYear" value="<?php /*echo date('Y'); */?>">-->
                                    <label class="mdl-textfield__label" for="buyerYear">Year</label>
                                </div>
                                <br>
                                <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent bookNow-event-btn common-btn" style="text-transform: capitalize;" disabled>
                                    Submit
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="mdl-cell--1-col hide-on-mdl-mobile"></div>
                </div>
            </div>
            <div class="form-wrapper-gift-beer hide">
                <div class="mdl-grid">
                    <div class="mdl-cell--1-col hide-on-mdl-mobile"></div>
                    <div class="mdl-cell--10-col margin-center">
                        <div class="demo-card-square mdl-shadow--2dp text-center">
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent get-back-choice common-btn pull-left">
                                <i class="fa fa-home"></i> Home
                            </button>
                            <h3 class="form-title">Buy/Gift Beer Pints</h3>
                            <br>
                            <form action="<?php echo base_url().'main/verifyPints';?>" method="POST" id="main-beer-form">
                                <h4>Your Details: </h4>
                                <br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" pattern="^[a-zA-Z\s]+$" type="text" id="buyerFName" name="buyerFName">
                                    <label class="mdl-textfield__label" for="buyerFName">First Name</label>
                                </div>
                                <br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" pattern="^[a-zA-Z\s]+$" type="text" id="buyerLName" name="buyerLName">
                                    <label class="mdl-textfield__label" for="buyerLName">Last Name</label>
                                </div>
                                <br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="email" id="buyerEmail" name="buyerEmail" title="Please Provide Valid Email Id">
                                    <label class="mdl-textfield__label" for="buyerEmail">Your Email</label>
                                </div>
                                <br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="number" id="buyerPhone" name="buyerPhone" minlength="10" maxlength="10" oninput="maxLengthCheck(this)">
                                    <label class="mdl-textfield__label" for="buyerPhone">Your Mobile number</label>
                                </div>
                                <br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <select id="buyerPints" name="totalPints" class="mdl-textfield__input" style="font-family: 'Averia Serif Libre' !important;">
                                        <?php
                                        for($i=1;$i<11;$i++)
                                        {
                                            ?>
                                            <option value="<?php echo $i;?>" <?php if($i==1){echo 'selected';} ?>><?php echo $i;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <label class="mdl-textfield__label" for="buyerPints">How many pints of beer</label>
                                </div>
                                <br>
                                <h4>Gifting To: </h4>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="text" id="receiverName" name="receiverName">
                                    <label class="mdl-textfield__label" for="receiverName">Name</label>
                                </div>
                                <br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="email" id="receiverEmail" name="receiverEmail">
                                    <label class="mdl-textfield__label" for="receiverEmail">Email</label>
                                </div>
                                <br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="text" id="receiverOccasion" name="receiverOccasion">
                                    <label class="mdl-textfield__label" for="receiverOccasion">Occasion (eg. just a gift, birthday)</label>
                                </div>
                                <br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <textarea class="mdl-textfield__input" id="specialMsg" name="specialMsg"></textarea>
                                    <label class="mdl-textfield__label" for="specialMsg">Personal Message (if any)</label>
                                </div>
                                <br>
                                <label class="schedule-label">Schedule Date:</label><br>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label custom-month-selection">
                                    <select id="receiverMonth" name="receiverMonth" class="mdl-textfield__input" style="font-family: 'Averia Serif Libre' !important;">
                                        <?php
                                        $monthList = $this->config->item('monthList');
                                        $i=1;
                                        foreach($monthList as $key)
                                        {
                                            ?>
                                            <option value="<?php echo $i;?>" <?php if($i == date('n')){echo 'Selected';} ?>><?php echo $key;?></option>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </select>
                                    <label class="mdl-textfield__label" for="receiverMonth">Month</label>
                                </div>&nbsp;
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label custom-date-selection">
                                    <select id="receiverDay" name="receiverDay" class="mdl-textfield__input" style="font-family: 'Averia Serif Libre' !important;">
                                        <?php
                                        for($i=1;$i<32;$i++)
                                        {
                                            ?>
                                            <option value="<?php echo $i;?>" <?php if($i == date('j')){echo 'Selected';} ?>><?php echo $i;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <!--<input class="mdl-textfield__input" type="number" id="receiverDay" name="receiverDay" value="<?php /*echo date('d'); */?>">-->
                                    <label class="mdl-textfield__label" for="receiverDay">Date</label>
                                </div>&nbsp;
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label custom-year-selection">
                                    <select id="receiverYear" name="receiverYear" class="mdl-textfield__input" style="font-family: 'Averia Serif Libre' !important;">
                                        <?php
                                        for($i=2018;$i<2026;$i++)
                                        {
                                            ?>
                                            <option value="<?php echo $i;?>" <?php if($i == date('Y')){echo 'Selected';} ?>><?php echo $i;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <!--<input class="mdl-textfield__input" type="number" id="receiverYear" name="receiverYear" value="<?php /*echo date('Y'); */?>">-->
                                    <label class="mdl-textfield__label" for="receiverYear">Year</label>
                                </div>
                                <br>
                                <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent bookNow-event-btn common-btn" style="text-transform: capitalize;">
                                    Submit
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="mdl-cell--1-col hide-on-mdl-mobile"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="demo-toast" class="mdl-js-snackbar mdl-snackbar">
        <div class="mdl-snackbar__text"></div>
        <button class="mdl-snackbar__action" type="button"></button>
    </div>
</body>
</html>