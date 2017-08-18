 <div class="page-content jukebox-page">
    <div class="content-block">
        <?php
        if(isset($taprooms) && myIsMultiArray($taprooms))
        {
            $offlineTaps = array();
            foreach($taprooms as $key => $row)
            {
                if(isset($row['id']) && $row['is_online'] === true)
                {
                    $title = str_replace('-','',$row['name']);
                    $title = str_replace('Doolally Taproom','Jukebox',$title);
                    ?>
                    <a href="taprom/<?php echo $row['slug'];?>" data-title="<?php echo $title;?>" class="taproom-btn dynamic">
                        <div class="mdl-card mdl-shadow--2dp demo-card-header-pic">
                            <img src="<?php $url = preg_replace("/^http:/i", "https:", $row['app_image_thumb']); echo $url;?>" alt="<?php echo $row['name'];?>"
                                 class="taproom-img"/>
                            <div class="card-content">
                                <div class="card-content-inner">
                                    <ul class="mdl-list main-avatar-list">
                                        <li class="mdl-list__item">
                                        <span class="mdl-list__item-primary-content">
                                            <span class="avatar-title">
                                                <?php echo str_replace('-','',$row['name']);?>
                                            </span>
                                        </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </a><br>
                    <?php
                }
                elseif(isset($row['name']) && $row['name'] != '')
                {
                    $name = str_replace('Doolally Taproom','', $row['name']);
                    $name = str_replace('-','',$name);
                    $offlineTaps[] = $name;
                }
            }
            if(myIsArray($offlineTaps))
            {
                ?>
                <input type="hidden" id="offlineTaps" value="<?php echo implode(',',$offlineTaps);?>"/>
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