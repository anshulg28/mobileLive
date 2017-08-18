
<div class="page-content event-add-page">
    <div class="content-block event-wrapper">
        <form action="<?php echo base_url().'saveEvent';?>" id="eventSave" method="post" class="ajax-submit">
            <input type="hidden" name="attachment"/>
            <div class="event-img-space" id="event-img-space">
                <div class="event-img-before">
                    <button type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect event-img-add-btn">
                        <i class="material-icons">add</i>
                    </button>
                    <p class="add-img-caption">Add a cover photo<!--<br> The image must be at least 1080 x 540 pixels--></p>
                    <input type="file" id="event-img-upload" onchange="uploadChange(this)" class="my-vanish"/>
                </div>
                <div class="event-img-after hide">
                    <button type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored event-img-remove hide">
                        <i class="ic_add"></i>
                    </button>
                    <div id="eventProgress" class="mdl-progress mdl-js-progress"></div>
                </div>
            </div>
            <div class="mdl-shadow--2dp my-whiteBack">
                <div id="cropContainerModal" class="hide">
                    <div class="done-overlay hide">
                        <button type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect event-overlay-remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <i class="fa fa-check upload-done-icon"></i>
                    <i class="fa fa-times upload-img-close"></i>
                    <img id="img-container" src="" style="max-width:100%"/>
                </div>
                <br>
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--6-col">
                        <span class="mdl-list__item-primary-content">Create an event</span>
                        <br>
                        <span class="light-description">
                            To organise an event, please read the event guidelines and then fill up the form.
                        </span>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col">
                        <div class="hide" id="event-guide"><?php echo $eventTc;?></div>
                        <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect bookNow-event-btn my-AutoWidth readEvent-guide">
                            <i class="material-icons">info_outline</i>&nbsp;&nbsp;Read Event Guidelines
                        </button>
                    </div>
                </div>
                <div class="event-header-name mdl-grid">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label my-fullWidth">
                        <!--onfocus="scrollToField(this)"-->
                        <input class="mdl-textfield__input" type="text" id="eventName" name="eventName">
                        <label class="mdl-textfield__label" for="eventName">Name of event</label>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label my-fullWidth">
                        <textarea class="mdl-textfield__input" type="text" rows= "3" id="eventDesc" name="eventDescription"></textarea>
                        <label class="mdl-textfield__label" for="eventDesc">Describe your event</label>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" id="eventDate" name="eventDate"
                                   placeholder="Date of Event" data-format="Y-m-d" data-default-date="new Date()" data-lock="from"
                                   data-large-default="true" data-large-mode="true" data-modal="true" data-max-year="2018" data-min-year="2016">
                            <label class="mdl-textfield__label" for="eventDate">Event Date</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label my-fullWidth">
                            <!--onfocus="scrollToField(this)"-->
                            <input class="mdl-textfield__input" type="text" id="endTime" name="endTime">
                            <label class="mdl-textfield__label" for="endTime">End Time</label>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label my-fullWidth">
                            <!--onfocus="scrollToField(this)"-->
                            <input class="mdl-textfield__input" type="text" id="startTime" name="startTime">
                            <label class="mdl-textfield__label" for="startTime">Start Time</label>
                        </div>
                        <!--<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <select name="eventType" id="eventType" class="mdl-textfield__input">
                                <?php
/*                                foreach($this->config->item('eventTypes') as $key => $row)
                                {
                                    */?>
                                    <option value="<?php /*echo $row;*/?>"><?php /*echo $row;*/?></option>
                                    <?php
