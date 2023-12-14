<?php 
  if (!$_SESSION['loggedin']) {
    header('Location: phpmotors/index.php');
  }
?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="/phpmotors/css/style.css" media="screen">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Client Admin | PHP Motors</title>
</head>

<body>
  <div id="wrapper">
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    </header>
    <nav>
      <?php echo $navList ?>
    </nav>
    <main>
      <h1 class="andale"><?php echo $_SESSION['clientData']['clientFirstname'] .' ' . $_SESSION['clientData']['clientLastname'] ;?></h1>

      <?php if (isset($_SESSION['message'])) {echo $_SESSION['message'];} elseif (isset($message)) {echo $message;}?>

      <p class='andale'>You are logged in.</p>
      <ul class ='andale'>
        <li>First name: <?php echo $_SESSION['clientData']['clientFirstname'];?></li>
        <li>Last name: <?php echo $_SESSION['clientData']['clientLastname'];?></li>
        <li>Email: <?php echo $_SESSION['clientData']['clientEmail'];?></li>
      </ul>

      <h3 class='andale'>Account Management</h3>
      <p class='andale'>Use this link to manage the inventory.</p>
      <a class='andale' href='/phpmotors/accounts/?action=updatePage'>Update Account Information</a>
      <?php 
        if ($_SESSION['clientData']['clientLevel'] > 1){
          echo "<h3 class='andale'>Inventory Management</h3>";
          echo "<p class='andale'>" . "Use this link to manage the inventory." . "</p>";
          echo "<a class='andale' href='/phpmotors/vehicles/'>Vehicle Management</a>";
        }
      ?>
    </main>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
    </footer>
  </div>
</body>

</html>