<!DOCTYPE html>
<html lang="en">

<body>
<!-- Status bar overlay for full screen mode (PhoneGap) -->
<!-- Top Navbar-->
<?php
    if(isset($eventDetails) && myIsMultiArray($eventDetails))
    {
        foreach($eventDetails as $key => $row)
        {
            ?>
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="left">
                        <a href="#" class="back link" data-ignore-cache="true">
                            <i class="ic_back_icon point-item"></i>
                        </a>
                    </div>
                    <div class="center sliding"><?php echo htmlspecialchars($row['eventName']);?></div>
                    <div class="right">
                        <i class="ic_me_refresh_icon point-item page-refresh-btn"></i>
                    </div>
                </div>
            </div>
            <div class="pages">
                <div data-page="eventSingle" class="page event-details">
                    <div class="page-content">
                        <?php
                            if(isset($status) && $status === false)
                            {
                                ?>
                                <a href="#" class="open-login-screen" id="login-btn">Open Login Screen</a>
                                <input type="hidden" id="isLoggedIn" value="0"/>
                                <?php
                            }
                            else
                            {
                                ?>
                                <div class="content-block event-wrapper">
                                    <input type="hidden" id="eventId" value="<?php echo $row['eventId'];?>"/>
                                    <div class="comment my-event-status">
                                <span>
                                <?php
                                if($row['ifApproved'] == EVENT_DECLINED)
                                {
                                    ?>
                                    <i class="ic_me_info_icon info-icon"></i>&nbsp;&nbsp;Event Declined!<?php
                                }
                                elseif($row['ifApproved'] == EVENT_WAITING)
                                {
                                    ?>
                                    <i class="ic_me_info_icon info-icon"></i>&nbsp;&nbsp;Review In Progress...<?php
                                }
                                elseif($row['ifApproved'] == EVENT_APPROVED && $row['ifActive'] == ACTIVE)
                                {
                                    ?>
                                    <i class="ic_me_info_icon info-icon"></i>&nbsp;&nbsp;Event Approved!<?php
                                }
                                elseif($row['ifApproved'] == EVENT_APPROVED && $row['ifActive'] == NOT_ACTIVE)
                                {
                                    ?>
                                    <i class="ic_me_info_icon info-icon"></i>&nbsp;&nbsp;Event Approved But Not Active<?php
                                }
                                elseif(isEventFinished($row['eventDate'], $row['endTime']))
                                {
                                    ?>
                                    <i class="ic_me_info_icon info-icon"></i>&nbsp;&nbsp;Event Completed<?php
                                }
                                ?>
                                </span>
                                    </div>
                                    <div class="row bottom-share-panel no-gutter">
                                        <div class="col-50">
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-content-inner">
                                                <span>
                                                    <i class="ic_me_rupee_icon main-rupee-icon"></i>
                                                    <label class="bigInfo">
                                                        <?php
                                                        if($row['costType'] == "1")
                                                        {
                                                            ?>
                                                            Free
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            $total = (int)$row['eventPrice'] * (int)$row['totalQuant'];
                                                            if(isset($EHTotal))
                                                            {
                                                                $EHAmt = (int)$row['eventPrice'] * (int)$EHTotal;
                                                                $total = $total + $EHAmt;
                                                            }
                                                            echo number_format($total);
                                                        }
                                                        ?>
                                                    </label>
                                                </span>
                                                        <br> Amount Collected
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-50">
                                            <?php
                                            if(isset($row['totalQuant']))
                                            {
                                                ?>
                                                <a href="<?php echo 'signup_list/EV-'.$row['eventId'].'/'.encrypt_data('EV-'.$row['eventId']);?>" data-ignore-cache="true" class="link event-bookNow">
                                                    <div class="card numbr-signup">
                                                        <div class="card-content">
                                                            <div class="card-content-inner">
                                                                <label class="bigInfo"><?php
                                                                    if(isset($row['totalQuant']))
                                                                    {
                                                                        $totQnt = $row['totalQuant'];
                                                                        if(isset($EHTotal))
                                                                        {
                                                                            $totQnt += $EHTotal;
                                                                        }
                                                                        echo $totQnt;
                                                                    }
                                                                    else
                                                                    {
                                                                        echo '0';
                                                                    }
                                                                    ?></label>
                                                                <br> Signups
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <div class="card numbr-signup">
                                                    <div class="card-content">
                                                        <div class="card-content-inner">
                                                            <label class="bigInfo"><?php
                                                                if(isset($row['totalQuant']))
                                                                {
                                                                    echo $row['totalQuant'];
                                                                }
                                                                else
                                                                {
                                                                    echo '0';
                                                                }
                                                                ?></label>
                                                            <br> Signups
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>

                                        </div>
                                    </div>
                                    <div class="list-block">
                                        <ul>
                                            <li>
                                                <?php
                                                if(isset($row['isEventCancel']) && ($row['isEventCancel'] == EVENT_CANCEL_REVIEW || $row['isEventCancel'] == EVENT_CANCEL_FINAL))
                                                {
                                                    ?>
                                                    <!--<a href="#" data-ignore-cache="true" class="link item-link list-button color-black event-bookNow" disabled>Edit Event</a>-->
                                                    <?php
                                                }
                                                elseif(isset($eventCompleted) && $eventCompleted)
                                                {

                                                }
                                                elseif(isEventStarted($row['eventDate'], $row['startTime']) || isEventFinished($row['eventDate'], $row['endTime']))
                                                {

                                                }
                                                else
                                                {
                                                    ?>
                                                    <a href="<?php echo 'eventEdit/'.$row['eventSlug'];?>" data-ignore-cache="true" class="link item-link list-button color-black event-bookNow">Edit Event</a>
                                                    <?php
                                                }
                                                ?>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="list-block">
                                        <ul>
                                            <li>
                                                <?php
                                                    if(isset($eventCompleted) && $eventCompleted)
                                                    {
                                                        ?>
                                                        <a href="#" class="item-link list-button color-black" disabled>Event Completed</a>
                                                        <?php
                                                    }
                                                    elseif(isset($row['isEventCancel']) && $row['isEventCancel'] == EVENT_CANCEL_REVIEW)
                                                    {
                                                        ?>
                                                        <a href="#" class="item-link list-button color-black" disabled>Cancellation in Review</a>
                                                        <?php
                                                    }
                                                    elseif(isset($row['isEventCancel']) && $row['isEventCancel'] == EVENT_CANCEL_FINAL)
                                                    {
                                                        ?>
                                                        <a href="#" class="item-link list-button color-black" disabled>Event Cancelled</a>
                                                        <?php
                                                    }
                                                    elseif(isEventFinished($row['eventDate'], $row['endTime']))
                                                    {
                                                        ?>
                                                        <a href="#" class="item-link list-button color-black" disabled>Event Completed</a>
                                                        <?php
                                                    }
                                                    elseif(isEventStarted($row['eventDate'], $row['startTime']))
                                                    {
                                                        ?>
                                                        <a href="#" class="item-link list-button color-black" disabled>Event In Progress</a>
                                                        <?php
                                                    }

                                                    else
                                                    {
                                                        ?>
                                                        <a href="#" data-eveId="<?php echo $row['eventId'];?>" data-commNum="<?php echo $commDetails['mobNum'];?>" data-commName="<?php echo $commDetails['userName'];?>" class="item-link list-button color-black event-cancel-btn">Cancel Event</a>
                                                        <?php
                                                    }
                                                ?>
                                            </li>
                                        </ul>
                                    </div>
                                    <!--<div class="comment individual-btns">
                                <a href="<?php /*echo 'eventEdit/EV-'.$row['eventId'].'/'.encrypt_data('EV-'.$row['eventId']);*/?>" data-ignore-cache="true" class="link color-black event-bookNow">Edit Event</a>
                            </div>-->
                                    <hr class="event-hr">
                                    <div class="bottom-share-panel">
                                        <br>
                                        <?php
                                        if(isset($meta) && myIsMultiArray($meta))
                                        {
                                            ?>
                                            <input type="hidden" id="meta_title" value="<?php echo $meta['title']; ?>"/>
                                            <?php
                                        }
                                        ?>
                                        <p class="event-share-text">
                                            Share "<?php echo htmlspecialchars($row['eventName']); ?>"
                                        </p>
                                        <input type="hidden" id="shareLink" value="<?php if(isset($row['shortUrl'])){echo $row['shortUrl'];}else{ echo $row['eventShareLink'];}?>"/>
                                        <div id="share" class="my-social-share"></div>
                                    </div>
                                </div>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    else
    {
        ?>
        <div class="navbar">
            <div class="navbar-inner">
                <div class="left">
                    <a href="#" class="back link">
                        <i class="icon icon-back"></i>
                        <span>Back</span>
                    </a>
                </div>
                <div class="center sliding">Nothing Found</div>
                <!--<div class="right">

                </div>-->
            </div>
        </div>
        <div class="pages">
            <div data-page="event" class="page">
                <div class="page-content">
                    <?php
                    if(isset($status) && $status === false)
                    {
                        ?>
                        <a href="#" class="open-login-screen" id="login-btn">Open Login Screen</a>
                        <input type="hidden" id="isLoggedIn" value="0"/>
                        <?php
                    }
                    else
                    {
                        ?>
                        <div class="content-block">
                            <p>No result Found!</p>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
?>
</body>
</html>