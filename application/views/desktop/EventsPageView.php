
<?php
    if(isset($meta['title']))
    {
        ?>
        <input type="hidden" value="Events" id="docTitle"/>
        <?php
    }
?>
<?php
if(isset($weekEvents) && myIsMultiArray($weekEvents))
{
    ?>
    <ul class="hide even-cal-list">
        <?php
        foreach($weekEvents as $key => $row)
        {
            ?>
            <li data-evenDate="<?php echo $row['eventDate'];?>"
                data-evenNames="<?php echo htmlspecialchars($row['eventNames']);?>"
                data-evenEndTimes="<?php echo $row['eventEndTimes'];?>"
                data-evenPlaces="<?php echo $row['eventPlaces'];?>">
            </li>
            <?php
        }
        ?>
    </ul>
    <?php
}
?>
<div class="mdl-shadow--2dp event-creator-box">
    <div class="mdl-grid">
        <div class="mdl-cell--8-col">
            <div class="mdl-textfield mdl-js-textfield">
                <input class="mdl-textfield__input" type="text" name="eventName" id="newEvent">
                <label class="mdl-textfield__label" for="newEvent">Create your event...</label>
            </div>
        </div>
        <div class="mdl-cell--4-col text-right">
            <a href="create_event" id="event-create-btn" data-title="Create Event" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect bookNow-event-btn my-AutoWidth dynamic">
                Continue
            </a>
        </div>
    </div>
