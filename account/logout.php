<?php
/**
 * Created by PhpStorm.
 * User: 风之凌殇
 * Date: 6/11/2016
 * Time: 11:26 AM
 */
session_start();
unset($_SESSION['current_user']);
header('Location: ' . '../home/index.php', true, 301);
?>


