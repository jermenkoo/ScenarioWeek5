<?php
  error_reporting(0);

  $dbhost = 'localhost';
  $dbuser = 'root';
  $dbpass = 't*_41sRwJw-jvHR';
  foreach ($_SERVER as $key => $value) {
    if (strpos($key, "MYSQLCONNSTR_localdb") !== 0) {
        continue;
    }
    $dbhost = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
    $dbuser = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
    $dbpass = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
  }

  try {
    // Connect to MySQL
    $conn = new PDO('mysql:host=' . $dbhost . ';charset=utf8', $dbuser, $dbpass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo 'Connected successfully';

    // Create db
    $conn->exec('DROP DATABASE IF EXISTS test_db');
    $conn->exec("CREATE Database test_db");

    echo "Database test_db created successfully\n";

    // Connect to db
    $conn = new PDO('mysql:host=' . $dbhost .  ';dbname=test_db;charset=utf8', $dbuser, $dbpass);

    echo "connection created";

    $conn->exec("CREATE TABLE user(
      id INT NOT NULL AUTO_INCREMENT,
      username VARCHAR(20) NOT NULL UNIQUE,
      password  VARCHAR(300) NOT NULL,
      colour   VARCHAR(100),
      icon    VARCHAR(10000) DEFAULT 'https://openclipart.org/download/247319/abstract-user-flat-3.svg',
      homepage   VARCHAR(100),
      isAdmin   BOOL NOT NULL,
      canPost   BOOL NOT NULL DEFAULT 1,
      privSnippet VARCHAR(10000),
      UNIQUE (username),
      primary key ( id ))");
    // $tableSnippet = 'CREATE TABLE snippet( '.
    //   'id INT NOT NULL AUTO_INCREMENT, '.
    //   'snippet  VARCHAR(10000) NOT NULL, '.
    //   'createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP, '.
    //   'userId   INT NOT NULL, '.
    //   'FOREIGN KEY fkUser(userId) '.
    //   'REFERENCES user(id) '.
    //   'ON UPDATE CASCADE '.
    //   'ON DELETE RESTRICT, '.
    //   'primary key ( id ))';
    // mysql_select_db('test_db');
    // $retval = mysql_query( $tableSnippet, $conn );

    $retval = $conn->prepare('CREATE TABLE snippet( '.
      'id INT NOT NULL AUTO_INCREMENT, '.
      'snippet  VARCHAR(10000) NOT NULL, '.
      'createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP, '.
      'userId   INT NOT NULL, '.
      'FOREIGN KEY fkUser(userId) '.
      'REFERENCES user(id) '.
      'ON UPDATE CASCADE '.
      'ON DELETE RESTRICT, '.
      'primary key ( id ))');
    $retval->execute();


    // $tableFile = 'CREATE TABLE file( '.
    //   'id INT NOT NULL AUTO_INCREMENT, '.
    //   'fileName  VARCHAR(10000) NOT NULL, '.
    //   'createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP, '.
    //   'userId   INT NOT NULL, '.
    //   'FOREIGN KEY fkUser(userId) '.
    //   'REFERENCES user(id) '.
    //   'ON UPDATE CASCADE '.
    //   'ON DELETE RESTRICT, '.
    //   'primary key ( id ))';
    // mysql_select_db('test_db');
    // $retval = mysql_query( $tableFile, $conn );

    $retval = $conn->prepare('CREATE TABLE file( '.
      'id INT NOT NULL AUTO_INCREMENT, '.
      'fileName  VARCHAR(10000) NOT NULL, '.
      'createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP, '.
      'userId   INT NOT NULL, '.
      'FOREIGN KEY fkUser(userId) '.
      'REFERENCES user(id) '.
      'ON UPDATE CASCADE '.
      'ON DELETE RESTRICT, '.
      'primary key ( id ))');
    $retval->execute();

    $retval = $conn->prepare('CREATE TABLE `login_attempts` (
      `username` varchar(50) NOT NULL,
      `ip_address` varchar(50) NOT NULL,
      `time` datetime NOT NULL,
      `attempts` INT NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');
    $retval->execute();

  } catch (PDOException $e) {
    echo 'Error' . $e->getMessage();
    die("DB ERROR: ". $e->getMessage());
  }

  include 'db.php';

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
