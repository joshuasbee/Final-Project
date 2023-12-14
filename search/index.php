<?php
//This is the VEHICLES CONTROLLER
session_start();

// Use the database connection file.
require_once '../library/connections.php';

// Use the phpmotors model.
require_once '../model/main-model.php';

// Use the vehicles model
require_once '../model/vehicle-model.php';

// Use the functions.php
require_once '../library/functions.php';

// Use the uploads model
require_once '../model/uploads-model.php';

// Use the search model
require_once '../model/search-model.php';

/* Create the $navList variable to build the dynamic menu from an array of classifications 
*  obtained by calling the function in library.functions.php */
$navList = navList(getClassifications());

/* Create a $classificationList variable to build a dynamic [drop-down select list]*/
$cList = getClassifications();

// Watch for and capture name-value pairs for decision making.
$action = filter_input(INPUT_GET, 'action');
if ($action == NULL) {
  $action = filter_input(INPUT_POST, 'action');
}

// Contain control structures to deliver views (discussed below).
switch ($action) {
  case 'search':
    $searchTerm = filter_input(INPUT_POST, 'searchTerm', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $searchTerm = strip_tags(html_entity_decode($searchTerm));

    if (isset($_POST['searchTerm'])) {
      $_SESSION['searchTerm'] = $searchTerm;
    }

    if (empty($searchTerm) && empty($_SESSION['searchTerm']))
    {
      $message = '<p>Search is empty</p>';
      include '../view/search-page.php';
      exit; 
    }
    $results = search($_SESSION['searchTerm']);

    
    if (!count($results)) {
      $message = "<p class='notice'>Sorry, no results found.</p>";
    }
    else {
      $searchDisplay = buildSearchDisplay($_SESSION['searchTerm'], $results);
    }
    include '../view/search-page.php';
    break;
  case 'searchPage':
    include '../view/search-page.php';
    break;
  default:
    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/search-page.php';
    exit;
}
