<a href="index.php">Back</a> <br><br>
<?php
    $arrayImageType = array("image/gif", "image/jpeg", "image/jpg", "image/png");
    $fileName = $_FILES["file"]["name"];
    $fileType = $_FILES["file"]["type"];
    $fileSize = $_FILES["file"]["size"];
    $fileTempPath = $_FILES["file"]["tmp_name"];
    $imagePath = "uploads/";

    $pos = strrpos($fileName, ".");
    $extension = substr($fileName, $pos);
    $fileNameWithoutExt = substr($fileName, 0, $pos);

    if(in_array($fileType, $arrayImageType))
    {
        if ($_FILES["file"]["error"] > 0) {
            echo "Error: There was an error uploading the file, please try again!";
        } else {
            
            $newFileName =  $fileNameWithoutExt. "_" .time() . $extension;
            $destination =  $imagePath . $newFileName;
            if(move_uploaded_file($fileTempPath, $destination)) {
                echo "The file ". $fileName . " has been uploaded successfully." . "<br>";
                echo "Type: " .  $fileType . "<br>";
                echo "Size: " . ($fileSize / 1024) . " kB<br><br>";
                echo "<img src='". $destination ."'/>";
            } else{
                echo "Error: There was an error uploading the file, please try again!";
            }
        }
    } else {
         echo "Error: This file is not an image. Please upload an image.";
    }
?>
    
