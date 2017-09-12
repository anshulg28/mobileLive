
// Init App
var tabToShow = '#tab2';
var myApp = new Framework7({
    // Enable Template7 pages
    pushState: true,
    pushStateSeparator: '?page/',
    //template7Pages: true,
    smartSelectOpenIn:'picker',
    //hideNavbarOnPageScroll: true,
    swipePanel: 'left',
    /*preprocess: function (content, url, next) {
        if(typeof url != 'undefined')
        {
            if(url == 'events')
            {
                tabToShow = '#tab2';
                return false;
            }
            /!*if(url.indexOf('events') != -1 || url.indexOf('create_event') != -1 || url.indexOf('event_dash') != -1
                || url.indexOf('eventEdit') != -1 || url.indexOf('event_details') != -1 || url.indexOf('contact_us') != -1
                || url.indexOf('jukebox') != -1 || url.indexOf('taprom') != -1 || url.indexOf('songlist') != -1)
            {
                console.log('under url ' + url);
                tabToShow = '#tab2';
            }*!/
        }
        return content;
    },*/
    preroute: function(view, options){
        if(typeof options.url != 'undefined')
        {
            if(options.url == 'events')
            {
                tabToShow = '#tab2';
                return false;
            }
        }
    }
});

var welcomescreen = myApp.welcomescreen(welcomescreen_slides, options);
// Init View
var mainView = myApp.addView('.view-main', {
    // Material doesn't support it but don't worry about it
    // F7 will ignore it for Material theme
    dynamicNavbar: true,
    uniqueHistory: true
});

