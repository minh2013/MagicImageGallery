<?php
class ListImages {
	public function showImages($largeImagePath, $thumbnailPath) {
        $thumbnailPath = "uploads/thumbnail/";
        $largeImagePath = "uploads/large/";
        if (!file_exists($largeImagePath) || !file_exists($largeImagePath) ) {
            exit;
        }
        $arrayImages = scandir($thumbnailPath);
        
        if(sizeof($arrayImages) == 0)
            exit;
        $count = 0;
        echo '<div class="row">';
        foreach ($arrayImages as $key => $value)
        {
            if($key != 0 && $key != 1) {
                $count ++;
                echo '  <div class="one-third column">
                            <a href="' . $largeImagePath . '/' . $value . '" target="_blank"><img src="' . $thumbnailPath . '/' . $value . '"></a>
                        </div>';
                if($count % 3 == 0) {
                    echo '</div>';
                    echo '<div class="row">';
                }
            }
        }
        echo '</div>';
    }
}