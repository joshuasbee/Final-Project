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

//Use the uploads model
require_once '../model/uploads-model.php';

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
  case 'addClassificationPage':
    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-classification.php';
    break;
  case 'addVehiclePage':
    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-vehicle.php';
    break;
    // Contain control structures to process requests to add new classifications to the carclassifications table and vehicles to the inventory table.
  case 'addClassification':
    $classificationName = trim(filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $checkClassificationName = verify($classificationName, 30, 'other');
    if (empty($checkClassificationName)) {
      $message = '<p>Please provide a classification name between 1 and 30 characters</p>';
      include '../view/add-classification.php';
      exit; //or else it will continue to the default case as well as this one
    }
    $addOutcome = insertClassification($classificationName);
    if ($addOutcome === 1) {
      //no success message, just load the page and make sure the navbar updates
      header("Location: http://localhost/phpmotors/vehicles/index.php");
      exit;
    } else {
      $message = "<p>Failed to add classification to database</p>";
      include '../view/add-classification.php';
      exit;
    }
    break;
  case 'addVehicle':
    $classificationId = trim(filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT));
    $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invDescription = trim(filter_input(INPUT_POST, 'invDescription'));
    $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_INT));
    $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT));
    $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    //Check the lengths on the server side of all the ones restricted in HTML so they are put into the database without trimming 
    $invMakeVer = verify($invMake, 30, 'text');
    $invModelVer = verify($invModel, 30, 'other');
    $invImageVer = verify($invImage, 50, 'text');
    $invThumbnailVer = verify($invThumbnail, 50, 'text');
    $invPriceVer = verify($invPrice, 10, 'number');
    $invStockVer = verify($invStock, 6, 'number');
    $invColorVer = verify($invColor, 20, 'text');

    if (
      empty($invMakeVer) || empty($invModelVer) || empty($invDescription) || empty($invPriceVer) ||
      empty($invStockVer) || empty($invColorVer) || empty($invImageVer) || empty($invThumbnailVer)
    ) {
      $message = '<p>Please fill all fields with the right number of characters and leave no field blank</p>';
      include '../view/add-vehicle.php';
      exit; //or else it will continue to the default case as well as this one
    }
    $addVehicleResult = insertVehicle($invMake, $invModel, $invDescription, $invPrice, $invStock, $invColor, $classificationId, $invImage, $invThumbnail);
    if ($addVehicleResult === 1) {
      $message = "<p>Successfully added vehicle $invMake $invModel!</p>";
      include '../view/add-vehicle.php';
      exit;
    } else {
      $message = "<p>Failed to add vehicle to database</p>";
      include '../view/add-vehicle.php';
      exit;
    }
    break;
  case 'getInventoryItems': 
    // Get the classificationId 
    $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT); 
    // Fetch the vehicles by classificationId from the DB 
    $inventoryArray = getInventoryByClassification($classificationId); 
    // Convert the array to a JSON object and send it back 
    echo json_encode($inventoryArray); 
    break;
  case 'mod':
    $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
    $invInfo = getInvItemInfo($invId);
    if(count($invInfo)<1){
     $message = 'Sorry, no vehicle information could be found.';
    }
    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/vehicle-update.php';
    exit;
    break;
  case 'updateVehicle':
    $classificationId = trim(filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT));
    $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
    $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT));
    $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
    //Check the lengths on the server side of all the ones restricted in HTML so they are put into the database without trimming 
    $invMakeVer = verify($invMake, 30, 'text');
    $invModelVer = verify($invModel, 30, 'other');
    $invImageVer = verify($invImage, 50, 'text');
    $invThumbnailVer = verify($invThumbnail, 50, 'text');
    $invPriceVer = verify($invPrice, 10, 'number');
    $invStockVer = verify($invStock, 6, 'number');
    $invColorVer = verify($invColor, 20, 'text');
   
    if (empty($invMakeVer) || empty($invModelVer) || empty($invDescription)
      || empty($invPriceVer) || empty($invStockVer) || empty($invColorVer)
      || empty($invImageVer) || empty($invThumbnailVer) || empty($classificationId)
    ) {
      $message = '<p>Please fill all fields with the right number of characters and leave no field blank</p>';
      include '../view/vehicle-update.php';
      exit; //or else it will continue to the default case as well as this one
    }
    $updateResult = updateVehicle($invMake, $invModel, $invDescription, $invPrice, $invStock, $invColor, $classificationId, $invImage, $invThumbnail, $invId);
    if ($updateResult === 1) {
      $message = "<p>The $invMake $invModel was successfully updated!</p>";
      $_SESSION['message'] = $message;
      header('Location: /phpmotors/vehicles/');
      exit;
    } else {
      $message = "<p>The $invMake $invModel was not updated.</p>";
      include '../view/vehicle-update.php';
      exit;
    }
    break;
  case 'del':
    $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
    $invInfo = getInvItemInfo($invId);
    if(count($invInfo)<1){
     $message = 'Sorry, no vehicle information could be found.';
    }
    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/vehicle-delete.php';
    exit;
    break;
  case 'deleteVehicle':
    $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

    $deleteResult = deleteVehicle($invId);
    if ($deleteResult) {
      $message = "<p>The $invMake $invModel was successfully deleted.</p>";
      $_SESSION['message'] = $message;
      header('Location: /phpmotors/vehicles/');
      exit;
    } else {
      $message = "<p>The $invMake $invModel was not deleted.</p>";
      $_SESSION['message'] = $message;
      header('Location: /phpmotors/vehicles');
      exit;
    }
    break;
  case 'classification':
    $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $vehicles = getVehiclesByClassification($classificationName);
    if(!count($vehicles)){
     $message = "<p class='notice'>Sorry, no $classificationName could be found.</p>";
    } else {
     $vehicleDisplay = buildVehiclesDisplay($vehicles);
    }
    include '../view/classification.php';
    break;
  case 'displayVehicle':
    $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //query the database, select * columns from row with matching $invId
    $vehicle = getInvItemInfo($invId);
    $vehicleThumbnails = getThumbnails($invId);
    // If the ID is not present in the database
    if(!count($vehicle)){
     $message = "<p class='notice'>Sorry, no $classificationName could be found.</p>";
     exit;
    } else { //Show the single vehicle view
     $oneVehicleDisplay = singleVehicleDisplay($vehicle, $vehicleThumbnails);
    }
    include '../view/vehicle-detail.php';
    break;
  default:
    $classificationList = buildClassificationList($cList);
    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/vehicle-management.php';
    exit;
}