myApp.onPageInit('event', function (page) {
    // Do something here for "about" page
    setTimeout(function(){
        myApp.hideIndicator();
    },500);
    $('.event-fab-btn').addClass('hide');
    if(typeof $('#meta_title').val() != 'undefined')
    {
        $('title').html($('#meta_title').val());
    }

    $("#share").jsSocials({
        url: $('#shareLink').val(),
        text:$('title').html(),
        showCount: false,
        shares: ["whatsapp", "twitter", "facebook"]
    });
    $('.jssocials-share').find('a').addClass('external');

    $$(document).on('click','.final-booking-btn', function(e){
        e.preventDefault();
        var payLink = $(this).attr('data-href');
        if(payLink != '')
        {
            myApp.modal({
                title:  'Booking Guidelines',
                text: $('#eventBookTc').html(),
                buttons: [
                    {
                        text: 'Ok',
                        onClick: function() {
                            var d=document.createElement("script");
                            d.src=payLink;
                            window.document.body.insertBefore(d, window.document.body.firstChild);
                        }
                    }
                ]
            });
        }
        else
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Payment Gateway Error!'
            });
        }
    });
    $$(document).on('click','.other-booking-btn', function(e){
        e.preventDefault();
        var payLink = $(this).attr('data-href');
        if(payLink != '')
        {
            var d=document.createElement("script");
            d.src=payLink;
            window.document.body.insertBefore(d, window.document.body.firstChild);
        }
        else
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Payment Gateway Error!'
            });
        }
    });

});
myApp.onPageInit('eventSingle', function (page) {
    // Do something here for "about" page
    setTimeout(function(){
        myApp.hideIndicator();
    },500);
    $('.event-fab-btn').addClass('hide');

    if($('#isLoggedIn').val() == '0')
    {
        myApp.loginScreen();
    }

    if(typeof $('#meta_title').val() != 'undefined')
    {
        $('title').html($('#meta_title').val());
    }

    $("#share").jsSocials({
        url: $('#shareLink').val(),
        text:$('title').html(),
        showCount: false,
        shares: ["whatsapp", "twitter", "facebook"]
    });
    $('.jssocials-share').find('a').addClass('external');

    $$(document).on('click','.event-cancel-btn', function(){
        var isConfirm = false;
        var cmName = $(this).attr('data-commName');
        var cmNum = $(this).attr('data-commNum');
        var eveId = $(this).attr('data-eveId');
        vex.dialog.buttons.YES.text = 'Cancel Event';
        vex.dialog.buttons.NO.text = 'Close';
        vex.dialog.confirm({
            unsafeMessage: '<label class="head-title">Cancel Event?</label><br><br>'+
            'Please Contact the venue\'s Community Manager ('+cmName+') on <a href="tel:'+cmNum+'">'+cmNum+'</a> to cancel your event.',
            showCloseButton: true,
            callback: function (value) {
                if (value) {
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: base_url+'sendCancelRequest',
                        data: {eventId: eveId},
                        success: function(){},
                        error: function(){}
                    });
                }
            }
            /*afterClose: function(){
                vex.closeAll();
                if(isConfirm)
                {
                    cancelEvent($$('.event-details #eventId').val());
                }
                var f = Object.keys(vex.getAll());
                if(f.length != 0)
                {
                    console.log(f.length);
                    for(var i=0;i<f.length;i++)
                    {
                        vex.close(''+f[i]+'');
                    }
                }*/
            /*},
            callback: function (value) {
                if (value) {
                    isConfirm = true;
                }
            }*/
        });
        //confirmDialog('Cancel Event?', "Once you tap 'Cancel Event', your event will be cancelled within 48 hours. All" +
            //" the fees collected will be refunded to the attendees.",'Cancel Event', $$('.event-details #eventId').val(), false);
    });

    $$(document).on('click','.page-refresh-btn', function(){
        myApp.showIndicator();
        setTimeout(function(){
            mainView.router.refreshPage();
            myApp.hideIndicator();
        },1000);
    });

    $$(document).on('click','.numbr-signup', function(e){
        var parent, ink, d, x, y;
        parent = $(this);
        //create .ink element if it doesn't exist
        if(parent.find(".ink").length == 0)
            parent.append("<span class='ink'></span>");

        ink = parent.find(".ink");
        //incase of quick double clicks stop the previous animation
        ink.removeClass("animate");

        //set size of .ink
        if(!ink.height() && !ink.width())
        {
            //use parent's width or height whichever is larger for the diameter to make a circle which can cover the entire element.
            d = Math.max(parent.outerWidth(), parent.outerHeight());
            ink.css({height: d, width: d});
        }

        //get click coordinates
        //logic = click coordinates relative to page - parent's position relative to page - half of self height/width to make it controllable from the center;
        x = e.pageX - parent.offset().left - ink.width()/2;
        y = e.pageY - parent.offset().top - ink.height()/2;

        //set the position and add class .animate
        ink.css({top: y+'px', left: x+'px'}).addClass("animate");
    });

});
myApp.onPageInit('signUpListPage', function (page) {
    // Do something here for "about" page
    setTimeout(function(){
        myApp.hideIndicator();
    },500);
    $('.event-fab-btn').addClass('hide');

    if($('#isLoggedIn').val() == '0')
    {
        myApp.loginScreen();
    }

    if(typeof $('#meta_title').val() != 'undefined')
    {
        $('title').html($('#meta_title').val());
    }

    $$(document).on('click','.page-refresh-btn', function(){
        myApp.showIndicator();
        setTimeout(function(){
            mainView.router.refreshPage();
            myApp.hideIndicator();
        },1000);
    });

});
myApp.onPageInit('eventsDash', function(page){

    setTimeout(function(){
        myApp.hideIndicator();
    },500);
    if(isRegistered)
    {
        isRegistered = false;
        myApp.showTab("#attending");
    }
    $('.event-fab-btn').addClass('hide');
    if($('#isLoggedIn').val() == '0')
    {
        myApp.loginScreen();
    }
    else
    {
        $('.logout-menu-item').show();
        $('.logout-menu-item').removeClass('hide');
    }
    $$(document).on('click','.custom-addToCal', function(){
        var evTitle = $(this).attr('data-ev-title');
        var evDescription = $(this).attr('data-ev-description');
        var evStart =  new Date(($(this).attr('data-ev-start')).replace(/-/g, "/"));
        var evEnd = new Date(($(this).attr('data-ev-end')).replace(/-/g, "/"));
        var evLoc = $(this).attr('data-ev-location');
        var data= {
            title: evTitle,
            start: evStart,
            end: evEnd,
            address: evLoc,
            description: evDescription
        };
        var cal = generateCalendars(data);
        var clickedLink = this;
        var popoverHTML = '<div class="popover">'+
            '<div class="popover-inner">'+
            '<div class="list-block">'+
            '<ul>'+
            '<li>'+cal.google+'</li>'+
            '<li>'+cal.ical+'</li>'+
            '<li>'+cal.yahoo+'</li>'+
            '<li>'+cal.outlook+'</li>'+
            '</ul>'+
            '</div>'+
            '</div>'+
            '</div>';
        myApp.popover(popoverHTML, clickedLink);
        //$(this).html(myCalendar);

    });
    $$('.even-dashboard #user-app-login').on('beforeSubmit', function (e) {
        e.preventDefault();
        setTimeout(function(){
            myApp.hideIndicator();
        },500);
        var xhr = e.detail.xhr;
        if($$('input[name="username"]').val() == '')
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Username Required!'
            });
            xhr.abort();
        }
        if($$('input[name="password"]').val() == '')
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Password Required!'
            });
            xhr.abort();
        }
    });
    $$('.even-dashboard #user-app-login').on('submitted', function(e){
        setTimeout(function(){
            myApp.hideIndicator();
        },500);
        var data = e.detail.data;
        var objJSON = JSON.parse(data);
        if(objJSON.status === true)
        {
            $('.iosHome .user-settings').removeClass('hide');
            mainView.router.refreshPage();
        }
        else
        {
            vex.dialog.buttons.YES.text = 'Close';
            vex.dialog.alert({
                unsafeMessage: '<label class="head-title">Error!</label><br><br>'+objJSON.errorMsg
            });
            //alertDialog('Error!',objJSON.errorMsg, false);
        }
    });

});
var eventAddStatus = false;
myApp.onPageInit('eventAdd', function (page) {
    // Do something here for "about" page
    appendScript(base_url+'asset/mobile/js/jquery.timepicker.min.js');
    appendScript(base_url+'asset/mobile/js/cropper.min.js');
    //appendScript(base_url+'asset/mobile/js/masonry.pkgd.min.js');
    appendStyle(base_url+'asset/mobile/css/cropper.min.css');
    setTimeout(function(){
        myApp.hideIndicator();
    },500);

    $('.event-fab-btn').addClass('hide');
    $$(document).on('click','.book-event-btn', function(){
        myApp.modal({
            title:  'Event Guidelines <i class="pull-right fa fa-times" id="guide-close"></i>',
            text: $('#event-guide').html()
        });
    });
    $$('.book-event-btn').click();
    $$(document).on('click','#guide-close', function(){
        myApp.closeModal();
    });
    componentHandler.upgradeDom();
    $('#startTime').timepicker({
        dropdown: false
    });
    $('#endTime').timepicker({
        dropdown: false
    });
    /*$('#startTime').timepicker({
        minuteStep: 1
    });
    $('#endTime').timepicker({
        minuteStep: 1
    });*/
    /*$('#startTime').clockpicker({
        default: 'now',
        placement: 'top',
        autoclose: true,
        vibrate: true,
        twelvehour: true,
        afterDone: function() {
            timeCheck();
        }
    });*/
    /*$('#endTime').clockpicker({
        default: 'now',
        placement: 'top',
        align:'right',
        autoclose: true,
        vibrate: true,
        twelvehour: true,
        afterDone: function() {
            timeCheck();
        }
    });*/
    var calendarDefault = myApp.calendar({
        input: '#eventDate',
        minDate: new Date(),
        closeOnSelect: true
    });
    var uploadVex = null;
    $$('.event-img-add-btn').touchend(function(){
        /*vex.dialog.buttons.YES.text = '';
        uploadVex = vex.dialog.open({
            unsafeMessage: '<label class="head-title">Add Cover Photo</label><br><br>'+"Upload your own photo or use one from Pixabay",
            showCloseButton: false,
            className: 'vex-theme-plain event-image-panel',
            input: [
                '<button type="button" id="upload-from-native" class="button button-fill common-app-btn my-fullWidth my-marginTop">Upload from Gallery</button>'+
                '<button type="button" id="upload-from-pixabay" class="button button-fill common-app-btn my-fullWidth my-marginTop">Use Pixabay Popup</button>'+
                '<button type="button" id="upload-from-pixabay-page" class="button button-fill common-app-btn my-fullWidth my-marginTop">Use Pixabay Page</button>'
            ].join('')
        });
        $('.event-image-panel .vex-dialog-input').addClass('my-NoMargin');
        $('.event-image-panel .vex-dialog-buttons').addClass('hide');*/
        $('#event-img-upload').click();
    });
    /*$$(document).on('touchend','#upload-from-native',function(){
        if(uploadVex != null)
        {
            vex.close(uploadVex);
        }
        $('#event-img-upload').click();
    });
    $$(document).on('touchend','#upload-from-pixabay', function(){
        if(uploadVex != null)
        {
            vex.close(uploadVex);
        }
        myApp.popup($('.pixabay-pop'));
    });*/
    $$(document).on('click','.event-img-remove', function(){
        filesArr = [];
        $$('.event-add .event-img-after .progressbar').removeClass('hide');
        $$('.event-add .event-img-after .event-img-remove').addClass('hide');
        $('.event-add .event-img-after').addClass('hide');
        $('.event-add .event-img-before').removeClass('hide');
        $$('.event-add #event-img-upload').val('');
        $$('.event-add .event-img-space').css({
           'background': '#EDEDEC'
        });
    });
    $$(document).on('keyup','#eventPrice', function(){
        var basic = 300;
        var inputVal = Number($(this).val());
        if(inputVal > 0)
        {
            var total = basic+inputVal;
            $$('.event-add .total-event-price').html(total);
            $$('.event-add input[name="eventPrice"]').val(total);
        }
        else
        {
            $$('.event-add .total-event-price').html(0);
            $$('.event-add input[name="eventPrice"]').val(0);
        }
    });
    $$(document).on('change','.event-add input[name="costType"]', function(){
        if($(this).val() == '1')
        {
            $('.event-add input[name="eventPrice"]').val(0);
            $('.event-add .total-event-price').html(0);
            $('.event-add #eventPrice').val(0).attr('disabled', 'disabled');
        }
        else
        {
            $('.event-add #eventPrice').removeAttr('disabled');
        }
    });

    $$(document).on('click','.event-add .my-mainMenuList .micDiv', function(){

        if($$(this).find('li').attr('disabled'))
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Pa System Available from 7 am to 11 am',
                hold:10*1000
            });
        }
    });
    $$(document).on('click','.event-add .my-mainMenuList .projDiv', function(){

        if($$(this).find('li').attr('disabled'))
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Projector Available from 7 am to 4 pm',
                hold:10*1000
            });
        }
    });

    $$(document).on('change','.event-add select[name="eventPlace"]', function(){
        if($$(this).val() != '' && $$('.event-add #eventDate').val() != '' && $$('.event-add input[name="startTime"]').val() != ''
         && $$('.event-add input[name="endTime"]').val() != '')
        {
            var postData = {
                'startTime' : $$('.event-add input[name="startTime"]').val(),
                'endTime' : $$('.event-add input[name="endTime"]').val(),
                'eventPlace' : $$(this).val(),
                'eventDate' : $$('.event-add #eventDate').val()
            };

            var errUrl = base_url+'checkEventSpace';
            $.ajax({
                type:"POST",
                dataType: 'json',
                url: base_url+'checkEventSpace',
                data: postData,
                success: function(data){
                    if(data.status === false)
                    {
                        vex.dialog.buttons.YES.text = 'Close';
                        vex.dialog.alert({
                            unsafeMessage: '<label class="head-title">Error!</label><br><br>'+data.errorMsg
                        });
                    }
                },
                error: function(xhr, status, error){
                    vex.dialog.buttons.YES.text = 'Close';
                    vex.dialog.alert({
                        unsafeMessage: '<label class="head-title">Error!</label><br><br>Some Error Occurred!'
                    });
                    var err = 'Url: '+errUrl+' StatusText: '+xhr.statusText+' Status: '+xhr.status+' resp: '+xhr.responseText;
                    saveErrorLog(err);
                }
            });
        }
    });

    $$(document).on('focusout','.event-add input[name="startTime"],.event-add input[name="endTime"]',function(){
        if($$('.event-add select[name="eventPlace"]').val() != '' && $$('.event-add #eventDate').val() != '' && $$('.event-add input[name="startTime"]').val() != ''
            && $$('.event-add input[name="endTime"]').val() != '')
        {
            var postData = {
                'startTime' : $$('.event-add input[name="startTime"]').val(),
                'endTime' : $$('.event-add input[name="endTime"]').val(),
                'eventPlace' : $$('.event-add select[name="eventPlace"]').val(),
                'eventDate' : $$('.event-add #eventDate').val()
            };

            var errUrl = base_url+'checkEventSpace';
            $.ajax({
                type:"POST",
                dataType: 'json',
                url: base_url+'checkEventSpace',
                data: postData,
                success: function(data){
                    if(data.status === false)
                    {
                        vex.dialog.buttons.YES.text = 'Close';
                        vex.dialog.alert({
                            unsafeMessage: '<label class="head-title">Error!</label><br><br>'+data.errorMsg
                        });
                    }
                },
                error: function(xhr, status, error){
                    vex.dialog.buttons.YES.text = 'Close';
                    vex.dialog.alert({
                        unsafeMessage: '<label class="head-title">Error!</label><br><br>Some Error Occurred!'
                    });
                    var err = 'Url: '+errUrl+' StatusText: '+xhr.statusText+' Status: '+xhr.status+' resp: '+xhr.responseText;
                    saveErrorLog(err);
                }
            });
        }
    });
    $$('.event-add form.ajax-submit').on('beforeSubmit', function (e) {
        e.preventDefault();
        var xhr = e.detail.xhr; // actual XHR object
        /*if($('.event-add input[name="attachment"]').val() == '')
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Cover Image Required!',
                hold:10*1000
            });
            xhr.abort();
            return false;
        }*/
        if($$('.event-add #eventName').val() == '')
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Event Name Required!',
                hold:10*1000
            });
            xhr.abort();
            return false;
        }
        if($$('.event-add #eventDesc').val() == '')
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Event Description Required!',
                hold:10*1000
            });
            xhr.abort();
            return false;
        }
        if($$('.event-add #eventPlace').val() == '')
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Event Place Required!',
                hold:10*1000
            });
            xhr.abort();
            return false;
        }
        if($$('.event-add #eventDate').val() == '')
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Event Date Required!',
                hold:10*1000
            });
            xhr.abort();
            return false;
        }
        if($$('.event-add #creatorName').val() == '')
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Organiser Name Required!',
                hold:10*1000
            });
            xhr.abort();
            return false;
        }
        if($$('.event-add #creatorPhone').val() == '')
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Organiser Phone Required!',
                hold:10*1000
            });
            xhr.abort();
            return false;
        }
        if($$('.event-add #creatorEmail').val() == '')
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Organiser Email Required!',
                hold:10*1000
            });
            xhr.abort();
            return false;
        }
        if(!$$('.event-add #tnc').is(':checked'))
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Please Agree To T&C!',
                hold:10*1000
            });
            xhr.abort();
            return false;
        }
        if($$('.event-add input[name="startTime"]').val() == '' || $$('.event-add input[name="endTime"]').val() == '')
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Start and End Time Required!',
                hold:10*1000
            });
            xhr.abort();
            return false;
        }

        /*var d = new Date($$('.event-add #eventDate').val());
        var startT = ConvertTimeformat('24',$$('.event-add input[name="startTime"]').val());
        var endT = ConvertTimeformat('24',$$('.event-add input[name="endTime"]').val());*/
        /*if(d.getDay() == 6 || d.getDay() == 0)
        {
            if(startT < "07:00")
            {
                myApp.addNotification({
                    title: 'Error!',
                    message: 'On weekends, events can be organised from 7 am to 2 pm!',
                    hold:10*1000
                });
                xhr.abort();
                return false;
            }
            if(endT > "14:00")
            {
                myApp.addNotification({
                    title: 'Error!',
                    message: 'On weekends, events can be organised from 7 am to 2 pm!',
                    hold:10*1000
                });
                xhr.abort();
                return false;
            }
        }
        else
        {
            if(startT < "07:00")
            {
                myApp.addNotification({
                    title: 'Error!',
                    message: 'On weekdays, events can be organised from 7 am to 6 pm!',
                    hold:10*1000
                });
                xhr.abort();
                return false;
            }
            if(endT > "18:00")
            {
                myApp.addNotification({
                    title: 'Error!',
                    message: 'On weekdays, events can be organised from 7 am to 6 pm!',
                    hold:10*1000
                });
                xhr.abort();
                return false;
            }
        }*/

        /*if(startT >= endT)
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Event Time is not proper!',
                hold:10*1000
            });
            xhr.abort();
            return false;
        }*/
        if(typeof cropData['imgUrl'] != 'undefined' && eventAddStatus === false)
        {
            xhr.abort();
            myApp.showIndicator();
            cropData['imgData'] = $('#img-container').cropper('getCroppedCanvas').toDataURL();
            var errUrl = base_url+'dashboard/cropEventImage';
            $.ajax({
                type:'POST',
                dataType:'json',
                url:base_url+'dashboard/cropEventImage',
                data:{data: cropData},
                success: function(data)
                {
                    myApp.hideIndicator();
                    if(data.status == 'error')
                    {
                        myApp.addNotification({
                            title: 'Error!',
                            message: data.message,
                            hold:10*1000
                        });
                        xhr.abort();
                        return false;
                    }
                    else
                    {
                        filesArr = [];
                        var uri = data.url.split('/');
                        filesArr.push(uri[uri.length-1]);
                        fillEventImgs();
                        eventAddStatus = true;
                        $$('.event-add .submit-event-btn').click();
                        //xhr.open();
                        //xhr.send();
                    }
                },
                error: function(xhr, status, error)
                {
                    myApp.hideIndicator();
                    myApp.addNotification({
                        title: 'Error!',
                        message: 'Some Error Occurred!',
                        hold:10*1000
                    });
                    xhr.abort();
                    var err = 'Url: '+errUrl+' StatusText: '+xhr.statusText+' Status: '+xhr.status+' resp: '+xhr.responseText;
                    saveErrorLog(err);
                    return false;
                }
            });
        }
        else if($('.event-add input[name="attachment"]').val() == '')
        {
            eventAddStatus = false;
            myApp.addNotification({
                title: 'Error!',
                message: 'Cover Image Required!',
                hold:10*1000
            });
            xhr.abort();
            return false;
        }
        else if(eventAddStatus === false)
        {
            fillEventImgs();
        }
        myApp.showIndicator();
    });
    $$('.event-add form.ajax-submit').on('submitted', function(e){
        setTimeout(function(){
            myApp.hideIndicator();
        },500);
        var data = e.detail.data;
        var objJSON = JSON.parse(data);
        if(objJSON.status === true)
        {
            vex.dialog.buttons.YES.text = 'Close';
            vex.dialog.alert({
                unsafeMessage: '<label class="head-title">Success</label><br><br>'+'Thank you for creating an event, ' +
                'We have sent you a confirmation email, please check for event status in My Events section.',
                callback: function(){
                    setTimeout(function(){
                        mainView.router.load({
                            url:'event_dash',
                            ignoreCache: true
                        });
                        myApp.showTab('#tab2');
                        /*mainView.router.back({
                            ignoreCache: true
                        });*/
                    },500);
                }
            });
            //alertDialog('Success','Thank you for creating an event, ' +
                //'We have send you an confirmation email, please check for event status in My Dashboard section.',true);
            //mainView.router.back();
        }
        else
        {
            vex.dialog.buttons.YES.text = 'Close';
            vex.dialog.alert({
                unsafeMessage: '<label class="head-title">Error!</label><br><br>'+objJSON.errorMsg
            });
            //alertDialog('Error!',objJSON.errorMsg, false);
        }
    });
});
$$(window).on('popstate', function(e){
    $('.pixabay-pop').each(function(i,val){
       myApp.closeModal(val);
    });
});
var eventEditStatus = false;
myApp.onPageInit('eventEdit', function (page) {
    // Do something here for "about" page
    appendScript(base_url+'asset/mobile/js/jquery.timepicker.min.js');
    appendScript(base_url+'asset/mobile/js/cropper.min.js');
    appendStyle(base_url+'asset/mobile/css/cropper.min.css');
    setTimeout(function(){
        myApp.hideIndicator();
    },500);
    $('.event-fab-btn').addClass('hide');
    if($('#isLoggedIn').val() == '0')
    {
        myApp.loginScreen();
    }
    $$(document).on('click','.book-event-btn', function(){
        myApp.modal({
            title:  'Event Guidelines <i class="pull-right fa fa-times" id="guide-close"></i>',
            text: $('#event-guide').html()
        });
    });
    $$(document).on('click','#guide-close', function(){
        myApp.closeModal();
    });
    componentHandler.upgradeDom();
    $('#startTime').timepicker({
        dropdown: false
    });
    $('#endTime').timepicker({
        dropdown: false
    });
    var calendarDefault = myApp.calendar({
        input: '#eventDate',
        minDate: new Date(),
        closeOnSelect: true
    });
    $$('.event-img-add-btn').touchend(function(){
        $('#event-img-upload').click();
    });
    $$(document).on('click','.event-img-remove', function(){
        filesArr = [];
        $$('.event-add .event-img-after .progressbar').removeClass('hide');
        $$('.event-add .event-img-after .event-img-remove').addClass('hide');
        $('.event-add .event-img-after').addClass('hide');
        $('.event-add .event-img-before').removeClass('hide');
        $$('.event-add #event-img-upload').val('');
        $$('.event-add .event-img-space').css({
            'background': '#EDEDEC'
        });
    });
    $$(document).on('keyup','#eventPrice', function(){
        var basic = 300;
        var feeVal = Number($('.event-add input[name="eventPrice"]').val());
        var inputVal = Number($(this).val());
        if(inputVal > 0)
        {
            var total = basic+inputVal;
            $$('.event-add .total-event-price').html(total);
            $$('.event-add input[name="eventPrice"]').val(total);
        }
        else
        {
            $$('.event-add .total-event-price').html(0);
            $$('.event-add input[name="eventPrice"]').val(feeVal);
        }
    });
    $$(document).on('change','.event-add input[name="costType"]', function(){
        if($(this).val() == '1')
        {
            $('.event-add input[name="eventPrice"]').val(0);
            $('.event-add .total-event-price').html(0);
            $('.event-add #eventPrice').val(0).attr('disabled', 'disabled');
        }
        else
        {
            $('.event-add #eventPrice').removeAttr('disabled');
        }
    });

    $$('.event-add form.ajax-submit').on('beforeSubmit', function (e) {
        e.preventDefault();
        var xhr = e.detail.xhr; // actual XHR object
        /*if($('.event-add input[name="attachment"]').val() == '')
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Cover Image Required!'
            });
            xhr.abort();
            return false;
        }*/
        if($$('.event-add #eventName').val() == '')
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Event Name Required!',
                hold:10*1000
            });
            xhr.abort();
            return false;
        }
        if($$('.event-add #eventDesc').val() == '')
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Event Description Required!',
                hold:10*1000
            });
            xhr.abort();
            return false;
        }
        /*if($$('.event-add #eventPlace').val() == '')
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Event Place Required!',
                hold:10*1000
            });
            xhr.abort();
            return false;
        }*/
        if($$('.event-add #eventDate').val() == '')
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Event Date Required!',
                hold:10*1000
            });
            xhr.abort();
            return false;
        }
        /*if($('.event-add #paidType').is(':checked') && $('.event-add #eventPrice').val() == '0')
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Paid Event Price Required!',
                hold:10*1000
            });
            xhr.abort();
            return false;
        }*/
        if($$('.event-add #creatorName').val() == '')
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Organiser Name Required!',
                hold:10*1000
            });
            xhr.abort();
            return false;
        }
        if($$('.event-add #creatorPhone').val() == '')
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Organiser Phone Required!',
                hold:10*1000
            });
            xhr.abort();
            return false;
        }
        if($$('.event-add #creatorEmail').val() == '')
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Organiser Email Required!',
                hold:10*1000
            });
            xhr.abort();
            return false;
        }
        if(!$$('.event-add #tnc').is(':checked'))
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Please Agree To T&C!',
                hold:10*1000
            });
            xhr.abort();
            return false;
        }
        if($$('.event-add input[name="startTime"]').val() == '' || $$('.event-add input[name="endTime"]').val() == '')
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Start and End Time Required!',
                hold:10*1000
            });
            xhr.abort();
            return false;
        }

        /*var d = new Date($$('.event-add #eventDate').val());
        var startT = ConvertTimeformat('24',$$('.event-add input[name="startTime"]').val());
        var endT = ConvertTimeformat('24',$$('.event-add input[name="endTime"]').val());*/
        /*if(d.getDay() == 6 || d.getDay() == 0)
        {
            if(startT < "07:00")
            {
                myApp.addNotification({
                    title: 'Error!',
                    message: 'On weekends, events can be organised from 7 am to 2 pm!',
                    hold:10*1000
                });
                xhr.abort();
                return false;
            }
            if(endT > "14:00")
            {
                myApp.addNotification({
                    title: 'Error!',
                    message: 'On weekends, events can be organised from 7 am to 2 pm!',
                    hold:10*1000
                });
                xhr.abort();
                return false;
            }
        }
        else
        {
            if(startT < "07:00")
            {
                myApp.addNotification({
                    title: 'Error!',
                    message: 'On weekdays, events can be organised from 7 am to 6 pm!',
                    hold:10*1000
                });
                xhr.abort();
                return false;
            }
            if(endT > "18:00")
            {
                myApp.addNotification({
                    title: 'Error!',
                    message: 'On weekdays, events can be organised from 7 am to 6 pm!',
                    hold:10*1000
                });
                xhr.abort();
                return false;
            }
        }*/

        /*if(startT > endT)
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Event Time is not proper!',
                hold:10*1000
            });
            xhr.abort();
            return false;
        }*/
        if(typeof cropData['imgUrl'] != 'undefined' && eventEditStatus === false)
        {
            xhr.abort();
            myApp.showIndicator();
            cropData['imgData'] = $('#img-container').cropper('getCroppedCanvas').toDataURL();
            var errUrl = base_url+'dashboard/cropEventImage';
            $.ajax({
                type:'POST',
                dataType:'json',
                url:base_url+'dashboard/cropEventImage',
                data:{data: cropData},
                success: function(data)
                {
                    myApp.hideIndicator();
                    if(data.status == 'error')
                    {
                        myApp.addNotification({
                            title: 'Error!',
                            message: data.message,
                            hold:10*1000
                        });
                        xhr.abort();
                        return false;
                    }
                    else
                    {
                        filesArr = [];
                        var uri = data.url.split('/');
                        filesArr.push(uri[uri.length-1]);
                        fillEventImgs();
                        eventEditStatus = true;
                        $$('.event-add .submit-event-btn').click();
                        //xhr.open();
                        //xhr.send();
                    }
                },
                error: function(xhr, status, error)
                {
                    myApp.hideIndicator();
                    myApp.addNotification({
                        title: 'Error!',
                        message: 'Some Error Occurred!',
                        hold:10*1000
                    });
                    xhr.abort();
                    var err = 'Url: '+errUrl+' StatusText: '+xhr.statusText+' Status: '+xhr.status+' resp: '+xhr.responseText;
                    saveErrorLog(err);
                    return false;
                }
            });
        }
        else if($('.event-add input[name="attachment"]').val() == '')
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Cover Image Required!',
                hold:10*1000
            });
            xhr.abort();
            return false;
        }
        else if(eventEditStatus === false)
        {
            fillEventImgs();
        }
        myApp.showIndicator();
    });
    $$('.event-add form.ajax-submit').on('submitted', function(e){
        setTimeout(function(){
            myApp.hideIndicator();
        },500);
        var data = e.detail.data;
        var objJSON = JSON.parse(data);
        if(objJSON.status === true)
        {
            if(objJSON.noChange === true)
            {
                mainView.router.refreshPreviousPage();
                vex.dialog.buttons.YES.text = 'Close';
                vex.dialog.alert({
                    unsafeMessage: '<label class="head-title">Information</label><br><br>'+'No Changes Found!',
                    callback: function(){
                        setTimeout(function(){
                            mainView.router.back({
                                ignoreCache: true
                            });
                        },500);
                    }
                });
            }
            else
            {
                mainView.router.refreshPreviousPage();
                vex.dialog.buttons.YES.text = 'Close';
                vex.dialog.alert({
                    unsafeMessage: '<label class="head-title">Success</label><br><br>'+'Your event is now in review state, ' +
                    'We will sent you mail once review is done, you can check for event status in My Events section.',
                    callback: function(){
                        setTimeout(function(){
                            mainView.router.back({
                                ignoreCache: true
                            });
                        },500);
                    }
                });
            }
            //alertDialog('Success!', 'Your event is now in review state, ' +
                //'We will send you mail once review is done, you can check for event status in My Events section.',true);

        }
        else
        {
            vex.dialog.buttons.YES.text = 'Close';
            vex.dialog.alert({
                unsafeMessage: '<label class="head-title">Error!</label><br><br>'+objJSON.errorMsg
            });
            //alertDialog('Error!',objJSON.errorMsg, false);
        }
    });
});
myApp.onPageInit('contactPage', function(page){
    setTimeout(function(){
        myApp.hideIndicator();
    },500);
    $('.event-fab-btn').addClass('hide');
});
myApp.onPageInit('jukeboxPage', function(page){
    setTimeout(function(){
        myApp.hideIndicator();
    },500);
    $('.event-fab-btn').addClass('hide');

    if(typeof $('#offlineTaps').val() != 'undefined')
    {
        var taps = $('#offlineTaps').val();
        if(taps != '')
        {
            if(localStorageUtil.getLocal('jukeboxNotify') == null || localStorageUtil.getLocal('jukeboxNotify') == '0')
            {
                localStorageUtil.setLocal('jukeboxNotify','1');
                myApp.addNotification({
                    title: 'Info!',
                    message: taps+' Taproom(s) Jukebox is currently offline!',
                    hold:10*1000
                });
            }
        }
    }

    $$(document).on('click','.taproom-btn', function(){
        myApp.showIndicator();
    });

});
myApp.onPageInit('taproomPage', function(page){

    setTimeout(function(){
        myApp.hideIndicator();
    },500);
    $('.event-fab-btn').addClass('hide');

    $$(document).on('click','.taproom-page .music-request-btn', function(){
        var tapId = $$('.taproom-page #taproom-Id').val();
        myApp.showIndicator();
        mainView.router.load({
            url:'songlist/'+tapId,
            ignoreCache: true
        });
    });

    $$(document).on('click','.page-refresh-btn', function(){
        myApp.showIndicator();
        mainView.router.refreshPage();
    });

});
myApp.onPageReinit('taproomPage', function(page) {
    setTimeout(function(){
        myApp.hideIndicator();
    },500);
});
myApp.onPageInit('songlist', function(page){

    appendScript(base_url+'asset/js/list.min.js');
    //appendScript(base_url+'asset/mobile/js/jquery.geolocation.min.js');
    setTimeout(function(){
        myApp.hideIndicator();
    },500);
    if(typeof FB != 'undefined')
    {
        FB.XFBML.parse();
    }

    if(typeof $$('#jukebx-form').html() != 'undefined')
    {
        renderButton();
    }
    else
    {
        $('.logout-menu-item').removeClass('hide');
        $('.logout-menu-item').show();
    }
    $('.event-fab-btn').addClass('hide');

    $$(document).on('change','.tapSong-page input[name="hasjukebox"]', function(){
        if($(this).is(':checked'))
        {
            $$('.jukepass-wrapper').removeClass('hide');
        }
        else
        {
            $$('.jukepass-wrapper').addClass('hide');
        }
    });

    //Signup
    $$('.tapSong-page #jukebox-signup').on('beforeSubmit', function (e) {
        e.preventDefault();
        var xhr = e.detail.xhr;
        if($$('.tapSong-page #jukebox-signup input[name="username"]').val() == '')
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Username Required!'
            });
            xhr.abort();
        }
        if($$('.tapSong-page #jukebox-signup input[name="mobNum"]').val() == '')
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Mobile Number Required!'
            });
            xhr.abort();
        }
        if($('.tapSong-page input[name="hasjukebox"]').is(':checked'))
        {
            if($$('.tapSong-pge input[name="jukepass"]').val() == '')
            {
                myApp.addNotification({
                    title: 'Error!',
                    message: 'Jukebox Password Required!'
                });
                xhr.abort();
            }
        }
        setTimeout(function(){
            myApp.hideIndicator();
        },500);
    });
    $$('.tapSong-page #jukebox-signup').on('submitted', function(e){
        var data = e.detail.data;
        var objJSON = JSON.parse(data);
        if(objJSON.status === true)
        {
            $('.iosHome .user-settings').removeClass('hide');
            mainView.router.refreshPage();
            mainView.router.refreshPreviousPage();
        }
        else
        {
            vex.dialog.buttons.YES.text = 'Close';
            vex.dialog.alert({
                unsafeMessage: '<label class="head-title">Error!</label><br><br>'+objJSON.errorMsg
            });
            //alertDialog('Error!',objJSON.errorMsg, false);
        }
        setTimeout(function(){
            myApp.hideIndicator();
        },500);
    });

    //Login
    $$('.tapSong-page #jukebox-login').on('beforeSubmit', function (e) {
        e.preventDefault();
        setTimeout(function(){
            myApp.hideIndicator();
        },500);
        var xhr = e.detail.xhr;
        if($$('.tapSong-page #jukebox-login input[name="username"]').val() == '')
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Username Required!'
            });
            xhr.abort();
        }
        if($$('.tapSong-page #jukebox-login input[name="password"]').val() == '')
        {
            myApp.addNotification({
                title: 'Error!',
                message: 'Password Required!'
            });
            xhr.abort();
        }
    });
    $$('.tapSong-page #jukebox-login').on('submitted', function(e){
        setTimeout(function(){
            myApp.hideIndicator();
        },500);
        var data = e.detail.data;
        var objJSON = JSON.parse(data);
        if(objJSON.status === true)
        {
            $('.iosHome .user-settings').removeClass('hide');
            mainView.router.refreshPage();
        }
        else
        {
            vex.dialog.buttons.YES.text = 'Close';
            vex.dialog.alert({
                unsafeMessage: '<label class="head-title">Error!</label><br><br>'+objJSON.errorMsg
            });
            //alertDialog('Error!',objJSON.errorMsg, false);
        }
    });

    $$('.request_song_btn').on('click', function(e){
        e.preventDefault();
        var currentId = $$(this).attr('data-songId');
        var tapId = $$(this).attr('data-tapId');
        var song = $$(this);
        $.geolocation.get({
            win: function(position)
            {
                jukeLat = position.coords.latitude;
                jukeLong = position.coords.longitude;
                myApp.showIndicator();
                var postData = {
                    'songId': currentId,
                    'tapId': tapId,
                    'location': jukeLong+','+jukeLat
                };
                var errUrl = base_url+'main/playTapSong';
                $.ajax({
                    type:'POST',
                    dataType:'json',
                    url: base_url+'main/playTapSong',
                    data:postData,
                    success: function(data){
                        if(data.status === true)
                        {
                            $$(song).addClass('hide');
                            myApp.hideIndicator();
                            myApp.addNotification({
                                title: 'Success!',
                                message: 'Your Song Queued.'
                            });
                            /*vex.dialog.buttons.YES.text = 'Close';
                            vex.dialog.alert({
                                unsafeMessage: '<label class="head-title">Success!</label><br><br>Your Song Queued.'
                            });*/
                        }
                        else if(data.errorNum == '1')
                        {
                            myApp.hideIndicator();
                            vex.dialog.buttons.YES.text = 'Close';
                            vex.dialog.alert({
                                unsafeMessage: '<label class="head-title">Error!</label><br><br>'+data.errorMsg,
                                callback: function(){
                                    setTimeout(function(){
                                        mainView.router.load({
                                            url:'jukebox',
                                            ignoreCache: true
                                        });
                                    },500);
                                }
                            });

                        }
                        else if(data.errorNum == '2')
                        {
                            myApp.hideIndicator();
                            alert(data.errorMsg);
                        }
                    },
                    error: function(xhr, status, error){
                        myApp.hideIndicator();
                        vex.dialog.buttons.YES.text = 'Close';
                        vex.dialog.alert({
                            unsafeMessage: '<label class="head-title">Error!</label><br><br>Some Error Occurred!'
                        });
                        var err = 'Url: '+errUrl+' StatusText: '+xhr.statusText+' Status: '+xhr.status+' resp: '+xhr.responseText;
                        saveErrorLog(err);
                    }
                });

                //console.log(position);
                //$$('.juke_status').html(position.coords.latitude + ", " + position.coords.longitude);
            },
            fail: function (error) {
                console.log(error);
                vex.dialog.buttons.YES.text = 'Close';
                vex.dialog.alert({
                    unsafeMessage: '<label class="head-title">Error!</label><br><br>'+getGeoError(error.code)
                });
            }
        });

    });
    $$(document).on('click','#music-logout-btn', function(){
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
            console.log('User signed out.');
        });
        myApp.showIndicator();
        var errUrl = base_url+'main/appLogout';
        $$.ajax({
            method:"GET",
            url: base_url+'main/appLogout',
            cache: false,
            dataType: 'json',
            success: function(data){
                myApp.hideIndicator();
                if(data.status === true)
                {
                    $('.iosHome .user-settings').addClass('hide');
                    mainView.router.refreshPage();
                }
            },
            error: function(xhr, status, error){
                myApp.hideIndicator();
                myApp.addNotification({
                    title: 'Error!',
                    message: 'Some Error Occurred!'
                });
                var err = 'Url: '+errUrl+' StatusText: '+xhr.statusText+' Status: '+xhr.status+' resp: '+xhr.responseText;
                saveErrorLog(err);
            }
        });
    });
    $(document).on('keyup','#sample1', function(){
        var keyText = $(this).val();
        var tapId = $('#taproomId').val();
        if(keyText != '' && $('.my-song-list li').length == 0)
        {
            $.ajax({
                type:'POST',
                dataType:'json',
                url:base_url+'main/saveMusicSearch',
                data:{searchText:keyText,tapId:tapId,fromWhere:'Mobile'},
                success: function(data){

                },
                error: function()
                {

                }
            });
        }
    });
    var monkeyList = new List('song-list', {
        valueNames: ['item-title','item-subtitle'],
        page: 20,
        pagination: true
    });
    componentHandler.upgradeDom();
});
myApp.onPageBeforeAnimation('comming-up', function (page) {
    if (page.from === 'left') {
        $('.event-fab-btn').removeClass('hide');
        renderCalendar();
    }
});

