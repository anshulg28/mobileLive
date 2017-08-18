<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $desktopStyle ;?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/bootstrap.min.css">
</head>
    <body class="mainHome">
    <div id="custom-progressBar" class="mdl-progress mdl-js-progress mdl-progress__indeterminate hide"></div>
    <div class="mdl-grid">
        <div class="mdl-cell--1-col"></div>
        <div class="mdl-cell--10-col">
            <div class="demo-card-square mdl-shadow--2dp text-center">
                <div class="mdl-custom-login-title">
                    <h2 class="mdl-card__title-text">Doolally New Mug Membership</h2>
                </div>
                <form action="<?php echo base_url().'main/verifyMember';?>" method="POST" id="main-mug-form">
                    <div class="mdl-card__supporting-text">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="number" id="mugId" name="mugId">
                            <label class="mdl-textfield__label" for="mugId">Mug Number</label>
                        </div>&nbsp;
                        <br>
                        <div class="mug-suggestions"></div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" id="firstName" name="firstName">
                            <label class="mdl-textfield__label" for="firstName">First Name</label>
                        </div>
                        <br>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" id="lastName" name="lastName">
                            <label class="mdl-textfield__label" for="lastName">Last Name</label>
                        </div>
                        <br>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" id="email" name="email">
                            <label class="mdl-textfield__label" for="email">Email</label>
                        </div>
                        <br>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="number" id="mobNum" name="mobNum">
                            <label class="mdl-textfield__label" for="mobNum">Mobile Number</label>
                        </div>
                        <br>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" id="tagName" name="tagName">
                            <label class="mdl-textfield__label" for="tagName">Name On Tag (if any)</label>
                        </div>
                        <br>
                        <div class="mdl-textfield mdl-js-textfield">
                            <input class="form-control" placeholder="Date Of Birth" type="text" id="dob" name="dob"/>
                            <!--<label class="mdl-textfield__label" for="dob">Date Of Birth</label>-->
                        </div>
                        <br>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <select id="homebase" name="homebase" class="mdl-textfield__input" style="font-family: 'Averia Serif Libre' !important;">
                                <option value=""></option>
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
                            <label class="mdl-textfield__label" for="homebase">Homebase</label>
                        </div>
                        <br>
                        <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent bookNow-event-btn" style="text-transform: capitalize;" disabled>
                            Register & Pay Rs. 3000
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="mdl-cell--1-col"></div>
    </div>
    <div id="demo-toast" class="mdl-js-snackbar mdl-snackbar">
        <div class="mdl-snackbar__text"></div>
        <button class="mdl-snackbar__action" type="button"></button>
    </div>
    </body>
<?php echo $desktopJs ;?>
<script type="application/javascript" src="<?php echo base_url(); ?>asset/js/bootstrap-datetimepicker.min.js"></script>
<script type="application/javascript" src="<?php echo base_url(); ?>asset/js/bootstrap.min.js"></script>
<script>
    $('#dob').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    //$('#dob').dateDropper();
    function getAge(dateString)
    {
        var today = new Date();
        var birthDate = new Date(dateString);
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate()))
        {
            age--;
        }
        return age;
    }
    $(document).on('submit','#main-mug-form',function(e){
        e.preventDefault();

        if($('#firstName').val() == '')
        {
            mySnackTime('Please Provide First Name');
            return false;
        }
        if($('#lastName').val() == '')
        {
            mySnackTime('Please Provide Last Name');
            return false;
        }

        if($('#email').val() == '')
        {
            mySnackTime('Please Provide Email');
            return false;
        }
        if($('#mobNum').val() == '')
        {
            mySnackTime('Mobile Number Required!');
            return false;
        }

        if(getAge($('#dob').val()) < 21)
        {
            mySnackTime('Not a Legal Drinking Age(21 yrs)');
            return false;
        }

        if($('#homebase').val() == '')
        {
            mySnackTime('Please Select The Homebase!');
            return false;
        }

        if($('#mugId').val() == '')
        {
            mySnackTime('Mug Number is Required!');
            return false;
        }

        showProgressLoader();
        $('button[type="submit"]').attr('disabled','disabled');

        $.ajax({
            type:'POST',
            dataType:'json',
            url:$(this).attr('action'),
            data:$(this).serialize(),
            success: function(data){
                hideProgressLoader();

                if(data.status === true)
                {
                    if(typeof data.payUrl != 'undefined')
                    {
                        window.location.href=data.payUrl;
                    }
                    else
                    {
                        vex.dialog.buttons.YES.text = 'Close';
                        vex.dialog.alert({
                            unsafeMessage: '<label class="head-title">Error!</label><br><br>Failed To Process Request, Please Try Again!'
                        });
                    }
                }
                else
                {
                    vex.dialog.buttons.YES.text = 'Close';
                    vex.dialog.alert({
                        unsafeMessage: '<label class="head-title">Error!</label><br><br>'+data.errorMsg
                    });
                }

            },
            error: function(xhr, status, error){
                hideProgressLoader();
                $('button[type="submit"]').removeAttr('disabled');
                vex.dialog.buttons.YES.text = 'Close';
                vex.dialog.alert({
                    unsafeMessage: '<label class="head-title">Error!</label><br><br>'+'Some Error Occurred!'
                });
                var err = '<pre>'+xhr.responseText+'</pre>';
                saveErrorLog(err);
            }
        });

    });

    $(document).on('focusout','#mugId', function(){
        if($(this).val() != '')
        {
            var mugNum = $(this).val();
            $.ajax({
                type:"GET",
                dataType:"json",
                url:base_url+'main/MugAvailability/'+mugNum,
                success: function(data)
                {
                    if(data.status === true)
                    {
                        $('.mug-suggestions').addClass('my-success-text').html('Mug Number is Available');
                        $('button[type="submit"]').removeAttr('disabled');
                    }
                    else
                    {
                        $('button[type="submit"]').attr('disabled','disabled');
                        var suggHtml = '<span class="my-danger-text">Mug Number is Not Available!</span><br>';
                        if(typeof data.availMugs != 'undefined')
                        {
                            var mugHtml = '';
                            var i = 1;
                            for(var index in data.availMugs)
                            {
                                if(i == 5)
                                {
                                    $('.mug-suggestions').html(suggHtml);
                                    return false;
                                }
                                suggHtml += '<span class="mdl-chip"><span class="mdl-chip__text avail-mugs">'+data.availMugs[index]+'</span></span>';
                                i++;
                            }
                        }
                        $('.mug-suggestions').addClass('my-danger-text').html(suggHtml);
                    }
                },
                error: function(xhr, status, error)
                {
                    $('.mug-suggestions').addClass('my-danger-text').html('Unable To Connect To Server!');
                    var err = '<pre>'+xhr.responseText+'</pre>';
                    saveErrorLog(err);
                }
            });
        }
    });

    $(document).on('click','.avail-mugs',function(){
        $('#mugId').val($(this).html());
        $('#mugId').trigger('focusout');
    });
    componentHandler.upgradeDom();
</script>
</html>

