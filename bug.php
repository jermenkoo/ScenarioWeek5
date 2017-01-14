<?php
// echo unserialize('O:9:"exception":1:{S:19:"\00Exception\00previous";r:1;}');
// echo "hello";
  function updateBug($text){
    $bug = getBug($id);
    if ($bug){
      $bug[] = $text;
      $txt = serialize($bug);
      setcookie("data", $txt, time() + 36000, "/bug.php");
    } else {
      $arr = [$text];
      $txt = serialize($arr);
      setcookie("data", $txt, time() + 36000, "/bug.php");
    }
  }
  function getBug(){
    if(isset($_COOKIE['data'])) {
      $arr = unserialize($_COOKIE['data']);
      echo $arr;
      return $arr;
    } else {
      return NULL;
    }
  }
  if (isset($_POST['note'])) {
      updateBug($_POST['note']);
      header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/bug.php');
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>bug</title>
  </head>
  <body>
    <form action="/bug.php" method="post">
      <input type="text" name="note" placeholder="Note">
      <input type="submit" value="submit">
      <?php
         $r = getBug();
         if ($r) {
           echo "<br>";
           foreach ($r as $key => $value) {
             echo $value;
             echo "<br>";
           }
         }
       ?>
    </form>
  </body>
</html>
