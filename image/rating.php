<?php
/**
 * Copyright (c) 2016. 
 * Contact me at fzls.zju@gmail.com [ Chen Ji ]
 */

/**
 * Created by PhpStorm.
 * User: 风之凌殇
 * Date: 6/17/2016
 * Time: 3:20 AM
 */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $image_id = $_POST['image_id'];
    $score = $_POST['score'];
    require_once '../common/connect_db.php';
    $conn = connect_db();
    $conn->query("INSERT INTO rate_image_event(user_id, image_id, score) VALUES (" . $user_id . "," . $image_id . "," . $score . ")");
    $conn->query("UPDATE image SET ratings=ratings+1, total_score=total_score+" . $score . " WHERE id=" . $image_id);
    $conn->close();
}
?>