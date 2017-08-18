<?php
if(isset($status) && $status === false)
{
    ?>
    <div class="content-block" id="event-login-form">
        <div class="demo-card-square mdl-shadow--2dp text-center">
            <div class="mdl-custom-login-title">
                <h2 class="mdl-card__title-text">Doolally Login</h2>
            </div>
            <form action="<?php echo base_url().'main/checkUser';?>" method="POST" id="main-event-form">
                <div class="mdl-card__supporting-text">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" type="text" id="email" name="username">
                        <label class="mdl-textfield__label" for="email">Email</label>
                    </div>
                    <br>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" type="number" id="mobNum" name="mobNum">
                        <label class="mdl-textfield__label" for="mobNum">Mobile Number</label>
                    </div>
                    <br>
                    <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
    <input type="hidden" value="Doolally Login" id="docTitle"/>
    <?php
}
elseif(isset($eventDetails) && myIsMultiArray($eventDetails))
{
    foreach ($eventDetails as $key => $row)
    {
        ?>
        <input type="hidden" value="Edit Event" id="docTitle"/>
        <div class="page-content event-add-page">
            <div class="content-block event-wrapper">
                <form action="<?php echo base_url().'updateEvent';?>" id="eventEditSave" method="post" class="ajax-submit">
                    <input type="hidden" name="eventId" value="<?php echo $row['eventId'];?>"/>
                    <input type="hidden" name="attachment" value="<?php echo $row['filename']; ?>"/>
                    <div class="event-img-space" id="event-img-space"
                         style="background:linear-gradient(rgba(255, 255, 255, 0.5), rgba(255, 255, 255, 0.5)), 0 / cover url('<?php echo base_url().EVENT_PATH_THUMB.$row['filename'];?>') no-repeat">
                        <div class="event-img-before hide">
                            <button type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect event-img-add-btn">
                                <i class="material-icons">add</i>
                            </button>
                            <p class="add-img-caption">Add a cover photo<!--<br> The image must be at least 1080 x 540 pixels--></p>
                            <input type="file" id="event-img-upload" onchange="uploadChange(this)" class="my-vanish"/>
                        </div>
                        <div class="event-img-after">
                            <button type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored event-img-remove">
                                <i class="fa fa-times my-black-text"></i>
                            </button>
                            <div id="eventProgress" class="mdl-progress mdl-js-progress hide"></div>
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
                                <span class="mdl-list__item-primary-content">Edit an event</span>
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
                                <input class="mdl-textfield__input" type="text" id="eventName" name="eventName"
                                       value="<?php echo $row['eventName'];?>"/>
                                <label class="mdl-textfield__label" for="eventName">Name of event</label>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label my-fullWidth">
                                <textarea class="mdl-textfield__input" type="text" rows= "3" id="eventDesc" name="eventDescription"><?php echo $row['eventDescription'];?></textarea>
                                <label class="mdl-textfield__label" for="eventDesc">Describe your event</label>
                            </div>
                            <div class="mdl-cell mdl-cell--6-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="text" id="eventDate" name="eventDate" value="<?php echo $row['eventDate'];?>"
                                           placeholder="Date of Event">
                                    <label class="mdl-textfield__label" for="eventDate">Event Date</label>
                                </div>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label my-fullWidth">
                                    <!--onfocus="scrollToField(this)"-->
                                    <input class="mdl-textfield__input" type="text" id="endTime" name="endTime"
                                           value="<?php echo date("h:i A", strtotime($row['endTime']));?>"/>
                                    <label class="mdl-textfield__label" for="endTime">End Time</label>
                                </div>

                            </div>
                            <div class="mdl-cell mdl-cell--6-col">
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
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label my-fullWidth">
                                    <!--onfocus="scrollToField(this)"-->
                                    <input class="mdl-textfield__input" type="text" id="startTime" name="startTime"
                                           value="<?php echo date("h:i A", strtotime($row['startTime']));?>"/>
                                    <label class="mdl-textfield__label" for="startTime">Start Time</label>
                                </div>
                            </div>
                        </div>
                        <div class="event-header-name mdl-grid">
                            <div class="mdl-cell mdl-cell--6-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <select id="eventPlace" class="mdl-textfield__input" disabled>
                                        <option value="">Select</option>
                                        <?php
                                        if(isset($locData))
                                        {
                                            foreach($locData as $subkey => $subrow)
                                            {
                                                if(isset($subrow['id']))
                                                {
                                                    ?>
                                                    <option value="<?php echo $subrow['id'];?>" <?php if($subrow['id'] == $row['eventPlace']){echo 'selected';} ?>>
                                                        <?php echo $subrow['locName'];?></option>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                    <label class="mdl-textfield__label" for="eventPlace">Event Place</label>
                                    <input type="hidden" name="eventPlace" value="<?php echo $row['eventPlace'];?>"/>
                                </div>
                            </div>
                            <div class="mdl-cell mdl-cell--6-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <select name="eventCapacity" id="eventCapacity" class="mdl-textfield__input">
                                        <?php
                                        for($i=1;$i<=20;$i++)
                                        {
                                            ?>
                                            <option value="<?php echo $i;?>" <?php if($i == $row['eventCapacity']){echo 'selected';} ?>>
                                                <?php echo $i;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <label class="mdl-textfield__label" for="eventCapacity">Event Capacity</label>
                                </div>
                            </div>
                        </div>
                        <div class="event-header-name mdl-grid">
                            <input type="hidden" name="costType" value="<?php echo $row['costType'];?>"/>
                            <?php
                                if($row['costType'] == EVENT_FREE)
                                {
                                    ?>
                                    <input type="hidden" name="eventPrice" value="0"/>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <input type="hidden" name="eventPrice" value="<?php echo $row['eventPrice'];?>"/>
                                    <?php
                                }
                            ?>

                            <!--<div class="mdl-cell mdl-cell--12-col">
                                <p class="event-cost-head">Is the event Free or Paid?</p>
                            </div>
                            <?php
/*                            if($row['costType'] == EVENT_PAID || $row['costType'] == EVENT_PAID_NO_PINT || $row['costType'] == EVENT_DOOLALLY_FEE)
                            {
                                */?>
                                <div class="mdl-cell mdl-cell--6-col">
                                    <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="paidType">
                                        <input type="radio" id="paidType" class="mdl-radio__button" name="costType" value="2" checked>
                                        <span class="mdl-radio__label">Paid</span>
                                    </label>
                                    <p class="event-sub-text">For paid events, we charge Rs <?php /*echo NEW_DOOLALLY_FEE;*/?> per attendee which includes a pint or house fries.</p>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label event-price">
                                        <input class="mdl-textfield__input" type="text" pattern="-?[0-9]*(\.[0-9]+)?" id="eventPrice"
                                               value="<?php /*$price = (int)$row['eventPrice'] - (int)NEW_DOOLALLY_FEE; echo $price;*/?>">
                                        <label class="mdl-textfield__label" for="eventPrice">Event Fee + Rs. <?php /*echo NEW_DOOLALLY_FEE;*/?> Doolally Fee</label>
                                        <span class="mdl-textfield__error">Input is not a number!</span>
                                    </div>
                                    <div>Total Price: Rs. <span class="total-event-price"><?php /*echo ($row['eventPrice']); */?></span></div>
                                    <input type="hidden" name="eventPrice" value="<?php /*echo ($row['eventPrice']); */?>"/>
                                </div>
                                <div class="mdl-cell mdl-cell--6-col">
                                    <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="freeType">
                                        <input type="radio" id="freeType" class="mdl-radio__button" name="costType" value="1">
                                        <span class="mdl-radio__label">Free</span>
                                    </label>
                                    <p class="event-sub-text">If you don't charge, we don't charge</p>
                                </div>
                                <?php
/*                            }
                            else
                            {
                                */?>
                                <div class="mdl-cell mdl-cell--6-col">
                                    <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="paidType">
                                        <input type="radio" id="paidType" class="mdl-radio__button" name="costType" value="2">
                                        <span class="mdl-radio__label">Paid</span>
                                    </label>
                                    <p class="event-sub-text">For paid events, we charge Rs <?php /*echo NEW_DOOLALLY_FEE;*/?> per attendee which includes a pint or house fries.</p>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label event-price">
                                        <input class="mdl-textfield__input" type="text" pattern="-?[0-9]*(\.[0-9]+)?" id="eventPrice">
                                        <label class="mdl-textfield__label" for="eventPrice">Event Fee + Rs. <?php /*echo NEW_DOOLALLY_FEE; */?>Doolally Fee</label>
                                        <span class="mdl-textfield__error">Input is not a number!</span>
                                    </div>
                                    <div>Total Price: Rs. <span class="total-event-price">0</span></div>
                                    <input type="hidden" name="eventPrice" value="0"/>
                                </div>
                                <div class="mdl-cell mdl-cell--6-col">
                                    <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="freeType">
                                        <input type="radio" id="freeType" class="mdl-radio__button" name="costType" value="1" checked>
                                        <span class="mdl-radio__label">Free</span>
                                    </label>
                                    <p class="event-sub-text">If you don't charge, we don't charge</p>
                                </div>
                                --><?php
/*                            }
                            */?>
                            <div class="mdl-cell mdl-cell--12-col">
                                <p class="event-cost-head my-NoMargin">Need Accessories: </p>
                            </div>
                            <div class="mdl-cell mdl-cell--6-col text-right projSection">
                                <?php
                                if($row['ifProjectorRequired'] == '1')
                                {
                                    ?>
                                    <div class="projDiv isChecked">
                                        <input type="checkbox" name="ifProjectorRequired" onchange="toggleAccess(this)" id="ifProjectorRequired" value="1" checked />
                                        <label for="ifProjectorRequired">
                                            <i class="ic_projector_icon on"></i>
                                            <span class="on">Projector</span>
                                        </label>
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <div class="projDiv">
                                        <input type="checkbox" name="ifProjectorRequired" onchange="toggleAccess(this)" id="ifProjectorRequired" value="1" />
                                        <label for="ifProjectorRequired">
                                            <i class="ic_projector_icon"></i>
                                            <span>Projector</span>
                                        </label>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="mdl-cell mdl-cell--6-col micSection">
                                <?php
                                    if($row['ifMicRequired'] == '1')
                                    {
                                        ?>
                                        <div class="micDiv isChecked">
                                            <input type="checkbox" name="ifMicRequired" onchange="toggleAccess(this)" id="ifMicRequired" value="1" checked />
                                            <label for="ifMicRequired">
                                                <i class="ic_mic_icon on"></i>
                                                <span class="on">Microphone</span>
                                            </label>
                                        </div>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <div class="micDiv">
                                            <input type="checkbox" name="ifMicRequired" onchange="toggleAccess(this)" id="ifMicRequired" value="1" />
                                            <label for="ifMicRequired">
                                                <i class="ic_mic_icon"></i>
                                                <span>Microphone</span>
                                            </label>
                                        </div>
                                        <?php
                                    }
                                ?>
                            </div>

                            <div class="mdl-cell mdl-cell--12-col">Your details</div>
                            <!--<p class="event-sub-text">We'll contact you while we curate your event.</p>-->
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label my-fullWidth">
                                <input class="mdl-textfield__input" type="text" name="creatorName" id="creatorName" value="<?php echo $row['creatorName']; ?>" />
                                <label class="mdl-textfield__label" for="creatorName">Name</label>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label my-fullWidth">
                                <input class="mdl-textfield__input" type="number" name="creatorPhone" id="creatorPhone" maxlength="10"
                                       oninput="maxLengthCheck(this)" value="<?php echo $row['creatorPhone']; ?>" />
                                <label class="mdl-textfield__label" for="creatorPhone">Phone Number</label>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label my-fullWidth">
                                <input class="mdl-textfield__input" type="email" name="creatorEmail" id="creatorEmail" value="<?php echo $row['creatorEmail']; ?>" />
                                <label class="mdl-textfield__label" for="creatorEmail">Email ID</label>
                            </div>
                            <input type="hidden" name="userId" value="<?php echo $row['userId'];?>"/>
                            <div class="mdl-cell mdl-cell--12-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label my-fullWidth">
                                    <textarea class="mdl-textfield__input kbdfix" type="text" rows= "3" id="aboutCreator" name="aboutCreator"><?php echo $row['aboutCreator']; ?></textarea>
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
                                    Update Event
                                </button>
                            </div>
                            <div class="mdl-cell mdl-cell--3-col"></div>
                        </div><!-- grid close -->
                    </div>
                </form>
            </div>
        </div>
        <?php
    }
}
else
{
    echo 'No Events Found!';
}
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/bootstrap-datetimepicker.min.css">
<script type="application/javascript" src="<?php echo base_url(); ?>asset/js/bootstrap.min.js"></script>
<script type="application/javascript" src="<?php echo base_url(); ?>asset/js/bootstrap-datetimepicker.min.js"></script>
<script>
    componentHandler.upgradeDom();
    $('#eventDate').datetimepicker({
        format: 'YYYY-MM-DD',
        minDate: new Date(),
        useCurrent: false
    });
        //.dateDropper();
    $('#startTime').timepicker({
        dropdown: false
    });
    $('#endTime').timepicker({
        dropdown: false
    });
    /*$(document).ready(function(){
        if(typeof $('#eventDate').attr('data-value') != 'undefined')
        {
            var dataVal = $('#eventDate').attr('data-value');
            $('#eventDate').val(dataVal);
        }
    });*/
</script>