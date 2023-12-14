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

  // $dropDownVehicles = "<option>Choose a Car Classification</option>";
  // foreach ($cList as $item) {
  //   $dropDownVehicles .= '<option value="'.urlencode($item['classificationId']). '"';
  //   if (isset($classificationId)){     
  //     if ($item['classificationId'] == $classificationId) {
  //       $dropDownVehicles .= ' selected ';
  //     }
  //   }
  //   elseif(isset($invInfo['classificationId'])) {    
  //     if($item['classificationId'] === $invInfo['classificationId']) {
  //       $dropDownVehicles .= ' selected ';
  //     }
  //   }
  //   $dropDownVehicles .= '>'.urlencode($item['classificationName']).'</option>';
  // }
?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="/phpmotors/css/style.css" media="screen">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
	 echo "Delete $invInfo[invMake] $invInfo[invModel]";} 
	elseif(isset($invMake) && isset($invModel)) { 
		echo "Delete $invMake $invModel"; }?> | PHP Motors</title>
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
	    echo "Delete $invInfo[invMake] $invInfo[invModel]";} 
    elseif(isset($invMake) && isset($invModel)) { 
	    echo "Delete $invMake $invModel"; }?></h1>
      <?php
      if (isset($message)) {
        echo $message;
      }
      ?>
      <form action="/phpmotors/vehicles/index.php" method="POST" class='andale'>
        <label for='make'>Make:</label><br>
        <input type="text" name="invMake" readonly <?php if(isset($invMake)){echo "value='$invMake'";} elseif(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; } ?>id='make' required><br>

        <label for='model'>Model:</label><br>
        <input type="text" name="invModel" readonly <?php if(isset($invModel)){echo "value='$invModel'";} elseif(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; }?> id='model' required><br>
        
        <label for='desc'>Description:</label><br>
        <input type="text" name="invDescription" readonly <?php if(isset($invDescription)){echo "value='$invDescription'";} elseif(isset($invInfo['invDescription'])) {echo "value='$invInfo[invDescription]'";}?> id='desc' required><br>
        
        <input type="hidden" name="action" value='deleteVehicle'>
        
        <input type="hidden" name="invId" value="
        <?php if(isset($invInfo['invId'])){ echo $invInfo['invId'];} 
        elseif(isset($invId)){ echo $invId; } ?>
        "><br>
        
        <input type="submit" name="submit" value="Delete Vehicle">
      </form>
    </main>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
    </footer>
  </div>
</body>

</html>