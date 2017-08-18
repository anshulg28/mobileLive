
<div class="page-content taproom-page">
    <div class="content-block">
        <input type="hidden" value="<?php echo $taproomId;?>" id="taproom-Id"/>
        <?php
        if(isset($taproomInfo) && myIsMultiArray($taproomInfo))
        {
            ?>
            <div class="content-block-title">Now Playing</div><br>
            <div class="mdl-card mdl-shadow--2dp demo-card-header-pic now-playing-card">
                <div class="card-content">
                    <div class="card-content-inner">
                        <ul class="demo-list-three mdl-list">
                            <?php
                            foreach($taproomInfo as $key => $row)
                            {
                                if($key == 'now_playing')
                                {
                                    ?>
                                    <li class="mdl-list__item mdl-list__item--three-line">
                                        <span class="mdl-list__item-primary-content">
                                            <img class="mdl-list__item-icon" src="<?php $url = preg_replace("/^http:/i", "https:", $row['albumartThumbnail']); echo $url;?>">
                                          <span class="now-song-name"><?php echo $row['name'];?></span>
                                          <span class="mdl-list__item-text-body">
                                            <?php echo $row['artist'];?><br>
                                            <?php echo $row['album'];?>
                                          </span>
                                        </span>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <br><div class="content-block-title">Queue</div><br>
        <?php
            if(isset($taproomInfo['request_queue']) && myIsMultiArray($taproomInfo['request_queue']))
            {
                ?>
                <div class="mdl-card mdl-shadow--2dp demo-card-header-pic request-queue-card">
                    <div class="card-content">
                        <div class="card-content-inner">
                            <ul class="demo-list-three mdl-list">
                                <?php
                                foreach($taproomInfo as $key => $row)
                                {
                                    if($key == 'request_queue')
                                    {
                                        foreach($row as $subKey => $subRow)
                                        {
                                            ?>
                                            <li class="mdl-list__item mdl-list__item--three-line">
                                                <span class="mdl-list__item-primary-content">
                                                    <img class="mdl-list__item-icon" src="<?php $url = preg_replace("/^http:/i", "https:", $subRow['albumartThumbnail']); echo $url;?>" >
                                                  <span class="now-song-name"><?php echo $subRow['name'];?></span>
                                                  <span class="mdl-list__item-text-body">
                                                    <?php echo $subRow['artist'];?>
                                                  </span>
                                                </span>
                                                <span class="mdl-list__item-secondary-content">
                                                  <span class="mdl-list__item-secondary-info"><?php echo $subRow['votes'];?></span>
                                                </span>
                                            </li>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
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
<a href="songlist/<?php echo $taproomId;?>" data-title="Request Song" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored music-request-btn dynamic">
    <i class="ic_request_music"></i>
</a>