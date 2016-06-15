<?php
/**
 * Copyright (c) 2016. 
 * Contact me at fzls.zju@gmail.com [ Chen Ji ]
 */

/**
 * Created by PhpStorm.
 * User: 风之凌殇
 * Date: 6/13/2016
 * Time: 11:50 PM
 */
require '../common/post_only.php';
require '../util/form_data_validation.php';
$added_user = censor_input($_POST['added_user']);
$image_id = censor_input($_POST['image_id']);
$tag_name = censor_input($_POST['tag_name']);

$conn = new mysqli('localhost', 'root', 'root', 'pilipili');
// if tag not exist, insert it into tag categrty
$res = $conn->query("SELECT * FROM tag_category WHERE name='" . $tag_name . "'");
if ($res->num_rows == 0) {
    $conn->query("INSERT INTO tag_category(name) VALUES ('" . $tag_name . "')");
}
// add tag to db
$conn->query("INSERT INTO image_tag (image_id,tag_id,added_user)
  SELECT " . $image_id . ", id, " . $added_user . " FROM tag_category WHERE name='" . $tag_name . "';");
// formatted it to send back

echo '
<div class="inline-block"><a href="../search/search.php?mode=tag_full&word=' . $tag_name . '"><span class="glyphicon glyphicon-tag tag" aria-hidden="true"></span> ' . $tag_name . '</a></div>
    ';

?>