<!DOCTYPE html>
<html lang="en">


<body>
<!-- Status bar overlay for full screen mode (PhoneGap) -->
<!-- Top Navbar-->
<div class="navbar mycustomNav">
    <div class="navbar-inner">
        <div class="left">
            <?php
                if(isSessionVariableSet($this->userMobFirstName))
                {
                    ?>
                    <a href="#" class="link icon-only open-panel main-menu-icon">
                        <!--<i class="fa fa-bars color-black"></i>-->
                        <span class="d-logo"></span>
                        <span class="bottom-bar-line"></span>
                        <!--<span class="d-logo"></span>-->
                        <!--<span class="bottom-bar-line"></span>-->
                        <!--<i class="fa fa-minus"></i>
                        <i class="fa fa-minus"></i>-->
                    </a>
                    <?php
                }
                else
                {
                    ?>
                    <a href="#" class="back link" data-ignore-cache="true">
                        <i class="ic_back_icon point-item"></i>
                    </a>
                    <?php
                }
            ?>
        </div>
        <div class="center sliding">
            <!--My Events-->
            <?php
                if(isSessionVariableSet($this->userMobFirstName))
                {
                    echo 'Welcome '.$this->userMobFirstName;
                }
                else
                {
                    echo 'My Events';
                }
            ?>
        </div>
        <!--<div class="right">
            <?php
/*                if(isset($status) && $status === true)
                {
                    */?>
                    <a href="#" id="logout-btn">
                        <i class="ic_logout_icon point-item"></i>
                    </a>
                    <?php
/*                }
            */?>
        </div>-->
        <?php
            if(isset($status) && $status === true)
            {
                ?>
                <div class="subnavbar myCustomSubNav">
                    <!-- Buttons row as tabs controller in Subnavbar-->
                    <div class="buttons-row">
                        <!-- Link to 2nd tab -->
                        <a href="#hosting" class="button active tab-link">Hosting</a>
                        <!-- Link to 1st tab, active -->
                        <a href="#attending" class="button tab-link">Attending</a>
                    </div>
                </div>
                <?php
            }
        ?>
    </div>
</div>

