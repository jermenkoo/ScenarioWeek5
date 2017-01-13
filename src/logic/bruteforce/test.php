<?php
///**
// * Created by PhpStorm.
// * User: yomek
// * Date: 6/9/16
// * Time: 3:53 PM
// */
//
//
//namespace BlockBruteForce
//{
//    require_once('BlockBruteForce.php');
//    include_once('config.php');
//
//    //print_r($config);
//
//    $block = new BlockBruteForce($config);
//    $status = $block->connect();
//    //check if connected was successful
//    if($status===true)
//    {
//        //loading the dependency database and table
//        if($block->loadDependencyDatabase()===false)
//        {
//            echo "There was an issue loading the dependencies";
//            exit;
//        }
//    }
//    else
//    {
//        echo 'We were not able to connect to the database';
//        exit;
//    }
//
//    //testing register failure
//    $username = 'kemoy@gmail.com';
//    //$block->registerFailedLogin($username);
//   // $res = $block->getLastLoginAttempt($username);
////    if(!$res instanceof \stdClass)
////    {
////        print_r($res);
////    }
//
////    $res = $block->isBlock($username);
////
////    if($res===true)
////    {
////        echo "The user is blocked";
////    }
////
////    else if($res===false)
////    {
////        echo "the usr is not block";
////    }
//
//    //$block->updateAttempts($username);
//
//    //$block->outputDebut(true);
//
//}