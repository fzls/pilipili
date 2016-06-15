<?php
/**
 * Copyright (c) 2016. 
 * Contact me at fzls.zju@gmail.com [ Chen Ji ]
 */

//    $title : the title of the generated html file
//    $btn_text : the text of the switch btn( if any) in the top right
//    $btn_action : the action of clicking the switch btn( if any) in the top right
//    $background_image : the name of the background image
//    $form_content : the name of the php file that contains codes for the form content
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php if (isset($title)) echo $title; ?> - powered by 风之凌殇</title>
    <?php require 'head.php' ?>
    <style>
        body {
            background: url("../img/<?php echo isset($background_image)?$background_image:'login_or_signup.jpg';?>") no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body>
<div>
    <?php require 'switch_btn.php';
    if (isset($btn_text) and isset($btn_action)) put_switch_btn($btn_text, $btn_action); ?>
    <div class="container">
        <div class="login-form-wrapper">
            <div style="padding-bottom: 50px;">
                <img src="../img/logo.png" alt="pilipili" style="height: 70px;"/> <br/>

                Splice your creating process
            </div>
            <!--form content-->
            <?php if (isset($form_content)) require $form_content; ?>
            <!--            social media links-->
            <div style="background-color: rgb(255, 255, 255); padding: 20px;">
                <div style="padding: 20px; font-size: 10px;">
                    Begin with an existing account
                </div>
                <div class="btn-group btn-group-justified pad-bottom" role="group">
                    <div class="btn-group pad-horizontal" role="group">
                        <a href="#" role="button" class="btn btn-default"><img src="../img/googleplus30x30.png"
                                                                               alt="Google"/></a>
                    </div>
                    <div class="btn-group pad-horizontal" role="group">
                        <a href="#" role="button" class="btn btn-default"><img src="../img/facebook30x30.png"
                                                                               alt="Facebook"/></a>
                    </div>
                    <div class="btn-group pad-horizontal" role="group">
                        <a href="#" role="button" class="btn btn-default"><img src="../img/twitter30x30.png"
                                                                               alt="Twitter"/></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--footer-->
<?php require '../common/footer_simplify.php' ?>
</body>
</html>
