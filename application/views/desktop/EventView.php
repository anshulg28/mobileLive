
<?php
    if(isset($meta['title']))
    {
        ?>
        <input type="hidden" value="<?php echo $meta['title'];?>" id="docTitle"/>
        <?php
    }
?>

<?php
    if(isset($eventDetails) && myIsMultiArray($eventDetails))
    {
        foreach($eventDetails as $key => $row)
        {
            ?>
            <div class="page-content desktop-event-view">
                <div class="hide" id="eventBookTc"><?php echo $eventBookTc;?></div>
                <div class="content-block event-wrapper mdl-card mdl-shadow--2dp demo-card-header-pic">
                    <div class="more-photos-wrapper">
                        <img src="<?php echo base_url().EVENT_PATH_THUMB.$row['filename'];?>" class="mainFeed-img"/>
                    </div>
                    <div class="card-content">
                        <div class="card-content-inner">
                            <ul class="mdl-list main-avatar-list">
                                <li class="mdl-list__item mdl-list__item--two-line">
                                    <span class="mdl-list__item-primary-content">
                                        <span class="avatar-title">
                                            <?php
                                            $eventName = (strlen($row['eventName']) > 45) ? substr($row['eventName'], 0, 45) . '..' : $row['eventName'];
                                            echo $eventName;
                                            ?>
                                        </span>
                                        <span class="mdl-list__item-sub-title">By <?php echo $row['creatorName'];?></span>
                                    </span>
                                </li>
                            </ul>
                            <div class="mdl-card__supporting-text">
                                <p><?php echo strip_tags($row['eventDescription'],'<br>');?></p>
                            </div>
                            <hr class="card-ptag">

                            <!-- Where Section -->
                            <ul class="mdl-list main-avatar-list">
                                <li class="mdl-list__item mdl-list__item--two-line">
                                    <span class="mdl-list__item-primary-content">
                                        <span class="avatar-title">Where</span>
                                        <span class="mdl-list__item-sub-title item-description">
                                            <?php
                                            if($row['isSpecialEvent'] == STATUS_YES)
                                            {
                                                echo 'Pune';
                                            }
                                            elseif($row['isEventEverywhere'] == '1')
                                            {
                                                echo 'All Taprooms';
                                            }
                                            else
                                            {
                                                echo 'Doolally Taproom, '.$row['locName'];
                                            }
                                            ?>
                                        </span>
                                    </span>
                                    <?php
                                    if($row['isEventEverywhere'] == '0')
                                    {
                                        ?>
                                        <span class="mdl-list__item-secondary-content">
                                            <span class="mdl-list__item-secondary-info">
                                               <a href="<?php echo $row['mapLink'];?>" class="external" target="_blank">
                                                    <i class="ic_me_location_icon point-item my-right-event-icon color-black"></i>
                                                </a>
                                            </span>
                                        </span>
                                        <?php
                                    }
                                    ?>
                                </li>
                            </ul>

                            <!-- When Section -->
                            <?php
                            if($row['showEventDate'] == STATUS_YES || $row['showEventTime'] == STATUS_YES)
                            {
                                ?>
                                <ul class="mdl-list main-avatar-list">
                                    <li class="mdl-list__item mdl-list__item--two-line">
                                    <span class="mdl-list__item-primary-content">
                                        <span class="avatar-title">When</span>
                                        <span class="mdl-list__item-sub-title item-description">
                                            <?php
                                            $d = date_create($row['eventDate']);
                                            $timeShown = false;
                                            if($row['showEventTime'] == STATUS_YES)
                                            {
                                                $timeShown = true;
                                                echo date('h:i a',strtotime($row['startTime'])).'-'.date('h:i a',strtotime($row['endTime']));
                                            }
                                            if($row['showEventDate'] == STATUS_YES)
                                            {
                                                if($timeShown)
                                                {
                                                    echo ', ';
                                                }
                                                echo date_format($d,EVENT_INSIDE_DATE_FORMAT);
                                            }
                                            ?>
                                        </span>
                                    </span>
                                        <span class="mdl-list__item-secondary-content">
                                            <span class="mdl-list__item-secondary-info">
                                               <span class="fa-15x ic_events_icon point-item my-right-event-icon custom-addToCal"
                                                     data-ev-title="<?php echo $row['eventName'];?>" data-ev-location="Doolally Taproom, <?php echo $row['locName'];?>"
                                                     data-ev-start="<?php echo $row['eventDate'].' '.$row['startTime'];?>"
                                                     data-ev-end="<?php echo $row['eventDate'].' '.$row['endTime'];?>"
                                                     data-ev-description="<?php echo strip_tags($row['eventDescription'],'<br>');?>">
                                                </span>
                                            </span>
                                        </span>
                                    </li>
                                </ul>
                                <?php
                            }
                            ?>

                            <!-- Host section -->
                            <ul class="mdl-list main-avatar-list">
                                <li class="mdl-list__item mdl-list__item--two-line">
                                    <span class="mdl-list__item-primary-content">
                                        <span class="avatar-title">Host</span>
                                        <span class="mdl-list__item-sub-title item-description">
                                            <?php echo $row['creatorName']; ?>
                                        </span>
                                    </span>
                                    <span class="mdl-list__item-secondary-content">
                                        <span class="mdl-list__item-secondary-info">
                                           <a href="mailto:<?php echo $row['creatorEmail']; ?>" class="external">
                                                <span class="ic_event_email_icon my-right-event-icon"></span>
                                            </a>
                                        </span>
                                    </span>
                                </li>
                            </ul>

                            <!-- Entry Section -->
                            <?php
                                if($row['showEventPrice'] == STATUS_YES)
                                {
                                    ?>
                                    <ul class="mdl-list main-avatar-list">
                                        <li class="mdl-list__item mdl-list__item--two-line">
                                            <span class="mdl-list__item-primary-content">
                                                <span class="avatar-title">Entry</span>
                                                <span class="mdl-list__item-sub-title item-description">
                                                    <?php
                                                    switch($row['costType'])
                                                    {
                                                        case "1":
                                                            echo "Free";
                                                            break;
                                                        default :
                                                            echo 'Rs. '.$row['eventPrice'];
                                                            break;
                                                    }
                                                    ?>
                                                </span>
                                            </span>
                                        </li>
                                    </ul>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>

                    <div class="mdl-grid my-fullWidth">
                        <div class="mdl-cell mdl-cell--2-col"></div>
                        <div class="mdl-cell mdl-cell--8-col">
                            <?php
                                if($row['isSpecialEvent'] == '1')
                                {
                                    ?>
                                    <a href="http://beerolympics.in" target="_blank" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored bookNow-event-btn">Visit Now </a>
                                    <?php
                                }
                                elseif($row['isEventEverywhere'] == STATUS_YES || (isset($eventCompleted) && $eventCompleted))
                                {
                                    ?>
                                    <!--<a href="#" class="button button-big button-fill bookNow-event-btn" disabled>Thank you for creating! </a>-->
                                    <?php
                                }
                                elseif(isset($userCreated) && $userCreated === true)
                                {
                                    ?>
                                    <a href="#" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored bookNow-event-btn" disabled>Thank you for creating! </a>
                                    <?php
                                }
                                elseif(isset($userBooked) && $userBooked === true)
                                {
                                    ?>
                                    <a href="#" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored bookNow-event-btn" disabled>Thank you for registering! </a>
                                    <?php
                                }
                                elseif($row['isRegFull'] == '1')
                                {
                                    ?>
                                    <a href="#" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored bookNow-event-btn" disabled>Registration Full! </a>
                                    <?php
                                }
                                elseif(isset($isUnderReview) && $isUnderReview === true)
                                {
                                    ?>
                                    <a href="#" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored bookNow-event-btn" disabled>Under Review </a>
                                    <?php
                                }
                                elseif($row['ifActive'] == NOT_ACTIVE || $row['isEventCancel'] == EVENT_CANCEL_REVIEW ||
                                    $row['isEventCancel'] == EVENT_CANCEL_FINAL)
                                {
                                    ?>
                                    <a href="#" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored bookNow-event-btn" disabled>Event Canceled </a>
                                    <?php
                                }
                                elseif(isset($row['eventPaymentLink']) && isStringSet($row['eventPaymentLink']) && stripos($row['eventPaymentLink'],'ticketing.eventshigh.com') !== FALSE)
                                {
                                    ?>
                                    <a href="#" data-href="<?php echo $row['eventPaymentLink'];?>" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored bookNow-event-btn final-booking-btn external">Book Now </a>
                                    <?php
                                }
                                elseif(isset($row['eventPaymentLink']) && isStringSet($row['eventPaymentLink']))
                                {
                                    ?>
                                    <a href="<?php echo $row['eventPaymentLink'];?>" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored bookNow-event-btn external">Book Now </a>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <a href="#" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored bookNow-event-btn" disabled>Book Now </a>
                                    <?php
                                }
                            ?>
                        </div>
                        <div class="mdl-cell mdl-cell--2-col"></div>
                    </div>
                    <br>
                    <div class="mdl-grid my-fullWidth my-NoPadding">
                        <div class="mdl-cell mdl-cell--12-col text-center">
                            <?php
                            if(isset($meta) && myIsMultiArray($meta))
                            {
                                ?>
                                <input type="hidden" id="meta_title" value="<?php echo $meta['title']; ?>"/>
                                <?php
                            }
                            ?>
                            <p class="event-share-text text-center">
                                Share "<?php echo $row['eventName']; ?>"
                            </p>
                            <input type="hidden" data-name="<?php echo $row['eventName'];?>" id="shareLink" value="<?php if(isset($row['shortUrl'])){echo $row['shortUrl'];}else{echo $row['eventShareLink'];}?>"/>
                            <div id="share" class="my-social-share"></div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
            <?php
        }
    }
    else
    {
        ?>
        <div class="page-content">
            <div class="content-block">
                <p>No result Found!</p>
            </div>
        </div>
        <?php
    }
?>
<script>
    $(document).ready(function(){
        if(typeof $('#shareLink').val() != 'undefined')
        {
            $('#share.my-social-share').jsSocials({
                showLabel: true,
                shareIn: "blank",
                showCount: false,
                text:$('#shareLink').attr('data-name'),
                url: $('#shareLink').val(),
                shares: [
                    { share: "twitter", label: "Twitter" },
                    { share: "facebook", label: "Facebook" }
                ]
            });
            var shUrl = $('#shareLink').val();
            $('#share.my-social-share .jssocials-shares').append('<i class="fa fa-link fa-15x copyToClip" data-url="'+shUrl+'"><span>Copy Link</span></i>');
        }
    });
</script>
