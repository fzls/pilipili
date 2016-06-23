<?php
/**
 * Copyright (c) 2016. 
 * Contact me at fzls.zju@gmail.com [ Chen Ji ]
 */

/**
 * Created by PhpStorm.
 * User: 风之凌殇
 * Date: 6/13/2016
 * Time: 3:45 AM
 */
require '../common/post_only.php';
require '../util/form_data_validation.php';
$user_id = censor_input($_POST['user_id']);
$image_id = censor_input($_POST['image_id']);
$content = censor_input($_POST['content']);
// connect to db
require_once '../common/connect_db.php';
$conn = connect_db();

// add to database
$conn->query("INSERT INTO comment (user_id,image_id,content) VALUES (" . $user_id . "," . $image_id . ",'" . $conn->real_escape_string($content) . "');");

// fetch comment back
$res = $conn->query("SELECT * FROM comment WHERE id=LAST_INSERT_ID()");
$comment = $res->fetch_assoc();

// add this comment to current page
$res = $conn->query("SELECT avatar_filepath,pilipili_id,id FROM user WHERE id=" . $user_id);
$comment_user = $res->fetch_assoc();
$conn->close();

require 'display_comment.php';
?>
