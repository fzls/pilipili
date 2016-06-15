<?php
/**
 * Copyright (c) 2016. 
 * Contact me at fzls.zju@gmail.com [ Chen Ji ]
 */

/**
 * Created by PhpStorm.
 * User: 风之凌殇
 * Date: 6/14/2016
 * Time: 6:04 AM
 */
require '../common/check_loged_in.php';
require '../util/add_button_width_with_nbsp.php';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $conn = new mysqli('localhost', 'root', 'root', 'pilipili');
    //TODO : validate user input
    $name = $_POST['title'];
    $ratings = $views = $total_score = 0;
    $author_id = $_SESSION['current_user']['id'];
    $res = $conn->query("SELECT id FROM image_category WHERE name='" . $_POST['original'] . "'");
    if ($res->num_rows != 0) {
        $category_id = $res->fetch_assoc()['id'];
    } else {
        $conn->query("INSERT INTO image_category(name) VALUES ('" . $_POST['original'] . "')");
        $category_id = $conn->query("SELECT id FROM image_category WHERE name='" . $_POST['original'] . "'")->fetch_assoc()['id'];
    }
    $description = $_POST['description'];
    if (isset($_POST['browsing_restriction']))
        $browsing_restriction = $_POST['browsing_restriction'];
    else
        $browsing_restriction = 'All ages';
    if (isset($_POST['privacy']))
        $privacy = $_POST['privacy'];
    else
        $privacy = 'public';
    $tags = preg_split('/\s+/', trim($_POST['tags']));


    //fixme: umfinished

    //DO upload works
    $upload_info = '';
    $cnt = 0;
    foreach ($_FILES['uploaded_images']['error'] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['uploaded_images']['tmp_name'][$key];
            date_default_timezone_set("Asia/Shanghai");
            $filename = date('Y-m-d_H-i-s') . '_' . $_FILES['uploaded_images']['name'][$key];
            $filesize = $_FILES['uploaded_images']['size'][$key];
            $filetype = $_FILES['uploaded_images']['type'][$key];
            //TODO: do some input check

            $upload_dir = '../uploaded_img/';
            $upload_file = $upload_dir . basename($filename);#with time stamp
            $file_already_exists = $conn->query("SELECT * FROM image WHERE md5_hash='" . md5_file($tmp_name) . "'")->num_rows != 0;
            if ($file_already_exists) {
                $upload_info .= $filename . ' ALREADY EXISTS in server<br>';
            } else if (move_uploaded_file($tmp_name, $upload_file)) {
                $upload_info .= $filename . ' has been UPLOADED<br>';
                $cnt++;
                list($width, $height) = getimagesize($upload_file);
                // TODO: add this image to db
                // insert into image
                $conn->query("INSERT INTO image (name, filepath, filesize, filename, filetype, ratings, views, author_id, total_score, resolution_height, resolution_width, category_id, description, browsing_restriction, privacy, md5_hash)
VALUES ('" . $name . "', '" . $upload_file . "', '" . $filesize . "', '" . $filename . "', '" . $filetype . "', " . $ratings . ", " . $views . ", " . $author_id . ", " . $total_score . ", " . $height . ", " . $width . ", " . $category_id . ", '" . $description . "', '" . $browsing_restriction . "', '" . $privacy . "', '" . md5_file($upload_file) . "');");
                // add tag to image_tag and tag_category if necessary
                $image_id = $conn->query("SELECT id FROM image WHERE id = LAST_INSERT_ID()")->fetch_assoc()['id'];
                foreach ($tags as $tag_name) {
                    // find the id of the name, or create it if not exists
                    $res = $conn->query("SELECT * FROM tag_category WHERE name='" . $tag_name . "'");
                    if ($res->num_rows != 0) {
                        $tag_id = $res->fetch_assoc()['id'];
                    } else {
                        $conn->query("INSERT INTO tag_category(name) VALUES ('" . $tag_name . "')");
                        $tag_id = $conn->query("SELECT * FROM tag_category WHERE name='" . $tag_name . "'")->fetch_assoc()['id'];
                    }
                    $conn->query("INSERT INTO image_tag(image_id, tag_id, added_user) VALUES (" . $image_id . "," . $tag_id . "," . $author_id . ")");
                }
            } else {
                $upload_info .= $filename . ' FAILED to upload<br>';
            }
        }
    }
    $conn->close();
    $upload_info .= '<h1>' . $cnt . ' files uploaded successfully</h1>';

    //finish : use  Post + Redirect to self
    $_SESSION['upload_info'] = $upload_info;
    header("location: upload.php");
    exit;
