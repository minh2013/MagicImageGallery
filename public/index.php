<?php include('tpl/header.php'); ?>
<?php include ("library/image.php"); ?>

<div class="container content">
    <div class="sixteen columns">
        <h2>Upload an image</h2>
        <form action="upload_file.php" method="post" enctype="multipart/form-data" class="upload-image">
            <label for="file">Filename:</label>
            <input type="file" name="file" id="file"><br>
            <input type="submit" name="submit" value="Submit">
        </form>
    </div>
    <div class="sixteen columns">
        <h2 style="margin-top: 30px;">List of images</h2>
    </div>
    <?php 
        $listImages = new ListImages();
        $listImages->showImages("uploads/large/", "uploads/thumbnail/");
    ?>
</div>
<?php include('tpl/footer.php'); ?>
