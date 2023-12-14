<?php
function search($searchTerm) {
  $db = phpmotorsConnect();
  $sql = "SELECT * FROM inventory WHERE ((inventory.invMake LIKE '%" . $searchTerm . "%') OR (inventory.invModel LIKE '%" . $searchTerm . "%'))";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $results;
}

function pagination($searchTerm, $offset, $no_of_records_per_page) {
  $db = phpmotorsConnect();
  $sql = "SELECT * FROM inventory WHERE ((inventory.invMake LIKE '%" . $searchTerm . "%') OR (inventory.invModel LIKE '%" . $searchTerm . "%')) LIMIT :offset, :no_of_records_per_page";
  $stmt = $db->prepare($sql); 
  $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
  $stmt->bindValue(':no_of_records_per_page', $no_of_records_per_page, PDO::PARAM_INT);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $results;
}