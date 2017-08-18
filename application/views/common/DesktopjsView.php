<!--not tho change js-->
<script type="application/javascript" src="<?php echo base_url(); ?>asset/js/jquery-2.2.4.min.js"></script>
<script type="application/javascript" src="<?php echo base_url(); ?>asset/js/material.min.js"></script>
<script type="application/javascript" src="<?php echo base_url(); ?>asset/mobile/js/moment.min.js"></script>
<script type="application/javascript" src="<?php echo base_url(); ?>asset/mobile/js/jquery.timeago.js"></script>
<script type="application/javascript" src="<?php echo base_url(); ?>asset/mobile/js/jssocials.min.js"></script>
<script type="application/javascript" src="<?php echo base_url();?>asset/mobile/js/jquery.timepicker.min.js"></script>
<script type="application/javascript" src="<?php echo base_url(); ?>asset/mobile/js/jquery.geolocation.min.js"></script>
<script type="application/javascript" src="<?php echo base_url(); ?>asset/mobile/js/cropper.min.js"></script>
<script type="application/javascript" src="<?php echo base_url(); ?>asset/js/doolally-local-session.js"></script>
<!--<script type="text/javascript" src="<?php /*echo base_url(); */?>asset/js/dialog-polyfill.min.js"></script>-->
<script type="application/javascript" src="<?php echo base_url(); ?>asset/js/vex.combined.min.js"></script>
<script type="application/javascript" src="<?php echo base_url(); ?>asset/mobile/js/fullcalendar.min.js"></script>
<script type="application/javascript" src="<?php echo base_url(); ?>asset/js/jquery.lazy.min.js"></script>
<script type="application/javascript" src="<?php echo base_url(); ?>asset/js/datedropper.min.js"></script>
<!--<script type="application/javascript" src="<?php /*echo base_url(); */?>asset/js/jquery.fastLiveFilter.js"></script>-->
<script type="application/javascript" src="<?php echo base_url(); ?>asset/js/list.min.js"></script>
<script type="application/javascript" src="<?php echo base_url(); ?>asset/js/tippy.min.js"></script>


<script>
    vex.defaultOptions.className = 'vex-theme-plain';
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-86757534-1', 'auto');
    ga('send', 'pageview');


    //Facebook Script
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.7&appId=635771029924628";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

    function saveErrorLog(errorTxt)
    {
        $.ajax({
            type:'POST',
            dataType:'json',
            url:base_url+'main/saveErrorLog',
            data:{errorTxt: errorTxt},
            success: function(data){},
            error: function(){}
        });
    }
</script>
<!-- Loading bar -->
<script>
    $(document).bind("contextmenu",function(e){
        e.preventDefault();
    });
    function showProgressLoader()
    {
        $('#custom-progressBar').removeClass('hide');
    }
    function hideProgressLoader()
    {
        $('#custom-progressBar').addClass('hide');
    }
    function myAlertDiag(type,txt,callBackUrl = '')
    {
        if(type == 'error')
        {
            $('#alertDialog .title-alert').css('color','red').html(txt);
        }
        else
        {
            $('#alertDialog .title-alert').css('color','#000').html(txt);
        }
        var dialog = document.querySelector('#alertDialog');

        if (! dialog.showModal) {
            dialogPolyfill.registerDialog(dialog);
        }
        dialog.showModal();
        dialog.querySelector('.close').addEventListener('click', function() {
            dialog.close();
            $('#alertDialog .mdl-dialog__content').css({
                'height': '',
                'overflow': ''
            });
            if(callBackUrl != '')
            {
                pushHistory('Doolally',callBackUrl,true);
            }
        });
    }
    function mySnackTime(txt)
    {
        var snackbarContainer = document.querySelector('#demo-toast');
        var data = {message: txt};
        snackbarContainer.MaterialSnackbar.showSnackbar(data);

    }
</script>

<script>
    window.jukeLat = 0;
    window.jukeLong = 0;
    window.base_url = '<?php echo base_url(); ?>';
    window.isDynamicReq = false;
    window.lastUrl = base_url;

    var MS_IN_MINUTES = 60 * 1000;
    var formatTime = function(date) {
        return date.toISOString().replace(/-|:|\.\d+/g, '');
    };

    var calculateEndTime = function(event) {
        return event.end ?
            formatTime(event.end) :
            formatTime(new Date(event.start.getTime() + (event.duration * MS_IN_MINUTES)));
    };

    var calendarGenerators = {
        google: function(event) {
            var startTime = formatTime(event.start);
            var endTime = calculateEndTime(event);

            var href = encodeURI([
                'https://www.google.com/calendar/render',
                '?action=TEMPLATE',
                '&text=' + (event.title || ''),
                '&dates=' + (startTime || ''),
                '/' + (endTime || ''),
                '&details=' + (event.description || ''),
                '&location=' + (event.address || ''),
                '&sprop=&sprop=name:'
            ].join(''));
            return '<a class="icon-google external item-link list-button" target="_blank" href="' +
                href + '">Google Calendar</a>';
        },

        yahoo: function(event) {
            var eventDuration = event.end ?
                ((event.end.getTime() - event.start.getTime())/ MS_IN_MINUTES) :
                event.duration;

            // Yahoo dates are crazy, we need to convert the duration from minutes to hh:mm
            var yahooHourDuration = eventDuration < 600 ?
            '0' + Math.floor((eventDuration / 60)) :
            Math.floor((eventDuration / 60)) + '';

            var yahooMinuteDuration = eventDuration % 60 < 10 ?
            '0' + eventDuration % 60 :
            eventDuration % 60 + '';

            var yahooEventDuration = yahooHourDuration + yahooMinuteDuration;

            // Remove timezone from event time
            var st = formatTime(new Date(event.start - (event.start.getTimezoneOffset() *
                    MS_IN_MINUTES))) || '';

            var href = encodeURI([
                'http://calendar.yahoo.com/?v=60&view=d&type=20',
                '&title=' + (event.title || ''),
                '&st=' + st,
                '&dur=' + (yahooEventDuration || ''),
                '&desc=' + (event.description || ''),
                '&in_loc=' + (event.address || '')
            ].join(''));

            return '<a class="icon-yahoo external item-link list-button" target="_blank" href="' +
                href + '">Yahoo! Calendar</a>';
        },

        ics: function(event, eClass, calendarName) {
            var startTime = formatTime(event.start);
            var endTime = calculateEndTime(event);

            var href = encodeURI(
                'data:text/calendar;charset=utf8,' + [
                    'BEGIN:VCALENDAR',
                    'VERSION:2.0',
                    'BEGIN:VEVENT',
                    'URL:' + document.URL,
                    'DTSTART:' + (startTime || ''),
                    'DTEND:' + (endTime || ''),
                    'SUMMARY:' + (event.title || ''),
                    'DESCRIPTION:' + (event.description || ''),
                    'LOCATION:' + (event.address || ''),
                    'END:VEVENT',
                    'END:VCALENDAR'].join('\n'));

            return '<a class="' + eClass + ' external item-link list-button" target="_blank" href="' +
                href + '">' + calendarName + ' Calendar</a>';
        },

        ical: function(event) {
            return this.ics(event, 'icon-ical', 'iCal');
        },

        outlook: function(event) {
            return this.ics(event, 'icon-outlook', 'Outlook');
        }
    };

    var generateCalendars = function(event) {
        return {
            google: calendarGenerators.google(event),
            yahoo: calendarGenerators.yahoo(event),
            ical: calendarGenerators.ical(event),
            outlook: calendarGenerators.outlook(event)
        };
    };
    function ConvertTimeformat(format, str)
    {
        if(str != '')
        {
            var time = str;
            var hours = Number(time.match(/^(\d+)/)[1]);
            var minutes = Number(time.match(/:(\d+)/)[1]);
            //var AMPM = time.substr(-2);
            var AMPM = time.match(/\s(.*)$/)[1];
            if (AMPM == "PM" && hours < 12) hours = hours + 12;
            if (AMPM == "AM" && hours == 12) hours = hours - 12;
            var sHours = hours.toString();
            var sMinutes = minutes.toString();
            if (hours < 10) sHours = "0" + sHours;
            if (minutes < 10) sMinutes = "0" + sMinutes;
            return sHours+":"+sMinutes;
        }
        else
        {
            return '';
        }
    }

    function getGeoError(code)
    {
        switch(code)
        {
            case 0:
                return 'Some Unknown Error Occurred!';
                break;
            case 1:
                return 'User Permission Denied Or Location Unknown';
                break;
            case 2:
                return 'position unavailable (error response from location provider)';
                break;
            case 3:
                return 'Location Fetching Timed out!';
                break;
            default:
                return 'Try again after sometime';
        }
    }
    function showCustomLoader()
    {
        $('body').addClass('custom-loader-body');
        $('.custom-loader-overlay').css('top',$(window).scrollTop()).addClass('show');
    }

    function hideCustomLoader()
    {
        $('body').removeClass('custom-loader-body');
        $('.custom-loader-overlay').removeClass('show');
    }
