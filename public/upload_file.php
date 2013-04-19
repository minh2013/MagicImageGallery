<a href="index.php">Back</a> <br><br>

<?php
    include ("library/image.php");

    $largeImageWidth = 800;
    $largeImageHeight = 600;
    $thumbnailWidth = 300;
    $thumbnailHeight = 275;
    $upload_max_filesize = ini_get('upload_max_filesize');
    
    $largeImagePath = "uploads/large/";
    $thumbnailPath = "uploads/thumbnail/";
    $imagePath = "uploads/original/";

    if (!file_exists($largeImagePath)) {
        mkdir($largeImagePath, 0777, true);
    }
    if (!file_exists($thumbnailPath)) {
        mkdir($thumbnailPath, 0777, true);
    }
    if (!file_exists($imagePath)) {
        mkdir($imagePath, 0777, true);
    }

    $arrayImageType = array("image/gif", "image/jpeg", "image/jpg", "image/png");
    
    if ($_FILES["file"]["error"] == 0) {
        $fileName = $_FILES["file"]["name"];
        $fileType = $_FILES["file"]["type"];
        $fileSize = $_FILES["file"]["size"];
        $fileTempPath = $_FILES["file"]["tmp_name"];
    }
    else if ($_FILES["file"]["error"] == 1 || $_FILES["file"]["error"] == 2){
        echo "Error: The uploaded file exceeds the upload max file size (". $upload_max_filesize ."). Please reduce the size of your file before uploading.";
        exit;
    }
    else if ($_FILES["file"]["error"] == 4) {
        echo "Error: No file was uploaded.";
        exit;
    }

    $pos = strrpos($fileName, ".");
    $extension = strtolower(substr($fileName, $pos));
    $fileNameWithoutExt = substr($fileName, 0, $pos);

    if(in_array($fileType, $arrayImageType))
    {
        if ($_FILES["file"]["error"] > 0) {
            echo "Error: There was an error uploading the file. Please try again!";
        } else {
            
            $newImageName =  $fileNameWithoutExt. "_" . mt_rand(0, time()) . $extension;
            $imageFullPath =  $imagePath . $newImageName;
            $larImageFullPath = $largeImagePath . $newImageName;
            $thumbnailImageFullPath = $thumbnailPath . $newImageName;

            if(move_uploaded_file($fileTempPath, $imageFullPath)) {
                echo "The file <strong>". $fileName . "</strong> has been uploaded successfully." . "<br>";
                echo "Type: " .  $fileType . "<br>";
                echo "Size: " . ($fileSize / 1024) . " kB<br><br>";
                echo "<img src='". $imageFullPath ."'/>";

                $image = new Image($imageFullPath);
                $image->resizeImage($largeImageWidth, $largeImageHeight, $larImageFullPath);
                $image->resizeImage($thumbnailWidth, $thumbnailHeight, $thumbnailImageFullPath);
            } else{
                echo "Error: There was an error uploading the file, please try again!";
            }
        }
    } else {
         echo "Error: This file is not an image. Please upload an image.";
    }
?>