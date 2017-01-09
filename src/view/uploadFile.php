<html>
    <head>
        <link rel="stylesheet" href="../styles/style.css">
    </head>
    <body>
        <?php
        include 'header.php';
        ?>


        <form action="../logic/upload.php" method="post" enctype="multipart/form-data">
            Select file to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload file" name="submit">
        </form>
    </body>
</html>