//    die($error_info);//fixme
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <?php require '../common/head.php'; ?>
    <link rel="stylesheet" href="../css/bootstrap.css"><!--fixme-->
    <script src="../js/jquery.MultiFile.js"></script>
    <style>
        #global_nav {
            margin-bottom: 0;
        }

        #choose_category_nav .navbar-inverse .navbar-nav {
            display: inline-block;
            float: none;
            vertical-align: top;
        }

        #choose_category_nav .navbar-inverse .navbar-collapse {
            text-align: center;
        }

        body {
            background-color: #f4f2f4;
        }

        #illustration_form input, #illustration_form textarea {
            padding: 16px 20px;
        }

    </style>
</head>
<body>
<?php require '../common/navbar.php'; ?>
<!--choose category-->
<div id="choose_category_nav">
    <nav class="navbar-inverse" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#choose_nav">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="choose_nav">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="upload.php"><?php add_nbsp(5, 'Illustrations'); ?></a></li>
                    <li><a href="upload.php?type=manga"><?php add_nbsp(5, 'Manga'); ?></a></li>
                    <li><a href="ugoira_upload.php"><?php add_nbsp(5, 'Ugoira'); ?></a></li>
                    <li><a href="../novel/upload.php"><?php add_nbsp(5, 'Novel'); ?></a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<form enctype="multipart/form-data" action="upload.php" method="post" class="form-horizontal" id="illustration_form">
    <div id="select_file" class="text-center" style="background-color: #333;height: 202px;position: relative;">
        <div class="inline-block "><img class="vertical-center" src="../img/hint-illust-1-en.png" alt="hint-1"
                                        style="height: 135px;position: absolute;top: 25px;left: 225px;"></div>
        <div class="inline-block">
            <div><img src="../img/hint-illust-2-en.png" alt="hint-2" style="height: 63px;margin-top: -10px;"></div>
            <label class="btn btn-primary btn-lg btn-file" style="margin: 10px 0;">
                <?php add_nbsp(15, '<span class="glyphicon glyphicon-open-file"></span> <b>Select file</b>'); ?>
                <input type="file" name="uploaded_images[]" style="display: none;" multiple
                       accept="image/jpeg, image/gif, image/png">
            </label>
            <div style="color: #ccc;font-size: 100%" class="container-fluid">
                <ul class="_inline-list">
                    <li>JPEG</li>
                    <li>GIF</li>
                    <li>PNG</li>
                    <li>1 image limit: 8MB</li>
                    <li class="total-files">total limit: 30MB, up to 200 images.</li>
                    <!--                    fixme-->
                </ul>
            </div>
        </div>
    </div>
    <?php if (isset($_SESSION['upload_info'])) echo '<div class="well container text-center">' . $_SESSION['upload_info'] . '</div>';
    unset($_SESSION['upload_info']) ?>

    <div class="container text-center">
        <input type="hidden" name="mode" value="upload">
        <input type="hidden" name="type" value="illustration">
        <input type="hidden" name="user_id" value="1"><!-- fixme -->
        <div class="form-group">
            <input type="text" class="form-control" id="title" name="title" placeholder="Title">
            <textarea rows="5" class="form-control" id="description"
                      name="description" placeholder="Description"></textarea>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="tags" name="tags"
                   placeholder="Enter your tags, and separate it with space or tab">
            <div class="text-left well-sm form-content">
                <div class="inline-block" style="color: #b8e986;">
                    Recommended<br>
                    Tags
                </div>
                <div class="inline-block" id="recommended_tags">

                </div>
            </div>
            <div class="text-left form-content">
                <input type="checkbox">Lock tags only to author
            </div>
        </div>
        <div class="form-group text-left form-content">
            <div class="inline-block">Browsing restriction <?php add_nbsp(2, ''); ?></div>
            <label class="radio-inline">
                <input type="radio" name="browsing_restriction" id="browsing_restriction_all_ages" value="All ages">
                all_ages
            </label>
            <label class="radio-inline">
                <input type="radio" name="browsing_restriction" id="browsing_restriction_R_18" value="R-18"> R-18
            </label>
            <label class="radio-inline">
                <input type="radio" name="browsing_restriction" id="browsing_restriction_R_18G" value="R-18G"> R-18G
            </label>
        </div>
        <div class="form-group form-content text-left">
            <div class="inline-block">Privacy<?php add_nbsp(2, ''); ?></div>
            <label class="radio-inline">
                <input type="radio" name="privacy" id="privacy_public" value="public"> Make public
            </label>
            <label class="radio-inline">
                <input type="radio" name="privacy" id="privacy_uploader_only" value="uploader only"> My pixiv only
            </label>
            <label class="radio-inline">
                <input type="radio" name="privacy" id="privacy_private" value="private"> Private
            </label>
        </div>
        <h3 class="text-left">Content</h3>
        <div class="form-group text-left">
            <div class="form-content"><input type="checkbox" name="original" value="Original[DEBUG]"> Original work
            </div>
            <div class="form-content">
                <div class="inline-block">Sexual/Suggestive content?<?php add_nbsp(2, ''); ?></div>
                <label class="radio-inline">
                    <input type="radio" name="sexual_content" id="sexual_content_none" value="none"> None
                </label>
                <label class="radio-inline">
                    <input type="radio" name="sexual_content" id="sexual_content_yes" value="yes"> Yes (Includes light
                    sexual or suggestive)
                </label>
            </div>
            <div class="form-content">
                <div class="inline-block" style="vertical-align: top">Contains <?php add_nbsp(5, ''); ?> </div>
                <div class="inline-block">
                    <ul>
                        <li class="checkbox">
                            <label><input type="checkbox" name="contains[]" id="contain_violence" value="violence">Violence</label>
                        </li>
                        <li class="checkbox">
                            <label><input type="checkbox" name="contains[]" id="contain_drugs"
                                          value="drugs, smoking, alcoholism">
                                Drugs, smoking, alcoholism</label>
                        </li>
                        <li class="checkbox">
                            <label><input type="checkbox" name="contains[]" id="contain_sensitive"
                                          value="Strong language/Sensitive themes">Strong language/Sensitive
                                themes</label>
                        </li>
                        <li class="checkbox">
                            <label><input type="checkbox" name="contains[]" id="contain_criminal" value="Criminal acts">Criminal
                                acts</label>
                        </li>
                        <li class="checkbox">
                            <label><input type="checkbox" name="contains[]" id="contain_religious"
                                          value="Religious imagery">Religious imagery</label>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="form-content">
                <div class="inline-block" style="vertical-align: top">Mature content <?php add_nbsp(5, ''); ?> </div>
                <div class="inline-block">
                    <ul>
                        <li class="checkbox">
                            <label><input type="checkbox" name="mature_content[]" id="minors"
                                          value="minors">Minors</label>
                        </li>
                        <li class="checkbox">
                            <label><input type="checkbox" name="mature_content[]" id="furry" value="furry">Furry</label>
                        </li>
                        <li class="checkbox">
                            <label><input type="checkbox" name="mature_content[]" id="bl" value="bl">BL</label>
                        </li>
                        <li class="checkbox">
                            <label><input type="checkbox" name="mature_content[]" id="gl" value="gl">GL</label>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="text-center form-content">
                Please only upload work that you've made or have permission to post. Work that violate our <a
                    href="#">Terms of Use</a> and <a href="#">Guidelines</a> will be deleted.
            </div>
        </div>
        <h3 class="text-left">Tools used</h3>
        <div class="form-group text-left">
            <div class="row">
                <div class="col-xs-4">
                    <input class="btn-group-justified" type="text" name="tool_1" id="tool_1" placeholder="Tools used 1">
                </div>
                <div class="col-xs-4">
                    <input class="btn-group-justified" type="text" name="tool_2" id="tool_2" placeholder="Tools used 2">
                </div>
                <div class="col-xs-4">
                    <input class="btn-group-justified" type="text" name="tool_3" id="tool_2" placeholder="Tools used 3">
                </div>
            </div>
        </div>

        <h3 class="text-left">Poll</h3>
        <div class="form-group text-left">
            <input type="text" class="form-control" name="poll_question" id="poll_question"
                   placeholder="Question: (eg: WTF this ASP.NET MVC is ?)">
        </div>

        <h3 class="text-left">Image response</h3>
        <div class="form-group text-left">
            <input type="text" class="form-control" name="image_response" id="image_response"
                   placeholder="Image Response Work ID / URL">
            <label class="checkbox form-content">
                <input type="checkbox" name="allow_response" id="allow_response" value="allow response"> Automatically
                allow responses to my work
            </label>
        </div>

        <h3 class="text-left">Reserve submissions</h3>
        <div class="form-group text-left">
            <label class="checkbox form-content">
                <input type="checkbox" name="submit_later" id="submit_later" value="submit later">
                Schedule the date and time of uploading
            </label>
            <div class="row">
                <div class="col-md-6">
                    <input type="date" class="form-control" name="reserve_submit_time" id="reserve_submit_time">
                </div>
                <div class="col-md-6">
                    <input type="time" class="form-control" name="reserve_submit_time" id="reserve_submit_time">
                </div>
            </div>
        </div>

        <button accesskey="c" class="btn btn-primary" role="button"
                type="submit"><?php add_nbsp(5, 'Submit'); ?></button>
    </div>
</form>
<div class="container text-center">
    <hr>
    <hr>
    <hr>
    <hr>
</div>
<?php require '../common/footer.php'; ?>
</body>
</html>
