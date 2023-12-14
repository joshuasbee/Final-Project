<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="/phpmotors/css/style.css" media="screen">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php if (isset($vehicle)) {echo $vehicle['invMake'] . ' ' . $vehicle['invModel'];}?> | PHP Motors</title>
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
      <div class=center>
        <h1 class="andale"><?php if (isset($vehicle)) {echo $vehicle['invMake'] . ' ' . $vehicle['invModel'];}?></h1>
</div>

      <?php if (isset($message)) {echo $message;}?>

      <?php if(isset($oneVehicleDisplay)) { echo $oneVehicleDisplay; } ?>
    </main>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
    </footer>
  </div>
</body>

</html>