function checkForUrl()
{
    var url = $('#currentUrl').val();
    if(url == '/')
    {
        tabToShow = '#tab1';
        /*if(url.indexOf('events') != -1 || url.indexOf('create_event') != -1 || url.indexOf('event_dash') != -1
            || url.indexOf('eventEdit') != -1 || url.indexOf('event_details') != -1 || url.indexOf('contact_us') != -1
            || url.indexOf('jukebox') != -1 || url.indexOf('taprom') != -1 || url.indexOf('songlist') != -1)
        {
            console.log('under url ' + url);

        }*/
    }
    else if(url.indexOf('filter_events') != -1)
    {
        url = url.replace('/?page/','');
        tabToShow = '#tab2';
        $.ajax({
            type:'GET',
            url:url,
            dataType:'json',
            success: function(data)
            {
                if(data.status === true)
                {
                    if(typeof data.locId != 'undefined')
                    {
                        var locId = data.locId;
                        $('#even-'+locId).click();
                    }
                }
            },
            error: function()
            {
                console.log('error');
            }
        });
    }
    else if(url.indexOf('fnbshare') != -1 || url.indexOf('fnb') != -1)
    {
        tabToShow = '#tab3';
    }
}

$$(document).on('click','.yes-age-btn', function(){
    myApp.showIndicator();
    var ageTimeout = setInterval(function(){
        $('.view.tab').each(function(i,val){
            if($(val).hasClass('active'))
            {
                clearInterval(ageTimeout);
                myApp.hideIndicator();
                localStorageUtil.setLocal('ageGateGone','1');
                welcomescreen.close();
                /*if(tabToShow == '#tab1')
                {
                    $$('.my-fab-btn').removeClass('hide');
                }*/
                if(tabToShow == '#tab2' && $('#currentUrl').val() == '/')
                {
                    $$('.event-fab-btn').removeClass('hide');
                }
            }
        });
    },1000);
});
$$(document).on('click','.no-age-btn', function(){
    window.location.href='http://www.amuldairy.com';
});
var isRegistered = false;
$$(window).on('load', function (e) {
    setTimeout(function(){
        //myApp.hideIndicator();
        checkForUrl();
        /*if(localStorageUtil.getLocal('onWhichTab') != null && $('#currentUrl').val() == '/')
        {
            tabToShow = localStorageUtil.getLocal('onWhichTab');
        }*/
        myApp.showTab(tabToShow);
        localStorageUtil.setLocal('jukeboxNotify','0');
        if(localStorageUtil.getLocal('ageGateGone') != null)
        {
            welcomescreen.close();
            /*if(tabToShow == '#tab1')
            {
                $$('.my-fab-btn').removeClass('hide');
            }*/
            if(tabToShow == '#tab2' && $('#currentUrl').val() == '/')
            {
                $$('.event-fab-btn').removeClass('hide');
            }
        }
        if($$('#MojoStatus').val() == '1' || $('#eventsHigh').val() == '1')
        {
            mainView.router.refreshPreviousPage();
            vex.dialog.buttons.YES.text = 'Close';
            vex.dialog.alert({
                unsafeMessage: '<label class="head-title">Success</label><br><br>'+'Congrats! You have successfully registered for the event, please find the details in My Events section'
            });
            //alertDialog('Success!','Congrats! You have successfully registered for the event, please find the details in My Events section',false);
            myApp.showIndicator();
            isRegistered = true;
            mainView.router.load({
                url:'event_dash',
                ignoreCache: true
            });
            myApp.showTab('#tab2');
        }
        else if($$('#MojoStatus').val() == '2' || $('#eventsHigh').val() == '2')
        {
            vex.dialog.buttons.YES.text = 'Close';
            vex.dialog.alert({
                unsafeMessage: '<label class="head-title">Failed!</label><br><br>'+'Some Error occurred! Please try again!'
            });
            //alertDialog('Failed!','Some Error occurred! Please try again!',false);
        }

        //Render weekly calendar
        renderCalendar();
        //Check fnb share set
        if(typeof $('#fnbShareId') !== 'undefined')
        {
            $('#tab3 .demo-card-header-pic').each(function(i,val){
                var fnbId = $(val).attr('data-fnbid');
                if($('#fnbShareId').val() == fnbId)
                {
                    var pos = $(val).position();
                    $('#tab3 .page-content').animate({
                        scrollTop: pos.top - 50
                    });
                    if(typeof $(val).attr('data-img') !== 'undefined')
                    {
                        $(val).trigger('click');
                    }
                    return false;
                }
            });
        }
    },1000);

    setTimeout(function(){
        //Checking for special event
        var specialEve = '';
        $('#tab2 .event-section div.demo-card-header-pic').each(function(i,val){
            if($(val).hasClass('eve-special'))
            {
                specialEve = $(val);
                $(val).remove();
                return false;
            }
        });
        if(specialEve != '')
        {
            $('#tab2 .event-section').prepend(specialEve);
        }
    },500);
    //checkForUrl();
    /*setTimeout(function(){
        $('#calendar-glance').fullCalendar('render');
    },1000);*/
    /*document.querySelector('.my-fb-label').MaterialCheckbox.check();
    document.querySelector('.my-tw-label').MaterialCheckbox.check();
    document.querySelector('.my-insta-label').MaterialCheckbox.check();*/
});
$(document).on('click','#tab2 #calendar-glance .fc-day-grid-event.fc-event', function(){
    var srcTitle = $(this).find('span').html();
    $('#tab2 .event-section .demo-card-header-pic').each(function(i,val){
        if($(val).attr('data-eveTitle') == srcTitle)
        {
            var pos = $(val).position();
            $('#tab2 .page-content').animate({
                scrollTop: pos.top - 50
            });
            return false;
        }
    });
});