</div>
<div class="content-for-mobile"></div>
<div class="event-section" id="desk-event-section">
    <div class="no-search-result hide">No Events Found</div>
    <?php
    if(isset($eventDetails) && myIsMultiArray($eventDetails))
    {
        $postImg = 0;
        foreach($eventDetails as $key => $row)
        {
            if(isEventFinished($row['eventDate'], $row['endTime']))
            {
                continue;
            }
            $img_collection = array();
            ?>
            <div class="search-event-card">
                <div itemscope itemtype="http://schema.org/Event" class="mdl-card mdl-shadow--2dp demo-card-header-pic <?php
                if(isset($row['eventPlace']))
                {
                    if($row['isSpecialEvent'] == STATUS_YES)
                    {
                        echo 'eve-speciall';
                    }
                    elseif($row['isEventEverywhere'] == STATUS_YES)
                    {
                        echo 'eve-all';
                    }
                    else
                    {
                        echo 'eve-'.$row['eventPlace'];
                    }
                }
                ?>" data-eveTitle="<?php echo htmlspecialchars($row['eventName']);?>" data-orgName="<?php echo addslashes($row['creatorName']);?>">

                    <!--<div style="background-image:url()" valign="bottom" class="card-header color-white no-border">Journey To Mountains</div>-->
                    <div class="card-content">
                        <div class="card-content-inner">
                            <?php
                            if($postImg <=2)
                            {
                                ?>
                                <a href="<?php echo 'events/'.$row['eventSlug'];?>" class="dynamic">
                                    <img itemprop="image" src="<?php echo base_url().EVENT_PATH_THUMB.$row['filename'];?>" class="mainFeed-img"/>
                                </a>
                                <?php
                            }
                            else
                            {
                                ?>
                                <a href="<?php echo 'events/'.$row['eventSlug'];?>" class="dynamic">
                                    <img itemprop="image" data-src="<?php echo base_url().EVENT_PATH_THUMB.$row['filename'];?>" class="mainFeed-img lazy"/>
                                </a>
                                <?php
                            }
                            $postImg++;
                            ?>
                            <ul class="mdl-list main-avatar-list">
                                <li class="mdl-list__item mdl-list__item--two-line">
                                                        <span class="mdl-list__item-primary-content">
                                                            <h1 class="hide" itemprop="name"> <?php echo $row['eventName'];?></h1>
                                                            <span class="avatar-title">
                                                                <?php
                                                                $eventName = (mb_strlen($row['eventName']) > 35) ? substr($row['eventName'], 0, 35) . '..' : $row['eventName'];
                                                                echo $eventName;
                                                                ?>
                                                            </span>
                                                            <span class="mdl-list__item-sub-title">By <?php echo $row['creatorName'];?></span>
                                                        </span>
                                    <span class="mdl-list__item-secondary-content">
                                                            <span class="mdl-list__item-secondary-info">
                                                                <input type="hidden" data-img="<?php if(isset($row['verticalImg']) && isStringSet($row['verticalImg'])){echo base_url().EVENT_PATH_THUMB.$row['verticalImg'];}else{echo base_url().EVENT_PATH_THUMB.$row['filename'];} ?>" data-shareTxt="This looks pretty cool, shall we?" data-name="<?php echo htmlspecialchars($row['eventName']);?>" value="<?php if(isset($row['shortUrl'])){echo $row['shortUrl'];}else{echo $row['eventShareLink'];} ?>"/>
                                                                <i class="my-pointer-item ic_me_share_icon pull-right event-share-icn event-card-share-btn"></i>
                                                            </span>
                                                        </span>
                                </li>
                            </ul>
                            <meta class="hide" itemprop="startDate" content="<?php echo $row['eventDate'].'T'.$row['startTime'];?>" />
                            <meta class="hide" itemprop="endDate" content="<?php echo $row['eventDate'].'T'.$row['endTime'];?>" />
                            <div class="mdl-card__supporting-text">
                                <?php
                                $row['eventDescription'] = str_replace('nbsp;',' ',$row['eventDescription']);
                                $eventDescrip = (mb_strlen($row['eventDescription']) > 100) ? substr(strip_tags($row['eventDescription']), 0, 100) . '..' : strip_tags($row['eventDescription']);
                                ?>
                                <a href="<?php echo 'events/'.$row['eventSlug'];?>" class="comment dynamic" itemprop="description">
                                    <?php echo $eventDescrip;?>
                                </a>
                                <p>
                                    <?php
                                    if($row['isEventEverywhere'] == STATUS_NO)
                                    {
                                    $mapSplit = explode('/',$row['mapLink']);
                                    $cords = explode(',',$mapSplit[count($mapSplit)-1]);
                                    ?>
                                <div style="opacity:0;position:absolute;z-index:-1" itemprop="location" itemscope itemtype="http://schema.org/Place">
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
                                <i class="ic_me_location_icon main-loc-icon"></i>&nbsp;<span class="eve-locName"><?php if($row['isSpecialEvent'] == STATUS_YES){echo '1st Brewhouse, Pune';} elseif($row['isEventEverywhere'] == STATUS_YES){echo 'All Taprooms';}else{ echo $row['locName'];} ?></span>
                                <?php
                                if($row['showEventDate'] == STATUS_YES)
                                {
                                    ?>
                                    &nbsp;&nbsp;<span class="ic_events_icon event-date-main my-display-inline"></span>&nbsp;
                                    <span class="eve-eventDate"><?php $d = date_create($row['eventDate']);
                                        echo date_format($d,EVENT_DATE_FORMAT); ?></span>
                                    <?php
                                }
                                if($row['showEventTime'] == STATUS_YES)
                                {
                                    ?>
                                    <i class="material-icons my-display-inline main-time-comp">access_time</i>
                                    <span class="eve-eventDate"><?php $d = date_create($row['startTime']);
                                        echo date_format($d,'g:i a'); ?></span>
                                    <?php
                                }
                                if($row['showEventPrice'] == STATUS_YES)
                                {
                                    ?>
                                    &nbsp;&nbsp;<i class="ic_me_rupee_icon main-rupee-icon"></i>
                                    <?php
                                    switch($row['costType'])
                                    {
                                        case "1":
                                            echo "Free";
                                            break;
                                        default :
                                            echo 'Rs '.$row['eventPrice'];
                                    }
                                }

                                /*if($row['isEventEverywhere'] == STATUS_YES)
                                {
                                    */?><!--
                                    <a href="<?php /*echo 'events/'.$row['eventSlug'];*/?>" class="event-bookNow dynamic">View Details</a>
                                    <?php
/*                                }
                                else
                                {
                                    */?>
                                    <div class="event-action-btns">
                                        <a href="#" data-eventId="<?php /*echo $row['eventId'];*/?>" class="remind-later-btn">Remind Me Later</a>
                                        <div class="btn-divider"></div>
                                        <a href="<?php /*echo 'events/'.$row['eventSlug'];*/?>" class="event-bookNow dynamic">Book Event <i class="ic_back_icon my-display-inline"></i></a>
                                    </div>
                                    --><?php
/*                                }
                                */?>
                                <div class="event-action-btns">
                                    <a href="#" data-eventId="<?php echo $row['eventId'];?>" class="remind-later-btn">Remind Me Later</a>
                                    <div class="btn-divider"></div>
                                    <a href="<?php echo 'events/'.$row['eventSlug'];?>" class="event-bookNow dynamic">Book Event <i class="ic_back_icon my-display-inline"></i></a>
                                </div>
                                <a itemprop="url" href="<?php echo base_url().'?page/events/'.$row['eventSlug'];?>" class="color-black hide"><?php echo $row['eventName'];?></a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    else
    {
        echo 'No Items Found!';
    }
    ?>
</div>

<script>
    $(document).ready(function(){
       if($(window).width() < mobileSize)
       {
           var mobHtm = '<br><div class="content-block-title weekly-cal">What\'s happening this week</div>' +
               '<div id="calendar-mobile-glance"></div><br><div class="content-block-title weekly-cal">All Events</div>';
           var eventAdd = '<a href="create_event" data-title="Create Event" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored mobile-event-create dynamic">\n' +
               '    <i class="ic_add"></i>\n' +
               '</a>';
           $('.event-creator-box').addClass('hide');
           $('.content-for-mobile').html(mobHtm);
           $('.content-for-mobile').append(eventAdd);
           renderCalendarMobile('#eventsTab .even-cal-list');
       }
        $('#eventSearch').fastLiveFilter('#desk-event-section .search-event-card',{
            selector:'.avatar-title,.mdl-list__item-sub-title,.eve-locName,.eve-eventDate',
            callback: function(total){
                if(total == 0)
                {
                    $('#desk-event-section .no-search-result').removeClass('hide');
                }
                else
                {
                    $('#desk-event-section .no-search-result').addClass('hide');
                }
            }
        });
        /*var monkeyList = new List('desk-event-section', {
            valueNames: ['avatar-title','mdl-list__item-sub-title','eve-locName','eve-eventDate'],
            pagination: false
        });*/
        componentHandler.upgradeDom();
    });
</script>


