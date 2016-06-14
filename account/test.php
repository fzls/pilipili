<?php
/**
 * Created by PhpStorm.
 * User: 风之凌殇
 * Date: 6/11/2016
 * Time: 9:21 AM
 */
//$title = 'test';
//$btn_text='login';
//$btn_action='login.php';
//require '_Layout.php';
//$conn = new mysqli('localhost','root','root','pilipili');
//$res = $conn->query("SELECT * FROM comment WHERE image_id =" . 1 . " ORDER BY id");
//$comments = $res->fetch_all(MYSQLI_ASSOC);
////print_r($comments);
//foreach ($comments as $comment) {
//    print_r($comment);
//    echo '<br>';
//}
//
//echo '--------------------<br>';
//print_r($comments);
//$conn->close();
//
////
//$content = '';
//eval('$content=\''.'喂，离截止日期只有 <h1 style="display: inline-block;">\';$rem = strtotime("2016-6-21") - time();$content.= (ceil($rem / 60 / 60 / 24).\'</h1> 天了\')'.'\';');
//echo $content;

//echo md5_file('../tmp_upload/1234.png').PHP_EOL;
//echo md5_file('../tmp_upload/1234_new_name_test_md5.png').PHP_EOL;

//echo date('Y-m-d_H-i-s');

list($width, $height) = getimagesize('../tmp_upload/1234.png');
echo $width . ' ' . $height;

?>