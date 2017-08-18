<header class="mdl-layout__header">
    <div class="mdl-layout__header-row">
        <!-- Title -->
        <div class="mdl-cell mdl-cell--2-col">
            <span class="mdl-layout-title main-menu-container">
                <button id="demo-menu-lower-left"
                        class="mdl-button mdl-js-button mdl-button--icon">
                    <i class="material-icons">menu</i>
                </button>
                <ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect"
                    data-mdl-for="demo-menu-lower-left" id="main-web-menu" title="<i class='material-icons custom-info'>info</i>Request a song, access your events dashboard, tour our other taprooms.">
                    <a href="<?php echo base_url();?>" class="my-noUnderline">
                        <li class="mdl-menu__item">
                            <i class="fa fa-home fa-14x mdl-list__item-icon"></i> Home
                        </li>
                    </a>
                    <a href="jukebox" class="my-noUnderline dynamic" data-title="Jukebox">
                        <li class="mdl-menu__item">
                            <i class="fa fa-music fa-14x mdl-list__item-icon"></i> Jukebox
                        </li>
                    </a>
                    <a href="event_dash" class="my-noUnderline dynamic" data-title="Events Dashboard">
                        <li class="mdl-menu__item">
                            <i class="fa fa-calendar fa-14x mdl-list__item-icon"></i> My Events
                        </li>
                    </a>
                    <a href="contact_us" class="my-noUnderline dynamic" data-title="Contact Us">
                        <li class="mdl-menu__item">
                            <i class="fa fa-life-ring fa-14x mdl-list__item-icon"></i> Contact
                        </li>
                    </a>
                </ul>
            </span>
        </div>
        <div class="mdl-cell mdl-cell--3-col"></div>
        <div class="mdl-cell mdl-cell--half-col"></div>
        <div class="mdl-cell mdl-cell--3-col my-filter-row">
            <div class="pull-left main-site-logo">
                <a href="<?php echo base_url();?>">
                    <img class="main-logo-img" src="<?php echo base_url().'asset/images/splashLogo.png';?>" alt="Logo"/>
                </a>
            </div>
            <!-- Add spacer, to align navigation to the right -->
            <div class="mdl-layout-spacer"></div>
            <!-- Navigation. We hide it in small screens. -->
            <nav class="mdl-navigation">
                <!--<button id="filter-timeline-menu"
                        class="mdl-button mdl-js-button mdl-button--icon">
                    <i class="ic_filter_icon"></i>
                </button>-->
                <!-- Filter for Timeline-->
                <i id="filter-timeline-menu" class="ic_filter_icon my-pointer-item"></i>
                <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect filter-timeline-list"
                    for="filter-timeline-menu">
                    <li class="mdl-menu__item mdl-menu__item--full-bleed-divider">Filter Posts</li>
                    <li class="mdl-menu__item">
                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="fb-checked">
                            <input type="checkbox" id="fb-checked" name="social-filter" value="1" class="mdl-checkbox__input">
                            <span class="mdl-checkbox__label my-display-block">Facebook</span>
                        </label>
                    </li>
                    <li class="mdl-menu__item">
                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="tw-checked">
                            <input type="checkbox" id="tw-checked" name="social-filter" value="2" class="mdl-checkbox__input">
                            <span class="mdl-checkbox__label my-display-block">Twitter</span>
                        </label>
                    </li>
                    <li class="mdl-menu__item">
                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="insta-checked">
                            <input type="checkbox" id="insta-checked" name="social-filter" value="3" class="mdl-checkbox__input">
                            <span class="mdl-checkbox__label my-display-block">Instagram</span>
                        </label>
                    </li>
                </ul>

                <!-- Filter for events -->
                <div id="event-filter-box">
                    <i id="filter-events-menu" class="ic_filter_icon my-pointer-item hide"></i>
                </div>
                <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect filter-events-list"
                    for="filter-events-menu">
                    <li class="mdl-menu__item mdl-menu__item--full-bleed-divider">Show Events In... &nbsp;
                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect clear-event-filter my-vanish">
                            Clear
                        </button>
                    </li>
                    <?php
                    if(isset($mainLocs) && myIsMultiArray($mainLocs) && $mainLocs['status'] == true)
                    {
                        foreach($mainLocs as $key => $row)
                        {
                            if(isset($row['id']))
                            {
                                ?>
                                <li class="mdl-menu__item">
                                    <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="even-<?php echo $row['id'];?>">
                                        <input type="radio" id="even-<?php echo $row['id'];?>" class="mdl-radio__button" name="event-locations" value="<?php echo $row['id'];?>">
                                        <span class="mdl-radio__label"><?php echo $row['locName'];?></span>
                                    </label>
                                </li>
                                <?php
                            }
                        }
                    }
                    ?>
                </ul>
            </nav>
        </div>
        <div class="mdl-cell mdl-cell--3-col"></div>
    </div>
    <div class="mdl-layout__tab-bar mdl-js-ripple-effect hide" id="mainNavBar">
        <a href="<?php echo base_url();?>" class="mdl-layout__tab is-active">
            <i class="fa fa-hashtag fa-17x my-display-block common-main-tabs on header-tabs-reposition mdl-badge--overlap" data-badge=""></i><span class="head-txt-up">Doolally</span>
        </a>
        <a href="events" id="main-events-tab" title="<i class='material-icons custom-info'>info</i>Create and sign up for events here." class="mdl-layout__tab dynamic" data-title="Doolally Events">
            <span class="ic_events_icon common-main-tabs header-tabs-reposition"></span><span class="head-txt-up">Events</span>
            <!-- Custom tooltip design for event interstitial -->
            <!--<div id="my-events-tooltip" style="display: none;">
                <p><i class="material-icons">info_outline</i>&nbsp;&nbsp;You can now browse through and create events in the events tab.
                    <a href="#" class="tooltip-common">OK</a>
                </p>
            </div>-->
        </a>
        <a href="fnb" class="mdl-layout__tab dynamic" data-title="Food n Beverages">
            <span class="ic_fnb_icon common-main-tabs header-tabs-reposition"></span><span class="head-txt-up">FnB</span>
        </a>
    </div>
</header>