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

  $dropDownVehicles = "<option>Choose a Car Classification</option>";
  foreach ($cList as $item) {
    $dropDownVehicles .= '<option value="'.urlencode($item['classificationId']). '"';
    if (isset($classificationId)){     
      if ($item['classificationId'] == $classificationId) {
        $dropDownVehicles .= ' selected ';
      }
    }
    elseif(isset($invInfo['classificationId'])) {    
      if($item['classificationId'] === $invInfo['classificationId']) {
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
  <title><?php if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
	 echo "Modify $invInfo[invMake] $invInfo[invModel]";} 
	elseif(isset($invMake) && isset($invModel)) { 
		echo "Modify $invMake $invModel"; }?> | PHP Motors</title>
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
    <h1 class='andale'>
    <?php
    if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
	    echo "Modify $invInfo[invMake] $invInfo[invModel]";} 
    elseif(isset($invMake) && isset($invModel)) { 
	    echo "Modify $invMake $invModel"; }?></h1>
      <?php
      if (isset($message)) {
        echo $message;
      }
      ?>
      <form action="/phpmotors/vehicles/index.php" method="POST" class='andale'>
        <label for='vehicles'>Classification:</label><br>
        <select id="vehicles" name="classificationId">
        <?php 
          echo $dropDownVehicles; 
        ?>
        </select><br>
        <label for='make'>Make:</label><br>
        <span>(Up to 30 characters)</span><br>
        <input type="text" name="invMake" maxlength="30" <?php if(isset($invMake)){echo "value='$invMake'";} elseif(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; } ?>id='make' required><br>
        
        <label for='model'>Model:</label><br>
        <span>(Up to 30 characters)</span><br>
        <input type="text" name="invModel" maxlength="30" <?php if(isset($invModel)){echo "value='$invModel'";} elseif(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; }?> id='model' required><br>
        
        <label for='desc'>Description:</label><br>
        <input type="text" name="invDescription" <?php if(isset($invDescription)){echo "value='$invDescription'";} elseif(isset($invInfo['invDescription'])) {echo "value='$invInfo[invDescription]'";}?> id='desc' required><br>
        
        <label for='imgpath'>Image Path:</label><br>
        <span>(Up to 50 characters)</span><br>
        <input type="text" name="invImage" value='/phpmotors/no-image.png' maxlength="50" <?php if(isset($invImage)){echo "value='$invImage'";} elseif(isset($invInfo['invImage'])) {echo "value='$invInfo[invImage]'";} ?> id='imgpath' required><br>
        
        <label for='thumbpath'>Thumbnail Path:</label><br>
        <span>(Up to 50 characters)</span><br>
        <input type="text" name="invThumbnail" value='/phpmotors/no-image.png' maxlength="50" <?php if(isset($invThumbnail)){echo "value='$invThumbnail'";} elseif(isset($invInfo['invThumbnail'])) {echo "value='$invInfo[invThumbnail]'";}  ?> id='thumbpath' required><br>
        
        <label for='price'>Price:</label><br>
        <span>(Up to 10 characters)</span><br>
        <input type="number" name="invPrice" maxlength="10" <?php if(isset($invPrice)){echo "value='$invPrice'";} elseif(isset($invInfo['invPrice'])) {echo "value='$invInfo[invPrice]'";}  ?> id='price' required><br>
        
        <label for='quantity'>Quantity in stock:</label><br>
        <span>(Up to 6 characters)</span><br>
        <input type="number" name="invStock" maxlength="6" <?php if(isset($invStock)){echo "value='$invStock'";} elseif(isset($invInfo['invStock'])) {echo "value='$invInfo[invStock]'";} ?> id='quantity' required><br>
        
        <label for='color'>Color:</label><br>
        <span>(Up to 20 characters)</span><br>
        <input type="text" name="invColor" maxlength="20" <?php if(isset($invColor)){echo "value='$invColor'";} elseif(isset($invInfo['invColor'])) {echo "value='$invInfo[invColor]'";}?> id='color' required><br>
        <!-- The form must send all data to the vehicles controller for checking and insertion to the database. -->
        <input type="hidden" name="action" value='updateVehicle'>
        <input type="hidden" name="invId" value="
        <?php if(isset($invInfo['invId'])){ echo $invInfo['invId'];} 
        elseif(isset($invId)){ echo $invId; } ?>">
        <br>
        <input type="submit" name="submit" value="Update Vehicle">
      </form>
    </main>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
    </footer>
  </div>
</body>

</html>