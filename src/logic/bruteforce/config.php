<?php
/**
 * Created by PhpStorm.
 * @author: Kemoy Campbell
 * Date: 5/20/16
 * Time: 12:49 PM
 * @version 1.5
 */

namespace BlockBruteForce
{
	/*----------------------------------------------------------
    THIS IS THE CONFIGURATION OF THE DATABASE
    SET UP THE VARIABLE ACCORDING TO YOUR DATABASE CONFIGURATION
*/

	//change those to your database configuration
	$dbname='test_db'; //replace with your database name or we will create 'brute_force_login_attempts' database for you
	$dbusername='root';//database username
	$dbpassword='t*_41sRwJw-jvHR';//database password
	$host ='localhost';//database host

	foreach ($_SERVER as $key => $value) {
    if (strpos($key, "MYSQLCONNSTR_localdb") !== 0) {
        continue;
    }
    $host = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
    $dbusername = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
    $dbpassword = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
  }

	//configuration for development environment
	$maxAttempt = 4;
	$blockTime = 10; //block for 10 minutes
	$sandbox = true;
	$debugEnable = true;



	//STOP! DO NOT MODIFY THOSE LINES BELOW
	$config = array('dbname'=>$dbname,'dbusername'=>$dbusername,'dbpassword'=>$dbpassword,'host'=>$host);
	$dev  = array('sandbox'=>$sandbox,'maxAttempt'=>$maxAttempt,'blockTime'=>$blockTime,'debugEnable'=>$debugEnable);
}
