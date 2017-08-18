
<?php
    if(isset($meta['title']))
    {
        ?>
        <input type="hidden" value="Food n Beverage" id="docTitle"/>
        <?php
    }
?>
<div class="page-content">
    <?php
    if(isset($fnbItems) && myIsMultiArray($fnbItems))
    {
        $postImg = 0;
        $resetCard = 0;
        $foodFlag = 0;
        $beerCount = array_count_values(array_map(function($foo){return $foo['itemType'];}, $fnbItems));
        foreach($fnbItems as $key => $row)
        {
            switch($row['itemType'])
            {
                case ITEM_FOOD:
                    ?>
                    <?php
                    if($foodFlag == 0)
                    {
                        $foodFlag = 1;
                        ?>
                        <div class="content-block-title">Food</div>
                        <?php
                    }
                    ?>
                    <div class="mdl-card mdl-shadow--2dp demo-card-header-pic" data-fnbId = "<?php echo $row['fnbId']; ?>">
                        <?php
                        if($postImg <=2)
                        {
                            ?>
                            <img src="<?php echo base_url().FOOD_PATH_THUMB.$row['filename'];?>" class="mainFeed-img"/>
                            <?php
                        }
                        else
                        {
                            ?>
                            <img data-src="<?php echo base_url().FOOD_PATH_THUMB.$row['filename'];?>" class="mainFeed-img lazy"/>
                            <?php
                        }
                        $postImg++;

                        ?>
                        <!--<div style="background-image:url()" valign="bottom" class="card-header color-white no-border">Journey To Mountains</div>-->
                        <ul class="mdl-list main-avatar-list">
                            <li class="mdl-list__item mdl-list__item--two-line">
                                                    <span class="mdl-list__item-primary-content">
                                                        <span class="avatar-title"><?php echo $row['itemName'];?></span>
                                                    </span>
                                <span class="mdl-list__item-secondary-content">
                                                        <span class="mdl-list__item-secondary-info">
                                                            <input type="hidden" data-name="<?php echo $row['itemName'];?>" value="<?php if(isset($row['shortUrl'])){ echo $row['shortUrl'];}else{echo $row['fnbShareLink'];}?>"/>
                                                            <i class="my-pointer-item ic_me_share_icon pull-right event-share-icn fnb-card-share-btn"></i>
                                                        </span>
                                                    </span>
                            </li>
                        </ul>
                        <div class="mdl-card__supporting-text">
                            <?php echo strip_tags($row['itemDescription'],'<br>');?>
                        </div>
                    </div>
                    <?php
                    break;
            }
        }
    }
    else
    {
        echo 'No Items Found!';
    }
    ?>
</div>
