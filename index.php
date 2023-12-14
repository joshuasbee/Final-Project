<?php
//THIS IS THE MAIN CONTROLLER FOR THE SITE
session_start();

require_once 'library/connections.php';
// Get the PHP Motors model for use as needed
require_once 'model/main-model.php';
// Use the functions.php
require_once 'library/functions.php';

// Build a navigation bar using the $classifications array
$navList = navList(getClassifications());

$action = filter_input(INPUT_GET, 'action');
if ($action == NULL) {
  $action = filter_input(INPUT_POST, 'action');
}

// Check if the firstname cookie exists, get its value
if(isset($_COOKIE['firstname'])){
  $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
 }

switch ($action) {
  case 'template':
    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/template.php';
    break;
  default:
    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/home.php';
}