$(document).on('click','#tab3 .show-full-beer-card', function(){
    var title = $(this).attr('data-title');
    var description = $(this).attr('data-descrip');
    var fullPrice = $(this).attr('data-fullprice');
    var halfPrice = $(this).attr('data-halfprice');
    var beerImg = $(this).attr('data-img');
    var shareLink = $(this).attr('data-sharelink');

    var myCardHtml = '<div class="row clear">' +
                    '<div class="col-100">' +
                    '<img src="'+beerImg+'" alt="beer" class="mainFeed-img"/>'+
                    '</div></div>'+
                    '<div class="card-content">' +
                    '<div class="card-content-inner">' +
                    '<p class="pull-left card-ptag">'+title+'</p>'+
                    '<input type="hidden" data-name="'+title+'" value="'+shareLink+'"/>'+
                    '<i class="ic_me_share_icon pull-right event-share-icn fnb-card-share-btn"></i>'+
                    '<div class="comment more content-block clear">'+description+'</div></div>';

    vex.dialog.buttons.YES.text = 'Close';
    vex.dialog.open({
        unsafeMessage: myCardHtml,
        showCloseButton: false,
        contentClassName: 'beer-overlay-pop'
    });
    /*myApp.modal({
        title:  '<i class="pull-right fa fa-times" id="guide-close"></i>',
        text: myCardHtml
    });*/

});
/*var myElement1 = document.getElementById('my-page1');
var myElement2 = document.getElementById('my-page2');
var myElement3 = document.getElementById('my-page3');
var mc1 = new Hammer(myElement1);
var mc2 = new Hammer(myElement2);
var mc3 = new Hammer(myElement3);

mc1.on("swipeleft", function(ev) {
    if(ev.target != myElement1 && ev.isFirst === false)
    {
        ev.preventDefault();
    }
    else
    {
        myApp.showTab('#tab2');
    }
});

mc2.on("swipeleft swiperight", function(ev) {

    if(ev.type == "swipeleft")
    {
        myApp.showTab('#tab3');
    }
    else
    {
        myApp.showTab('#tab1');
    }
});

mc3.on("swiperight", function(ev) {
    if(ev.target != myElement3 && ev.isFirst === false)
    {
        ev.preventDefault();
    }
    else
    {
        myApp.showTab('#tab2');
    }
});*/

var lastIndex = 5;
var maxItems = $$('.custom-accordion .my-card-items').length;
var itemsPerLoad = 5;
var loading = false;
var lastFetched = 1;
var alreadyFetchingFeeds = false;

// Attach 'infinite' event handler
$$('.infinite-scroll').on('infinite', function () {

    // Exit, if loading in progress
    if (loading) return;
    loading = true;

    // Emulate 1s loading
    setTimeout(function () {
        // Reset loading flag
        loading = false;

        var totalToLoad = lastIndex + itemsPerLoad;
        if(totalToLoad > maxItems)
        {
            totalToLoad = maxItems;
        }
        for (var i = lastIndex; i < totalToLoad; i++) {
            $$($$('.custom-accordion .my-card-items')[i]).removeClass('hide');
            $('.my-card-items').each(function(i,val){
                if(!$(this).hasClass('hide'))
                {
                    if(typeof $(this).find('.my-link-url').val() !== 'undefined')
                    renderLinks($(this).find('.my-link-url'));
                }
                //renderLinks(val);
            });
        }

        // Update last loaded index
        lastIndex = totalToLoad;
        if (lastIndex >= maxItems) {
            getMeMoreFeeds(lastFetched);
        }
    }, 1000);
});

