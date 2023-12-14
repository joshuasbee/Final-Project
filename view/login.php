<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="/phpmotors/css/style.css" media="screen">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | PHP Motors</title>
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
      <h1 class="andale, center">Login</h1>
      <?php if (isset($_SESSION['message'])) {echo $_SESSION['message'];}?>
      <form action='/phpmotors/accounts/index.php' method='POST' class='center'>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="clientEmail" <?php if(isset($clientEmail)){echo "value='$clientEmail'";} ?> required><br>
        <label for="password">Password:</label><br>
        <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span><br>
        <input type="password" id="password" name="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br><br>
        <input type="hidden" name="action" value="Login">
        <input type="submit" value="Log In">
      </form>
      <br>
      <div class="center">
        <a class='plain_link' href="/phpmotors/accounts?action=signup">Don't have an account? Click to sign up</a>
      </div>
    </main>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
    </footer>
  </div>
</body>

</html>