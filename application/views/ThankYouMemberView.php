<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $desktopStyle ;?>
</head>
    <body class="mainHome">
    <div class="mdl-grid">
        <div class="mdl-cell--1-col"></div>
        <div class="mdl-cell--10-col">
            <div class="demo-card-square mdl-shadow--2dp text-center">
                <div class="mdl-custom-login-title">
                    <br>
                    <h4 class="mdl-card__title-text my-success-text" style="font-size:20px">Thank You For Registering Mug Membership<br>You'll Receive Email Once Membership is confirmed!</h4>
                    <br>
                    <a href="<?php echo base_url();?>" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent bookNow-event-btn" style="text-transform: capitalize;">
                        Visit Doolally
                    </a>
                </div>
                <br>
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
<script>
    $('#dob').dateDropper();
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

        if($('#userName').val() == '')
        {
            mySnackTime('Please Provide Name');
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

                }
                else
                {
                    vex.dialog.buttons.YES.text = 'Close';
                    vex.dialog.alert({
                        unsafeMessage: '<label class="head-title">Error!</label><br><br>'+data.errorMsg
                    });
                }

            },
            error: function(){
                hideProgressLoader();
                $('button[type="submit"]').removeAttr('disabled');
                vex.dialog.buttons.YES.text = 'Close';
                vex.dialog.alert({
                    unsafeMessage: '<label class="head-title">Error!</label><br><br>'+'Some Error Occurred!'
                });
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
                error: function()
                {
                    $('.mug-suggestions').addClass('my-danger-text').html('Unable To Connect To Server!');
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

