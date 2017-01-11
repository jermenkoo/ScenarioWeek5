<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  include 'db.php';

  echo 'Connected successfully';
  mysql_query('DROP DATABASE IF EXISTS test_db') or die(mysql_error());
  $sql = 'CREATE Database test_db';
  $retval = mysql_query( $sql, $conn );
  if(! $retval ) {
    die('Could not create database: ' . mysql_error());
  }

  echo "Database test_db created successfully\n";

  $tableUser = 'CREATE TABLE user( '.
    'id INT NOT NULL AUTO_INCREMENT, '.
    'username VARCHAR(20) NOT NULL UNIQUE, '.
    'password  VARCHAR(30) NOT NULL, '.
    'colour   VARCHAR(100), '.
    'icon    VARCHAR(10000) DEFAULT "https://openclipart.org/download/247319/abstract-user-flat-3.svg", '.
    'homepage   VARCHAR(100), '.
    'isAdmin   BOOL NOT NULL, '.
    'privSnippet VARCHAR(10000),'.
    'UNIQUE (username), '.
    'primary key ( id ))';
  mysql_select_db('test_db');
  $retval = mysql_query( $tableUser, $conn );

  if(! $retval ) {
    die('Could not create table: ' . mysql_error());
  }

  $tableSnippet = 'CREATE TABLE snippet( '.
    'id INT NOT NULL AUTO_INCREMENT, '.
    'snippet  VARCHAR(10000) NOT NULL, '.
    'createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP, '.
    'userId   INT NOT NULL, '.
    'FOREIGN KEY fkUser(userId) '.
    'REFERENCES user(id) '.
    'ON UPDATE CASCADE '.
    'ON DELETE RESTRICT, '.
    'primary key ( id ))';
  mysql_select_db('test_db');
  $retval = mysql_query( $tableSnippet, $conn );

  if(! $retval ) {
    die('Could not create table: ' . mysql_error());
  }

  $tableFile = 'CREATE TABLE file( '.
    'id INT NOT NULL AUTO_INCREMENT, '.
    'fileName  VARCHAR(10000) NOT NULL, '.
    'createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP, '.
    'userId   INT NOT NULL, '.
    'FOREIGN KEY fkUser(userId) '.
    'REFERENCES user(id) '.
    'ON UPDATE CASCADE '.
    'ON DELETE RESTRICT, '.
    'primary key ( id ))';
  mysql_select_db('test_db');
  $retval = mysql_query( $tableFile, $conn );

  if(! $retval ) {
    die('Could not create table: ' . mysql_error());
  }

  echo "Tables user, snippet, file created successfully\n";
  createUser("marco", "123");
  createUser("jaro", "123");
  createUser("marti", "123");
  createUser("janos", "123");
  createSnippet("hello world", 1);
  createSnippet("how are you?", 1);
  createSnippet("good", 2);
  createSnippet("totally", 3);
  createSnippet("WOW", 4);

  mysql_close($conn);
?>