/*                                }
                                */?>
                            </select>
                            <label class="mdl-textfield__label" for="eventType">Event Type</label>
                        </div>-->
                    </div>
                </div>
                <div class="event-header-name mdl-grid">
                    <div class="mdl-cell mdl-cell--6-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="location-div">
                            <select id="eventPlace" name="eventPlace" class="mdl-textfield__input">
                                <option value="">Select</option>
                                <?php
                                if(isset($locData))
                                {
                                    foreach($locData as $key => $row)
                                    {
                                        if(isset($row['id']))
                                        {
                                            ?>
                                            <option value="<?php echo $row['id'];?>"><?php echo $row['locName'];?></option>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </select>
                            <label class="mdl-textfield__label" for="eventPlace">Event Place</label>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <select name="eventCapacity" id="eventCapacity" class="mdl-textfield__input">
                                <?php
                                for($i=1;$i<=20;$i++)
                                {
                                    ?>
                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <label class="mdl-textfield__label" for="eventCapacity">Event Capacity</label>
                        </div>
                    </div>
                </div>
                <div class="event-header-name mdl-grid">
                    <div class="mdl-cell mdl-cell--12-col">
                        <p class="event-cost-head">Is the event Free or Paid?</p>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col">
                        <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="paidType">
                            <input type="radio" id="paidType" class="mdl-radio__button" name="costType" value="2" checked>
                            <span class="mdl-radio__label">Paid</span>
                        </label>
                        <p class="event-sub-text">For paid events, we charge an additional Rs <?php echo NEW_DOOLALLY_FEE;?> per attendee which includes a pint or house fries.</p>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label event-price">
                            <input class="mdl-textfield__input" type="text" pattern="-?[0-9]*(\.[0-9]+)?" id="eventPrice">
                            <label class="mdl-textfield__label" for="eventPrice">Event Fee</label>
                            <span class="mdl-textfield__error">Input is not a number!</span>
                        </div>
                        <div>Total Price: Rs. <span class="total-event-price"><?php echo NEW_DOOLALLY_FEE;?></span><br>
                            ( + Rs <?php echo NEW_DOOLALLY_FEE;?> Doolally Fee)
                        </div>
                        <input type="hidden" name="eventPrice" value="0"/>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col">
                        <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="freeType">
                            <input type="radio" id="freeType" class="mdl-radio__button" name="costType" value="1">
                            <span class="mdl-radio__label">Free</span>
                        </label>
                        <p class="event-sub-text">If you don't charge, we don't charge</p>
                    </div>
                    <div class="mdl-cell mdl-cell--12-col">
                        <p class="event-cost-head my-NoMargin">Need Accessories: </p>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col text-right projSection">
                        <div class="projDiv">
                            <input type="checkbox" name="ifProjectorRequired" onchange="toggleAccess(this)" id="ifProjectorRequired" value="1" />
                            <label for="ifProjectorRequired">
                                <i class="ic_projector_icon"></i>
                                <span>Projector</span>
                            </label>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col micSection">
                        <div class="micDiv">
                            <input type="checkbox" name="ifMicRequired" onchange="toggleAccess(this)" id="ifMicRequired" value="1" />
                            <label for="ifMicRequired">
                                <i class="ic_mic_icon"></i>
                                <span>Microphone</span>
                            </label>
                        </div>
                    </div>
                    <?php
                    $isLogged = false;
                    if(!isSessionVariableSet($this->userMobId))
                    {
                        $isLogged = true;
                        ?>
                        <div class="mdl-cell mdl-cell--12-col">Your details</div>
                        <!--<p class="event-sub-text">We'll contact you while we curate your event.</p>-->
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label my-fullWidth">
                            <input class="mdl-textfield__input" type="text" name="creatorName" id="creatorName">
                            <label class="mdl-textfield__label" for="creatorName">Name</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label my-fullWidth">
                            <input class="mdl-textfield__input" type="number" name="creatorPhone" id="creatorPhone" maxlength="10"
                                   oninput="maxLengthCheck(this)">
                            <label class="mdl-textfield__label" for="creatorPhone">Phone Number</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label my-fullWidth">
                            <input class="mdl-textfield__input" type="email" name="creatorEmail" id="creatorEmail">
                            <label class="mdl-textfield__label" for="creatorEmail">Email ID</label>
                        </div>
                        <?php
                    }
                    if($isLogged === false)
                    {
                        if(!isStringSet($this->userMobFirstName))
                        {
                            ?>
                            <div class="mdl-cell mdl-cell--12-col">
                                <p class="event-cost-head my-NoMargin">Your details</p>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label my-fullWidth">
                                    <input class="mdl-textfield__input" type="text" name="creatorName" id="creatorName">
                                    <label class="mdl-textfield__label" for="creatorName">Name</label>
                                </div>
                            </div>
                            <!--<p class="event-sub-text">We'll contact you while we curate your event.</p>-->
                            <?php
                        }
                        if(!isSessionVariableSet($this->userMobNumber))
                        {
                            ?>
                            <div class="mdl-cell mdl-cell--12-col">
                                <p class="event-cost-head my-NoMargin">Your details</p>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label my-fullWidth">
                                    <input class="mdl-textfield__input" type="number" name="creatorPhone" id="creatorPhone" maxlength="10"
                                           oninput="maxLengthCheck(this)">
                                    <label class="mdl-textfield__label" for="creatorPhone">Phone Number</label>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <div class="mdl-cell mdl-cell--12-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label my-fullWidth">
                            <textarea class="mdl-textfield__input kbdfix" type="text" rows= "3" id="aboutCreator" name="aboutCreator"></textarea>
                            <label class="mdl-textfield__label" for="aboutCreator">Something about yourself (Optional)</label>
                        </div>
                        <div class="event-header-name">
                            All events are reviewed and approved by Doolally. Once approved, we will create an Instamojo payment link and
                            accept payments on your behalf.
                        </div>
                        <hr>
                        <label class="mdl-checkbox mdl-js-checkbox" for="tnc">
                            <input type="checkbox" id="tnc" value="1" class="mdl-checkbox__input">
                            <span class="mdl-checkbox__label">I have read and agree to the
                                <a href="#" class="dynamic">Terms and Conditions.</a>
                            </span>
                        </label>
                        <br>
                    </div>
                    <div class="mdl-cell mdl-cell--3-col"></div>
                    <div class="mdl-cell mdl-cell--6-col">
                        <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect bookNow-event-btn">
                            Create Event
                        </button>
                    </div>
                    <div class="mdl-cell mdl-cell--3-col"></div>
                </div><!-- grid close -->
            </div>
        </form>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/bootstrap-datetimepicker.min.css">
<script type="application/javascript" src="<?php echo base_url(); ?>asset/js/bootstrap.min.js"></script>
<script type="application/javascript" src="<?php echo base_url(); ?>asset/js/bootstrap-datetimepicker.min.js"></script>
<script>
    if(localStorageUtil.getLocal('eventName') != null)
    {
        $('#eventName').val(localStorageUtil.getLocal('eventName'));
        localStorageUtil.delLocal('eventName');
    }
    $('#eventDate').datetimepicker({
        format: 'YYYY-MM-DD',
        minDate: new Date(),
        useCurrent: false
    });
    $('#startTime').timepicker({
        dropdown: false
    });
    $('#endTime').timepicker({
        dropdown: false
    });
    componentHandler.upgradeDom();
    $(document).ready(function(){
        $('#location-div').addClass('is-dirty');
    });
</script>