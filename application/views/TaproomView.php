<!DOCTYPE html>
<html lang="en">

<body>
<!-- Status bar overlay for full screen mode (PhoneGap) -->
<!-- Top Navbar-->
<div class="navbar">
    <div class="navbar-inner">
        <div class="left">
            <a href="#" class="back link" data-ignore-cache="true">
                <i class="ic_back_icon point-item"></i>
            </a>
        </div>
        <div class="center sliding">Jukebox</div>
        <div class="right">
            <i class="ic_me_refresh_icon point-item page-refresh-btn"></i>
        </div>
    </div>
</div>
<div class="pages">
    <div data-page="taproomPage" class="page taproom-page">
        <div class="page-content">
            <div class="content-block">
                <input type="hidden" value="<?php echo $taproomId;?>" id="taproom-Id"/>
                <?php
                if(isset($taproomInfo) && myIsMultiArray($taproomInfo))
                {
                    ?>
                    <div class="content-block-title">Now Playing</div>
                    <div class="list-block media-list">
                        <ul>
                            <?php
                            foreach($taproomInfo as $key => $row)
                            {
                                if($key == 'now_playing')
                                {
                                    ?>
                                    <li>
                                        <a href="#" class="item-content color-black">
                                            <div class="item-media">
                                                <img class="album-thumb" src="<?php $url = preg_replace("/^http:/i", "https:", $row['albumartThumbnail']); echo $url;?>" width="80">
                                            </div>
                                            <div class="item-inner">
                                                <div class="item-title-row">
                                                    <div class="item-title"><?php echo $row['name'];?></div>
                                                </div>
                                                <div class="item-subtitle"><?php echo $row['artist'];?></div>
                                                <div class="item-text"><?php echo $row['album'];?></div>
                                            </div>
                                        </a>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="content-block-title">Queue</div>
                <?php
                    if(isset($taproomInfo['request_queue']) && myIsMultiArray($taproomInfo['request_queue']))
                    {
                        ?>
                        <div class="list-block media-list">
                            <ul>
                                <?php
                                foreach($taproomInfo as $key => $row)
                                {
                                    if($key == 'request_queue')
                                    {
                                        foreach($row as $subKey => $subRow)
                                        {
                                            ?>
                                            <li>
                                                <div class="item-content">
                                                    <div class="item-media"><img class="queue-img-icon" src="<?php $url = preg_replace("/^http:/i", "https:", $subRow['albumartThumbnail']); echo $url;?>" width="44"></div>
                                                    <div class="item-inner">
                                                        <div class="item-title-row">
                                                            <div class="item-title subtitle-queue"><?php echo $subRow['name'];?></div>
                                                            <div class="item-title color-gray"><?php echo $subRow['votes'];?></div>
                                                        </div>
                                                        <div class="item-subtitle">
                                                            <?php echo $subRow['artist'];?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    <?php
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
        <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored music-request-btn">
            <i class="ic_request_music"></i>
            <!--<i class="fa fa-plus"></i>-->
        </button>
    </div>
</div>
</body>
</html>