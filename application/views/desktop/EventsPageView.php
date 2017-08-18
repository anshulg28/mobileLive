
<?php
    if(isset($meta['title']))
    {
        ?>
        <input type="hidden" value="Events" id="docTitle"/>
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
<div class="event-section">
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
            <div itemscope itemtype="http://schema.org/Event" class="mdl-card mdl-shadow--2dp demo-card-header-pic <?php
            if(isset($row['eventPlace']))
            {
                if($row['isSpecialEvent'] == STATUS_YES)
                {
                    echo 'eve-special';
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
            ?>" data-eveTitle="<?php echo $row['eventName'];?>">
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
                <!--<div style="background-image:url()" valign="bottom" class="card-header color-white no-border">Journey To Mountains</div>-->
                <div class="card-content">
                    <div class="card-content-inner">
                        <ul class="mdl-list main-avatar-list">
                            <li class="mdl-list__item mdl-list__item--two-line">
                                                        <span class="mdl-list__item-primary-content">
                                                            <h1 class="hide" itemprop="name"> <?php echo $row['eventName'];?></h1>
                                                            <span class="avatar-title">
                                                                <?php
                                                                $eventName = (strlen($row['eventName']) > 45) ? substr($row['eventName'], 0, 45) . '..' : $row['eventName'];
                                                                echo $eventName;
                                                                ?>
                                                            </span>
                                                            <span class="mdl-list__item-sub-title">By <?php echo $row['creatorName'];?></span>
                                                        </span>
                                <span class="mdl-list__item-secondary-content">
                                                            <span class="mdl-list__item-secondary-info">
                                                                <input type="hidden" data-name="<?php echo $row['eventName'];?>" value="<?php if(isset($row['shortUrl'])){echo $row['shortUrl'];}else{echo $row['eventShareLink'];} ?>"/>
                                                                <i class="my-pointer-item ic_me_share_icon pull-right event-share-icn event-card-share-btn"></i>
                                                            </span>
                                                        </span>
                            </li>
                        </ul>
                        <meta class="hide" itemprop="startDate" content="<?php echo $row['eventDate'].'T'.$row['startTime'];?>" />
                        <meta class="hide" itemprop="endDate" content="<?php echo $row['eventDate'].'T'.$row['endTime'];?>" />
                        <div class="mdl-card__supporting-text">
                            <?php
                            $eventDescrip = (strlen($row['eventDescription']) > 100) ? substr($row['eventDescription'], 0, 100) . '..' : $row['eventDescription'];
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
                            <i class="ic_me_location_icon main-loc-icon"></i>&nbsp;<?php if($row['isSpecialEvent'] == STATUS_YES){echo 'Pune';} elseif($row['isEventEverywhere'] == STATUS_YES){echo 'All Taprooms';}else{ echo $row['locName'];} ?>
                            <?php
                            if($row['showEventDate'] == STATUS_YES)
                            {
                                ?>
                                &nbsp;&nbsp;<span class="ic_events_icon event-date-main my-display-inline"></span>&nbsp;
                                <?php $d = date_create($row['eventDate']);
                                echo date_format($d,EVENT_DATE_FORMAT); ?>
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
                            if($row['isEventEverywhere'] == '1')
                            {
                                ?>
                                <a href="<?php echo 'events/'.$row['eventSlug'];?>" class="event-bookNow dynamic">View Details</a>
                                <?php
                            }
                            else
                            {
                                ?>
                                <a href="<?php echo 'events/'.$row['eventSlug'];?>" class="event-bookNow dynamic">Book Event <i class="ic_back_icon my-display-inline"></i></a>
                                <?php
                            }
                            ?>
                            <a itemprop="url" href="<?php echo base_url().'?page/events/'.$row['eventSlug'];?>" class="color-black hide"><?php echo $row['eventName'];?></a>
                            </p>
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

