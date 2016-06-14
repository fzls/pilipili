<?php
/**
 * Created by PhpStorm.
 * User: 风之凌殇
 * Date: 6/13/2016
 * Time: 4:58 AM
 */
// require
// $comment: the comment itself
// $comment_user: the user who post the comment

$div_id = 'area_comments_' . $comment['id'];
echo '
<div class="wrap">
    <div id="' . $div_id . '" class="col-md-12 container-fluid">
        <div class="col-md-2">
            <img src="' . $comment_user['avator_filepath'] . '" alt="avator of ' . $comment_user['pilipili_id'] . '">
        </div>
        <div class="col-md-10">
            <div id="' . $div_id . '_user_info">
                <a href="#">' . $comment_user['pilipili_id'] . '</a> ' . $comment['post_time'] . '
            </div>
            <div id="' . $div_id . '_content">
                <pre>' . $comment['content'] . '</pre>
            </div>
            <div>
                <!--TODO: add comment"s user page link after user page done-->
                <a href="#">reply</a>
            </div>
        </div>
    </div>
    <div>&nbsp</div>
</div>
';
?>