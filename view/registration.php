<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <?php //include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/css/style.css'; 
  ?>
  <link rel="stylesheet" href="/phpmotors/css/style.css" media="screen">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register | PHP Motors</title>
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
      <h1 class="andale, center">Register</h1>
      <?php
      if (isset($message)) {
        echo $message;
      }
      ?>
      <form action='/phpmotors/accounts/index.php' method='POST' class='center'>
        <label for="fname">First Name:</label><br>
        <input type="text" name="clientFirstname" id="fname" <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";} ?> required><br>

        <label for="lname">Last Name:</label><br>
        <input type="text" id="lname" name="clientLastname" <?php if(isset($clientLastname)){echo "value='$clientLastname'";} ?> required><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="clientEmail" <?php if(isset($clientEmail)){echo "value='$clientEmail'";} ?> required><br>
        
        <label for="password">Password: <label><br>
        <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span><br>
        <input type="password" id="password" name="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br><br>
        <input type="submit" value="Sign Up">
        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="register">
      </form>
    </main>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
    </footer>
  </div>
</body>

</html>