<div class="pages">
    <div data-page="eventsDash" class="page even-dashboard">
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
                <input type="hidden" id="isLoggedIn" value="1"/>
                <!-- Tabs swipeable wrapper, required to switch tabs with swipes -->
                <div class="tabs-swipeable-wrap">
                    <!-- Tabs, tabs wrapper -->
                    <div class="tabs">
                        <!-- Tab 2 -->
                        <div id="hosting" class="page-content tab active">
                            <div class="content-block">
                                <?php
                                if(isset($userEvents) && myIsMultiArray($userEvents))
                                {
                                    $postImg = 0;
                                    foreach($userEvents as $key => $row)
                                    {
                                        if(isEventFinished($row['eventDate'], $row['endTime']) || $row['isEventCancel'] == EVENT_CANCEL_FINAL)
                                        {
                                            continue;
                                        }
                                        $img_collection = array();
                                        ?>
                                        <div class="card demo-card-header-pic">
                                            <div class="row no-gutter">
                                                <div class="col-100"> <!--more-photos-wrapper-->
                                                    <?php
                                                    if($postImg >=10)
                                                    {
                                                        ?>
                                                        <img src="<?php echo base_url().EVENT_PATH_THUMB.$row['filename'];?>" class="mainFeed-img"/>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <img data-src="<?php echo base_url().EVENT_PATH_THUMB.$row['filename'];?>" class="mainFeed-img lazy lazy-fadein"/>
                                                        <?php
                                                    }
                                                    $postImg++;
                                                    ?>
                                                </div>
                                            </div>
                                            <!--<div style="background-image:url()" valign="bottom" class="card-header color-white no-border">Journey To Mountains</div>-->
                                            <div class="card-content">
                                                <div class="card-content-inner">
                                                    <div class="event-info-wrapper">
                                                        <p class="pull-left card-ptag event-date-tag">
                                                            <?php
                                                            $eventName = (strlen($row['eventName']) > 25) ? substr($row['eventName'], 0, 25) . '..' : $row['eventName'];
                                                            echo $eventName;?>
                                                        </p>
                                                        <input type="hidden" data-name="<?php echo $row['eventName'];?>" value="<?php if(isset($row['shortUrl'])){echo $row['shortUrl'];}else{ echo $row['eventShareLink'];}?>"/>
                                                        <?php
                                                        if($row['ifApproved'] == EVENT_APPROVED && $row['ifActive'] == ACTIVE)
                                                        {
                                                            ?>
                                                            <i class="ic_me_share_icon pull-right event-share-icn event-card-share-btn"></i>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="comment my-event-status clear">
                                                            <span>
                                                            <?php
                                                            $isApprov = false;
                                                            if($row['isEventCancel'] == EVENT_CANCEL_REVIEW)
                                                            {
                                                                $isApprov = true;
                                                                ?>
                                                                <i class="ic_me_info_icon info-icon"></i>&nbsp;&nbsp;Cancellation In Review<?php
                                                            }
                                                            elseif($row['ifApproved'] == EVENT_DECLINED)
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
                                                                $isApprov = true;
                                                                ?>
                                                                <i class="ic_me_info_icon info-icon"></i>&nbsp;&nbsp;Event Approved!<?php
                                                            }
                                                            elseif($row['ifApproved'] == EVENT_APPROVED && $row['ifActive'] == NOT_ACTIVE)
                                                            {
                                                                $isApprov = true;
                                                                ?>
                                                                <i class="ic_me_info_icon info-icon"></i>&nbsp;&nbsp;Event Approved But Not Active<?php
                                                            }
                                                            ?>
                                                            </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer event-card-footer">
                                                <?php
                                                if($isApprov === true)
                                                {
                                                    ?>
                                                    <a href="<?php echo 'event_details/'.$row['eventSlug'];?>" data-ignore-cache="true" class="link color-black event-bookNow">View&nbsp;Details</a>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <a href="<?php echo 'event_details/'.$row['eventSlug'];?>" data-ignore-cache="true" class="link color-black event-bookNow" disabled>View&nbsp;Details</a>
                                                    <?php
                                                }
                                                ?>

                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                else
                                {
                                    echo 'No Event Created Yet!';
                                }
                                ?>
                            </div>
                        </div>
                        <!-- Tab 1, active by default -->
                        <div id="attending" class="page-content tab">
                            <div class="content-block">
                                <?php
                                    if(isset($registeredEvents) && myIsMultiArray($registeredEvents))
                                    {
                                        $postImg = 0;
                                        foreach($registeredEvents as $key => $row)
                                        {
                                            if(isEventFinished($row['eventDate'], $row['endTime']) || $row['isEventCancel'] == EVENT_CANCEL_FINAL)
                                            {
                                                continue;
                                            }
                                            $img_collection = array();
                                            ?>
                                            <div class="card demo-card-header-pic">
                                                <div class="row no-gutter">
                                                    <div class="col-100"> <!--more-photos-wrapper-->
                                                        <?php
                                                        if($postImg >=10)
                                                        {
                                                            ?>
                                                            <img src="<?php echo base_url().EVENT_PATH_THUMB.$row['filename'];?>" class="mainFeed-img"/>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <img data-src="<?php echo base_url().EVENT_PATH_THUMB.$row['filename'];?>" class="mainFeed-img lazy lazy-fadein"/>
                                                            <?php
                                                        }
                                                        $postImg++;
                                                        ?>
                                                    </div>
                                                </div>
                                                <!--<div style="background-image:url()" valign="bottom" class="card-header color-white no-border">Journey To Mountains</div>-->
                                                <div class="card-content">
                                                    <div class="card-content-inner">
                                                        <div class="event-info-wrapper">
                                                            <p class="pull-left card-ptag event-date-tag">
                                                                <?php
                                                                $eventName = (strlen($row['eventName']) > 25) ? substr($row['eventName'], 0, 25) . '..' : $row['eventName'];
                                                                echo $eventName;?>
                                                            </p>
                                                            <input type="hidden" data-shareTxt="Finally! I have signed myself up, why don't you check it out?" data-name="<?php echo $row['eventName'];?>" value="<?php if(isset($row['shortUrl'])){echo $row['shortUrl'];}else{ echo $row['eventShareLink'];}?>"/>
                                                            <i class="ic_me_share_icon pull-right event-share-icn event-card-share-btn"></i>
                                                        </div>

                                                        <div class="comment my-event-status clear">
                                                            <?php echo $row['eventDescription'];?>
                                                            <p>
                                                                <i class="ic_me_location_icon main-loc-icon"></i>&nbsp;<?php echo $row['locName']; ?>
                                                                &nbsp;&nbsp;<i class="ic_me_rupee_icon main-rupee-icon"></i>
                                                                <?php
                                                                switch($row['costType'])
                                                                {
                                                                    case "1":
                                                                        echo "Free";
                                                                        break;
                                                                    case "2":
                                                                        echo 'Rs '.$row['eventPrice'];
                                                                        break;
                                                                    default :
                                                                        echo 'Rs '.$row['eventPrice'];
                                                                }
                                                                ?>
                                                                <a href="#" class="custom-addToCal"
                                                                   data-ev-title="<?php echo $row['eventName'];?>" data-ev-location="Doolally Taproom, <?php echo $row['locName'];?>"
                                                                   data-ev-start="<?php echo $row['eventDate'].' '.$row['startTime'];?>"
                                                                   data-ev-end="<?php echo $row['eventDate'].' '.$row['endTime'];?>"
                                                                   data-ev-description="<?php echo strip_tags($row['eventDescription'],'<br>');?>">

                                                                    &nbsp;&nbsp;<span class="ic_events_icon event-date-main"></span>&nbsp;
                                                                    <u><?php $d = date_create($row['eventDate']);
                                                                    echo date_format($d,EVENT_DATE_FORMAT); ?></u>
                                                                </a>
                                                            </p>
                                                            <?php
                                                            $price = 0;
                                                            if($row['costType'] != EVENT_FREE)
                                                            {
                                                                $price = ((int)$row['quantity'] * (int)$row['eventPrice']);
                                                            }
                                                            ?>
                                                            <div class="attendee-pay-info"><i class="fa fa-money"></i> Booking Information</div>
                                                            <span class="my-display-inline">Quantity: <?php echo $row['quantity'];?></span>&nbsp;
                                                            <span class="my-display-inline">Amount Paid: <?php if($price==0){echo 'Free';}else{echo 'Rs '.$price;}?></span>
                                                            <span class="my-display-inline">Booking Date/Time:
                                                                <?php
                                                                $d = date_create($row['createdDT']);
                                                                echo date_format($d,DATE_TIME_FORMAT_UI);
                                                                ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <a href="mailto:<?php echo $row['creatorEmail'];?>" class="link external color-black">
                                                        <i class="ic_event_email_icon"></i>&nbsp;&nbsp;Contact
                                                    </a>
                                                    <?php
                                                        if($row['isUserCancel'] == '1')
                                                        {
                                                            ?>
                                                            <a href="#" class="link color-black" disabled>Booking Cancelled</a>
                                                            <?php
                                                        }
                                                        elseif($row['isEventCancel'] == '2')
                                                        {
                                                            ?>
                                                            <a href="#" class="link color-black" disabled>Event Cancelled</a>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <a data-bookerId="<?php echo $row['bookerId'];?>" href="#" class="link color-black eve-cancel-btn"><i class="fa fa-ban fa-15x"></i>&nbsp;Cancel Booking</a>
                                                            <?php
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <!--<div class="content-block">

            </div>-->
            <div class="page-content login-screen">
                <div class="login-screen-title">Doolally Login</div>
                <form action="<?php echo base_url().'main/checkUser';?>" id="user-app-login" method="post" class="ajax-submit">
                    <div class="list-block">
                        <ul>
                            <li class="item-content">
                                <div class="item-inner">
                                    <div class="item-title label">Email</div>
                                    <div class="item-input">
                                        <input type="text" name="username" placeholder="Email">
                                    </div>
                                </div>
                            </li>
                            <li class="item-content">
                                <div class="item-inner">
                                    <div class="item-title label">Mobile No.</div>
                                    <div class="item-input">
                                        <input type="number" name="mobNum" placeholder="Mobile Number">
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="list-block">
                        <ul>
                            <li><input onclick="myApp.showIndicator()" type="submit" class="button button-big button-fill" value="Sign In"/></li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!--    <div class="login-screen">
        <div class="view">
            <div class="page">

            </div>
        </div>
    </div>-->
</div>

</body>
</html>