<?php
function add_nbsp($cnt, $content)
{
    for ($i = 0; $i < $cnt; ++$i)
        echo '&nbsp';
    echo $content;
    for ($i = 0; $i < $cnt; ++$i)
        echo '&nbsp';
}

?>