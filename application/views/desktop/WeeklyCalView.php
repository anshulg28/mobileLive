<div class="content-block-title weekly-cal">What's happening this week</div>
<?php
if(isset($weekEvents) && myIsMultiArray($weekEvents))
{
    ?>
    <ul class="hide even-cal-list">
        <?php
        foreach($weekEvents as $key => $row)
        {
            if(isset($row['error']))
            {
                ?>
                <li data-evenDate="<?php echo $row['eventDate'];?>"
                    data-error="<?php echo $row['error'];?>">
                </li>
                <?php
            }
            else
            {
                ?>
                <li data-evenDate="<?php echo $row['eventDate'];?>"
                    data-evenNames="<?php echo $row['eventNames'];?>"
                    data-evenPlaces="<?php echo $row['eventPlaces'];?>"
                    data-evenUrls="<?php
                        $ids = explode(',',$row['eventSlugs']);
                        $urls = array();
                        foreach($ids as $subKey)
                        {
                            $urls[] = 'events/'.$subKey;
                        }
                        echo implode(',',$urls);
                    ?>">
                </li>
                <?php
            }
        }
        ?>
    </ul>
    <?php
}
?>
<div id='calendar-glance'></div>