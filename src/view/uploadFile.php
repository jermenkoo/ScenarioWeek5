<html>
    <head>
        <link rel="stylesheet" href="./styles/style.css">
    </head>
    <body>

    <?php
    include 'header.php';
    ?>


    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select file to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
    </form>



    </body>
</html>
