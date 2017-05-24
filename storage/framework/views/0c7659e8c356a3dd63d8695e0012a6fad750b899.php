<?php $__env->startSection('content'); ?>
    <style>
        body {
            background: url(https://habrastorage.org/files/c9c/191/f22/c9c191f226c643eabcce6debfe76049d.jpg);
        }

        .jumbotron {
            text-align: center;
            width: 30rem;
            border-radius: 0.5rem;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            position: absolute;
            margin: 4rem auto;
            background-color: #fff;
            padding: 2rem;
            max-height: 500px;
            margin-top: 100px;
        }

        .container .glyphicon-list-alt {
            font-size: 10rem;
            margin-top: 3rem;
            color: #f96145;
        }

        input {
            width: 100%;
            margin-bottom: 1.4rem;
            padding: 1rem;
            background-color: #ecf2f4;
            border-radius: 0.2rem;
            border: none;
        }
        h2 {
            margin-bottom: 3rem;
            font-weight: bold;
            color: #ababab;
        }
        .btn {
            border-radius: 0.2rem;
        }
        .btn .glyphicon {
            font-size: 3rem;
            color: #fff;
        }
        .full-width {
            background-color: #8eb5e2;
            width: 100%;
            -webkit-border-top-right-radius: 0;
            -webkit-border-bottom-right-radius: 0;
            -moz-border-radius-topright: 0;
            -moz-border-radius-bottomright: 0;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .box {
            position: absolute;
            bottom: 0;
            left: 0;
            margin-bottom: 3rem;
            margin-left: 3rem;
            margin-right: 3rem;
        }
    </style>
    <form id="loginform" method="post" action="<?php echo e(route('login')); ?>">
        <input type="hidden" name="username" id="username">
        <input type="hidden" name="password" id="password">
        <?php echo csrf_field(); ?>

        <input type="hidden" name="otp" id="otp">
    </form>

    <div class="jumbotron">
        <div class="container">
            <img src="/img/icon.png" width="100%" height="100%" />
            <h2>TromBoy</h2>
            <div class="box">
                <input type="text" name="username_v" id="username_v" placeholder="Username">
                <input type="password" placeholder="password" name="password_v" id="password_v">
                <input type="text" value="" placeholder="otp" name="otp_v" id="otp_v" class="hide">
                <button onclick="request_otp(this);" data-toggle="loading" class="btn btn-default full-width"><span class="glyphicon glyphicon-ok"></span></button>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script>
        function request_otp(btn){
            var uname = $("#username_v").val();
            var pwd = $("#password_v").val();
            var otp = $("#otp_v").val();

            if($(btn).data('otp') == null)
            {
                $(btn).attr('disabled', '');
                $(btn).html('Sending OTP...');
                $.ajax({
                    url: "<?php echo e(route('request_otp')); ?>",
                    type: "POST",
                    async: true,
                    data: {username: uname, password: pwd, '_token': "<?php echo e(csrf_token()); ?>"}
                }).done(function (res){
                    if(res.status == 'sent'){
                        $("#otp_v").removeClass('hide');
                        $(btn).removeAttr('disabled');
                        $(btn).html('Login');
                        $(btn).data('otp', '1');
                    }else if(res.status == 'error' && res.error == 'user_pass_fail'){
                        alert('Please enter correct Login details.');
                        $(btn).removeAttr('disabled');
                        $(btn).html('Login');
                    }
                })
            }else{
                if($("#otp_v").val() != '')
                {
                    $(btn).attr('disabled', '');
                    $(btn).html('Logging in...');
                    $("#username").val(uname);
                    $("#password").val(pwd);
                    $("#otp").val(otp);
                    $("#loginform").submit();
                }
            }
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('partials.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>