<?php
/**
 * Copyright (c) 2016. 
 * Contact me at fzls.zju@gmail.com [ Chen Ji ]
 */

/**
 * Created by PhpStorm.
 * User: 风之凌殇
 * Date: 6/11/2016
 * Time: 5:02 AM
 */
function censor_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function email_registered($email)
{
    require_once '../common/connect_db.php';
    $conn = connect_db();
    return $conn->query("SELECT * FROM user WHERE email = '" . $email . "'")->num_rows != 0;
}

function id_registered($id)
{
    require_once '../common/connect_db.php';
    $conn = connect_db();
    return $conn->query("SELECT * FROM user WHERE pilipili_id = '" . $id . "'")->num_rows != 0;
}

?>