<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  include 'db.php';

  echo 'Connected successfully';

  $sql = 'CREATE Database test_db';
  $retval = mysql_query( $sql, $conn );
  if(! $retval ) {
    die('Could not create database: ' . mysql_error());
  }

  echo "Database test_db created successfully\n";

  $sql = 'CREATE TABLE user( '.
    'id INT NOT NULL AUTO_INCREMENT, '.
    'username VARCHAR(20) NOT NULL, '.
    'password  VARCHAR(30) NOT NULL, '.
    'color   VARCHAR(100), '.
    'icon    VARCHAR(100), '.
    'homepage   VARCHAR(100), '.
    'isAdmin   BOOL NOT NULL, '.
    'primary key ( id ))';
  mysql_select_db('test_db');
  $retvalCreate = mysql_query( $sql, $conn );

  if(! $retvalCreate ) {
    die('Could not create table: ' . mysql_error());
  }

  echo "Table user created successfully\n";
  createUser("marco", "123");
  createUser("jaro", "123");

  mysql_close($conn);
?>
