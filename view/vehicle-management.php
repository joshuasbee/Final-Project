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
  //change the message
  if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
  }
?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="/phpmotors/css/style.css" media="screen">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Vehicle Management | PHP Motors</title>
</head>

<body>
  <div id="wrapper">
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    </header>
    <nav>
      <?php echo $navList; ?>
    </nav>
    <main class="center">
      <h1 class="andale">Vehicle Management</h1>
      <!-- TWO links -->
      <!-- 1. One to the controller that will trigger the delivery of the add classification view. -->
      <form action='/phpmotors/vehicles/index.php' method='POST' class='center'>
        <input type='submit' value='Add Classification'>
        <input type="hidden" name="action" value="addClassificationPage">
      </form><br>
      <!-- 2. One to the controller that will trigger the delivery of the add vehicle view. -->
      <form action='/phpmotors/vehicles/index.php' method='POST' class='center'>
        <input type='submit' value='Add Vehicle'>
        <input type="hidden" name="action" value="addVehiclePage">
      </form><br>
      <?php
        if (isset($message)) { 
        echo $message; 
        } 
        if (isset($classificationList)) { 
        echo '<h2 class="andale">Vehicles By Classification</h2>'; 
        echo '<p class="andale">Choose a classification to see those vehicles</p>'; 
        echo $classificationList; 
        }
      ?>
      <noscript>
      <p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
      </noscript>
      <table id="inventoryDisplay"></table>
      <script src="../js/inventory.js"></script>
    </main>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
    </footer>
  </div>
</body>
</html>
<?php unset($_SESSION['message']); ?>