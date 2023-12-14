<?php 
//if they are logged in and have above level 1, allow otherwise do not allow 
  $loggedIn = isset($_SESSION['loggedin']);
  if ($loggedIn) {
      $_SESSION['clientData']['clientLevel'] > 1 ? $level23 = 1 : $level23 = 0;
  }
  if (!($loggedIn && $level23)) {
    header("Location: /phpmotors/index.php");
    exit;
  } 

  $dropDownVehicles = "";
  foreach ($cList as $item) {
    $dropDownVehicles .= '<option value="'.urlencode($item['classificationId']). '"';
    if (isset($classificationId)){
      if ($item['classificationId'] == $classificationId) {
        $dropDownVehicles .= ' selected ';
      }
    }
    $dropDownVehicles .= '>'.urlencode($item['classificationName']).'</option>';
  } 
?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="/phpmotors/css/style.css" media="screen">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Vehicle | PHP Motors</title>
</head>

<body>
  <div id="wrapper">
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    </header>
    <nav>
      <?php echo $navList ?>
    </nav>
    <main class='center'>
      <h1 class="andale">Add a Vehicle</h1>
      <!-- The view must have the means of displaying messages returned to it from the controller. -->
      <!-- If the new vehicle is added successfully, a message to that effect must be displayed in the "add new vehicle" view. -->
      <?php
      if (isset($message)) {
        echo $message;
      }
      ?>
      <!-- Contain a form for adding a new vehicle to the inventory table. ( *Hint: Check the inventory table in the phpmotors database for the fields that will be needed in the form. **DO NOT** have a form field for the invId field as it is the primary key and is auto-incrementing in the database table*). -->
      <!-- When indicating the classification the vehicle belongs to, the classification must use the "select" element's drop-down list that should have been pre-built in the controller. -->
      <form action="/phpmotors/vehicles/index.php" method="POST" class='andale'>
        <label for='vehicles'>Classification:</label><br>
        <select id="vehicles" name="classificationId">
        <?php 
          echo $dropDownVehicles; 
        ?>
        </select><br>
        <label for='make'>Make:</label><br>
        <span>(Up to 30 characters)</span><br>
        <input type="text" name="invMake" maxlength="30" <?php if(isset($invMake)){echo "value='$invMake'";} ?>id='make' required><br>
        <label for='model'>Model:</label><br>
        <span>(Up to 30 characters)</span><br>
        <input type="text" name="invModel" maxlength="30" <?php if(isset($invModel)){echo "value='$invModel'";} ?> id='model' required><br>
        <label for='desc'>Description:</label><br>
        <input type="text" name="invDescription" <?php if(isset($invDescription)){echo "value='$invDescription'";} ?> id='desc' required><br>
        <!-- When adding images use the path to the "No Image Available" image that you downloaded and stored in this enhancement. (Hint: this could be hard coded into the form to happen automatically for now) -->
        <label for='imgpath'>Image Path:</label><br>
        <span>(Up to 50 characters)</span><br>
        <input type="text" name="invImage" value='/phpmotors/images/vehicles/no-image.png' maxlength="50" <?php if(isset($invImage)){echo "value='$invImage'";} ?> id='imgpath' required><br>
        <label for='thumbpath'>Thumbnail Path:</label><br>
        <span>(Up to 50 characters)</span><br>
        <input type="text" name="invThumbnail" value='/phpmotors/images/vehicles/no-image-tn.png' maxlength="50" <?php if(isset($invThumbnail)){echo "value='$invThumbnail'";} ?> id='thumbpath' required><br>
        <label for='price'>Price:</label><br>
        <span>(Up to 10 characters)</span><br>
        <input type="number" name="invPrice" maxlength="10" <?php if(isset($invPrice)){echo "value='$invPrice'";} ?> id='price' required><br>
        <label for='quantity'>Quantity in stock:</label><br>
        <span>(Up to 6 characters)</span><br>
        <input type="number" name="invStock" maxlength="6" <?php if(isset($invStock)){echo "value='$invStock'";} ?> id='quantity' required><br>
        <label for='color'>Color:</label><br>
        <span>(Up to 20 characters)</span><br>
        <input type="text" name="invColor" maxlength="20" <?php if(isset($invColor)){echo "value='$invColor'";} ?> id='color' required><br>
        <!-- The form must send all data to the vehicles controller for checking and insertion to the database. -->
        <input type="hidden" name="action" value='addVehicle'>
        <br>
        <input type="submit" value="Submit!">
      </form>
    </main>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
    </footer>
  </div>
</body>

</html>