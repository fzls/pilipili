<?php
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
    $conn = new mysqli('localhost', 'root', 'root', 'pilipili');
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->close();
    $conn->close();
    return $res->num_rows != 0;
}

function id_registered($id)
{
    $conn = new mysqli('localhost', 'root', 'root', 'pilipili');
    $stmt = $conn->prepare("SELECT * FROM user WHERE id = ?");
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->close();
    $conn->close();
    return $res->num_rows != 0;
}

?>