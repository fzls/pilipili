<?php
/**
 * Created by PhpStorm.
 * User: 风之凌殇
 * Date: 6/11/2016
 * Time: 8:52 AM
 */

function put_switch_btn($str_on_btn, $action)
{
    echo '<div class="pull-right" style="padding: 10px;">
        <a href="' . $action . '" role="button" class="btn-lg btn-info btn-block"
           style="text-decoration: none; font-size: 10px;">' . $str_on_btn . '</a>
    </div>';
}

?>