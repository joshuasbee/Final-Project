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
?><!DOCTYPE html>
<html lang="en">
 
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="/phpmotors/css/style.css" media="screen">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add a Classification | PHP Motors</title>
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
      <h1 class="andale">Add a classification</h1>
      <?php
      //The view must have the means of displaying messages returned to it from the controller.
      if (isset($message)) {
        echo $message;
      }
      ?>
      <!-- Contain a form for adding a new classification (you will only need to add the name, the id in the table is auto-incrementing). -->
      <!-- The form must send all data to the vehicles controller for checking and insertion to the database. -->
      <form action='/phpmotors/vehicles/index.php' method='POST'>
        <label for='classification'>Classification name to add:</label><br>
        <span>Classification must be less than 30 characters</span><br>
        <input type="text" name='classificationName' maxlength="30" id='classification' required><br>
        <input type="submit" value="Add it!"><br>
        <input type="hidden" name="action" value='addClassification'>
      </form>
    </main>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
    </footer>
  </div>
</body>

</html>