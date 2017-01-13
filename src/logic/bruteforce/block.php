<?php
/**
 * Created by PhpStorm.
 * @author Kemoy Campbell
 * Date: 6/9/16
 * Time: 3:53 PM
 * @version 1.5
 */


namespace BlockBruteForce
{
    require_once('BlockBruteForce.php');
    include_once('config.php');

    $block = new BlockBruteForce($config);

    //enable the debug output status
    //$block->setEnableDebug($dev['debugEnable']);

    //attempt to connect
    $block->connect();

    //load the dependency database and table
    $block->loadDependencyDatabase();

    //notify system we are developing on localhost or production
    $block->setSandbox($dev['sandbox']);

    //set the max attempt and max block time
    $block->setBlockAttempts($dev['maxAttempt']);
    $block->setBlockTime($dev['blockTime']);
}
