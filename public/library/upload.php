<?php
include ("configuration.php");
include ("library/image.php");
class Upload {
    
    private $largeImageWidth = LARGE_IMAGE_WIDTH;
    private $largeImageHeight = LARGE_IMAGE_HEIGHT;
    private $thumbnailWidth = THUMBNAIL_WIDTH;
    private $thumbnailHeight = THUMBNAIL_HEIGHT;
    private $uploadMaxFileSize = UPLOAD_MAX_FILE_SIZE;
    private $largeImagePath = LARGE_IMAGE_PATH;
    private $thumbnailPath = THUMBNAIL_IMAGE_PATH;
    private $imagePath = ORIGINAL_IMAGE_PATH;
    private $files;

    public function __construct($fileInfo) {
        $this->files = $fileInfo;

    }

    private function checkFlolderExistence() {
        if (!file_exists($this->largeImagePath)) {
            mkdir($this->largeImagePath, 0777, true);
        }
        if (!file_exists($this->thumbnailPath)) {
            mkdir($this->thumbnailPath, 0777, true);
        }
        if (!file_exists($this->imagePath)) {
            mkdir($this->imagePath, 0777, true);
        }
    }
    
    private function checkUploadingFile() {
        if ($this->files["file"]["error"] == 0) {
            return true;
        }
        else if ($this->files["file"]["error"] == 1 || $this->files["file"]["error"] == 2){
            echo "Error: The uploaded file exceeds the upload max file size (". $this->uploadMaxFileSize ."). Please reduce the size of your file before uploading.";
            exit;
        }
        else if ($this->files["file"]["error"] == 4) {
            echo "Error: No file was uploaded.";
            exit;
        }
        else {
            echo "Error: There was an error uploading the file. Please try again!";
            exit;
        }
        return true;
    }
    private function displayImageInfo($fileName, $fileType, $fileSize, $imageFullPath) {
        echo "The file <strong>". $fileName . "</strong> has been uploaded successfully." . "<br>";
        echo "Type: " .  $fileType . "<br>";
        echo "Size: " . ($fileSize / 1024) . " kB<br><br>";
        echo "<img style='width: 100%' src='". $imageFullPath ."'/>";

    }

    public function uploadFile() {
        $this->checkFlolderExistence();

        if ($this->checkUploadingFile()) {
            $fileName = $this->files["file"]["name"];
            $fileType = $this->files["file"]["type"];
            $fileSize = $this->files["file"]["size"];
            $fileTempPath = $this->files["file"]["tmp_name"];
        }

        $pos = strrpos($fileName, ".");
        $extension = strtolower(substr($fileName, $pos));
        $fileNameWithoutExt = substr($fileName, 0, $pos);
        $arrayImageType = array("image/gif", "image/jpeg", "image/jpg", "image/png");

        if(in_array($fileType, $arrayImageType))
        {
            if ($this->files["file"]["error"] > 0) {
                echo "Error: There was an error uploading the file. Please try again!";
            } else {
                
                $newImageName =  $fileNameWithoutExt. "_" . mt_rand(0, time()) . $extension;
                $imageFullPath =  $this->imagePath . $newImageName;
                $larImageFullPath = $this->largeImagePath . $newImageName;
                $thumbnailImageFullPath = $this->thumbnailPath . $newImageName;

                if(move_uploaded_file($fileTempPath, $imageFullPath)) {
                    $this->displayImageInfo($fileName, $fileType, $fileSize, $imageFullPath);

                    $image = new Image($imageFullPath);
                    $image->resizeImage($this->largeImageWidth, $this->largeImageHeight, $larImageFullPath);
                    $image->resizeImage($this->thumbnailWidth, $this->thumbnailHeight, $thumbnailImageFullPath);
                } else{
                    echo "Error: There was an error uploading the file, please try again!";
                }
            }
        } else {
             echo "Error: This file is not an image. Please upload an image.";
        }
    }
}