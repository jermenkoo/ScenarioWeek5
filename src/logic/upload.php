<?php
include ($_SERVER['DOCUMENT_ROOT'] . "/src/view/header.php");

$target_dir = $_SERVER['DOCUMENT_ROOT'] . '/userID_' . $_SESSION['userID'] . '/';

if (!file_exists($target_dir)) {
  mkdir($target_dir);
}

$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;

// Check if file already exists
if (file_exists($target_file)) {
    header('Location: ' . $URL . '/src/view/uploadFile.php?error=' . "Sorry, file already exists.");
    $uploadOk = 0;
}

if ($_FILES["fileToUpload"]["type"] != "image/jpeg") {
    header('Location: ' . $URL . '/src/view/uploadFile.php?error=' . "File is not an image!");
    $uploadOk = 0;
}

if ( ($_FILES["fileToUpload"]["size"] > 350000) || ($_FILES["fileToUpload"]["size"] < 10000) ) {
    header('Location: ' . $URL . '/src/view/uploadFile.php?error=' . "File is too small or too large!");
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $fileurl = '/userID_' . $_SESSION['userID'] . "/" . basename($_FILES["fileToUpload"]["name"]);
        header('Location: ' . $URL . '/src/view/uploadFile.php?url=' . $fileurl);
    } else {
      header('Location: ' . $URL . '/src/view/uploadFile.php?error=' . "Sorry, there was an error uploading your file.");
    }
}
?>
