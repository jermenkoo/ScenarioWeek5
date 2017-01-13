<?php
/**
 * Created by PhpStorm.
 * User: yomek
 * Date: 6/11/16
 * Time: 11:10 AM
 */

include('autoload.php');

$username = 'kemoy@gmail.com';
if($block->isBlock($username))
{

    $again = $block->youMayLoginAgainIn($username);

    if($again!==false && !$again instanceof stdClass)
    {
        echo "You may login again in:".$again;
    }
}
else
{
    echo "the user is not block. May continue other attempts";
}