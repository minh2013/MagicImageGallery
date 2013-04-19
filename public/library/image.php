<?php
Class Image
{
    // *** Class variables
    private $image;
    private $width;
    private $height;
    private $extension;
    private $imageResized;

    public function __construct($imageName) {
        $this->image = $this->openImage($imageName);
        $size = getimagesize($imageName);
        $this->width  = $size[0];
        $this->height = $size[1];
    }

    private function openImage($imageName) {
        $this->extension = strtolower(strrchr($imageName, '.'));
        switch($this->extension)
        {
            case '.jpg':
            case '.jpeg':
                $img = imagecreatefromjpeg($imageName);
                break;
            case '.gif':
                $img = imagecreatefromgif($imageName);
                break;
            case '.png':
                $img = imagecreatefrompng($imageName);
                break;
            default:
                $img = false;
                break;
        }
        return $img;
    }

    public function resizeImage($newWidth, $newHeight, $destination) {
        $arrayOfDimensions = $this->getOptimalSize($newWidth, $newHeight);
        $optimalWidth  = $arrayOfDimensions[0];
        $optimalHeight = $arrayOfDimensions[1];

        // Resize the image to the optimal size
        $this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight);
        imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $optimalWidth, $optimalHeight, $this->width, $this->height);
        
        // Crop the image to the desired size
        $this->crop($optimalWidth, $optimalHeight, $newWidth, $newHeight);
        
        // Save the image
        $this->saveImage($destination);
    }

    private function getOptimalSize($newWidth, $newHeight) {
    	$widthRatio  = $this->width /  $newWidth;
        $heightRatio = $this->height / $newHeight;
      
        if ($widthRatio < $heightRatio) {
            $ratio = $widthRatio;
        } else {
            $ratio = $heightRatio;
        }

        $optimalHeight = $this->height / $ratio;
        $optimalWidth  = $this->width  / $ratio;
        return array($optimalWidth, $optimalHeight);
    }

    private function crop($optimalWidth, $optimalHeight, $newWidth, $newHeight) {
        $cropStartAtX = ( $optimalWidth / 2) - ( $newWidth /2 );
        $cropStartAtY = ( $optimalHeight/ 2) - ( $newHeight/2 );

        $ImageCropped = $this->imageResized;
        $this->imageResized = imagecreatetruecolor($newWidth , $newHeight);
        imagecopyresampled($this->imageResized, $ImageCropped , 0, 0, $cropStartAtX, $cropStartAtY, $newWidth, $newHeight , $newWidth, $newHeight);
    }

    private function saveImage($destination) {
        switch($this->extension)
        {
            case '.jpg':
            case '.jpeg':
                if (imagetypes() & IMG_JPG) {
                    imagejpeg($this->imageResized, $destination, 100);
                }
                break;

            case '.gif':
                if (imagetypes() & IMG_GIF) {
                    imagegif($this->imageResized, $destination);
                }
                break;

            case '.png':
                if (imagetypes() & IMG_PNG) {
                     imagepng($this->imageResized, $destination, 0);
                }
                break;
            default:
                break;
        }
        imagedestroy($this->imageResized);
    }
}