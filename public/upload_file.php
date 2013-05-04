<?php
    include ("library/upload.php");
    echo '<a href="index.php">Back</a> <br><br>';

    $upload = new Upload($_FILES);
    $upload->uploadFile();
   