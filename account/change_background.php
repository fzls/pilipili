<?php
/**
 * Copyright (c) 2016. 
 * Contact me at fzls.zju@gmail.com [ Chen Ji ]
 */

/**
 * Created by PhpStorm.
 * User: 风之凌殇
 * Date: 6/19/2016
 * Time: 10:17 AM
 */
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $conn = new mysqli('localhost', 'root', 'root', 'pilipili');
    $bg = $conn->query("SELECT * FROM image ORDER BY rand() LIMIT 1")->fetch_assoc()['filepath'];
    echo $bg;
}
?>