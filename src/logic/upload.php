<?php
include ($_SERVER['DOCUMENT_ROOT'] . "/src/view/header.php");

$target_dir = $_SERVER['DOCUMENT_ROOT'] . '/userID_' . $_SESSION['userID'] . '/';

if (!file_exists($target_dir)) {
  mkdir($target_dir);
}

$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if file already exists
if (file_exists($target_file)) {
    header('Location: ' . $URL . '/src/view/uploadFile.php?error=' . "Sorry, file already exists.");
    die();
}

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  header('Location: ' . $URL . '/src/view/uploadFile.php?error=' . "File is not an image!");
  die();
}

if ($_FILES["fileToUpload"]["size"] > 350000) {
    header('Location: ' . $URL . '/src/view/uploadFile.php?error=' . "File is too large!");
    die();
}

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    $fileurl = '/userID_' . $_SESSION['userID'] . "/" . basename($_FILES["fileToUpload"]["name"]);
    header('Location: ' . $URL . '/src/view/uploadFile.php?url=' . $fileurl);
} else {
  header('Location: ' . $URL . '/src/view/uploadFile.php?error=' . "Sorry, there was an error uploading your file.");
}
?>
