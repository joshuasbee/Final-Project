
<img src="/phpmotors/images/site/logo.png" alt="PHP Motors Logo">
<?php
if (isset($_SESSION['clientData'])) {

  echo '<div class="andale" id="account"><form action="/phpmotors/search/index.php" method="POST"><a href="/phpmotors/accounts">Welcome ' . $_SESSION['clientData']['clientFirstname'] . '</a> | <a href="/phpmotors/accounts?action=logout">Logout</a>' . '<button type="submit">&#x1F50D;</button><input type="hidden" name="action" value="searchPage"></form></div>';
}
else {
  echo '<div class="andale" id="account"><form action="/phpmotors/search/index.php" method="POST"><a class="andale" id="account" href="/phpmotors/accounts?action=loginView">My Account</a>' . '<button type="submit">&#x1F50D</button><input type="hidden" name="action" value="searchPage"></form></div>';
} 
?>