</script>
<script>
    function renderCalendar()
    {
        if(typeof $('.even-cal-list') === 'undefined')
        {
            var d = new Date();
            $('#calendar-glance').fullCalendar({
                defaultView: 'listWeek',
                header: false,
                height:'parent',
                firstDay: d.getDay(),
                defaultDate: d,
                listDayFormat:'ddd'
            });
        }
        else
        {
            var events = [];
            var d = new Date();
            $('.even-cal-list li').each(function(j,val){
                var tempData = {};
                if(typeof $(val).attr('data-evenNames') !== 'undefined')
                {
                    var eveName = $(val).attr('data-evenNames');
                    if(eveName.indexOf(';') != -1)
                    {
                        var res = eveName.split(';');
                        var places = $(val).attr('data-evenPlaces').split(',');
                        var urls = $(val).attr('data-evenUrls').split(',');
                        for(var i=0;i<res.length;i++)
                        {
                            tempData = {};
                            if(res[i].length > 35)
                            {
                                tempData['title'] = res[i].substr(0,35)+'..';
                            }
                            else
                            {
                                tempData['title'] = res[i];
                            }
                            tempData['allDay'] = true;
                            tempData['start'] = $(val).attr('data-evenDate');
                            tempData['className'] = 'evenPlace_'+places[i];
                            tempData['url'] = urls[i];
                            events.push(tempData);
                        }
                    }
                    else
                    {
                        tempData = {};
                        if(eveName.length > 35)
                        {
                            tempData['title'] = eveName.substr(0,35)+'..';
                        }
                        else
                        {
                            tempData['title'] = eveName;
                        }
                        tempData['allDay'] = true;
                        tempData['start'] = $(val).attr('data-evenDate');
                        tempData['className'] = 'evenPlace_'+$(val).attr('data-evenPlaces');
                        tempData['url'] = $(val).attr('data-evenUrls');
                        events.push(tempData);
                    }
                }
                else
                {
                    tempData = {};
                    tempData['allDay'] = true;
                    tempData['start'] = $(val).attr('data-evenDate');
                    events.push(tempData);
                }
            });
            $('#calendar-glance').fullCalendar({
                defaultView: 'listWeek',
                header: false,
                height:'parent',
                firstDay:d.getDay(),
                defaultDate: d,
                events: events,
                listDayFormat:'ddd',
                eventClick: function(event) {
                    if (event.url) {
                        pushHistory('Doolally',event.url,true);
                        return false;
                    }
                }
            });
        }
        $('#calendar-glance').fullCalendar('render');

        $('#calendar-glance .fc-list-item .fc-list-item-time').html('');
        $('#calendar-glance .fc-list-heading').each(function(i,val){

            var txt = $(val).find('.fc-list-heading-main').html();
            if(txt != '')
            {
                $(val).next().find('.fc-list-item-time').html(txt);
            }
        });
        $('#calendar-glance .fc-list-item').each(function(i,val){
            if(!$(val).hasClass('fc-has-url'))
            {
                $(val).addClass('hide');
            }
            $(val).find('.fc-list-item-title a').addClass('dynamic');
            var txt = $(val).find('.fc-list-item-title a').html();
            if(txt == '')
            {
                $(val).find('.fc-list-item-title').css({
                    'cursor': 'default',
                    'background':'none'
                });
            }
        });
    }
    renderCalendar();

    var contentTime = setInterval(function(){
        if(!$('#mainContent-view').hasClass('my-vanish'))
        {
            clearInterval(contentTime);
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
            $(".lazy").lazy({
                effect : "fadeIn"
            });
        }
    },2000);

    var isFnbShare = false;
    var fnbId = 0;

    $(window).load(function(){
        $('.mainFeed-img').each(function(i,val){
            if($(val).attr('data-src') != '')
            {
                $(val).attr('src',$(val).attr('data-src'));
            }
        });
        $('#mainNavBar').removeClass('hide');
        $('#mainContent-view').removeClass('my-vanish');
        $("time.timeago").timeago();

        if($('#MojoStatus').val() == '1' || $('#eventsHigh').val() == '1')
        {
            vex.dialog.buttons.YES.text = 'Close';
            vex.dialog.alert({
                unsafeMessage: '<label class="head-title">Success</label><br><br>'+'Congrats! You have successfully registered for the event, please find the details in My Events section'
            });
            //alertDialog('Success!','Congrats! You have successfully registered for the event, please find the details in My Events section',false);
            showProgressLoader();
            setTimeout(function(){
                pushHistory('Doolally','event_dash',true);
            },500);
        }
        else if($('#MojoStatus').val() == '2' || $('#eventsHigh').val() == '2')
        {
            vex.dialog.buttons.YES.text = 'Close';
            vex.dialog.alert({
                unsafeMessage: '<label class="head-title">Failed!</label><br><br>'+'Some Error occurred! Please try again!'
            });
            //alertDialog('Failed!','Some Error occurred! Please try again!',false);
        }

        if(isFnbShare)
        {
            isFnbShare = false;
            var wasBeer = false;
            showDesktopTab('#fnbTab');
            $('.sideFnbWrapper .demo-card-header-pic').each(function(i,val){
                if($(val).attr('data-fnbid') == fnbId)
                {
                    if(typeof $(val).attr('data-img') !== 'undefined')
                    {
                        wasBeer = true;
                        $(val).trigger('click');
                    }
                    return false;
                }
            });
            if(!wasBeer)
            {
                $('section#fnbTab .demo-card-header-pic').each(function(i,val){
                    if($(val).attr('data-fnbid') == fnbId)
                    {
                        var pos = $(val).position();
                        $('.mdl-layout__content').animate({
                            scrollTop: pos.top
                        });
                        return false;
                    }
                });
            }
        }
        doLazyWork();
        setInterval(fetchNewFeeds,5*60*1000);
    });
    $(document).on('click','.show-full-beer-card', function(){
        var title = $(this).attr('data-title');
        var description = $(this).attr('data-descrip');
        var fullPrice = $(this).attr('data-fullprice');
        var halfPrice = $(this).attr('data-halfprice');
        var beerImg = $(this).attr('data-img');
        var shareLink = $(this).attr('data-sharelink');

        var beerHtml =  '<div class="mdl-card demo-card-header-pic">'+
                            '<img src="'+beerImg+'" alt="beer" class="mainFeed-img my-default-cursor"/>'+
                            '<ul class="mdl-list main-avatar-list my-NoMargin my-NoPadding">'+
                                '<li class="mdl-list__item mdl-list__item--two-line">'+
                                    '<span class="mdl-list__item-primary-content">'+
                                        '<span class="avatar-title">'+title+'</span>'+
                                    '</span>'+
                                    '<span class="mdl-list__item-secondary-content">'+
                                        '<span class="mdl-list__item-secondary-info">'+
                                            '<input type="hidden" data-name="'+title+'" value="'+shareLink+'"/>'+
                                            '<i class="ic_me_share_icon pull-right event-share-icn fnb-card-share-btn"></i>'+
                                        '</span>'+
                                    '</span>'+
                                '</li>'+
                            '</ul>'+
                            '<div class="mdl-card__supporting-text">'+description+'</div>'+
                        '</div>';

        /*$('#beerDialog').find('img').attr('src',beerImg);
        $('#beerDialog .mdl-dialog__content').find('.title-beer').html(title);
        $('#beerDialog .mdl-dialog__content').find('input').attr('data-name',title).val(shareLink);
        $('#beerDialog .mdl-dialog__content').find('.description-beer').html(description);

        var dialog = document.querySelector('#beerDialog');

        if (! dialog.showModal) {
            dialogPolyfill.registerDialog(dialog);
        }
        dialog.showModal();
        dialog.querySelector('.close').addEventListener('click', function() {
            dialog.close();
        });*/
        vex.dialog.buttons.YES.text = 'Close';
        vex.dialog.open({
            unsafeMessage: beerHtml,
            showCloseButton: false,
            contentClassName: 'beer-overlay-pop'
        });
    });

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
                        //$(ele).parent().find('.liveurl').find('img').addClass('lazy');
                    }
                    else
                    {
                        $(ele).parent().find('.liveurl').find('img').attr('src',data.image);//base_url+'asset/images/placeholder.jpg');
                        //$(ele).parent().find('.liveurl').find('img').attr('data-src',);
                        //$(ele).parent().find('.liveurl').find('img').addClass('lazy');
                    }
                    var mainTitle = data.title;
                    if(data.title.length>45)
                    {
                        mainTitle = data.title.substr(0,45)+'...';
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

    var timelineInitHeight;
    $(document).on('click','a[href="#timelineTab"]', function(){
        localStorageUtil.setLocal('desktopTab','#timelineTab');
        showDesktopTab('#timelineTab');
    });
    $(document).on('click','a[href="#eventsTab"]', function(){
        if($(this).hasClass('is-active') && localStorageUtil.getLocal('desktopTab') == '#eventsTab')
        {
            if(mainEventsHtml != '')
            {
                $('section#eventsTab').fadeOut(500, function() {
                    $(this).html(mainEventsHtml).fadeIn(500);
                });
            }
        }
        localStorageUtil.setLocal('desktopTab','#eventsTab');
        showDesktopTab('#eventsTab');
    });
    $(document).on('click','a[href="#fnbTab"]', function(){
        localStorageUtil.setLocal('desktopTab','#fnbTab');
        showDesktopTab('#fnbTab');
    });


    var loading = false;
    var lastIndex = 5;
    var maxItems = $('.custom-accordion .my-card-items').length;
    var itemsPerLoad = 5;
    $(document).ready(function(){
        //$('#eventsTab #event-create-btn').fadeOut();

        if(isDynamicReq === false)
        {
            showDesktopTab('#timelineTab');
            /*if(localStorageUtil.getLocal('desktopTab') != null && )
            {
                showDesktopTab(localStorageUtil.getLocal('desktopTab'));
            }
            else
            {

            }*/
        }

        if($('#currentUrl').val() == '/' || $('#currentUrl').val().indexOf('filter_events') != -1 ||
            (typeof $('#pageUrl').val() != 'undefined' && ($('#pageUrl').val() == 'events' || $('#pageUrl').val() == 'events/')) )
        {
            $('#event-filter-box').removeClass('hide');
        }
        else
        {
            $('#event-filter-box').addClass('hide');
        }
        timelineInitHeight = $('section#timelineTab').height();

        /*setInterval(function(){
            if($('section#timelineTab').height() != timelineInitHeight && $('a[href="#timelineTab"]').hasClass('is-active'))
            {
                timelineInitHeight = $('section#timelineTab').height();
                showDesktopTab('#timelineTab');
            }
        },1000);*/
    });

    // Each time the user scrolls
    var timelineScroll = 0;
    var eventScroll = 0;
    var fnbScroll = 0;
    $('.mdl-layout__content').scroll(function() {

        if($(this).scrollTop() >= 500)
        {
            $('.scrollUp').fadeIn('slow');
        }

        if($(this).scrollTop() <= 100)
        {
            $('.scrollUp').fadeOut('slow');
        }
        if($('#mainNavBar a:nth-child(1).mdl-layout__tab').hasClass('is-active'))
        {
            timelineScroll = $(this).scrollTop();
        }
        else if($('#mainNavBar a:nth-child(2).mdl-layout__tab').hasClass('is-active'))
        {
            eventScroll = $(this).scrollTop();
        }
        else
        {
            fnbScroll = $(this).scrollTop();
        }

        if($('#mainNavBar a:nth-child(1).mdl-layout__tab').hasClass('is-active'))
        {
            // End of the document reached?
            if ($('section#timelineTab').height() - $('.mainHome').height() <= $(this).scrollTop())
            {
                // Exit, if loading in progress
                if (loading) return;
                loading = true;

                $('#loading-icn').removeClass('hide');
                setTimeout(function(){
                    loading = false;
                    $('#loading-icn').addClass('hide');
                    var totalToLoad = lastIndex + itemsPerLoad;
                    if(totalToLoad > maxItems)
                    {
                        totalToLoad = maxItems;
                    }
                    for (var i = lastIndex; i < totalToLoad; i++) {
                        $($('.custom-accordion .my-card-items')[i]).removeClass('hide');
                        $('.my-card-items').each(function(i,val){
                            if(!$(this).hasClass('hide'))
                            {
                                if(typeof $(this).find('.my-link-url').val() !== 'undefined')
                                    renderLinks($(this).find('.my-link-url'));
                            }
                            //renderLinks(val);
                        });
                    }
                    var oldScroll = $('.mdl-layout__content').scrollTop();
                    $('.mdl-layout__content').scrollTop(oldScroll-100);

                    // Update last loaded index
                    lastIndex = totalToLoad;
                    if (lastIndex >= maxItems) {
                        // Nothing more to load, detach infinite scroll events to prevent unnecessary loading
                        $('#loading-icn').parent().remove();
                    }
                },1000);

            }
        }
        var panelHeight = $('#mainContent-view section.mdl-layout__tab-panel.is-active').height()+50;
        var fnbHeight = $('.sideFnbWrapper').height()+50;
        if(panelHeight > fnbHeight)
        {
            $('.mdl-grid.page-content').css({
                'height': panelHeight,
                'overflow':'hidden'
            });
        }
        else
        {
            $('.mdl-grid.page-content').css({
                'height': fnbHeight,
                'overflow':'hidden'
            });
        }
    });
    function showDesktopTab(tabName)
    {
        $('#mainNavBar .mdl-layout__tab').removeClass('is-active');
        $('#mainContent-view .mdl-layout__tab-panel').removeClass('is-active');
        $('#mainNavBar .common-main-tabs').removeClass('on');
        switch(tabName)
        {
            case '#timelineTab':
                $('#filter-timeline-menu').removeClass('hide');
                $('#filter-events-menu').addClass('hide');
                $('.mdl-layout__content').scrollTop(timelineScroll);
                $('a:nth-child(1).mdl-layout__tab').addClass('is-active');
                $('#mainContent-view section#timelineTab').addClass('is-active');
                $('#mainNavBar a:nth-child(1) .common-main-tabs').addClass('on');
                var newHeight = $('section#timelineTab').height()+100;
                var fnbHeight = $('.sideFnbWrapper').height()+50;
                if(fnbHeight > newHeight)
                {
                    $('.mdl-grid.page-content').css({
                        'height': fnbHeight,
                        'overflow':'hidden'
                    });
                }
                else
                {
                    $('.mdl-grid.page-content').css({
                        'height': newHeight,
                        'overflow':'hidden'
                    });
                }
                break;
            case '#eventsTab':
                if(document.location.href == base_url+'?page/events' || document.location.href == base_url+'?page/events/'
                    || document.location.href.indexOf('filter_events') != -1)
                {
                    $('#filter-timeline-menu').addClass('hide');
                    $('#filter-events-menu').removeClass('hide');
                }
                else
                {
                    $('#filter-timeline-menu').addClass('hide');
                    $('#filter-events-menu').addClass('hide');
                }
                $('.mdl-layout__content').scrollTop(eventScroll);
                $('a:nth-child(2).mdl-layout__tab').addClass('is-active');
                $('#mainContent-view section#eventsTab').addClass('is-active');
                $('#mainNavBar a:nth-child(2) .common-main-tabs').addClass('on');
                var newHeight = $('section#eventsTab').height()+100;
                var fnbHeight = $('.sideFnbWrapper').height()+50;
                if(fnbHeight > newHeight)
                {
                    $('.mdl-grid.page-content').css({
                        'height': fnbHeight,
                        'overflow':'hidden'
                    });
                }
                else
                {
                    $('.mdl-grid.page-content').css({
                        'height': newHeight,
                        'overflow':'hidden'
                    });
                }
                break;
            case '#fnbTab':
                $('#filter-timeline-menu').addClass('hide');
                $('#filter-events-menu').addClass('hide');
                $('.mdl-layout__content').scrollTop(fnbScroll);
                $('a:nth-child(3).mdl-layout__tab').addClass('is-active');
                $('#mainContent-view section#fnbTab').addClass('is-active');
                $('#mainNavBar a:nth-child(3) .common-main-tabs').addClass('on');
                var newHeight = $('section#fnbTab').height()+100;
                var fnbHeight = $('.sideFnbWrapper').height()+50;
                if(fnbHeight > newHeight)
                {
                    $('.mdl-grid.page-content').css({
                        'height': fnbHeight,
                        'overflow':'hidden'
                    });
                }
                else
                {
                    $('.mdl-grid.page-content').css({
                        'height': newHeight,
                        'overflow':'hidden'
                    });
                }
                break;

        }
    }

    function doLazyWork()
    {
        $('.my-card-items').each(function(i,val){
            if($(this).hasClass('hide'))
            {
                if(!$(this).find('.myAvtar-list').hasClass('lazy'))
                {
                    $(this).find('.myAvtar-list').addClass('lazy');
                }
                if(!$(this).find('.mainFeed-img').hasClass('lazy'))
                {
                    $(this).find('.mainFeed-img').addClass('lazy');
                }
            }
        });

        $(".lazy").lazy({
            effect : "fadeIn"
        });
    }

    $(document).on('click','.event-card-share-btn', function(){

        $('#shareDialog .title-share').html('Share "'+$(this).parent().find('input[type="hidden"]').attr('data-name')+'"');
        $('#shareDialog #main-share').jsSocials({
            showLabel: true,
            shareIn: "blank",
            text:$(this).parent().find('input[type="hidden"]').attr('data-shareTxt'),
            url: $(this).parent().find('input[type="hidden"]').val(),
            shares: [
                { share: "twitter", label: "Twitter" },
                { share: "facebook", label: "Facebook" }
            ]
        });
        var shUrl = $(this).parent().find('input[type="hidden"]').val();
        $('#shareDialog #main-share .jssocials-shares').append('<i class="fa fa-link fa-15x copyToClip popupClipIcon" data-url="'+shUrl+'"><span>Copy Link</span></i>');
        /*var dialog = document.querySelector('#shareDialog');

        if (! dialog.showModal) {
            dialogPolyfill.registerDialog(dialog);
        }
        dialog.showModal();
        dialog.querySelector('.close').addEventListener('click', function() {
            dialog.close();
        });*/
        vex.dialog.buttons.YES.text = 'Close';
        vex.dialog.open({
            unsafeMessage: $('#shareDialog').html(),
            showCloseButton: false,
            contentClassName: 'share-overlay-pop'
        });
        //myApp.popover('.popover-share',$(this));
    });
    $(document).on('click','.fnb-card-share-btn', function(){

        $('#shareDialog .title-share').html('Share "'+$(this).parent().find('input[type="hidden"]').attr('data-name')+'"');
        $('#shareDialog #main-share').jsSocials({
            showLabel: true,
            shareIn: "blank",
            text:$(this).parent().find('input[type="hidden"]').attr('data-name'),
            url: $(this).parent().find('input[type="hidden"]').val(),
            shares: [
                { share: "twitter", label: "Twitter" },
                { share: "facebook", label: "Facebook" }
            ]
        });
        var shUrl = $(this).parent().find('input[type="hidden"]').val();
        $('#shareDialog #main-share .jssocials-shares').append('<i class="fa fa-link fa-15x copyToClip popupClipIcon" data-url="'+shUrl+'"><span>Copy Link</span></i>');
        /*var dialog = document.querySelector('#shareDialog');

         if (! dialog.showModal) {
         dialogPolyfill.registerDialog(dialog);
         }
         dialog.showModal();
         dialog.querySelector('.close').addEventListener('click', function() {
         dialog.close();
         });*/
        vex.dialog.buttons.YES.text = 'Close';
        vex.dialog.open({
            unsafeMessage: $('#shareDialog').html(),
            showCloseButton: false,
            contentClassName: 'share-overlay-pop'
        });
        //myApp.popover('.popover-share',$(this));
    });

    $(document).on('click','.scrollUp', function(){
        $('.mdl-layout__content').animate({
            scrollTop:0
        },400);
    });
</script>
<script>
    var mainFeeds = '';

    function highlight(regex,text)
    {
        var m = regex.exec(text);
        if(!m)
            return text;
        for(var i=0;i<m.length;i++)
        {
            descrip[i] = '<label>'+m[i]+'</label>';
        }
        if( typeof descrip !== 'undefined')
        {
            return text.replace(descrip,m);
        }
        else
        {
            return text;
        }
    }
    function fetchNewFeeds()
    {
        $.ajax({
            type:"GET",
            dataType:"json",
            url: '<?php echo  base_url();?>main/returnAllFeeds/json',
            success: function(data)
            {
                if(mainFeeds == '' && typeof mainFeeds == 'undefined')
                {
                    return false;
                }
                var newFeeds = [];
                for(var i=0;i<data.length;i++)
                {
                    var currentId = '';
                    data[i] = $.parseJSON(data[i]['feedText']);
                    switch(data[i]['socialType'])
                    {
                        case 't':
                            currentId = data[i]['id_str'];
                            break;
                        case 'i':
                            currentId = data[i]['id'];
                            break;
                        case 'f':
                            currentId = data[i]['id'];
                            break;
                    }
                    if(currentId == mainFeeds)
                    {
                        break;
                    }
                    else
                    {
                        newFeeds[i] = data[i];
                    }
                }
                if(newFeeds.length > 0)
                {
                    addCards(newFeeds);
                }
            },
            error: function(xhr) {
                console.log('error');
                /*
                 var err = eval("(" + xhr.responseText + ")");
                 alert(err.Message);*/
            }
        });
    }

    String.prototype.capitalize = function() {
        return this.charAt(0).toUpperCase() + this.slice(1);
    }
    function addCards(data)
    {
        var ifUpdate = false;
        var totalNew = 0;
        var oldHeight = $('section#timelineTab').height();
        for(var i=data.length-1;i>=0;i--)
        {
            switch(data[i]['socialType'])
            {
                case 'i':
                    if(ifUpdate == false)
                    {
                        ifUpdate = true;
                        mainFeeds = data[0]['id'];
                    }
                    var urlRegex =/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
                    var backupLink = urlRegex.exec(data[i]['unformatted_message']);
                    var truncated_RestaurantName ='';
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
                    var bigCardHtml = '';
                    bigCardHtml += '<a href="'+data[i]['full_url']+'" target="_blank" class="instagram-wrapper new-post-wrapper hide">';
                    bigCardHtml += '<div class="my-card-items"><div class="mdl-card mdl-shadow--2dp demo-card-header-pic">';
                    bigCardHtml += '<div class="card-content"><div class="card-content-inner">';
                    bigCardHtml += '<ul class="mdl-list main-avatar-list"><li class="mdl-list__item mdl-list__item--two-line">';
                    bigCardHtml += '<span class="mdl-list__item-primary-content"><img class="myAvtar-list mdl-list__item-avatar lazy" data-src="'+data[i]['poster_image']+'" width="44"/>';
                    bigCardHtml += '<span class="avatar-title">'+data[i]['poster_name'].capitalize()+'</span>';
                    if(data[i].hasOwnProperty('source'))
                    {
                        if(data[i]['source']['term_type'] == 'hashtag')
                        {
                            bigCardHtml += '<span class="mdl-list__item-sub-title">#'+data[i]['source']['term']+'</span>';
                        }
                        else if(data[i]['source']['term_type'] == 'hashtag')
                        {
                            <?php $locs = $this->config->item('insta_locationMap');?>
                            bigCardHtml += '<span class="mdl-list__item-sub-title">'+getInstaLoc(data[i]['source']['term'])+'</span>';
                        }
                        else
                        {
                            bigCardHtml += '<span class="mdl-list__item-sub-title">@'+data[i]['source']['term']+'</span>';
                        }
                    }
                    bigCardHtml += '</span><span class="mdl-list__item-secondary-content">';
                    bigCardHtml += '<span class="mdl-list__item-secondary-info">';
                    bigCardHtml += '<i class="fa fa-instagram social-icon-gap"></i></span>';
                    bigCardHtml += '<span class="mdl-list__item-secondary-action">';
                    bigCardHtml += '<time class="timeago time-stamp" datetime="'+data[i]['created_at']+'"></time></span></span>';
                    bigCardHtml += '</li></ul>';
                    if(data[i].hasOwnProperty('image'))
                    {
                        bigCardHtml += '<img data-src="'+data[i]['image']+'" class="mainFeed-img lazy"/>';
                    }
                    else if(data[i].hasOwnProperty('video'))
                    {
                        if(data[i]['video'].indexOf('youtube') != -1 || data[i]['video'].indexOf('youtu.be') != -1)
                        {
                            bigCardHtml += '<iframe width="100%" src="'+data[i]['video']+'" frameborder="0" allowfullscreen>';
                            bigCardHtml += '</iframe>';
                        }
                        else
                        {
                            bigCardHtml += '<video width="100%" controls>';
                            bigCardHtml += '<source src="'+data[i]['video']+'">No Video found!';
                            bigCardHtml += '</video>';
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

                    bigCardHtml += '<div class="mdl-card__supporting-text">';
                    bigCardHtml += '<p class="final-card-text">'+truncated_RestaurantName+'</p>';
                    bigCardHtml += '</div></div></div></div></div></a>';

                    $('section#timelineTab .custom-accordion').prepend(bigCardHtml);

                    totalNew++;
                    break;
                case 'f':
                    if(ifUpdate == false)
                    {
                        ifUpdate = true;
                        mainFeeds = data[0]['id'];
                    }
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
                    bigCardHtml += '<a href="'+data[i]['permalink_url']+'" target="_blank" class="facebook-wrapper new-post-wrapper hide">';
                    bigCardHtml += '<div class="my-card-items"><div class="mdl-card mdl-shadow--2dp demo-card-header-pic">';
                    bigCardHtml += '<div class="card-content"><div class="card-content-inner">';
                    bigCardHtml += '<ul class="mdl-list main-avatar-list"><li class="mdl-list__item mdl-list__item--two-line">';
                    bigCardHtml += '<span class="mdl-list__item-primary-content"><img class="myAvtar-list mdl-list__item-avatar lazy" data-src="https://graph.facebook.com/v2.7/'+data[i]['from']['id']+'/picture" width="44"/>';
                    bigCardHtml += '<span class="avatar-title">'+data[i]['from']['name'].capitalize()+'</span>';
                    bigCardHtml += '</span><span class="mdl-list__item-secondary-content">';
                    bigCardHtml += '<span class="mdl-list__item-secondary-info">';
                    bigCardHtml += '<i class="fa fa-facebook social-icon-gap"></i></span>';
                    bigCardHtml += '<span class="mdl-list__item-secondary-action">';
                    bigCardHtml += '<time class="timeago time-stamp" datetime="'+data[i]['created_at']+'"></time></span></span>';
                    bigCardHtml += '</li></ul>';
                    if(data[i].hasOwnProperty('source'))
                    {
                        if(data[i]['source'].indexOf('youtube') != -1 || data[i]['source'].indexOf('youtu.be') != -1)
                        {
                            bigCardHtml += '<iframe width="100%" src="'+data[i]['source']+'" frameborder="0" allowfullscreen>';
                            bigCardHtml += '</iframe>';
                        }
                        else
                        {
                            bigCardHtml += '<video width="100%" controls>';
                            bigCardHtml += '<source src="'+data[i]['source']+'">No Video found!';
                            bigCardHtml += '</video>';
                        }
                    }

                    else if(data[i].hasOwnProperty('picture'))
                    {
                        bigCardHtml += '<img data-src="'+data[i]['picture']+'" class="mainFeed-img lazy"/>';
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

                    bigCardHtml += '<div class="mdl-card__supporting-text">';
                    bigCardHtml += '<p class="final-card-text">'+truncated_RestaurantName+'</p>';
                    bigCardHtml += '</div></div></div></div></div></a>';

                    $('section#timelineTab .custom-accordion').prepend(bigCardHtml);
                    totalNew++;
                    break;
                case 't':
                    if(ifUpdate == false)
                    {
                        ifUpdate = true;
                        mainFeeds = data[0]['id_str'];
                    }
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
                    bigCardHtml += '<a href="https://twitter.com/'+data[i]['user']['screen_name']+'/status/'+data[i]['id_str']+'" target="_blank" class="twitter-wrapper new-post-wrapper hide">';
                    bigCardHtml += '<div class="my-card-items"><div class="mdl-card mdl-shadow--2dp demo-card-header-pic">';
                    bigCardHtml += '<div class="card-content"><div class="card-content-inner">';
                    bigCardHtml += '<ul class="mdl-list main-avatar-list"><li class="mdl-list__item mdl-list__item--two-line">';
                    bigCardHtml += '<span class="mdl-list__item-primary-content"><img class="myAvtar-list mdl-list__item-avatar lazy" data-src="'+data[i]['user']['profile_image_url_https']+'" width="44"/>';
                    bigCardHtml += '<span class="avatar-title">'+data[i]['user']['name'].capitalize()+'</span>';
                    bigCardHtml += '<span class="mdl-list__item-sub-title">@'+data[i]['user']['screen_name']+'</span>';
                    bigCardHtml += '</span><span class="mdl-list__item-secondary-content">';
                    bigCardHtml += '<span class="mdl-list__item-secondary-info">';
                    bigCardHtml += '<i class="fa fa-twitter social-icon-gap"></i></span>';
                    bigCardHtml += '<span class="mdl-list__item-secondary-action">';
                    bigCardHtml += '<time class="timeago time-stamp" datetime="'+data[i]['created_at']+'"></time></span></span>';
                    bigCardHtml += '</li></ul>';

                    if(data[i].hasOwnProperty('extended_entities'))
                    {
                        var imageLimit = 0;
                        for(var j=0;j<data[i]['extended_entities']['media'].length;j++)
                        {
                            if(imageLimit >= 1)
                            {
                                return false;
                            }
                            imageLimit++;
                            if(typeof data[i]['extended_entities']['media'][j]['media_url_https'] != 'undefined' &&
                                data[i]['extended_entities']['media'][j]['media_url_https'] != '')
                            {
                                bigCardHtml += '<img data-src="'+data[i]['extended_entities']['media'][j]['media_url_https']+'" class="mainFeed-img lazy"/>';
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
                                    bigCardHtml += '<iframe width="100%" src="'+videoUrl+'" frameborder="0" allowfullscreen>';
                                    bigCardHtml += '</iframe>';
                                }
                                else
                                {
                                    bigCardHtml += '<video width="100%" controls>';
                                    bigCardHtml += '<source src="'+videoUrl+'" type="'+videoType+'">No Video found!';
                                    bigCardHtml += '</video>';
                                }
                            }
                        }
                    }
                    else if(data[i]['is_quote_status'] != null && data[i]['is_quote_status'] == true)
                    {
                        bigCardHtml += '<div class="mdl-card__supporting-text">';
                        bigCardHtml += '<p class="final-card-text">'+truncated_RestaurantName+'</p></div>';
                        if(data[i]['quoted_status'] != null && Array.isArray(data[i]['quoted_status']))
                        {
                            bigCardHtml += '<div class="content-block inset quoted-block">';
                            bigCardHtml += '<div class="content-block-inner">';
                            bigCardHtml += '<ul class="mdl-list">';
                            bigCardHtml += '<li class="mdl-list__item mdl-list__item--two-line"><span class="mdl-list__item-primary-content">';
                            bigCardHtml += '<span>'+data[i]['quoted_status']['user']['name']+'</span>';
                            bigCardHtml += '<span class="mdl-list__item-sub-title">@'+data[i]['quoted_status']['user']['screen_name']+'</span>';
                            bigCardHtml += '</span></li></ul>';
                            data[i]['quoted_status']['text'] = data[i]['quoted_status']['text'].replace(urlRegex,'');

                            data[i]['quoted_status']['text'] = data[i]['quoted_status']['text'].replace(/(#[a-z\d-]+)/ig,"<label>$1</label>");
                            data[i]['quoted_status']['text'] = data[i]['quoted_status']['text'].replace(/(@[a-z\d-]+)/ig,"<label>$1</label>");
                            bigCardHtml += '<div class="mdl-card__supporting-text">';
                            bigCardHtml += '<p class="final-card-text">'+data[i]['quoted_status']['text']+'</p></div>';
                            bigCardHtml += '</div></div>';
                        }
                        else if(data[i]['retweeted_status'] != null && Array.isArray(data[i]['retweeted_status']))
                        {
                            bigCardHtml += '<div class="content-block inset quoted-block">';
                            bigCardHtml += '<div class="content-block-inner">';
                            bigCardHtml += '<ul class="mdl-list">';
                            bigCardHtml += '<li class="mdl-list__item mdl-list__item--two-line"><span class="mdl-list__item-primary-content">';
                            bigCardHtml += '<span>'+data[i]['retweeted_status']['quoted_status']['user']['name']+'</span>';
                            bigCardHtml += '<span class="mdl-list__item-sub-title">@'+data[i]['retweeted_status']['quoted_status']['user']['screen_name']+'</span>';
                            bigCardHtml += '</span></li></ul>';
                            data[i]['retweeted_status']['quoted_status']['text'] = data[i]['retweeted_status']['quoted_status']['text'].replace(urlRegex,'');

                            data[i]['retweeted_status']['quoted_status']['text'] = data[i]['retweeted_status']['quoted_status']['text'].replace(/(#[a-z\d-]+)/ig,"<label>$1</label>");
                            data[i]['retweeted_status']['quoted_status']['text'] = data[i]['retweeted_status']['quoted_status']['text'].replace(/(@[a-z\d-]+)/ig,"<label>$1</label>");
                            bigCardHtml += '<div class="mdl-card__supporting-text">';
                            bigCardHtml += '<p class="final-card-text">'+data[i]['retweeted_status']['quoted_status']['text']+'</p></div>';
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

                    if(data[i]['is_quote_status'] != null && data[i]['is_quote_status'] == true)
                    {
                        bigCardHtml += '<div class="mdl-card__supporting-text">';
                        bigCardHtml += '<p class="final-card-text">'+truncated_RestaurantName+'</p>';
                        bigCardHtml += '</div>';
                    }
                    bigCardHtml += '</div></div></div></div></a>';

                    $('section#timelineTab .custom-accordion').prepend(bigCardHtml);
                    /*var oldHeight = $('.custom-accordion').height();
                     $('.custom-accordion').prepend(bigCardHtml);
                     var total = currentPos+($('.custom-accordion').height()- oldHeight);
                     $('.page-content').scrollTop(total);*/
                    totalNew++;
                    break;
            }
        }

        $('section#timelineTab .new-post-wrapper').removeClass('hide').removeClass('new-post-wrapper');
        var total = timelineScroll+($('section#timelineTab .custom-accordion').height()- oldHeight);
        $('.mdl-layout__content').animate({
            scrollTop: total
        },100);

        $('#mainNavBar a:nth-child(1).mdl-layout__tab').find('i').addClass('mdl-badge');
        if(timelineScroll <=100)
        {
            if($('#mainNavBar a:nth-child(1).mdl-layout__tab').find('i').hasClass('mdl-badge'))
            {
                $('#mainNavBar a:nth-child(1).mdl-layout__tab').find('i').removeClass('mdl-badge');
            }
        }
        $("time.timeago").timeago();
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
</script>

<!-- Dynamic Loading Script -->
<script>

    $(window).bind('popstate', function (e) {

        var state = history.state;
        if (state !== null) {
            showProgressLoader();
            document.title = state.title;
            load(state.uri);
        } else {
            window.location.href = base_url;
        }
    });
    function pushHistory(titl,uri,ismobile)
    {
        lastUrl = uri;
        if(ismobile)
        {
            history.pushState({uri:uri,title:titl}, titl, '?page/'+uri);
        }
        else
        {
            history.pushState({uri:uri,title:titl}, titl, uri);
        }

        load(uri);
    }
    function replaceHistory(titl,uri,ismobile)
    {
        lastUrl = uri;
        if(ismobile)
        {
            history.replaceState({uri:uri,title:titl}, titl, '?page/'+uri);
        }
        else
        {
            history.replaceState({uri:uri,title:titl}, titl, uri);
        }

        load(uri);
    }

    $(document).on('click','a.dynamic', function(e){
        e.preventDefault();
        var title = 'Doolally';
        if(typeof $(this).attr('data-title') != 'undefined')
        {
            title = $(this).attr('data-title');
            document.title = title;
        }
        var url = $(this).attr('href');
        if(url != '#')
        {
            showProgressLoader();
            pushHistory(title,url,true);
        }
    });
    function load(url)
    {
        $.ajax({
            type:'POST',
            cache: false,
            url: url,
            data:{isAjax:1},
            success: function(data){
                if(url.indexOf('jukebox') != -1)
                {
                    replaceContent('jukebox',data);
                }
                else if(url.indexOf('taprom') != -1)
                {
                    replaceContent('taprom',data);
                }
                else if(url.indexOf('songlist') != -1)
                {
                    replaceContent('songlist',data);
                }
                else if(url.indexOf('contact_us') != -1)
                {
                    replaceContent('contact_us',data);
                }
                else if(url == 'fnb')
                {
                    replaceContent('fnb',data);
                }
                else
                {
                    replaceContent('',data);
                }
                componentHandler.upgradeDom();
            },
            error: function(xhr, status ,error)
            {
                alert('Error Fetching Details!');
                var err = '<pre>'+xhr.responseText+'</pre>';
                saveErrorLog(err);
            }
        });
    }

    var mainEventsHtml = '';
    function replaceContent(pageName, data)
    {
        switch(pageName)
        {
            case 'taprom':
            case 'songlist':
            case 'jukebox':
                //FB.XFBML.parse();
                //renderButton();
                resetTabs();
                $('#mainContent-view section.mdl-layout__tab-panel').removeClass('is-active');
                $('section#jukeboxTab').html(data).addClass('is-active');
                break;
            case 'contact_us':
                resetTabs();
                $('#mainContent-view section.mdl-layout__tab-panel').removeClass('is-active');
                $('section#contactTab').html(data).addClass('is-active');
                break;
            case 'fnb':
                showDesktopTab('#fnbTab');
                $('#mainContent-view section.mdl-layout__tab-panel').removeClass('is-active');
                $('section#fnbTab').html(data).addClass('is-active');
                break;
            default:
                showDesktopTab('#eventsTab');
                $('section#eventsTab').fadeOut(500, function() {
                    $(this).html(data).fadeIn(500);
                    changeTitle();
                });
        }
        hideProgressLoader();
        var panelHeight = $('#mainContent-view section.mdl-layout__tab-panel.is-active').height()+50;
        var fnbHeight = $('.sideFnbWrapper').height()+50;
        if(panelHeight > fnbHeight)
        {
            $('.mdl-grid.page-content').css({
                'height': panelHeight,
                'overflow':'hidden'
            });
        }
        else
        {
            $('.mdl-grid.page-content').css({
                'height': fnbHeight,
                'overflow':'hidden'
            });
        }
        $('.scrollUp').click();
        setTimeout(function(){
            $('.lazy').each(function(i,val){
                if(typeof $(val).attr('data-src') != 'undefined')
                {
                    setTimeout(function(){
                        $(val).attr('src',$(val).attr('data-src'));
                    },500);
                }
            });
           /* $(".lazy").lazy({
                effect : "fadeIn"
            });*/
        },1000);

        setTimeout(function(){
            //Checking for special event
            var specialEve = '';
            $('#eventsTab .event-section div.demo-card-header-pic').each(function(i,val){
                if($(val).hasClass('eve-special'))
                {
                    console.log('in');
                    specialEve = $(val);
                    $(val).remove();
                    return false;
                }
            });
            if(specialEve != '')
            {
                console.log('doing');
                $('#eventsTab .event-section').prepend(specialEve);
            }
        },1000);
    }

    function checkForDynamic()
    {
        mainEventsHtml = $('section#eventsTab').html();
        if(typeof $('#pageName').val() != 'undefined' && typeof $('#pageUrl').val() != 'undefined')
        {
            isDynamicReq = true;
            //showDesktopTab('#eventsTab');
            var pageName = $('#pageName').val();
            var pageUrl = $('#pageUrl').val();
            var title = window.document.title;
            if(pageName == 'fnbshare')
            {
                isFnbShare = true;
                fnbId = pageUrl.split('-')[1];
            }
            /*else if(pageUrl == 'events' || pageUrl == 'events/')
            {
                showDesktopTab('#eventsTab');
            }*/
            else if(pageUrl.indexOf('filter_events') != -1)
            {
                showDesktopTab('#eventsTab');
                $.ajax({
                    type:'GET',
                    cache:false,
                    url:pageUrl,
                    dataType:'json',
                    success: function(data)
                    {
                        if(data.status === true)
                        {
                            console.log(data.locId );
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
            else
            {
                showProgressLoader();
                pushHistory(title,pageUrl,true);
            }
        }
    }
    checkForDynamic();

    function changeTitle()
    {
        if(typeof $('#docTitle').val() !== 'undefined' && $('#docTitle').val() != '' )
        {
            document.title= $('#docTitle').val();
        }
    }

    function resetTabs()
    {
        $('#mainNavBar .mdl-layout__tab').removeClass('is-active');
        $('#mainNavBar .common-main-tabs').removeClass('on');
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
                vex.dialog.buttons.YES.text = 'Close';
                vex.dialog.alert({
                    unsafeMessage: '<label class="head-title">Error!</label><br><br>'+'Login Canceled!'
                });
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
                    unsafeMessage: '<label class="head-title">Error!</label><br><br>'+'User login cancelled because email id is not received.'
                });
            }
            else
            {
                $(this).attr('disabled','disabled');
                var postData = {
                    'fbId': response.id,
                    'email': response.email
                };

                showProgressLoader();
                $.ajax({
                    type:'POST',
                    dataType:'json',
                    url:base_url+'main/checkJukeboxUser',
                    data:postData,
                    success: function(data)
                    {
                        hideProgressLoader();
                        $(this).removeAttr('disabled');
                        replaceHistory('Doolally',lastUrl,true);
                    },
                    error: function(xhr, status, error){
                        hideProgressLoader();
                        $(this).removeAttr('disabled');
                        vex.dialog.buttons.YES.text = 'Close';
                        vex.dialog.alert({
                            unsafeMessage: '<label class="head-title">Error!</label><br><br>'+'Some Error Occurred!'
                        });
                        var err = '<pre>'+xhr.responseText+'</pre>';
                        saveErrorLog(err);
                    }
                });
            }
        });
    }

    // Google plus login script
    function onSuccess(googleUser) {
        $(this).attr('disabled','disabled');
        var postData = {
            'fbId': googleUser.getBasicProfile().getId(),
            'email': googleUser.getBasicProfile().getEmail()
        };

        showProgressLoader();
        $.ajax({
            type:'POST',
            dataType:'json',
            url:base_url+'main/checkJukeboxUser',
            data:postData,
            success: function(data)
            {
                hideProgressLoader();
                $(this).removeAttr('disabled');
                replaceHistory('Doolally',lastUrl,true);
            },
            error: function(xhr, status, error){
                hideProgressLoader();
                $(this).removeAttr('disabled');
                vex.dialog.buttons.YES.text = 'Close';
                vex.dialog.alert({
                    unsafeMessage: '<label class="head-title">Error!</label><br><br>'+'Some Error Occurred!'
                });
                var err = '<pre>'+xhr.responseText+'</pre>';
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

    $(document).on('click','#jukebox-login-btn', function(){
        if($('#jukebox-login-form input[name="email"]').val() == '')
        {
            vex.dialog.buttons.YES.text = 'Close';
            vex.dialog.alert({
                unsafeMessage: '<label class="head-title">Error!</label><br><br>'+'Email Id is Required!'
            });
        }
        $(this).attr('disabled','disabled');
        showProgressLoader();
        $.ajax({
            type:'POST',
            dataType:'json',
            url:base_url+'main/checkJukeboxUser',
            data:{email:$('#jukebox-login-form input[name="email"]').val()},
            success: function(data)
            {
                hideProgressLoader();
                $(this).removeAttr('disabled');
                replaceHistory('Doolally',lastUrl,true);
            },
            error: function(xhr, status, error){
                hideProgressLoader();
                $(this).removeAttr('disabled');
                vex.dialog.buttons.YES.text = 'Close';
                vex.dialog.alert({
                    unsafeMessage: '<label class="head-title">Error!</label><br><br>'+'Some Error Occurred!'
                });
                var err = '<pre>'+xhr.responseText+'</pre>';
                saveErrorLog(err);
            }
        });
    });

    $(document).on('click','#juke-logout', function(){
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
            console.log('User signed out.');
        });
        /*if(GoogleAuth.isSignedIn.get())
        {
            GoogleAuth.signOut();
        }*/
        showProgressLoader();
        $.ajax({
            type:'GET',
            dataType:'json',
            url:base_url+'main/appLogout',
            cache:false,
            success: function(data){
                hideProgressLoader();
                if(data.status === true)
                {
                    replaceHistory('Doolally',lastUrl,true);
                }
            },
            error: function(xhr, status, error){
                hideProgressLoader();
                vex.dialog.buttons.YES.text = 'Close';
                vex.dialog.alert({
                    unsafeMessage: '<label class="head-title">Error!</label><br><br>'+'Some Error Occurred!'
                });
                var err = '<pre>'+xhr.responseText+'</pre>';
                saveErrorLog(err);
            }
        });
    });

    $(document).on('click','.demo-list-two .request_song_btn', function(){
        var songId = $(this).attr('data-songId');
        var tapId = $(this).attr('data-tapId');
        var song = $(this);
        $.geolocation.get({
            win: function(position)
            {
                jukeLat = position.coords.latitude;
                jukeLong = position.coords.longitude;
                showProgressLoader();
                var postData = {
                    'songId': songId,
                    'tapId': tapId,
                    'location': jukeLong+','+jukeLat
                };
                $.ajax({
                    type:'POST',
                    dataType:'json',
                    url: base_url+'main/playTapSong',
                    data:postData,
                    success: function(data){
                        hideProgressLoader();
                        if(data.status === true)
                        {
                            $(song).addClass('hide');
                            mySnackTime('Your Song Queued');
                        }
                        else if(data.errorNum == '1')
                        {
                            vex.dialog.buttons.YES.text = 'Close';
                            vex.dialog.alert({
                                unsafeMessage: '<label class="head-title">Error!</label><br><br>'+data.errorMsg
                            });

                        }
                        else if(data.errorNum == '2')
                        {
                            vex.dialog.buttons.YES.text = 'Close';
                            vex.dialog.alert({
                                unsafeMessage: '<label class="head-title">Error!</label><br><br>'+data.errorMsg
                            });
                        }
                    },
                    error: function(xhr, status,error){
                        hideProgressLoader();
                        vex.dialog.buttons.YES.text = 'Close';
                        vex.dialog.alert({
                            unsafeMessage: '<label class="head-title">Error!</label><br><br>'+'Some Error Occurred!'
                        });
                        var err = '<pre>'+xhr.responseText+'</pre>';
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

    $(document).on('submit','#event-login-form #main-event-form', function(e){
        e.preventDefault();
        if($(this).find('input[name="email"]').val() == '' && $(this).find('input[name="mobNum"]').val() == '')
        {
            vex.dialog.buttons.YES.text = 'Close';
            vex.dialog.alert({
                unsafeMessage: '<label class="head-title">Error!</label><br><br>'+'All Fields Are Required!'
            });
        }
        $(this).find('button[type="submit"]').attr('disabled','disabled');
        showProgressLoader();
        $.ajax({
            type:'POST',
            dataType:'json',
            url:base_url+'main/checkUser',
            data:$(this).serialize(),
            success: function(data)
            {
                hideProgressLoader();
                if(data.status == false)
                {
                    vex.dialog.buttons.YES.text = 'Close';
                    vex.dialog.alert({
                        unsafeMessage: '<label class="head-title">Error!</label><br><br>'+data.errorMsg
                    });
                }
                else
                {
                    replaceHistory('Doolally',lastUrl,true);
                }
                $(this).find('button[type="submit"]').removeAttr('disabled');
            },
            error: function(xhr, status, error){
                hideProgressLoader();
                $(this).find('button[type="submit"]').removeAttr('disabled');
                vex.dialog.buttons.YES.text = 'Close';
                vex.dialog.alert({
                    unsafeMessage: '<label class="head-title">Error!</label><br><br>'+'Some Error Occurred!'
                });
                var err = '<pre>'+xhr.responseText+'</pre>';
                saveErrorLog(err);
            }
        });
    });

    function copyToClipboard(element,isBody) {
        var $temp = $("<input>");
        if(isBody)
        {
            $('body').append($temp);
        }
        else
        {
            $('.share-overlay-pop').append($temp);
        }
        $temp.val(element).focus().select();
        document.execCommand("copy");
        $temp.remove();
    }

    $(document).on('click','.copyToClip', function(){
        var url = $(this).attr('data-url');
        if($(this).hasClass('popupClipIcon'))
        {
            copyToClipboard(url,false);
        }
        else
        {
            copyToClipboard(url,true);
        }
        vex.dialog.buttons.YES.text = 'Close';
        vex.dialog.alert({
            unsafeMessage: '<label class="head-title">Success!</label><br><br>'+'Copied To Clipboard'
        });
    });

    $(document).on('keyup','#eventsTab #newEvent', function(){
        /*if($(this).val() == '')
        {
            $('#eventsTab #event-create-btn').fadeOut('slow');
        }
        else
        {
            $('#eventsTab #event-create-btn').fadeIn('slow');
        }*/

        localStorageUtil.setLocal('eventName',$(this).val());

    });
</script>

<!-- Event Add Page events -->
<script>
    var filesArr = [];
    var cropData = {};
    var hasCropped = false;
    function uploadChange(ele)
    {
        $('.event-add-page .event-img-after').removeClass('hide');
        $('.event-add-page .event-img-before').addClass('hide');
        var xhr = [];
        var totalFiles = ele.files.length;
        for(var i=0;i<totalFiles;i++)
        {
            xhr[i] = new XMLHttpRequest();
            (xhr[i].upload || xhr[i]).addEventListener('progress', function(e) {
                var done = e.position || e.loaded;
                var total = e.totalSize || e.total;
                document.querySelector('#eventProgress').addEventListener('mdl-componentupgraded', function() {
                    this.MaterialProgress.setProgress(Math.round(done/total*100));
                });
                //$('.event-add .event-img-after .progressbar').css('width', Math.round(done/total*100)+'%').attr('aria-valuenow', Math.round(done/total*100)).html(parseInt(Math.round(done/total*100))+'%');
            });
            xhr[i].addEventListener('load', function(e) {
                //$('.event-add button[type="submit"]').removeAttr('disabled');
            });
            xhr[i].open('post', base_url+'dashboard/uploadEventFiles', true);

            var data = new FormData;
            data.append('attachment', ele.files[i]);
            xhr[i].send(data);
            xhr[i].onreadystatechange = function(e) {
                if (e.srcElement.readyState == 4 && e.srcElement.status == 200) {
                    if(e.srcElement.responseText == 'Some Error Occurred!')
                    {
                        vex.dialog.buttons.YES.text = 'Close';
                        vex.dialog.alert({
                            unsafeMessage: '<label class="head-title">Error!</label><br><br>'+'File size Limit 30MB'
                        });
                        return false;
                    }
                    filesArr = [];
                    filesArr.push(e.srcElement.responseText);
                    document.querySelector('#eventProgress').addEventListener('mdl-componentupgraded', function() {
                        this.MaterialProgress.setProgress(0);
                    });
                    $('.event-add-page .event-img-after #eventProgress').addClass('hide');
                    var eventImg = base_url+'uploads/events/thumb/'+e.srcElement.responseText;
                    $('.event-add-page .event-img-space').addClass('hide');
                    $('.event-add-page #cropContainerModal').removeClass('hide').find('#img-container').attr('src',eventImg);
                    cropData['imgUrl'] = eventImg;
                    $('.event-add-page #img-container').cropper({
                        viewMode:3,
                        minContainerHeight: 250,
                        dragMode:'move',
                        aspectRatio: 16 / 9
                    });
                }
            }
        }
    }
    function timeCheck()
    {
        var startTime  = ConvertTimeformat('24', $('.event-add-page input[name="startTime"]').val());
        var endTime  = ConvertTimeformat('24', $('.event-add-page input[name="endTime"]').val());

        if(startTime != '' && endTime != '')
        {
            var sArray = startTime.split(':');
            var eArray = endTime.split(':');
            if($('.event-add-page input[name="eventPlace"]').val() != '4')
            {
                if(Number(sArray[0]) >= 7 && Number(eArray[0]) <= 11)
                {
                    $('.event-add-page .micDiv').removeClass('disabledbutton');
                }
                else
                {
                    $('.event-add-page .micDiv input[type="checkbox"]').attr('checked',false);
                    $('.event-add-page .micDiv').addClass('disabledbutton');
                }
            }
            else
            {
                if(Number(sArray[0]) >= 7 && Number(eArray[0]) <= 16)
                {
                    $('.event-add-page .micDiv').removeClass('disabledbutton');
                }
                else
                {
                    $('.event-add-page .micDiv input[type="checkbox"]').attr('checked',false);
                    $('.event-add-page .micDiv').addClass('disabledbutton');
                }
            }
            if(Number(sArray[0]) >= 7 && Number(eArray[0]) <= 16)
            {
                $('.event-add-page .projDiv').removeClass('disabledbutton');
            }
            else
            {
                $('.event-add-page .projDiv input[type="checkbox"]').attr('checked',false);
                $('.event-add-page .projDiv').addClass('disabledbutton');
            }
        }
        else
        {
            $('.event-add-page .micDiv input[type="checkbox"]').attr('checked',false);
            $('.event-add-page .projDiv input[type="checkbox"]').attr('checked',false);
            $('.event-add-page .micDiv').addClass('disabledbutton');
            $('.event-add-page .projDiv').addClass('disabledbutton');
        }
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
    function maxLengthCheck(object)
    {
        if (object.value.length > object.maxLength)
            object.value = object.value.slice(0, object.maxLength)
    }
    function fillEventImgs()
    {
        if(typeof filesArr[0] != 'undefined')
            $('.event-add-page input[name="attachment"]').val(filesArr.join());
    }
    $(document).on('click','.event-add-page .event-img-add-btn', function(){

        $('.event-add-page #event-img-upload').click();
    });
    $(document).on('click', '.event-add-page .upload-done-icon', function(){
        $('.event-add-page #cropContainerModal .done-overlay').removeClass('hide');
        $(this).addClass('hide');
        $('.event-add-page #eventName').focus();
    });
    $(document).on('click','.event-add-page .upload-img-close', function(){
        filesArr = [];
        $('.event-add-page .event-img-after #eventProgress').removeClass('hide');
        $('.event-add-page .event-img-after').addClass('hide');
        $('.event-add-page .event-img-before').removeClass('hide');
        $('.event-add-page #event-img-upload').val('');
        $('.event-add-page .event-img-space').removeClass('hide');
        $('.event-add-page #cropContainerModal').addClass('hide');
        $('.event-add-page #img-container').cropper('destroy');
    });
    $(document).on('click','.event-add-page .event-img-remove', function(){
        filesArr = [];
        $('.event-add-page .event-img-after #eventProgress').removeClass('hide');
        $('.event-add-page .event-img-after .event-img-remove').addClass('hide');
        $('.event-add-page .event-img-after').addClass('hide');
        $('.event-add-page .event-img-before').removeClass('hide');
        $('.event-add-page #event-img-upload').val('');
        $('.event-add-page .event-img-space').css({
            'background': '#EDEDEC'
        });
    });
    $(document).on('click', '.event-add-page .event-overlay-remove', function(){
        $('.event-add-page #cropContainerModal .done-overlay').addClass('hide');
        $('.event-add-page .upload-done-icon').removeClass('hide');
    });
    $(document).on('click','.event-add-page .readEvent-guide', function(){
        vex.dialog.buttons.YES.text = 'Close';
        vex.dialog.alert({
            unsafeMessage: '<div style="height:300px;overflow:auto">'+$('.event-add-page #event-guide').html()+'</div>'
        });
        /*myAlertDiag('',$('.event-add-page #event-guide').html());
        $('#alertDialog .mdl-dialog__content').css({
            'height': '300px',
            'overflow': 'auto'
        });*/
    });
    $(document).on('keyup','.event-add-page #eventPrice', function(){
        var basic = <?php echo NEW_DOOLALLY_FEE;?>;
        var inputVal = Number($(this).val());
        if(inputVal > 0)
        {
            var total = basic+inputVal;
            $('.event-add-page .total-event-price').html(total);
            $('.event-add-page input[name="eventPrice"]').val(total);
        }
        else
        {
            $('.event-add-page .total-event-price').html(0);
            $('.event-add-page input[name="eventPrice"]').val(0);
        }
    });

    $(document).on('change','.event-add-page input[name="costType"]', function(){
        if($(this).val() == '1')
        {
            $('.event-add-page input[name="eventPrice"]').val(0);
            $('.event-add-page .total-event-price').html(0);
            $('.event-add-page #eventPrice').attr('disabled', 'disabled');
        }
        else
        {
            $('.event-add-page #eventPrice').removeAttr('disabled');
        }
    });

    $(document).on('click','.event-add-page .micSection', function(){

        if($(this).find('.micDiv').hasClass('disabledbutton'))
        {
            mySnackTime('Pa System Available from 7 am to 11 am');
        }
    });
    $(document).on('click','.event-add-page .projSection', function(){

        if($(this).find('.projDiv').hasClass('disabledbutton'))
        {
            mySnackTime('Projector Available from 7 am to 4 pm');
        }
    });

    $(document).on('change','.event-add-page select[name="eventPlace"]', function(){
        if($(this).val() != '' && $('.event-add-page #eventDate').val() != '' && $('.event-add-page input[name="startTime"]').val() != ''
            && $('.event-add-page input[name="endTime"]').val() != '')
        {
            var postData = {
                'startTime' : $('.event-add-page input[name="startTime"]').val(),
                'endTime' : $('.event-add-page input[name="endTime"]').val(),
                'eventPlace' : $(this).val(),
                'eventDate' : $('.event-add-page #eventDate').val()
            };

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
                        unsafeMessage: '<label class="head-title">Error!</label><br><br>'+'Some Error Occurred!'
                    });
                    var err = '<pre>'+xhr.responseText+'</pre>';
                    saveErrorLog(err);
                }
            });
        }
    });

    $(document).on('submit', '.event-add-page #eventSave', function(e){
        e.preventDefault();
        var eventAddStatus = false;
        var formObj = this;

        if($('.event-add-page #eventName').val() == '')
        {
            mySnackTime('Event Name Required!');
            return false;
        }
        if($('.event-add-page #eventDesc').val() == '')
        {
            mySnackTime('Event Description Required!');
            return false;
        }
        if($('.event-add-page #eventPlace').val() == '')
        {
            mySnackTime('Event Place Required!');
            return false;
        }
        if($('.event-add-page #creatorName').val() == '')
        {
            mySnackTime('Organiser Name Required!');
            return false;
        }
        if($('.event-add-page #creatorPhone').val() == '')
        {
            mySnackTime('Organiser Phone Required!');
            return false;
        }
        if($('.event-add-page #creatorEmail').val() == '')
        {
            mySnackTime('Organiser Email Required!');
            return false;
        }
        if(!$('.event-add-page #tnc').is(':checked'))
        {
            mySnackTime('Please Agree To T&C!');
            return false;
        }
        if($('.event-add-page input[name="startTime"]').val() == '' || $('.event-add-page input[name="endTime"]').val() == '')
        {
            mySnackTime('Start and End Time Required!');
            return false;
        }

        /*var d = new Date($('.event-add-page #eventDate').val());
        var startT = ConvertTimeformat('24',$('.event-add-page input[name="startTime"]').val());
        var endT = ConvertTimeformat('24',$('.event-add-page input[name="endTime"]').val());*/
        /*if(d.getDay() == 6 || d.getDay() == 0)
        {
            if(startT < "07:00")
            {
                mySnackTime('On weekends, events can be organised from 7 am to 2 pm!');
                return false;
            }
            if(endT > "14:00")
            {
                mySnackTime('On weekends, events can be organised from 7 am to 2 pm!');
                return false;
            }
        }
        else
        {
            if(startT < "07:00")
            {
                mySnackTime('On weekdays, events can be organised from 7 am to 6 pm!');
                return false;
            }
            if(endT > "18:00")
            {
                mySnackTime('On weekdays, events can be organised from 7 am to 6 pm!');
                return false;
            }
        }*/

        /*if(startT > endT)
        {
            mySnackTime('Event Time is not proper!');
            return false;
        }*/
        if(typeof cropData['imgUrl'] != 'undefined' && eventAddStatus === false)
        {
            showProgressLoader();
            cropData['imgData'] = $('#img-container').cropper('getCroppedCanvas').toDataURL();
            $.ajax({
                type:'POST',
                dataType:'json',
                url:base_url+'dashboard/cropEventImage',
                data:{data: cropData},
                success: function(data)
                {
                    hideProgressLoader();
                    if(data.status == 'error')
                    {
                        mySnackTime(data.message);
                        return false;
                    }
                    else
                    {
                        filesArr = [];
                        var uri = data.url.split('/');
                        filesArr.push(uri[uri.length-1]);
                        fillEventImgs();
                        eventAddStatus = true;
                        addEvent(formObj);
                    }
                },
                error: function(xhr, status, error)
                {
                    hideProgressLoader();
                    mySnackTime('Some Error Occurred!');
                    var err = '<pre>'+xhr.responseText+'</pre>';
                    saveErrorLog(err);
                    return false;
                }
            });
        }
        else if(eventAddStatus === false)
        {
            if($('.event-add-page input[name="attachment"]').val() != '')
            {
                addEvent(formObj);
            }
            else
            {
                fillEventImgs();
            }
        }
        else if($('.event-add-page input[name="attachment"]').val() == '')
        {
            mySnackTime('Cover Image Required!');
            return false;
        }
        else if(eventAddStatus === true)
        {
            addEvent(formObj);
        }
    });
    var isReqPending = false;
    function addEvent(ele)
    {
        if(!isReqPending)
        {
            isReqPending = true;
            showProgressLoader();
            $.ajax({
                type:'POST',
                dataType:'json',
                url:$(ele).attr('action'),
                data:$(ele).serialize(),
                success: function(data){
                    isReqPending = false;
                    if(data.status == true)
                    {
                        vex.dialog.buttons.YES.text = 'Close';
                        vex.dialog.alert({
                            unsafeMessage: '<label class="head-title">Success</label><br><br>'+'Thank you for creating an event, ' +
                            'We have sent you a confirmation email, please check for event status in My Events section.',
                            callback: function(){
                                setTimeout(function(){
                                    pushHistory('Doolally','event_dash',true);
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
                    isReqPending= false;
                    vex.dialog.buttons.YES.text = 'Close';
                    vex.dialog.alert({
                        unsafeMessage: '<label class="head-title">Error!</label><br><br>'+'Some Error Occurred!'
                    });
                    var err = '<pre>'+xhr.responseText+'</pre>';
                    saveErrorLog(err);
                }
            });
        }
    }

    //For Event Edit
    var eventEditStatus = false;
    var isReqEditPending = false;
    $(document).on('submit', '.event-add-page #eventEditSave', function(e){
        e.preventDefault();

        var formObj = this;

        if($('.event-add-page #eventName').val() == '')
        {
            mySnackTime('Event Name Required!');
            return false;
        }
        if($('.event-add-page #eventDesc').val() == '')
        {
            mySnackTime('Event Description Required!');
            return false;
        }
        /*if($('.event-add-page #eventPlace').val() == '')
        {
            mySnackTime('Event Place Required!');
            return false;
        }*/
        if($('.event-add-page #creatorName').val() == '')
        {
            mySnackTime('Organiser Name Required!');
            return false;
        }
        if($('.event-add-page #creatorPhone').val() == '')
        {
            mySnackTime('Organiser Phone Required!');
            return false;
        }
        if($('.event-add-page #creatorEmail').val() == '')
        {
            mySnackTime('Organiser Email Required!');
            return false;
        }
        if(!$('.event-add-page #tnc').is(':checked'))
        {
            mySnackTime('Please Agree To T&C!');
            return false;
        }
        if($('.event-add-page input[name="startTime"]').val() == '' || $('.event-add-page input[name="endTime"]').val() == '')
        {
            mySnackTime('Start and End Time Required!');
            return false;
        }

       /* var d = new Date($('.event-add-page #eventDate').val());
        var startT = ConvertTimeformat('24',$('.event-add-page input[name="startTime"]').val());
        var endT = ConvertTimeformat('24',$('.event-add-page input[name="endTime"]').val());*/
        /*if(d.getDay() == 6 || d.getDay() == 0)
        {
            if(startT < "07:00")
            {
                mySnackTime('On weekends, events can be organised from 7 am to 2 pm!');
                return false;
            }
            if(endT > "14:00")
            {
                mySnackTime('On weekends, events can be organised from 7 am to 2 pm!');
                return false;
            }
        }
        else
        {
            if(startT < "07:00")
            {
                mySnackTime('On weekdays, events can be organised from 7 am to 6 pm!');
                return false;
            }
            if(endT > "18:00")
            {
                mySnackTime('On weekdays, events can be organised from 7 am to 6 pm!');
                return false;
            }
        }*/

        /*if(startT > endT)
        {
            mySnackTime('Event Time is not proper!');
            return false;
        }*/
        if(typeof cropData['imgUrl'] != 'undefined' && eventEditStatus === false)
        {
            showProgressLoader();
            cropData['imgData'] = $('#img-container').cropper('getCroppedCanvas').toDataURL();
            $.ajax({
                type:'POST',
                dataType:'json',
                url:base_url+'dashboard/cropEventImage',
                data:{data: cropData},
                success: function(data)
                {
                    hideProgressLoader();
                    if(data.status == 'error')
                    {
                        mySnackTime(data.message);
                        return false;
                    }
                    else
                    {
                        filesArr = [];
                        var uri = data.url.split('/');
                        filesArr.push(uri[uri.length-1]);
                        fillEventImgs();
                        eventEditStatus = true;
                        editEvent(formObj);
                    }
                },
                error: function(xhr, status, error)
                {
                    hideProgressLoader();
                    mySnackTime('Some Error Occurred!');
                    var err = '<pre>'+xhr.responseText+'</pre>';
                    saveErrorLog(err);
                    return false;
                }
            });
        }
        else if($('.event-add-page input[name="attachment"]').val() == '')
        {
            mySnackTime('Cover Image Required!');
            return false;
        }
        else if(eventEditStatus === false)
        {
            if($('.event-add-page input[name="attachment"]').val() != '')
            {
                editEvent(formObj);
            }
            else
            {
                fillEventImgs();
            }
        }
        else if(eventEditStatus === true)
        {
            editEvent(formObj);
        }
    });

    function editEvent(ele)
    {
        if(!isReqEditPending)
        {
            isReqEditPending = true;
            showProgressLoader();
            $.ajax({
                type:'POST',
                dataType:'json',
                url:$(ele).attr('action'),
                data:$(ele).serialize(),
                success: function(data){
                    isReqEditPending = false;
                    if(data.status == true)
                    {
                        if(data.noChange === true)
                        {
                            vex.dialog.buttons.YES.text = 'Close';
                            vex.dialog.alert({
                                unsafeMessage: '<label class="head-title">Information</label><br><br>'+'No Changes Found!',
                                callback: function(){
                                    setTimeout(function(){
                                        pushHistory('Doolally','event_dash',true);
                                    },500);
                                }
                            });
                        }
                        else
                        {
                            vex.dialog.buttons.YES.text = 'Close';
                            vex.dialog.alert({
                                unsafeMessage: '<label class="head-title">Success</label><br><br>'+'Your event is now in review state, ' +
                                'We will sent you mail once review is done, you can check for event status in My Events section.',
                                callback: function(){
                                    setTimeout(function(){
                                        pushHistory('Doolally','event_dash',true);
                                    },500);
                                }
                            });
                        }
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
                    isReqEditPending = false;
                    vex.dialog.buttons.YES.text = 'Close';
                    vex.dialog.alert({
                        unsafeMessage: '<label class="head-title">Error!</label><br><br>'+'Some Error Occurred!'
                    });
                    var err = '<pre>'+xhr.responseText+'</pre>';
                    saveErrorLog(err);
                }
            });
        }

    }

    $(document).on('click','#dashboard-logout', function(){
        showProgressLoader();
        $.ajax({
            type:'GET',
            dataType:'json',
            url:base_url+'main/appLogout',
            cache:false,
            success: function(data){
                hideProgressLoader();
                if(data.status === true)
                {
                    replaceHistory('Doolally',lastUrl,true);
                }
            },
            error: function(xhr, status, error){
                hideProgressLoader();
                vex.dialog.buttons.YES.text = 'Close';
                vex.dialog.alert({
                    unsafeMessage: '<label class="head-title">Error!</label><br><br>'+'Some Error Occurred!'
                });
                var err = '<pre>'+xhr.responseText+'</pre>';
                saveErrorLog(err);
            }
        });
    });

    $(document).on('click','.custom-addToCal', function(){
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

        var beerHtml =  '<div class="mdl-card demo-card-header-pic">'+
                            '<p>Save To Calendar: "'+evTitle+'"</p>'+
                            '<ul class="demo-list-icon mdl-list">'+
                                '<li class="mdl-list__item"><span class="mdl-list__item-primary-content">'+cal.google+'</li>'+
                                '<li class="mdl-list__item"><span class="mdl-list__item-primary-content">'+cal.ical+'</li>'+
                                '<li class="mdl-list__item"><span class="mdl-list__item-primary-content">'+cal.yahoo+'</li>'+
                                '<li class="mdl-list__item"><span class="mdl-list__item-primary-content">'+cal.outlook+'</li>'+
                            '</ul></div>';

        vex.dialog.buttons.YES.text = 'Close';
        vex.dialog.open({
            unsafeMessage: beerHtml,
            showCloseButton: false,
            contentClassName: 'calender-overlay-pop'
        });
        //$(this).html(myCalendar);

    });

    //Event details page events
    $(document).on('click','.event-details-page .event-cancel-btn', function(){
        var isConfirm = false;
        vex.dialog.buttons.YES.text = 'Cancel Event';
        vex.dialog.buttons.NO.text = 'Close';
        vex.dialog.confirm({
            unsafeMessage: '<label class="head-title">Cancel Event?</label><br><br>'+"We will send your cancellation request to the venue's Community Manager.",
            showCloseButton: true,
            afterClose: function(){
                vex.closeAll();
                if(isConfirm)
                {
                    cancelEvent($('.event-details-page #eventId').val());
                }
            },
            callback: function (value) {
                if (value) {
                    isConfirm = true;
                }
            }
        });
        //confirmDialog('Cancel Event?', "Once you tap 'Cancel Event', your event will be cancelled within 48 hours. All" +
        //" the fees collected will be refunded to the attendees.",'Cancel Event', $$('.event-details #eventId').val(), false);
    });
    function cancelEvent(eventId)
    {
        showProgressLoader();
        $.ajax({
            method:"GET",
            url: base_url+'dashboard/cancelEvent/'+eventId,
            cache: false,
            dataType: 'json',
            success: function(data){
                hideProgressLoader();
                if(data.status === true)
                {
                    window.history.back();
                }
            },
            error: function(xhr, status, error){
               hideProgressLoader();
                mySnackTime('Some Error Occurred!');
                var err = '<pre>'+xhr.responseText+'</pre>';
                saveErrorLog(err);
                vex.closeTop();
            }
        });
    }

    $(document).on('click','.eventDash .eve-cancel-btn', function() {
        var bookerId = $(this).attr('data-bookerId');

        vex.dialog.buttons.YES.text = 'Yes';
        vex.dialog.confirm({
            message: 'Are you sure you want to cancel?',
            callback: function (value) {
                if (value) {
                    showProgressLoader();
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: base_url + 'eventCancel',
                        data: {bId: bookerId},
                        success: function (data) {
                            hideProgressLoader();
                            if (data.status == true) {
                                vex.dialog.buttons.YES.text = 'Close';
                                vex.dialog.alert({
                                    unsafeMessage: '<label class="head-title">Success!</label><br><br>We will inform the organiser that you will not be attending the event. For paid events, the money will be fully refunded to you.',
                                    callback: function () {
                                        setTimeout(function () {
                                            replaceHistory('Doolally', 'event_dash', true);
                                        }, 500);
                                    }
                                });

                            }
                            else {
                                vex.dialog.buttons.YES.text = 'Close';
                                vex.dialog.alert({
                                    unsafeMessage: '<label class="head-title">Error!</label><br><br>' + data.errorMsg
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            hideProgressLoader();
                            vex.dialog.buttons.YES.text = 'Close';
                            vex.dialog.alert({
                                unsafeMessage: '<label class="head-title">Error!</label><br><br>Some Error Occurred!'
                            });
                            var err = '<pre>'+xhr.responseText+'</pre>';
                            saveErrorLog(err);
                        }
                    });
                } else {

                }
            }
        });
    });

    //Filter Code for timeline

    $(document).on('change','.filter-timeline-list input[name=social-filter]',function(){
        var notSelectedFilters = [];
        var selectedFilters = [];
        $(".filter-timeline-list input[name=social-filter]:not(:checked)").each(function(){
            notSelectedFilters.push($(this).val());
            switch($(this).val())
            {
                case "1":
                    $('#timelineTab .facebook-wrapper').fadeOut();
                    //$$('#timelineTab .page-content').scrollTop($(document).height(),500);
                    break;
                case "2":
                    $('#timelineTab .twitter-wrapper').fadeOut();
                    //$$('#timelineTab .page-content').scrollTop($(document).height(),500);
                    break;
                case "3":
                    $('#timelineTab .instagram-wrapper').fadeOut();
                    //$$('#timelineTab .page-content').scrollTop($(document).height(),500);
                    break;
            }
        });
        if(notSelectedFilters.length == 3)
        {
            //$$('.infinite-scroll-preloader').hide();
            $('#timelineTab .facebook-wrapper').fadeIn();
            $('#timelineTab .twitter-wrapper').fadeIn();
            $('#timelineTab .instagram-wrapper').fadeIn();
        }
        $(".filter-timeline-list input[name=social-filter]:checked").each(function(){
            selectedFilters.push($(this).val());
            switch($(this).val())
            {
                case "1":
                    $('#timelineTab .facebook-wrapper').fadeIn();
                    break;
                case "2":
                    $('#timelineTab .twitter-wrapper').fadeIn();
                    break;
                case "3":
                    $('#timelineTab .instagram-wrapper').fadeIn();
                    break;
            }
        });
        /*if(selectedFilters.length >= 1)
        {
            $$('.infinite-scroll-preloader').show();
        }*/
    });
    var fnb_initial_state = '';
    var event_initial_state = '';
    $(document).on('change', '.filter-events-list input[name="event-locations"]', function(){
        if(typeof $(this).val() != 'undefined')
        {
            if(event_initial_state == '')
            {
                event_initial_state = $('#eventsTab .event-section').html();
            }
            $('.filter-events-list .clear-event-filter').removeClass('my-vanish');
            $('#filter-events-menu').addClass('on');
            var filterVal = $(this).val();
            //var catArray = '';
            if(event_initial_state != '')
            {
                $('#eventsTab .event-section').html(event_initial_state);
            }
            var specialEves = $('#eventsTab .eve-special');
            var allLocEves = $('#eventsTab .eve-all');
            var catArray = $('#eventsTab .eve-'+filterVal);
            if(catArray.length == 0)
            {
                $('#eventsTab .event-section').append('No Events Found!');
            }
            else
            {
                $(catArray).hide();
                $('#eventsTab .eve-'+filterVal).remove();
                $('#eventsTab .event-section').prepend(catArray);
                $(catArray).slideToggle();
            }
            if(allLocEves.length != 0)
            {
                $('#eventsTab .event-section').prepend(allLocEves);
            }
            if(specialEves.length != 0)
            {
                $('#eventsTab .event-section').prepend(specialEves);
            }

            //myApp.closeModal('.popover-event-filter');
        }
    });

    $(document).on('click','.filter-events-list .clear-event-filter', function(){

        $('#filter-events-menu').removeClass('on');
        $('.filter-events-list li').each(function(i,val){
            if(typeof $(val).find('input').val() != 'undefined')
            {
                var inp = '#'+$(val).find('input').attr('id');
                document.querySelector(inp).parentNode.MaterialRadio.uncheck();
            }
        });
        $('.filter-events-list .clear-event-filter').addClass('my-vanish');
        if(event_initial_state != '')
        {
            $('#eventsTab .event-section').empty().html(event_initial_state);
        }
            //myApp.closeModal('.popover-event-filter');

        //document.querySelector('input[name="beer-locations"]').parentNode.MaterialRadio.uncheck();
    });

    // Filtering beer
    $(document).on('change', '.filter-fnb-list input[name="beer-locations"]', function(){
        if(typeof $(this).val() != 'undefined')
        {
            if(fnb_initial_state == '')
            {
                fnb_initial_state = $('.sideFnbWrapper').html();
            }
            $('.filter-fnb-list .clear-fnb-filter').removeClass('my-vanish');
            $('#filter-fnb-menu').addClass('on');
            var filterVal = $(this).val();
            $('.sideFnbWrapper .show-full-beer-card').each(function(i,val){
                if(!$(val).hasClass('category-'+filterVal))
                {
                    $(val).parent().hide();
                }
            });
        }
    });

    $(document).on('click','.filter-fnb-list .clear-fnb-filter', function(){
        $('#filter-fnb-menu').removeClass('on');
        $('.filter-fnb-list li').each(function(i,val){
            if(typeof $(val).find('input').val() != 'undefined')
            {
                var inp = '#'+$(val).find('input').attr('id');
                document.querySelector(inp).parentNode.MaterialRadio.uncheck();
            }
        });
        $(this).addClass('my-vanish');
        if(fnb_initial_state != '')
        {
            $('.sideFnbWrapper').empty().html(fnb_initial_state);
        }
            //myApp.closeModal('.popover-filters');

        //document.querySelector('input[name="beer-locations"]').parentNode.MaterialRadio.uncheck();
    });

    $(document).on('click','#filter-fnb-menu', function(){
        setTimeout(function(){
            var pos = $('#filter-fnb-menu').position();
            var wid = $('.sideFnbWrapper').width();
            $('.fnb-side-menu-wrapper .mdl-menu__container').css("left",(pos.left-wid)+40);
        },10);
    });
</script>


<!-- Age Gate code -->
<script>
    if(localStorageUtil.getLocal("ageGateGone") == null)
    {
        $('#doolally-age-gate').removeClass('hide');
    }
    $(document).on('click','#doolally-age-gate .age-gate-yes', function(){
        localStorageUtil.setLocal("ageGateGone","1");
        $('#doolally-age-gate').addClass('hide');
    });

    const eventTip =  tippy('#main-events-tab',{
        //html: '#my-events-tooltip',
        arrow: true,
        position: 'bottom-start',
        animation: 'scale',
        duration: 500,
        //interactive: true,
        trigger: 'manual',
        //hideOnClick: 'persistent',
        multiple:true,
        hidden: function(){
            localStorageUtil.setLocal('isEventPop','1');
            $('#demo-menu-lower-left').click();
            if(localStorageUtil.getLocal('isMenuPop') != null)
            {
                if(localStorageUtil.getLocal('isMenuPop') == '0')
                {
                    menuTip.show(menuPopper);
                }
            }
            else
            {
                menuTip.show(menuPopper);
            }
        },
        inertia: true
    });
    const eventEl = document.querySelector('#main-events-tab');
    const eventPopper = eventTip.getPopperElement(eventEl);

    const menuTip =  tippy('#main-web-menu',{
        //html: '#my-events-tooltip',
        arrow: true,
        position: 'right',
        animation: 'scale',
        duration: 500,
        //interactive: true,
        trigger: 'manual',
        //hideOnClick: 'persistent',
        multiple:true,
        hidden: function(){
            //menuTip.hide(menuPopper);
            localStorageUtil.setLocal('isMenuPop','1');
            $('.tippy-overlay').addClass('hide');
        },
        inertia: true
    });
    const menuEl = document.querySelector('#main-web-menu');
    const menuPopper = menuTip.getPopperElement(menuEl);

    $(window).load(function(){
        //my-events-tooltip
        if(localStorageUtil.getLocal('isEventPop') != null)
        {
            if(localStorageUtil.getLocal('isEventPop') == '0')
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
    });
    /*$(document).on('click','#event-tip-dismis', function(e){
        e.preventDefault();
        localStorageUtil.setLocal('isEventPop','1');
        eventTip.hide(eventPopper);
        $('#demo-menu-lower-left').click();
    });*/
    /*$(document).on('click','#demo-menu-lower-left', function(){
        /!*localStorageUtil.setLocal('isEventPop','1');
        eventTip.hide(eventPopper);*!/
        if(localStorageUtil.getLocal('isMenuPop') != null)
        {
            if(localStorageUtil.getLocal('isMenuPop') == '0')
            {
                menuTip.show(menuPopper);
                /!*var tempMenu = setInterval(function(){
                    if(!$('.main-menu-container .mdl-menu__container.is-upgraded').hasClass('is-visible'))
                    {
                        localStorageUtil.setLocal('isMenuPop','1');
                        menuTip.hide(menuPopper);
                        $('.tippy-overlay').addClass('hide');
                        clearInterval(tempMenu);
                    }
                },100);*!/
            }
        }
        else
        {
            menuTip.show(menuPopper);
            /!*var tempMenu = setInterval(function(){
                if(!$('.main-menu-container .mdl-menu__container.is-upgraded').hasClass('is-visible'))
                {
                    localStorageUtil.setLocal('isMenuPop','1');
                    menuTip.hide(menuPopper);
                    $('.tippy-overlay').addClass('hide');
                    clearInterval(tempMenu);
                }
            },100);*!/
        }
    });*/
    /*$(document).on('click','#menu-tip-dismis', function(e){
        e.preventDefault();
        localStorageUtil.setLocal('isMenuPop','1');
        menuTip.hide(menuPopper);
        $('.tippy-overlay').addClass('hide');
    });
    $(document).on('click', '.tippy-overlay', function(e){
        e.preventDefault();
        console.log('in');
    });*/

    function createEventsHigh(eventData)
    {

        var postData = {
            'event_id': 'e851c4854663c3aa71097066a647fec2',
            'refund_amount' : 0,
            'booking_id' : 'kiskX'
        };

        var ifError = '';
        showCustomLoader();
        $.ajax({
            type:'POST',
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            url:'https://developer.eventshigh.com/refund_booking?key=ev3nt5h1ghte5tK3y',
            data: JSON.stringify(postData),
            success: function(data){
                console.log(data);
                if(data.status == 'error')
                {
                    if(typeof data.message !== 'undefined')
                    {
                        hideCustomLoader();
                        ifError = data.message;
                        bootbox.alert(data.message);
                    }
                }
            },
            error: function(xhr, status, error){
                hideCustomLoader();
                bootbox.alert('Some Error Occurred!');
                var err = '<pre>'+xhr.responseText+'</pre>';
                saveErrorLog(err);
            }
        });
    }
</script>