<?php 
/*
* This is the ACCOUNTS CONTROLLER
*/
session_start();
// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the accounts model
require_once '../model/accounts-model.php';
// Get the functions library
require_once '../library/functions.php';

// Get the array of classifications
$classifications = getClassifications();

// Build a navigation bar using the $classifications array
$navList = navList(getClassifications());

$action = filter_input(INPUT_GET, 'action');
if ($action == NULL) {
  $action = filter_input(INPUT_POST, 'action');
}

switch ($action) {
  case 'Login':// for an actual login attempt 
    $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
    $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $clientEmail = checkEmail($clientEmail);
    $passwordCheck = checkPassword($clientPassword);
    if (empty($clientEmail) || empty($passwordCheck)){
      $message = '<p>Please provide valid email and password.</p>';
      include '../view/login.php';
      exit;
    }
    // If both inputs are valid, continue login process
    // Query for client data based on input
    $clientData = getClient($clientEmail);
    // Check if the inputted password hash matches the hash in the database
    $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
    // If the hashes don't match go to login view again with an error message
    if (!$hashCheck) {
      $message = '<p>Please check your password and try again.</p>';
      include '../view/login.php';
      exit;
    }
    // Valid user exists, log them in
    $_SESSION['loggedin'] = TRUE;
    // Remove password from array, pop does this because the last item is the password
    array_pop($clientData);
    // Store the rest of the array in the session
    $_SESSION['clientData'] = $clientData;
    // Send them to the admin view
    include '../view/admin.php';
    exit;
    break;

  case 'loginView':// For 'My account' button on top right 
    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/login.php';
    break;
  case 'signup':// For 'signup' button in login.php
    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/registration.php';
    break;
  case 'register':
    $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
    $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $clientEmail = checkEmail($clientEmail);
    $passwordCheck = checkPassword($clientPassword);
    // checking to make sure the email is not already registered
    $existingEmail = checkExistingEmail($clientEmail);
    if ($existingEmail){
      $message = '<p>That email address already exists. Do you want to login instead?</p>';
      include '../view/login.php';
      exit;
    }

    // Check for missing data
    if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($passwordCheck)){
      $message = '<p>Please provide information for all empty form fields.</p>';
      include '../view/registration.php';
      exit; 
    }
    // Hash the checked password
    $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
    $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);
    // Check and report the result
    if($regOutcome === 1){
      setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
      // $message = "<p>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
      $_SESSION['message'] = "Thanks for registering $clientFirstname. Please use your email and password to login.";
      //include '../view/login.php';
      header('Location: /phpmotors/accounts/?action=login');
      exit;
    } else {
      $message = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
      include '../view/registration.php';
      exit;
    }
    break;

  case 'logout':
    //unset session data 
    unset($_SESSION['clientData']);
    unset($_SESSION['loggedin']);
    // destroy session
    session_destroy();
    //back to main phpmotors controller
    header("Location: /phpmotors/index.php");
    break;
  case 'updatePage':
    include $_SERVER['DOCUMENT_ROOT'] . "/phpmotors/view/client-update.php";
    break;
  case 'updateAccountInfo': 
    $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
    $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

    $verifyFirstname = verify($clientFirstname, 30, 'text');
    $verifyLastname = verify($clientLastname, 30, 'text');
    $clientEmail = checkEmail($clientEmail);

    if (isset($_SESSION['clientData']['clientEmail']) && $_SESSION['clientData']['clientEmail'] != $clientEmail) {
      $existingEmail = checkExistingEmail($clientEmail);
      if ($existingEmail){
        $message = '<p>That email address is being used</p>';
        include '../view/client-update.php';
        exit;
      }
    }
    //if a field isnt filled properly
    if (empty($verifyFirstname) || empty($verifyLastname)){
      $message = '<p>Please make sure the fields are filled and valid</p>';
      include '../view/client-update.php';
      exit;
    }
    //continue on to updateAccountInfo in database
    $updateResult = updateAccountInfo($clientFirstname, $clientLastname, $clientEmail, $clientId);
    // if $updateresult === 1 do $message = 'it was successful' and go to admin page
    if ($updateResult === 1) {
      $message = "<p>Account successfully updated</p>";
      $_SESSION['message'] = $message;
      //fetches newly set account info from database to update the session variables
      $clientData = getClientFromId($clientId);
      //This pops off the password, not storing it in the session
      array_pop($clientData);
      //update session variable to reflect updated items
      $_SESSION['clientData'] = $clientData;
      header('Location: /phpmotors/accounts/');
      exit;
    }
    //if we get here that means nothing was changed
    $message = "<p>No changes to your account were made</p>";
    $_SESSION['message'] = $message;
    header('Location: /phpmotors/accounts/');
    break;
  case 'updatePassword':
    $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

    $checkPassword = checkPassword($clientPassword);
    if (!$checkPassword){
      $message = "<p>Password not changed. Please make sure new password is valid and not empty</p>";
      include '../view/client-update.php';
      exit;
    }
    //hash it 
    $clientPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
    //add hashed password to the database
    $updateResult = updatePassword($clientPassword, $clientId);
    if ($updateResult === 1) {
      $message = "<p>Password changed successfully</p>";
      $_SESSION['message'] = $message;
      include '../view/admin.php';
    }
    else {
      $message = "<p>Password not updated</p>";
      $_SESSION['message'] = $message;
      include '../view/client-update.php';
    }
    
    exit;
    break;
      default:
    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/admin.php';
}

?>