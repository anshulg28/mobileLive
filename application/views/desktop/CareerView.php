
<div class="page-content career-page">
    <div class="content-block event-wrapper">
        <div class="content-block-title job-main-title text-center">Work with Us</div>
        <br>
        <?php
        if(isset($careerData) && myIsMultiArray($careerData))
        {
            foreach($careerData as $key => $row)
            {
                ?>
                <div class="mdl-card mdl-shadow--2dp demo-card-header-pic">
                    <div class="inner-job-describ"><?php echo $row['jobDescription'];?></div>
                    <div class="card-content">
                        <div class="card-content-inner text-center">
                            <span class="my-black-text inner-job-title"><?php echo $row['jobTitle'];?></span><br>
                            <span class="inner-job-depart"><?php echo $row['jobDepartment'];?></span><br>
                            <span class="inner-job-location"><?php if(isset($row['locName'])){echo $row['locName'];}else{echo $row['otherLocation'];} ;?></span>
                            <br>
                            <hr class="job-custom-hr"/>
                            <span class="inner-job-caption">Write to Us</span><br>
                            <span class="inner-job-contact"><?php echo $row['contactEmail'];?></span>
                        </div>
                    </div>
                </div>
                <br>
                <?php
            }
        }
        else
        {
            ?>
            <div class="content-block text-center">
                Not Jobs Available Yet!
            </div>
            <?php
        }
        ?>
    </div>
</div>