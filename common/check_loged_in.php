<?php
/**
 * Created by PhpStorm.
 * User: 风之凌殇
 * Date: 6/12/2016
 * Time: 8:24 PM
 */
session_start();
//TODO: check whether user valid or not
if (!isset($_SESSION['current_user'])) {
    header('Location: ' . '../account/login_or_signup.php', true, 301);
    exit;
}
?>