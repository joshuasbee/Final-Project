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
  <title>Account Management | PHP Motors</title>
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
      <h1 class="andale">Update Account</h1>
      <?php if (isset($message)){echo $message;}?>
      <form action="/phpmotors/accounts/index.php" method='POST' class='andale'>
        <label for="fname">First Name:</label><br>
        <input type="text" id='fname' name='clientFirstname' <?php if(isset($clientFirstName)){echo "value='$clientFirstName'";} elseif(isset($_SESSION['clientData']['clientFirstname'])) {echo "value=". $_SESSION['clientData']['clientFirstname']; } ?> required><br>
        
        <label for="lname">Last Name:</label><br>
        <input type="text" id='lname' name='clientLastname' <?php if(isset($clientLastName)){echo "value='$clientLastName'";} elseif(isset($_SESSION['clientData']['clientLastname'])) {echo "value=". $_SESSION['clientData']['clientLastname']; } ?> required><br>
        
        <label for="email">Email:</label><br>
        <input type="text" name='clientEmail' id="email" <?php 
          if(isset($clientEmail)){
            echo "value='" . $_SESSION['clientData']['clientEmail'] . "'";}
          elseif(isset($_SESSION['clientData']['clientEmail'])) {
            echo "value='". $_SESSION['clientData']['clientEmail'] . "'"; } ?> 
        required><br><br>

        <?php if(isset($_SESSION['clientData'])) { 
          echo "<input type='hidden' name='clientId' value=" . $_SESSION['clientData']['clientId'] . '>';
        } ?>
        <input type="hidden" name="action" value='updateAccountInfo'>
        <input type='submit' value='Update Info'>
      </form>
      <h3 class='andale'>Update Password</h3>
      <p class='andale'>Paswords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</p>
      <p class='andale'>*note your original password will be changed</p>
      <form action="/phpmotors/accounts/index.php" method='POST' class='andale'>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br>

        <?php if(isset($_SESSION['clientData'])) { 
          echo "<input type='hidden' name='clientId' value=" . $_SESSION['clientData']['clientId'] . '>';
        } ?>
        <input type="hidden" name="action" value='updatePassword'><br>
        <input type="submit" value="Update Password">
      </form>
    </main>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
    </footer>
  </div>
</body>

</html>