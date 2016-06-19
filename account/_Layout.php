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
            background-image: url("../img/<?php echo isset($background_image)?$background_image:'login_or_signup.jpg';?>");
            background-repeat: no-repeat;
            background-size: cover;
        }

    </style>
    <script>
        function change_background(index) {
            var ajax = new XMLHttpRequest();
            var url = "change_background.php";
            ajax.onreadystatechange = function () {
                if (ajax.readyState == 4 && ajax.status == 200) {
                    var new_bg = ajax.responseText;
                    document.body.style = 'background-image: url("' + new_bg + '");background-repeat: no-repeat;background-size: cover;transition: background-image 0.5s linear;';
                    setTimeout(function () {
                        change_background();
                    }, 5000);
                }
            }
            ajax.open('get', url, true);
            ajax.send();
        }
        window.onload = function () {
            change_background();
            var bgm = document.getElementById('bgm');
            bgm.volume = 0.3;
        }
    </script>
</head>
<body>
<div>
    <?php require 'switch_btn.php';
    if (isset($btn_text) and isset($btn_action)) put_switch_btn($btn_text, $btn_action); ?>
    <div class="container">
        <audio id="bgm" src="../music/佐倉綾音 - Daydream café ~ご注文はココアですか？ ver.~.mp3" loop autoplay="autoplay">
            <p>If you are reading this, it is because your browser does not support the audio element.</p>
        </audio>
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
