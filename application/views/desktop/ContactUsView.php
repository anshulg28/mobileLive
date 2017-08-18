
<div class="page-content">
    <div class="content-block event-wrapper">
        <?php
        if(isset($locData) && myIsMultiArray($locData))
        {
            foreach($locData as $key => $row)
            {
                if(isset($row['viewFrame']))
                {
                    ?>
                    <div class="mdl-card mdl-shadow--2dp demo-card-header-pic">
                        <?php echo $row['viewFrame'];?>
                        <div class="card-content">
                            <div class="card-content-inner">
                                <ul class="mdl-list main-avatar-list">
                                    <li class="mdl-list__item">
                                        <span class="mdl-list__item-primary-content">
                                            <span class="avatar-title">
                                                <?php echo $row['locName'];?> Taproom
                                            </span>
                                        </span>
                                    </li>
                                </ul>
                                <div class="mdl-card__actions mdl-card--border">
                                    <a href="tel:<?php echo $row['phoneNumber']; ?>" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                                        <span class="ic_event_contact_icon point-item"></span> Call
                                    </a>
                                    <a href="<?php echo $row['mapLink'];?>" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect pull-right" target="_blank">
                                        <i class="ic_me_location_icon point-item"></i>
                                        Get Directions
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <?php
                }
            }
        }
        else
        {
            ?>
            <div class="content-block">
                Not Available!
            </div>
            <?php
        }
        ?>
    </div>
</div>