var foundMoreFeeds = false;
function getMeMoreFeeds(lastNum)
{
    if(!alreadyFetchingFeeds)
    {
        alreadyFetchingFeeds = true;
        $.ajax({
            type:'GET',
            dataType:'json',
            url:base_url+'main/getMoreFeeds/'+lastNum,
            success: function(data)
            {
                alreadyFetchingFeeds = false;
                if(data.status == true)
                {
                    lastFetched += 1;
                    foundMoreFeeds = true;
                    appendCards(data.moreFeeds);
                }
                else
                {
                    // Nothing more to load, detach infinite scroll events to prevent unnecessary loadings
                    myApp.detachInfiniteScroll($$('.infinite-scroll'));
                    // Remove preloader
                    $$('.infinite-scroll-preloader').remove();
                }
            },
            error: function(){
                alreadyFetchingFeeds = false;
                console.log('error');
                // Nothing more to load, detach infinite scroll events to prevent unnecessary loadings
                myApp.detachInfiniteScroll($$('.infinite-scroll'));
                // Remove preloader
                $$('.infinite-scroll-preloader').remove();
            }
        });
    }
}
function appendCards(data)
{
    var ifUpdate = false;
    var totalNew = 0;
    var oldHeight = $('.custom-accordion').height();
    var currData = '';

    for(var i=0;i<data.length;i++) //for(var i=(data.length-1);i>=0;i--)
    {
        currData = i;
        try
        {
            if(typeof data[i] != 'object')
            {
                data[i] = eval('('+data[i]+')');
            }
            switch(data[i]['socialType'])
            {
                case 'i':
                    var truncated_RestaurantName ='';
                    if(data[i]['unformatted_message'] != null)
                    {
                        var urlRegex =/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
                        var backupLink = urlRegex.exec(data[i]['unformatted_message']);
                        data[i]['unformatted_message'] = data[i]['unformatted_message'].replace(urlRegex,'');

                        data[i]['unformatted_message'] = data[i]['unformatted_message'].replace(/(#[a-z\d-]+)/ig,"<label>$1</label>");
                        data[i]['unformatted_message'] = data[i]['unformatted_message'].replace(/(@[a-z\d-]+)/ig,"<label>$1</label>");
                        if(data[i]['unformatted_message'].length > 140)
                        {
                            truncated_RestaurantName = data[i]['unformatted_message'].substr(0,140)+'..';
                        }
                        else
                        {
                            truncated_RestaurantName = data[i]['unformatted_message'];
                        }
                    }
                    else
                    {
                        truncated_RestaurantName = '';
                    }
                    var bigCardHtml = '';
                    bigCardHtml += '<a href="'+data[i]['full_url']+'" target="_blank" class="external instagram-wrapper">';
                    bigCardHtml += '<div class="my-card-items new-post-wrapper hide"><div class="card demo-card-header-pic">';
                    bigCardHtml += '<div class="card-content"><div class="card-content-inner">';
                    bigCardHtml += '<div class="list-block media-list"><ul><li><div class="item-content">';
                    bigCardHtml += '<div class="item-media"><img class="myAvtar-list" src="'+data[i]['poster_image']+'" width="44"/></div>';
                    bigCardHtml += '<div class="item-inner"><div class="item-title-row">';
                    bigCardHtml += '<div class="item-title">'+data[i]['poster_name'].capitalize()+'</div>';
                    bigCardHtml += '<i class="fa fa-instagram social-icon-gap"></i></div>';
                    if(data[i].hasOwnProperty('source'))
                    {
                        if(data[i]['source']['term_type'] == 'hashtag')
                        {
                            bigCardHtml += '<div class="item-subtitle">#'+data[i]['source']['term'];
                            bigCardHtml += '<time class="timeago time-stamp" datetime="'+data[i]['created_at']+'"></time></div>';
                            //bigCardHtml += '<span class="time-stamp"></span></div>'
                        }
                        else if(data[i]['source']['term_type'] == 'location')
                        {
                            bigCardHtml += '<div class="item-subtitle">'+getInstaLoc(data[i]['source']['term']);
                            bigCardHtml += '<time class="timeago time-stamp" datetime="'+data[i]['created_at']+'"></time></div>';
                            //bigCardHtml += '<span class="time-stamp"></span></div>'
                        }
                        else
                        {
                            bigCardHtml += '<div class="item-subtitle">@'+data[i]['source']['term'];
                            bigCardHtml += '<time class="timeago time-stamp" datetime="'+data[i]['created_at']+'"></time></div>';
                        }
                    }
                    bigCardHtml += '</div></div></li></ul></div>';
                    if(data[i].hasOwnProperty('image'))
                    {
                        bigCardHtml += '<div class="row no-gutter feed-image-container">';
                        bigCardHtml += '<div class="col-100">';
                        bigCardHtml += '<img src="'+data[i]['image']+'" class="mainFeed-img"/>';
                        bigCardHtml += '</div></div>';
                    }
                    else if(data[i].hasOwnProperty('video'))
                    {
                        if(data[i]['video'].indexOf('youtube') != -1 || data[i]['video'].indexOf('youtu.be') != -1)
                        {
                            bigCardHtml += '<div class="row no-gutter feed-image-container">';
                            bigCardHtml += '<div class="col-100">';
                            bigCardHtml += '<iframe width="100%" src="'+data[i]['video']+'" frameborder="0" allowfullscreen>';
                            bigCardHtml += '</iframe></div></div>';
                        }
                        else
                        {
                            bigCardHtml += '<div class="row no-gutter feed-image-container">';
                            bigCardHtml += '<div class="col-100">';
                            bigCardHtml += '<video width="100%" controls>';
                            bigCardHtml += '<source src="'+data[i]['video']+'">No Video found!';
                            bigCardHtml += '</video></div></div>';
                        }
                    }
                    else if(typeof backupLink !== 'undefined')
                    {
                        bigCardHtml += '<div class="link-card-wrapper">';
                        bigCardHtml += '<input type="hidden" class="my-link-url" value="'+backupLink[0]+'"/>';
                        bigCardHtml += '<div class="liveurl feed-image-container hide">';
                        bigCardHtml += '<img src="" class="link-image mainFeed-img lazy lazy-fadein"/>';
                        bigCardHtml += '<div class="details"><div class="title"></div><div class="description"></div>';
                        bigCardHtml += '</div></div></div>';
                    }

                    bigCardHtml += '<p class="final-card-text">'+truncated_RestaurantName+'</p>';
                    bigCardHtml += '</div></div></div></a>';

                    $('.custom-accordion').append(bigCardHtml);

                    totalNew++;
                    break;
                case 'f':

                    var urlRegex =/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
                    var backupLink = urlRegex.exec(data[i]['message']);
                    var truncated_RestaurantName ='';
                    data[i]['message'] = data[i]['message'].replace(urlRegex,'');

                    data[i]['message'] = data[i]['message'].replace(/(#[a-z\d-]+)/ig,"<label>$1</label>");
                    data[i]['message'] = data[i]['message'].replace(/(@[a-z\d-]+)/ig,"<label>$1</label>");
                    if(data[i]['message'].length > 140)
                    {
                        truncated_RestaurantName = data[i]['message'].substr(0,140)+'..';
                    }
                    else
                    {
                        truncated_RestaurantName = data[i]['message'];
                    }
                    var bigCardHtml = '';
                    bigCardHtml += '<a href="'+data[i]['permalink_url']+'" target="_blank" class="external facebook-wrapper">';
                    bigCardHtml += '<div class="my-card-items new-post-wrapper hide"><div class="card demo-card-header-pic">';
                    bigCardHtml += '<div class="card-content"><div class="card-content-inner">';
                    bigCardHtml += '<div class="list-block media-list"><ul><li><div class="item-content">';
                    bigCardHtml += '<div class="item-media"><img class="myAvtar-list" src="https://graph.facebook.com/v2.7/'+data[i]['from']['id']+'/picture" width="44"/></div>';
                    bigCardHtml += '<div class="item-inner"><div class="item-title-row">';
                    bigCardHtml += '<div class="item-title">'+data[i]['from']['name'].capitalize()+'</div>';
                    bigCardHtml += '<i class="fa fa-facebook social-icon-gap"></i></div>';
                    bigCardHtml += '<div class="item-subtitle">';
                    bigCardHtml += '<time class="timeago time-stamp" datetime="'+data[i]['created_at']+'"></time></div>';
                    /*if(data[i].hasOwnProperty('source'))
                     {
                     if(data[i]['source']['term_type'] == 'hashtag')
                     {
                     bigCardHtml += '<div class="item-subtitle">#'+data[i]['source']['term']+'</div>';
                     }
                     else
                     {
                     bigCardHtml += '<div class="item-subtitle">@'+data[i]['source']['term']+'</div>';
                     }
                     }*/
                    bigCardHtml += '</div></div></li></ul></div>';
                    if(data[i].hasOwnProperty('picture'))
                    {
                        bigCardHtml += '<div class="row no-gutter feed-image-container">';
                        bigCardHtml += '<div class="col-100">';
                        bigCardHtml += '<img src="'+data[i]['picture']+'" class="mainFeed-img"/>';
                        bigCardHtml += '</div></div>';
                    }
                    else if(data[i].hasOwnProperty('source'))
                    {
                        if(data[i]['source'].indexOf('youtube') != -1 || data[i]['source'].indexOf('youtu.be') != -1)
                        {
                            bigCardHtml += '<div class="row no-gutter feed-image-container">';
                            bigCardHtml += '<div class="col-100">';
                            bigCardHtml += '<iframe width="100%" src="'+data[i]['source']+'" frameborder="0" allowfullscreen>';
                            bigCardHtml += '</iframe></div></div>';
                        }
                        else
                        {
                            bigCardHtml += '<div class="row no-gutter feed-image-container">';
                            bigCardHtml += '<div class="col-100">';
                            bigCardHtml += '<video width="100%" controls>';
                            bigCardHtml += '<source src="'+data[i]['source']+'">No Video found!';
                            bigCardHtml += '</video></div></div>';
                        }
                    }
                    else if(typeof backupLink !== 'undefined' && backupLink != null)
                    {
                        bigCardHtml += '<div class="link-card-wrapper">';
                        bigCardHtml += '<input type="hidden" class="my-link-url" value="'+backupLink[0]+'"/>';
                        bigCardHtml += '<div class="liveurl feed-image-container hide">';
                        bigCardHtml += '<img src="" class="link-image mainFeed-img lazy lazy-fadein"/>';
                        bigCardHtml += '<div class="details"><div class="title"></div><div class="description"></div>';
                        bigCardHtml += '</div></div></div>';
                    }

                    bigCardHtml += '<p class="final-card-text">'+truncated_RestaurantName+'</p>';
                    bigCardHtml += '</div></div></div></a>';
                    /*var oldHeight = $('.custom-accordion').height();
                     $('.custom-accordion').prepend(bigCardHtml);
                     var total = currentPos+($('.custom-accordion').height()- oldHeight);
                     $('.page-content').scrollTop(total);*/
                    $('.custom-accordion').append(bigCardHtml);
                    totalNew++;
                    break;
                case 't':

                    var urlRegex =/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
                    //var httpPattern = "!(http|ftp|scp)(s)?:\/\/[a-zA-Z0-9.?%=&_/]+!";
                    var truncated_RestaurantName ='';
                    data[i]['text'] = data[i]['text'].replace(urlRegex,'');

                    data[i]['text'] = data[i]['text'].replace(/(#[a-z\d-]+)/ig,"<label>$1</label>");
                    data[i]['text'] = data[i]['text'].replace(/(@[a-z\d-]+)/ig,"<label>$1</label>");
                    if(data[i]['text'].length > 140)
                    {
                        truncated_RestaurantName = data[i]['text'].substr(0,140)+'..';
                    }
                    else
                    {
                        truncated_RestaurantName = data[i]['text'];
                    }
                    var bigCardHtml = '';
                    bigCardHtml += '<a href="https://twitter.com/'+data[i]['user']['screen_name']+'/status/'+data[i]['id_str']+'" target="_blank" class="external twitter-wrapper">';
                    bigCardHtml += '<div class="my-card-items new-post-wrapper hide"><div class="card demo-card-header-pic">';
                    bigCardHtml += '<div class="card-content"><div class="card-content-inner">';
                    bigCardHtml += '<div class="list-block media-list"><ul><li><div class="item-content">';
                    bigCardHtml += '<div class="item-media"><img class="myAvtar-list" src="'+data[i]['user']['profile_image_url_https']+'" width="44"/></div>';
                    bigCardHtml += '<div class="item-inner"><div class="item-title-row">';
                    bigCardHtml += '<div class="item-title">'+data[i]['user']['name'].capitalize()+'</div>';
                    bigCardHtml += '<i class="fa fa-twitter social-icon-gap"></i></div>';
                    bigCardHtml += '<div class="item-subtitle">@'+data[i]['user']['screen_name'];
                    bigCardHtml += '<time class="timeago time-stamp" datetime="'+data[i]['created_at']+'"></time></div>';

                    bigCardHtml += '</div></div></li></ul></div>';

                    if(data[i].hasOwnProperty('extended_entities'))
                    {
                        bigCardHtml += '<div class="row no-gutter feed-image-container">';
                        var imageLimit = 0;
                        for(var j=0;j<data[i]['extended_entities']['media'].length;j++)
                        {
                            if(imageLimit >= 1)
                            {
                                break;
                            }
                            imageLimit++;
                            if(typeof data[i]['extended_entities']['media'][j]['media_url_https'] != 'undefined' &&
                                data[i]['extended_entities']['media'][j]['media_url_https'] != '')
                            {
                                bigCardHtml += '<div class="col-100">';
                                bigCardHtml += '<img src="'+data[i]['extended_entities']['media'][j]['media_url_https']+'" class="mainFeed-img"/>';
                                bigCardHtml += '</div></div>';
                            }
                            else if(data[i]['extended_entities']['media'][j].hasOwnProperty('video_info') && data[i]['extended_entities']['media'][j]['video_info']['variants'] != null)
                            {
                                var videoUrl = '';
                                var videoType = '';
                                for(var k=0;k<data[i]['extended_entities']['media'][j]['video_info']['variants'].length;k++)
                                {
                                    if(data[i]['extended_entities']['media'][j]['video_info']['variants'][k].hasOwnProperty('bitrate'))
                                    {
                                        videoUrl = data[i]['extended_entities']['media'][j]['video_info']['variants'][k]['url'];
                                        videoType = data[i]['extended_entities']['media'][j]['video_info']['variants'][k]['content_type'];
                                    }
                                }
                                if(videoUrl.indexOf('youtube') != -1 || videoUrl.indexOf('youtu.be') != -1)
                                {
                                    bigCardHtml += '<div class="col-100">';
                                    bigCardHtml += '<iframe width="100%" src="'+videoUrl+'" frameborder="0" allowfullscreen>';
                                    bigCardHtml += '</iframe></div></div>';
                                }
                                else
                                {
                                    bigCardHtml += '<div class="col-100">';
                                    bigCardHtml += '<video width="100%" controls>';
                                    bigCardHtml += '<source src="'+videoUrl+'" type="'+videoType+'">No Video found!';
                                    bigCardHtml += '</video></div></div>';
                                }
                            }
                        }
                    }
                    else if(data[i]['is_quote_status'] != null && data[i]['is_quote_status'] == true)
                    {
                        bigCardHtml += '<p class="final-card-text">'+truncated_RestaurantName+'</p>';
                        if(data[i]['quoted_status'] != null && Array.isArray(data[i]['quoted_status']))
                        {
                            bigCardHtml += '<div class="content-block inset quoted-block">';
                            bigCardHtml += '<div class="content-block-inner">';
                            bigCardHtml += '<div class="item-inner">';
                            bigCardHtml += '<div class="item-title-row"><div class="item-title">'+data[i]['quoted_status']['user']['name']+'</div></div>';
                            bigCardHtml += '<div class="item-subtitle">'+data[i]['quoted_status']['user']['screen_name']+'</div></div>';
                            data[i]['quoted_status']['text'] = data[i]['quoted_status']['text'].replace(urlRegex,'');

                            data[i]['quoted_status']['text'] = data[i]['quoted_status']['text'].replace(/(#[a-z\d-]+)/ig,"<label>$1</label>");
                            data[i]['quoted_status']['text'] = data[i]['quoted_status']['text'].replace(/(@[a-z\d-]+)/ig,"<label>$1</label>");
                            bigCardHtml += '<p class="final-card-text">'+data[i]['quoted_status']['text']+'</p>';
                            bigCardHtml += '</div></div>';
                        }
                        else if(data[i]['retweeted_status'] != null && Array.isArray(data[i]['retweeted_status']))
                        {
                            bigCardHtml += '<div class="content-block inset quoted-block">';
                            bigCardHtml += '<div class="content-block-inner">';
                            bigCardHtml += '<div class="item-inner">';
                            bigCardHtml += '<div class="item-title-row"><div class="item-title">'+data[i]['retweeted_status']['quoted_status']['user']['name']+'</div></div>';
                            bigCardHtml += '<div class="item-subtitle">'+data[i]['retweeted_status']['quoted_status']['user']['screen_name']+'</div></div>';
                            data[i]['retweeted_status']['quoted_status']['text'] = data[i]['retweeted_status']['quoted_status']['text'].replace(urlRegex,'');

                            data[i]['retweeted_status']['quoted_status']['text'] = data[i]['retweeted_status']['quoted_status']['text'].replace(/(#[a-z\d-]+)/ig,"<label>$1</label>");
                            data[i]['retweeted_status']['quoted_status']['text'] = data[i]['retweeted_status']['quoted_status']['text'].replace(/(@[a-z\d-]+)/ig,"<label>$1</label>");
                            bigCardHtml += '<p class="final-card-text">'+data[i]['retweeted_status']['quoted_status']['text']+'</p>';
                            bigCardHtml += '</div></div>';
                        }
                    }
                    else if(data[i]['entities']['urls'] != null && data[i]['entities']['urls'].length > 0)
                    {
                        bigCardHtml += '<div class="link-card-wrapper">';
                        bigCardHtml += '<input type="hidden" class="my-link-url" value="'+data[i]['entities']['urls'][0]['expanded_url']+'"/>';
                        bigCardHtml += '<div class="liveurl feed-image-container hide">';
                        bigCardHtml += '<img src="" class="link-image mainFeed-img lazy lazy-fadein"/>';
                        bigCardHtml += '<div class="details"><div class="title"></div><div class="description"></div>';
                        bigCardHtml += '</div></div></div>';
                    }

                    if(data[i]['is_quote_status'] != null && data[i]['is_quote_status'] == false)
                    {
                        bigCardHtml += '<p class="final-card-text">'+truncated_RestaurantName+'</p>';
                    }
                    bigCardHtml += '</div></div></div></a>';
                    $('.custom-accordion').append(bigCardHtml);
                    /*var oldHeight = $('.custom-accordion').height();
                     $('.custom-accordion').prepend(bigCardHtml);
                     var total = currentPos+($('.custom-accordion').height()- oldHeight);
                     $('.page-content').scrollTop(total);*/
                    totalNew++;
                    break;
            }
        }
        catch(ex)
        {
            var err = currData+' Error: '+ex.message+' Stack: '+ex.stack;
            saveErrorLog(err);
        }
    }

    var total = currentPos+($('.custom-accordion').height()- oldHeight);
    $('.page-content').animate({
        scrollTop: total
    },100);
    maxItems = $$('.custom-accordion .my-card-items').length;

    $("time.timeago").timeago();
}
/* FAB Button click*/
$(document).on('click','.my-fab-btn',function(){
    if($(this).hasClass('open-popover'))
    {
        $('.popover-toggle-on').fadeOut(100,function(){
            $('.popover-toggle-off').fadeIn();
        });
        $(this).removeClass('open-popover').addClass('close-popover');
    }
    else if($(this).hasClass('close-popover'))
    {
        myApp.closeModal('.popover-links');
        $('.popover-toggle-off').fadeOut(100,function(){
            $('.popover-toggle-on').fadeIn();
        });
        $(this).removeClass('close-popover').addClass('open-popover');
    }
});

$$('.popover-links').on('close', function(){
    $('.popover-toggle-off').fadeOut(100,function(){
        $('.popover-toggle-on').fadeIn();
    });
    $('.my-fab-btn').removeClass('close-popover').addClass('open-popover');
});

$(document).ready(function(e){
    $('.my-card-items').each(function(i,val){
        if(!$(val).hasClass('hide'))
        {
            if(typeof $(val).find('.my-link-url').val() !== 'undefined')
            {
                renderLinks($(val).find('.my-link-url'));
            }
        }
        //renderLinks(val);
    });
    $("time.timeago").timeago();
    //checkNewEvents();
});

//renderLinks($('.my-link-url'));
function renderLinks(ele)
{
    if($(ele).val() != '')
    {
        $.ajax({
            type:'POST',
            dataType:'json',
            crossDomain:true,
            url:base_url+'renderLink',
            data:{url:$(ele).val()},
            success: function(data)
            {
                if(typeof data.image === 'undefined')
                {
                    $(ele).parent().find('.liveurl').find('img').attr('src',base_url+'asset/images/placeholder.jpg');
                }
                else
                {
                    $(ele).parent().find('.liveurl').find('img').attr('data-src',base_url+'asset/images/placeholder.jpg');
                    $(ele).parent().find('.liveurl').find('img').attr('src',data.image);
                }
                var mainTitle = '';
                if(typeof data.title !== 'undefined')
                {
                    mainTitle = data.title;
                    if(data.title.length>45)
                    {
                        mainTitle = data.title.substr(0,45)+'...';
                    }
                }
                $(ele).parent().find('.liveurl').find('.title').html(mainTitle);
                $(ele).parent().find('.liveurl').find('.description').html(data.site_name);
                $(ele).parent().find('.liveurl').removeClass('hide');
                $(ele).removeClass('my-link-url');
            },
            error: function()
            {

            }
        });
    }
}
/* Scroll Part
 ------------------ */

/*$('#tab3 .page-content').scroll(function(){
    didScroll = true;
    headerScroll = $(this).scrollTop();
    showHideScrollUp(headerScroll);
});
$('#tab2 .page-content').scroll(function(){
    didScroll = true;
    headerScroll = $(this).scrollTop();
    showHideScrollUp(headerScroll);
});*/


// Hide Header on on scroll down
/*
var didScroll;
var headerScroll = 0;
var lastScrollTop = 0;
var delta = 5;
var navbarHeight = $('.myMainBottomBar').outerHeight();*/

$$(document).on('change','input[name=social-filter]',function(){
    var notSelectedFilters = [];
    var selectedFilters = [];
    $("input[name=social-filter]:not(:checked)").each(function(){
        notSelectedFilters.push($(this).val());
        switch($(this).val())
        {
            case "1":
                $('#tab1 .facebook-wrapper').fadeOut();
                $$('#tab1 .page-content').scrollTop($(document).height(),500);
                break;
            case "2":
                $('#tab1 .twitter-wrapper').fadeOut();
                $$('#tab1 .page-content').scrollTop($(document).height(),500);
                break;
            case "3":
                $('#tab1 .instagram-wrapper').fadeOut();
                $$('#tab1 .page-content').scrollTop($(document).height(),500);
                break;
        }
    });
    if(notSelectedFilters.length == 3)
    {
        $$('.infinite-scroll-preloader').hide();
        $('#tab1 .facebook-wrapper').fadeIn();
        $('#tab1 .twitter-wrapper').fadeIn();
        $('#tab1 .instagram-wrapper').fadeIn();
    }
    $("input[name=social-filter]:checked").each(function(){
        selectedFilters.push($(this).val());
        switch($(this).val())
        {
            case "1":
                $('.facebook-wrapper').fadeIn();
                break;
            case "2":
                $('.twitter-wrapper').fadeIn();
                break;
            case "3":
                $('.instagram-wrapper').fadeIn();
                break;
        }
    });
    if(selectedFilters.length >= 1)
    {
        $$('.infinite-scroll-preloader').show();
    }
});
var currentPos = 0;
$('#tab1 .page-content').scroll(function(){
    //didScroll = true;
    currentPos = $(this).scrollTop();
    //headerScroll = $(this).scrollTop();
    if(currentPos <=20)
    {
        if(!$('.feed-notifier').hasClass('hide'))
        {
            $('.feed-notifier').addClass('hide');
        }
    }
    //showHideScrollUp(currentPos);
});
/*setInterval(function() {
    if (didScroll) {
        hasScrolled();
        didScroll = false;
    }
}, 250);*/
/*
function hasScrolled() {
    var st = headerScroll;

    // Make sure they scroll more than delta
    if(Math.abs(lastScrollTop - st) <= delta)
        return;

    // If they scrolled down and are past the navbar, add class .nav-up.
    // This is necessary so you never see what is "behind" the navbar.
    if (st > lastScrollTop && st > navbarHeight){
        console.log('down');
        // Scroll Down
        $('.myMainBottomBar').removeClass('nav-down').addClass('nav-up');
    } else {
        console.log('up');
        // Scroll Up
        //if(st + $('#tab1 .page-content').height() < $('#tab1 .page-content').height()) {
            $('.myMainBottomBar').removeClass('nav-up').addClass('nav-down');
        //}
    }

    lastScrollTop = st;
}
function showHideScrollUp(currentScroll)
{
    if(currentScroll > 200)
    {
        $('.custom-scroll-up').fadeIn();
    }
    else
    {
        $('.custom-scroll-up').fadeOut();
    }
}
$$(document).on('click','.custom-scroll-up',function(){

    $('.page-content').animate({
        scrollTop:0
    },200);
});*/
function preventAct(ele)
{
    ele.preventDefault();
}

var pickerDevice = myApp.picker({
    input: '#picker-device',
    rotateEffect: true,
    cols: [
        {
            textAlign: 'center',
            values: ['Andheri Taproom', 'Bandra Taproom', 'Kemps Taproom']
        }
    ]
});

// Adding lazy load later
function doLazyWork()
{
    $$('.my-card-items').each(function(i,val){
        if($$(this).hasClass('hide'))
        {
            if(!$$(this).find('.myAvtar-list').hasClass('lazy'))
            {
                $$(this).find('.myAvtar-list').addClass('lazy');
            }
            if(!$$(this).find('.mainFeed-img').hasClass('lazy'))
            {
                $$(this).find('.mainFeed-img').addClass('lazy').addClass('lazy-fadein');
            }
        }
    });
    myApp.initImagesLazyLoad('.my-card-items');
}

function makeTxtShort()
{
    var showChar = 100;
    var ellipsestext = "...";
    var moretext = "more";
    var lesstext = "less";
    $('.more').each(function() {
        var content = $(this).html();

        if(content.length > showChar) {

            var c = content.substr(0, showChar);
            var h = content.substr(showChar-1, content.length - showChar);

            var html = c + '<span class="moreelipses">'+ellipsestext+'</span>&nbsp;<span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">'+moretext+'</a></span>';

            $(this).html(html);
        }

    });

    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
}
//makeTxtShort();

/*$$(document).on('click','.more-photos-wrapper', function(){
    var pics = $$(this).find('.imgs_collection').val().split(',');
    if(typeof pics != 'undefined')
    {
        var newPics = [];
        for(var i=0;i<pics.length;i++)
        {
            var temp = {href:pics[i],title:''};
            newPics[i] = temp;
        }
        $.swipebox( newPics );
        /!* var myPhotoBrowserDark = myApp.photoBrowser({
             photos : pics,
             type: 'page',
             backLinkText: 'Back'
         });
         myPhotoBrowserDark.open();*!/
    }
});*/
$$('.my-events-tab-icon').on('click', function(){
    if(mainView.url == 'event_dash' || mainView.url == 'contact_us' || mainView.url == 'jukebox')
    {
        mainView.router.back();
    }
});
$$('#tab2').on('show',function(){ //Events Section
    localStorageUtil.setLocal('onWhichTab','#tab2');
    $('#calendar-glance').fullCalendar('render');
    $('#calendar-glance .fc-day-header.fc-widget-header').each(function(i,val){
        var txt = $(val).find('span').html();
        if(txt != '')
        {
            var newVal = txt.split(' ')[0].trim();
            $(val).find('span').html(newVal);
        }
    });
    if(typeof $('.welcomescreen-container').val() === 'undefined' && $$('#tab2').attr('data-page') == 'comming-up')
    {
        $$('.event-fab-btn').removeClass('hide');
    }
    $$('.my-fab-btn').addClass('hide');
    $$('.ic_events_icon').addClass('on');
    $$('.ic_fnb_icon').removeClass('on');
});
$$('#tab3').on('show',function(){ //Fnb Section
    localStorageUtil.setLocal('onWhichTab','#tab3');
    $$('.my-fab-btn').addClass('hide');
    $$('.event-fab-btn').addClass('hide');
    $$('.ic_events_icon').removeClass('on');
    $$('.ic_fnb_icon').addClass('on');
});
$$('#tab1').on('show',function(){ //Timeline Section
    localStorageUtil.setLocal('onWhichTab','#tab1');
    if(typeof $('.welcomescreen-container').val() === 'undefined')
    {
        $$('.my-fab-btn').removeClass('hide');
    }
    $$('.event-fab-btn').addClass('hide');
    $$('.ic_events_icon').removeClass('on');
    $$('.ic_fnb_icon').removeClass('on');
});

var contentTime = setInterval(function(){
        if(typeof $('.welcomescreen-container').val() === 'undefined')
        {
            clearInterval(contentTime);
            doLazyWork();
        }
},2000);
$$(document).on('click','.event-bookNow',function(){
   myApp.showIndicator();
});
function checkNewEvents()
{
    //event-new-notify
    $('#tab2 .demo-card-header-pic .card-footer .event-new-notify').each(function(i,val){
        if(typeof $(val).attr('data-created') != 'undefined')
        {
            var created = new Date($(val).attr('data-created').replace(/-/g,"/"));
            var today = new Date();
            var timeDiff = Math.abs(today.getTime() - created.getTime());
            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

            if(diffDays <= 3)
            {
                $(val).removeClass('my-vanish');
            }
        }
    });
}

$$(document).on('click','.event-fab-btn', function(){
    if(mainView.activePage.url != 'create_event')
    {
        myApp.showIndicator();
        mainView.router.load({
            url:'create_event',
            ignoreCache: true
        });
    }
    else
    {
        myApp.closePanel();
        mainView.router.refreshPage();
    }
});
$$(document).on('click','#my-events-tab', function(){
    if(mainView.activePage.url != 'event_dash')
    {
        myApp.closePanel();
        myApp.showIndicator();
        mainView.router.load({
            url:'event_dash',
            ignoreCache: true
        });
        myApp.showTab('#tab2');
    }
    else
    {
        myApp.closePanel();
        mainView.router.refreshPage();
    }
});
$$(document).on('click','#contact-tab', function(){
    if(mainView.activePage.url != 'contact_us')
    {
        myApp.closePanel();
        myApp.showIndicator();
        mainView.router.load({
            url:'contact_us',
            ignoreCache: true
        });
        myApp.showTab('#tab2');
    }
    else
    {
        myApp.closePanel();
        mainView.router.refreshPage();
    }
});
$$(document).on('click','#my-jukebox-tab', function(){
    if(mainView.activePage.url != 'jukebox')
    {
        myApp.closePanel();
        myApp.showIndicator();
        mainView.router.load({
            url:'jukebox',
            ignoreCache: true
        });
        myApp.showTab('#tab2');
    }
    else
    {
        myApp.closePanel();
        mainView.router.refreshPage();
    }
});

$$(document).on('click','#logout-btn', function(){
    if(typeof gapi.auth2 != 'undefined')
    {
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
            console.log('User signed out.');
        });
    }
    myApp.showIndicator();
    var errUrl = base_url+'main/appLogout';
    $$.ajax({
        method:"GET",
        url: base_url+'main/appLogout',
        cache: false,
        dataType: 'json',
        success: function(data){
            myApp.hideIndicator();
            if(data.status === true)
            {
                $('.iosHome .user-settings').addClass('hide');
                $('.logout-menu-item').addClass('hide');
                mainView.router.refreshPage();
            }
        },
        error: function(xhr, status, errror){
            myApp.hideIndicator();
            myApp.addNotification({
                title: 'Error!',
                message: 'Some Error Occurred!'
            });
            var err = 'Url: '+errUrl+' StatusText: '+xhr.statusText+' Status: '+xhr.status+' resp: '+xhr.responseText;
            saveErrorLog(err);
        }
    });
});

$$(document).on('click','.event-card-share-btn', function(){

    $$('.popover-share').find('p').html('Share "'+$(this).parent().find('input[type="hidden"]').attr('data-name')+'"');
    $('#main-share').jsSocials({
        showLabel: true,
        text:$(this).parent().find('input[type="hidden"]').attr('data-shareTxt'),
        url: $(this).parent().find('input[type="hidden"]').val(),
        showCount:false,
        shares: [
            { share: "whatsapp", label: "WhatsApp" },
            { share: "twitter", label: "Twitter" },
            { share: "facebook", label: "Facebook" }
        ]
    });
    $('.jssocials-share').find('a').addClass('external');
    myApp.popover('.popover-share',$(this));
});
$$(document).on('click','.fnb-card-share-btn', function(){

    $$('.popover-share').find('p').html('Share "'+$(this).parent().find('input[type="hidden"]').attr('data-name')+'"');
    $('#main-share').jsSocials({
        showLabel: true,
        text:$(this).parent().find('input[type="hidden"]').attr('data-name'),
        url: $(this).parent().find('input[type="hidden"]').val(),
        showCount:false,
        shares: [
            { share: "whatsapp", label: "WhatsApp" },
            { share: "twitter", label: "Twitter" },
            { share: "facebook", label: "Facebook" }
        ]
    });
    $('.jssocials-share').find('a').addClass('external');
    myApp.popover('.popover-share',$(this));
});
var filesArr = [];
var cropData = {};
var hasCropped = false;
function uploadChange(ele)
{
    //$('.event-add button[type="submit"]').attr('disabled','true');
    $('.event-add .event-img-after').removeClass('hide');
    $('.event-add .event-img-before').addClass('hide');
    vex.closeAll();
    var xhr = [];
    var totalFiles = ele.files.length;
    for(var i=0;i<totalFiles;i++)
    {
        xhr[i] = new XMLHttpRequest();
        (xhr[i].upload || xhr[i]).addEventListener('progress', function(e) {
            var done = e.position || e.loaded;
            var total = e.totalSize || e.total;
            myApp.setProgressbar($$('.event-add .event-img-after .progressbar'),Math.round(done/total*100));
            //$('.event-add .event-img-after .progressbar').css('width', Math.round(done/total*100)+'%').attr('aria-valuenow', Math.round(done/total*100)).html(parseInt(Math.round(done/total*100))+'%');
        });
        xhr[i].addEventListener('load', function(e) {
            //$('.event-add button[type="submit"]').removeAttr('disabled');
        });
        xhr[i].open('post', base_url+'dashboard/uploadEventFiles', true);

        var data = new FormData;
        data.append('attachment', ele.files[i]);
        xhr[i].send(data);
        var currentXhr = xhr[i];
        xhr[i].onreadystatechange = function(e) {
            var eles = e.srcElement;
            if(typeof e.srcElement === 'undefined')
            {
                eles = currentXhr;
            }

            if (eles.readyState == 4 && eles.status == 200) {
                if(eles.responseText == 'Some Error Occurred!')
                {
                    vex.dialog.buttons.YES.text = 'Close';
                    vex.dialog.alert({
                        unsafeMessage: '<label class="head-title">Error!</label><br><br>'+'File size Limit 30MB'
                    });
                    //alertDialog('Error!','File size Limit 30MB',false);
                    return false;
                }
                filesArr.push(eles.responseText);
                $$('.event-add .event-img-after .progressbar').addClass('hide');
                var eventImg = base_url+'uploads/events/thumb/'+eles.responseText;
                $$('.event-add .event-img-space').addClass('hide');
                $('.event-add #cropContainerModal').removeClass('hide').find('#img-container').attr('src',eventImg);
                cropData['imgUrl'] = eventImg;
                $('#img-container').cropper({
                    viewMode:3,
                    minContainerHeight: 250,
                    dragMode:'move',
                    aspectRatio: 16 / 9
                    /*crop: function(e) {
                        // Output the result data for cropping image.
                        cropData['imgUrl'] = eventImg;
                        cropData['x'] = e.x;
                        cropData['y'] = e.y;
                        cropData['width'] = e.width;
                        cropData['height'] = e.height;
                        cropData['rotate'] = e.rotate;
                        cropData['scaleX'] = e.scaleX;
                        cropData['scaleY'] = e.scaleY;
                        /!*cropData['cWidth'] = $('.cropper-crop-box').width();
                        cropData['cHeight'] = $('.cropper-crop-box').height();*!/
                        /!*console.log(e.x);
                        console.log(e.y);
                        console.log(e.width);
                        console.log(e.height);
                        console.log(e.rotate);
                        console.log(e.scaleX);
                        console.log(e.scaleY);*!/
                    }*/
                });
                /*var cropperOptions = {
                    cropUrl:base_url+'dashboard/cropEventImage',
                    loadPicture:eventImg,
                    imgEyecandy:false,
                    loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
                    onAfterImgCrop:function(data){
                        filesArr = [];
                        var uri = data.url.split('/');
                        filesArr.push(uri[uri.length-1]);
                        hasCropped = true;
                    },
                    onReset:function(){
                        if(hasCropped === true)
                        {
                            hasCropped = false;
                            filesArr = [];
                            $$('.event-add .event-img-after .progressbar').removeClass('hide');
                            $('.event-add .event-img-after').addClass('hide');
                            $('.event-add .event-img-before').removeClass('hide');
                            $$('.event-add #event-img-upload').val('');
                            $$('.event-add .event-img-space').removeClass('hide');
                            $('.event-add #cropContainerModal').addClass('hide');

                        }
                    },
                    onError:function(errormessage){ console.log('onError:'+errormessage) }
                };

                var cropperHeader = new Croppic('cropContainerModal', cropperOptions);
                $('.event-add #cropContainerModal').removeClass('hide');
                cropperHeader.reset();*/
                //$('.event-add #cropContainerModal').css('height','auto');
                /*$$('.event-add .event-img-space').css({
                   'background' : 'linear-gradient(rgba(255, 255, 255, 0.5), rgba(255, 255, 255, 0.5)), 0 / cover url('+eventImg+') no-repeat'
                });
                $$('.event-add .event-img-after .event-img-remove').removeClass('hide');*/

            }
        }
    }
}
$$(document).on('click','.upload-img-close', function(){
    filesArr = [];
    $$('.event-add .event-img-after .progressbar').removeClass('hide');
    $('.event-add .event-img-after').addClass('hide');
    $('.event-add .event-img-before').removeClass('hide');
    $$('.event-add #event-img-upload').val('');
    $$('.event-add .event-img-space').removeClass('hide');
    $('.event-add #cropContainerModal').addClass('hide');
    $('#img-container').cropper('destroy');
});

$$(document).on('click', '.upload-done-icon', function(){
    $$('.event-add #cropContainerModal .done-overlay').removeClass('hide');
    $$(this).addClass('hide');
    $('.event-add #eventName').focus();
});
$$(document).on('click', '.event-overlay-remove', function(){
    $$('.event-add #cropContainerModal .done-overlay').addClass('hide');
    $$('.event-add .upload-done-icon').removeClass('hide');
});
var fnb_initial_state = '';
var event_initial_state = '';
$$(document).on('change', 'input[name="beer-locations"]', function(){
    if(typeof $$(this).val() != 'undefined')
    {
        if(fnb_initial_state == '')
        {
            fnb_initial_state = $$('.fnb-section').html();
        }
        $$('.clear-beer-filter').removeClass('hide');
        $$('#tab3 .beer-filter-toggler').addClass('on');
        var filterVal = $$(this).val();
        $('#tab3 .show-full-beer-card').each(function(i,val){
            if(!$(this).hasClass('category-'+filterVal))
            {
                $(this).parent().hide();
            }
        });
        // var catArray = $$('#tab3 .category-'+filterVal).parent();
        // $(':not('+catArray+')').hide();
        //$$('#tab3 .category-'+filterVal).parent().remove();
        //$$('.fnb-section').prepend(catArray);
        //$(catArray).slideToggle();
        //myApp.closeModal('.popover-filters');
    }
});
$$(document).on('click','.clear-beer-filter', function(){
    if(!$$(this).find('.close-icon').hasClass('hide'))
    {
        $$('#tab3 .beer-filter-toggler').removeClass('on');
        $$('.popover-filters ul li').each(function(i,val){
            var inp = '#'+$$(val).find('input').attr('id');
            document.querySelector(inp).parentNode.MaterialRadio.uncheck();
        });
        $$('.clear-beer-filter').addClass('hide');
        if(fnb_initial_state != '')
        {
            $('.fnb-section').empty().html(fnb_initial_state);
        }
        //myApp.closeModal('.popover-filters');
    }

    //document.querySelector('input[name="beer-locations"]').parentNode.MaterialRadio.uncheck();
});
//For events sorting
$$(document).on('change', 'input[name="event-locations"]', function(){
    if(typeof $$(this).val() != 'undefined')
    {
        if(event_initial_state == '')
        {
            event_initial_state = $('.event-section').html();
        }
        $$('.clear-event-filter').removeClass('hide');
        $$('#tab2 .event-filter-toggler').addClass('on');
        var filterVal = $$(this).val();
        if(event_initial_state != '')
        {
            $('.event-section').html(event_initial_state);
        }
        var specialEves = $('#tab2 .eve-special');
        var allLocEves = $('#tab2 .eve-all');
        var catArray = $('#tab2 .eve-'+filterVal);
        if(catArray.length == 0)
        {
            $('.event-section').html('No Events Found!');
        }
        else
        {
            $(catArray).hide();
            $('#tab2 .eve-'+filterVal).remove();
            $('.event-section').prepend(catArray);
            /*$('.event-section').html(catArray);*/
            $(catArray).slideToggle();
        }
        if(allLocEves.length != 0)
        {
            $('#tab2 .event-section').prepend(allLocEves);
        }
        if(specialEves.length != 0)
        {
            $('#tab2 .event-section').prepend(specialEves);
        }
        //myApp.closeModal('.popover-event-filter');
    }
});
$$(document).on('click','.clear-event-filter', function(){

    if(!$$(this).find('.close-icon').hasClass('hide'))
    {
        $$('#tab2 .event-filter-toggler').removeClass('on');
        $$('.popover-event-filter ul li').each(function(i,val){
            var inp = '#'+$$(val).find('input').attr('id');
            document.querySelector(inp).parentNode.MaterialRadio.uncheck();
        });
        $$('.clear-event-filter').addClass('hide');
        if(event_initial_state != '')
        {
            $('.event-section').empty().html(event_initial_state);
        }
        //myApp.closeModal('.popover-event-filter');
    }

    //document.querySelector('input[name="beer-locations"]').parentNode.MaterialRadio.uncheck();
});
function fillEventImgs()
{
    if(typeof filesArr[0] != 'undefined')
    $('.event-add input[name="attachment"]').val(filesArr.join());
}

function toggleAccess(ele)
{
    if($(ele).is(':checked'))
    {
        $(ele).parent().addClass('isChecked').find('i,span').addClass('on');
    }
    else
    {
        $(ele).parent().removeClass('isChecked').find('i,span').removeClass('on');
    }
}

function timeCheck()
{
    var startTime  = ConvertTimeformat('24', $('.event-add input[name="startTime"]').val());
    var endTime  = ConvertTimeformat('24', $('.event-add input[name="endTime"]').val());

    if(startTime != '' && endTime != '')
    {
        var sArray = startTime.split(':');
        var eArray = endTime.split(':');
        if($('.event-add input[name="eventPlace"]').val() != '4')
        {
            if(Number(sArray[0]) >= 7 && Number(eArray[0]) <= 11)
            {
                $('.event-add #micWrapper').removeAttr('disabled');
            }
            else
            {
                $('.event-add #micWrapper').attr('disabled','disabled');
            }
        }
        else
        {
            if(Number(sArray[0]) >= 7 && Number(eArray[0]) <= 16)
            {
                $('.event-add #micWrapper').removeAttr('disabled');
            }
            else
            {
                $('.event-add #micWrapper').attr('disabled','disabled');
            }
        }
        if(Number(sArray[0]) >= 7 && Number(eArray[0]) <= 16)
        {
            $('.event-add #projWrapper').removeAttr('disabled');
        }
        else
        {
            $('.event-add #projWrapper').attr('disabled','disabled');
        }
    }
    else
    {
        $('.event-add #micWrapper').attr('disabled','disabled');
        $('.event-add #projWrapper').attr('disabled','disabled');

    }
}
function maxLengthCheck(object)
{
    if (object.value.length > object.maxLength)
        object.value = object.value.slice(0, object.maxLength)
}

$$(document).on('click', '#global-home-btn', function(){
    /*if(mainView.router.back() === false)
    {
        window.location.href= base_url;
    }
    else
    {
        mainView.router.back();
    }*/
    myApp.showTab('#tab1');
    myApp.closePanel();
});
var shortUri = '';
function urlshort(url)
{
    $.urlShortener({
        longUrl: url,
        success: function (shortUrl) {
            //shortUrl ->  Shortened URL
            shortUri = shortUrl;
        },
        error: function(err)
        {
            shortUri = 'error';
            //alert(JSON.stringify(err));
        }
    });
}

function cancelEvent(eventId)
{
    myApp.showIndicator();
    var errUrl = base_url+'dashboard/cancelEvent/'+eventId;
    $$.ajax({
        method:"GET",
        url: base_url+'dashboard/cancelEvent/'+eventId,
        cache: false,
        dataType: 'json',
        success: function(data){
            myApp.hideIndicator();
            if(data.status === true)
            {
                mainView.router.back({
                    ignoreCache: true
                });
            }
        },
        error: function(xhr, status, error){
            myApp.hideIndicator();
            myApp.addNotification({
                title: 'Error!',
                message: 'Some Error Occurred!'
            });
            vex.closeTop();
            var err = 'Url: '+errUrl+' StatusText: '+xhr.statusText+' Status: '+xhr.status+' resp: '+xhr.responseText;
            saveErrorLog(err);
        }
    });
}

function renderCalendar()
{
    if(typeof $('#tab2 .even-cal-list') === 'undefined')
    {
        var d = new Date();
        $('#calendar-glance').fullCalendar({
            defaultView: 'basicWeek',
            header: false,
            height:'auto',
            firstDay: d.getDay(),
            defaultDate: d,
            viewRender: function(view, element)
            {
                $('#calendar-glance .fc-day-header.fc-widget-header').each(function(i,val){
                    var txt = $(val).find('span').html();
                    if(txt != '')
                    {
                        var newVal = txt.split(' ')[0].trim();
                        $(val).find('span').html(newVal);
                    }
                });
            }
        });
    }
    else
    {
        var events = [];
        var d = new Date();
        $('#tab2 .even-cal-list li').each(function(j,val){
            var tempData = {};
            var eveName = $(val).attr('data-evenNames');
            if(eveName.indexOf(';') != -1)
            {
                var res = eveName.split(';');
                var places = $(val).attr('data-evenPlaces').split(',');
                var endTimes = $(val).attr('data-evenEndTimes').split(',');
                for(var i=0;i<res.length;i++)
                {
                    if(!isEventFinished($(val).attr('data-evenDate'),endTimes[i]))
                    {
                        tempData = {};
                        tempData['title'] = res[i];
                        tempData['allDay'] = true;
                        tempData['start'] = $(val).attr('data-evenDate');
                        tempData['className'] = 'evenPlace';
                        events.push(tempData);
                    }
                }
            }
            else
            {
                if(!isEventFinished($(val).attr('data-evenDate'),$(val).attr('data-evenEndTimes')))
                {
                    tempData = {};
                    tempData['title'] = eveName;
                    tempData['allDay'] = true;
                    tempData['start'] = $(val).attr('data-evenDate');
                    tempData['className'] = 'evenPlace';
                    events.push(tempData);
                }
            }
        });
        $('#calendar-glance').fullCalendar({
            defaultView: 'basicWeek',
            header: false,
            height:'auto',
            firstDay:d.getDay(),
            defaultDate: d,
            events: events,
            viewRender: function(view, element)
            {
                $('#calendar-glance .fc-day-header.fc-widget-header').each(function(i,val){
                    var txt = $(val).find('span').html();
                    if(txt != '')
                    {
                        var newVal = txt.split(' ')[0].trim();
                        $(val).find('span').html(newVal);
                    }
                });
            }
        });
    }
    $('#calendar-glance').fullCalendar('render');

}

function getInstaLoc(locId)
{
    var taproom = '';
    switch(locId)
    {
        case '1020175853':
            taproom =  'Andheri Taproom';
            break;
        case '402256524':
            taproom = 'Bandra Taproom';
            break;
        case '1741740822733140':
            taproom = 'Kemps Taproom';
            break;
    }
    return taproom;
}

//Facebook login script
function checkLoginState()
{
    FB.getLoginStatus(function(response) {
        if(response.status == 'connected')
        {
            statusChangeCallback(response);
        }
        else
        {
            myAlertDiag('error','Login Canceled!');
        }
    });
}
function statusChangeCallback(response)
{
    FB.api('/me?fields=name,email', function(response)
    {
        if(!response.email)
        {
            vex.dialog.buttons.YES.text = 'Close';
            vex.dialog.alert({
                unsafeMessage: '<label class="head-title">Error!</label><br><br>User login cancelled because email id is not received.'
            });
        }
        else
        {
            var postData = {
                'fbId': response.id,
                'email': response.email
            };

            var errUrl = base_url+'main/checkJukeboxUser';
            myApp.showIndicator();
            $.ajax({
                type:'POST',
                dataType:'json',
                url:base_url+'main/checkJukeboxUser',
                data:postData,
                success: function(data)
                {
                    myApp.hideIndicator();
                    mainView.router.refreshPage();
                },
                error: function(xhr, status, error){
                    myApp.hideIndicator();
                    vex.dialog.buttons.YES.text = 'Close';
                    vex.dialog.alert({
                        unsafeMessage: '<label class="head-title">Error!</label><br><br>Some Error Occurred!'
                    });
                    var err = 'Url: '+errUrl+' StatusText: '+xhr.statusText+' Status: '+xhr.status+' resp: '+xhr.responseText;
                    saveErrorLog(err);
                }
            });
        }
    });
}

// Google plus login script
function onSuccess(googleUser) {
    var postData = {
        'fbId': googleUser.getBasicProfile().getId(),
        'email': googleUser.getBasicProfile().getEmail()
    };

    var errUrl = base_url+'main/checkJukeboxUser';
    myApp.showIndicator();
    $.ajax({
        type:'POST',
        dataType:'json',
        url:base_url+'main/checkJukeboxUser',
        data:postData,
        success: function(data)
        {
            myApp.hideIndicator();
            mainView.router.refreshPage();
        },
        error: function(xhr, status, error){
            myApp.hideIndicator();
            vex.dialog.buttons.YES.text = 'Close';
            vex.dialog.alert({
                unsafeMessage: '<label class="head-title">Error!</label><br><br>Some Error Occurred!'
            });
            var err = 'Url: '+errUrl+' StatusText: '+xhr.statusText+' Status: '+xhr.status+' resp: '+xhr.responseText;
            saveErrorLog(err);
        }
    });
}
function onFailure(error) {
    vex.dialog.buttons.YES.text = 'Close';
    vex.dialog.alert({
        unsafeMessage: '<label class="head-title">Error!</label><br><br>'+error
    });
}
var GooleAuth;
function renderButton() {
    gapi.signin2.render('my-signin2', {
        'scope': 'email',
        'width': 80,
        'height': 24,
        'theme': 'dark',
        'onsuccess': onSuccess,
        'onfailure': onFailure
    });
    gapi.load('auth2', function() {
        gapi.auth2.init();
    });

}

function jukeboxLoginFunc(ele)
{
    if($$('.tapSong-page #jukebx-form input[name="username"]').val() == '')
    {
        myApp.addNotification({
            title: 'Error!',
            message: 'Email Required!'
        });
        return false;
    }
    if(!isEmailValid($$('.tapSong-page #jukebx-form input[name="username"]').val()))
    {
        myApp.addNotification({
            title: 'Error!',
            message: 'Valid Email Required!'
        });
        return false;
    }
    $(ele).attr('disabled','disabled');
    myApp.showIndicator();
    var errUrl = base_url+'main/checkJukeboxUser';
    $.ajax({
        type:'POST',
        dataType:'json',
        url:base_url+'main/checkJukeboxUser',
        data:{email:$$('.tapSong-page #jukebx-form input[name="username"]').val()},
        success: function(data)
        {
            myApp.hideIndicator();
            $(ele).removeAttr('disabled');
            mainView.router.refreshPage();
        },
        error: function(xhr, status, error){
            myApp.hideIndicator();
            $(ele).removeAttr('disabled');
            vex.dialog.buttons.YES.text = 'Close';
            vex.dialog.alert({
                unsafeMessage: '<label class="head-title">Error!</label><br><br>Some Error Occurred!'
            });
            var err = 'Url: '+errUrl+' StatusText: '+xhr.statusText+' Status: '+xhr.status+' resp: '+xhr.responseText;
            saveErrorLog(err);
        }
    });
}

function appendScript(sUrl)
{
    var isLoaded = false;
    $('body').find('script').each(function(i,val){
        if($(val).attr('src') == sUrl)
        {
            isLoaded = true;
            return false;
        }
    });
    if(!isLoaded)
    {
        var scriptHtml = '<script type="application/javascript" src="'+sUrl+'">';
        $('body').append(scriptHtml);
    }
}
function appendStyle(sUrl)
{
    var isLoaded = false;
    $('head').find('link').each(function(i,val){
        if($(val).attr('href') == sUrl)
        {
            isLoaded = true;
            return false;
        }
    });
    if(!isLoaded)
    {
        var scriptHtml = '<link rel="stylesheet" type="text/css" href="'+sUrl+'">';
        $('head').append(scriptHtml);
    }
}

$(document).on('click','.eve-cancel-btn', function(){
 var bookerId = $(this).attr('data-bookerId');

    vex.dialog.buttons.YES.text = 'Yes';
    vex.dialog.confirm({
        message: 'Are you sure you want to cancel?',
        callback: function (value) {
            if (value) {
                var errUrl = base_url+'eventCancel';
                myApp.showIndicator();
                $.ajax({
                    type:'POST',
                    dataType:'json',
                    url:base_url+'eventCancel',
                    data:{bId: bookerId},
                    success: function(data){
                        myApp.hideIndicator();
                        if(data.status == true)
                        {
                            vex.dialog.buttons.YES.text = 'Close';
                            vex.dialog.alert({
                                unsafeMessage: '<label class="head-title">Success!</label><br><br>We will inform the organiser that you will not be attending the event. For paid events, the money will be refunded after deducting 2.24% transaction charges.',
                                callback: function(){
                                    setTimeout(function(){
                                        mainView.router.refreshPage();
                                    },500);
                                }
                            });

                        }
                        else
                        {
                            vex.dialog.buttons.YES.text = 'Close';
                            vex.dialog.alert({
                                unsafeMessage: '<label class="head-title">Error!</label><br><br>'+data.errorMsg
                            });
                        }
                    },
                    error: function(xhr, status, error){
                        myApp.hideIndicator();
                        vex.dialog.buttons.YES.text = 'Close';
                        vex.dialog.alert({
                            unsafeMessage: '<label class="head-title">Error!</label><br><br>Some Error Occurred!'
                        });
                        var err = 'Url: '+errUrl+' StatusText: '+xhr.statusText+' Status: '+xhr.status+' resp: '+xhr.responseText;
                        saveErrorLog(err);
                    }
                });
            } else {

            }
        }
    });
 /*   myApp.confirm('Are you sure you want to cancel?', 'Cancel Booking', function () {

    });
    $('.iosHome .modal').css('margin-left','-135px');
    $('.iosHome .modal.modal-in, .iosHome .modal-inner').css({
        'width': 'auto',
        'border-radius': '13px'
    });
    $('.iosHome .modal-text').css('height','auto');*/
});

function isEventFinished(eventDate, endTime)
{
    var result = false;
    var date1 = new Date(eventDate);
    var nowDate = new Date();
    if(nowDate >= date1)
    {
        var time1 = null;
        if(endTime.toLowerCase().indexOf('m') != -1)
        {
            time1 = ConvertTimeformat('24',endTime);
        }
        else
        {
            time1 = endTime;
        }
        var nowTime = nowDate.getHours()+':'+nowDate.getMinutes();
        if(nowTime > time1)
        {
            result = true;
        }
        else
        {
            result = false;
        }
    }
    else
    {
        result = false;
    }
    return result;
}
$(document).bind("contextmenu",function(e){
    e.preventDefault();
});

// Intertatails
const eventTip =  tippy('#main-events-tab',{
    arrow: true,
    position: 'top',
    animation: 'scale',
    duration: 500,
    trigger: 'manual',
    hidden: function() {
        //eventTip.hide(eventPopper);
        myApp.openPanel('left',true);
        localStorageUtil.setLocal('isMobEventPop','1');
    },
    inertia: true
});
const eventEl = document.querySelector('#main-events-tab');
const eventPopper = eventTip.getPopperElement(eventEl);
$(window).load(function(){
    var ageTimeout = setInterval(function(){
        if(typeof $('.welcomescreen-container').val() === 'undefined')
        {
            clearInterval(ageTimeout);
            if(localStorageUtil.getLocal('isMobEventPop') != null)
            {
                if(localStorageUtil.getLocal('isMobEventPop') == '0')
                {
                    eventTip.show(eventPopper);
                    $('.tippy-overlay').removeClass('hide');
                }
            }
            else
            {
                eventTip.show(eventPopper);
                $('.tippy-overlay').removeClass('hide');
            }
        }
    },1000);
});
/*$(document).on('click','#event-tip-dismis', function(e){
    e.preventDefault();
    localStorageUtil.setLocal('isMobEventPop','1');
    eventTip.hide(eventPopper);
    myApp.openPanel('left',true);
});*/
const menuTip =  tippy('#main-web-menu',{
    //html: '#my-events-tooltip',
    arrow: true,
    position: 'bottom-start',
    animation: 'scale',
    duration: 500,
    //interactive: true,
    trigger: 'manual',
    //hideOnClick: false,
    hidden: function(){
        //menuTip.hide(menuPopper);
        $('.tippy-overlay').addClass('hide');
        localStorageUtil.setLocal('isMobMenuPop','1');
        myApp.closePanel();
    },
    inertia: true
});
const menuEl = document.querySelector('#main-web-menu');
const menuPopper = menuTip.getPopperElement(menuEl);
$$('.panel-left').on('panel:opened', function () {
    //localStorageUtil.setLocal('isMobEventPop','1');
    //eventTip.hide(eventPopper);
    if(localStorageUtil.getLocal('isMobMenuPop') != null)
    {
        if(localStorageUtil.getLocal('isMobMenuPop') == '0')
        {
            menuTip.show(menuPopper);
            var panClose = setInterval(function(){
                if(!$('body').hasClass('with-panel-left-cover'))
                {
                    clearInterval(panClose);
                    localStorageUtil.setLocal('isMobMenuPop','1');
                    menuTip.hide(menuPopper);
                    $('.tippy-overlay').addClass('hide');
                }
            },500);
        }
    }
    else
    {
        menuTip.show(menuPopper);
        var panClose = setInterval(function(){
            if(!$('body').hasClass('with-panel-left-cover'))
            {
                clearInterval(panClose);
                localStorageUtil.setLocal('isMobMenuPop','1');
                menuTip.hide(menuPopper);
                $('.tippy-overlay').addClass('hide');
            }
        },500);
    }
});
/*
$(document).on('click','#menu-tip-dismis', function(e){
    e.preventDefault();
    localStorageUtil.setLocal('isMobMenuPop','1');
    menuTip.hide(menuPopper);
    $('.tippy-overlay').addClass('hide');
    myApp.closePanel();
});
$(document).on('click', '.tippy-overlay', function(e){
    e.preventDefault();
});*/
