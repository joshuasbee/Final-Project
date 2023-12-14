<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="/phpmotors/css/style.css" media="screen">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Search | PHP Motors</title>
</head>

<body>
  <div id="wrapper">
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    </header>
    <nav>
      <?php echo $navList ?>
    </nav>
    <main class="andale">
      <h1 class="andale">Search</h1>
      <?php if (isset($message)) { echo $message; } ?>
      <form action="/phpmotors/search/index.php" method='POST'>
        <label for="searchTerm" hidden>Search</label>
        <input type="text" name="searchTerm" id="searchTerm" placeholder="Search" <?php 
        if (isset($searchTerm)) { echo "value='$searchTerm'"; } 
        elseif (isset($_SESSION['searchTerm'])){ echo "value='" . $_SESSION['searchTerm'] . "'"; }?>>
        <button type="submit">&#x1F50D;</button>
        <input type="hidden" name="action" value="search">
      </form>
    <?php 
      if (isset($results)) {
        if (isset($searchDisplay)) {
          echo $searchDisplay;
        }
      }

    ?>
    </main>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
    </footer>
  </div>
</body>

</html>