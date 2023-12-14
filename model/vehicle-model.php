<?php //This is the VEHICLES MODEL

// Contain a function for inserting a new classification to the carclassifications table.
function insertClassification($classificationName) {
  //connect to my local database using phpMotorsConnect function
  $db = phpMotorsConnect();
  $sql = 'INSERT INTO carclassification (classificationName) 
    VALUES (:classificationName);';
  //generate a prepared statement
  $stmt = $db->prepare($sql);
  //change the value of :classificationName to the one passed in, in a safe way
  $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
  //execute my query
  $stmt->execute();
  //find number of rows affected
  $rowsChanged = $stmt->rowCount();
  //close connection
  $stmt->closeCursor();
  //return rows changed for reference
  return $rowsChanged;
}
 
// Contain a function for inserting a new vehicle to the inventory table.
function insertVehicle($invMake, $invModel, $invDescription, $invPrice, $invStock, $invColor, $classificationId, $invImage, $invThumbnail) {
  $db = phpMotorsConnect();
  $sql = 'INSERT INTO inventory (invMake, invModel, invDescription, invPrice, invStock, invColor, classificationId, invImage, invThumbnail) 
  VALUES (:invMake, :invModel, :invDescription, :invPrice, :invStock, :invColor, :classificationId, :invImage, :invThumbnail)';
  //generate a prepared statement
  $stmt = $db->prepare($sql);
  //change the value of :x to the one passed in, in a safe way
  $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
  $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
  $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
  $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_INT);
  $stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
  $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
  $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);
  $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
  $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);

  //execute my query
  $stmt->execute();
  //find number of rows affected
  $rowsChanged = $stmt->rowCount();
  //close connection
  $stmt->closeCursor();
  //return rows changed for reference
  return $rowsChanged;
}

// Get vehicles by classificationId 
function getInventoryByClassification($classificationId){ 
  $db = phpmotorsConnect(); 
  $sql = ' SELECT * FROM inventory WHERE classificationId = :classificationId'; 
  $stmt = $db->prepare($sql); 
  $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT); 
  $stmt->execute(); 
  $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC); 
  $stmt->closeCursor(); 
  return $inventory; 
}

// Get vehicle information by invId
function getInvItemInfo($invId){
  $db = phpmotorsConnect();
  $sql = "SELECT inventory.invId, inventory.invMake, inventory.invModel, inventory.invDescription, inventory.invPrice, inventory.invMiles, inventory.invColor, inventory.classificationId, images.imgPath FROM inventory INNER JOIN images ON inventory.invId = images.invId WHERE inventory.classificationId IN (SELECT classificationId FROM carclassification WHERE inventory.invId = :invId) AND images.imgPath NOT LIKE '%-tn.%'";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
  $stmt->execute();
  $invInfo = $stmt->fetch(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  // var_dump($invInfo);
  return $invInfo;
}

function updateVehicle($invMake, $invModel, $invDescription, $invPrice, $invStock, $invColor, $classificationId, $invImage, $invThumbnail, $invId){
  $db = phpMotorsConnect();
  $sql = 'UPDATE inventory SET invMake = :invMake, invModel = :invModel, invDescription = :invDescription, invPrice = :invPrice, invStock = :invStock, invColor = :invColor, invImage = :invImage, invThumbnail = :invThumbnail, classificationId = :classificationId WHERE invId = :invId';
  //generate a prepared statement
  $stmt = $db->prepare($sql);
  //change the value of :x to the one passed in, in a safe way
  $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
  $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
  $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
  $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_INT);
  $stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
  $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
  $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);
  $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
  $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
  $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
  //execute my query
  $stmt->execute();
  //find number of rows affected
  $rowsChanged = $stmt->rowCount();
  //close connection
  $stmt->closeCursor();
  //return rows changed for reference
  return $rowsChanged;
}

function deleteVehicle($invId) {
  $db = phpMotorsConnect();
  $sql = 'DELETE FROM inventory WHERE invId = :invId';
  //generate a prepared statement
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
  //execute my query
  $stmt->execute();
  //find number of rows affected
  $rowsChanged = $stmt->rowCount();
  //close connection
  $stmt->closeCursor();
  //return rows changed for reference
  return $rowsChanged;
}

function getVehiclesByClassification($classificationName) {
  $db = phpmotorsConnect();
  $sql = 'SELECT inventory.invId, inventory.invMake, inventory.invModel, inventory.invDescription, inventory.invPrice, /*inventory.invStock, */inventory.invColor, inventory.classificationId, images.imgPath FROM inventory INNER JOIN images ON inventory.invId = images.invId WHERE classificationId IN (SELECT classificationId FROM carclassification WHERE classificationName = :classificationName) /*AND images.imgPrimary = 1*/ AND images.imgPath LIKE "%-tn.%"';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
  $stmt->execute();
  $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $vehicles;
}

//Get information for all vehicles 
function getVehicles() {
  $db = phpmotorsConnect();
	$sql = 'SELECT invId, invMake, invModel FROM inventory';
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $invInfo;
}