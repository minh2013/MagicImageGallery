<?php include('tpl/header.php'); ?>

<!-- Primary Page Layout
================================================== -->

<!-- Delete everything in this .container and get started on your own site! -->

<div class="container content">
	<div class="sixteen columns">
        <h2>Upload an image</h2>
        <form action="upload_file.php" method="post" enctype="multipart/form-data" class="upload-image">
            <label for="file">Filename:</label>
            <input type="file" name="file" id="file"><br>
            <input type="submit" name="submit" value="Submit">
        </form>

    </div>
</div><!-- container -->

<!-- Footer -->
<?php include('tpl/footer.php'); ?>
