<?php
$target_dir = "/vagrant/" . $_COOKIE['id'] . "/";
if (!file_exists($target_dir)) {
  mkdir($target_dir);
}
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

// Check if file already exists
if (file_exists($target_file)) {
    header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] .
    '/src/view/uploadFile.php?error=' . "Sorry, file already exists.");
    $uploadOk = 0;
}

$q = getimagesize($_FILES["fileToUpload"]["name"]);
if (empty($q)) {
  header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] .
  '/src/view/uploadFile.php?error=' . "Bad file type.");
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $url = $_COOKIE['id'] . "/" . basename($_FILES["fileToUpload"]["name"]);
        header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] .
        '/src/view/uploadFile.php?url=' . $url);
    } else {
      header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] .
      '/src/view/uploadFile.php?error=' . "Sorry, there was an error uploading your file.");
    }
}
?>
