<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="/phpmotors/css/style.css" media="screen">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Image Management | PHP Motors</title>
</head>

<body>
  <?php if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
  } ?>
  <div id="wrapper">
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    </header>
    <nav>
      <?php echo $navList ?>
    </nav>
    <main>
      <h1 class="andale">Image Management</h1>
      <p>Welcome to the Image Management Page, please select one of the options below</p>
      <h2>Add New Vehicle Image</h2>
      <?php
      if (isset($message)) {
        echo $message;
      } ?>

      <form action="/phpmotors/uploads/" method="post" class=andale enctype="multipart/form-data">
        <label for="invItem">Vehicle</label><br>
        <?php echo $prodSelect; ?>
        <fieldset>
          <label>Is this the main image for the vehicle?</label><br>
          <label for="priYes" class="pImage">Yes</label>
          <input type="radio" name="imgPrimary" id="priYes" class="pImage" value="1">
          <label for="priNo" class="pImage">No</label>
          <input type="radio" name="imgPrimary" id="priNo" class="pImage" checked value="0">
        </fieldset>
        <label>Upload Image:</label><br>
        <input type="file" name="file1">
        <input type="submit" class="regbtn" value="Upload">
        <input type="hidden" name="action" value="upload">
      </form>
      <hr>
      <div class=listBlack>
      <h2 class=andale>Existing Images</h2>
      <p class=andale>If deleting an image, delete the thumbnail too and vice versa.</p>
      <?php
      if (isset($imageDisplay)) {
        echo $imageDisplay;
      } ?>
      </div>
    </main>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
    </footer>
  </div>
</body>

</html>
<?php unset($_SESSION['message']); ?>