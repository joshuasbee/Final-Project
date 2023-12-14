<?php //This is the ACCOUNTS MODEL

//this function will handle site registrations
function regClient($clientFirstname, $clientLastname, $clientEmail, $clientPassword)
{
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'INSERT INTO clients (clientFirstname, clientLastname,clientEmail, clientPassword)
    VALUES (:clientFirstname, :clientLastname, :clientEmail, :clientPassword)';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
    $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}

//This function will check if an email address is already used
function checkExistingEmail($clientEmail)
{
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'SELECT clientEmail FROM clients WHERE clientEmail = :email';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // Replace :email with the email input
    $stmt->bindValue(':email', $clientEmail, PDO::PARAM_STR);
    //Run the select query
    $stmt->execute();
    //See if it got an existing email address or not
    $matchEmail = $stmt->fetch(PDO::FETCH_NUM);
    // Close the database interaction
    $stmt->closeCursor();
    if (empty($matchEmail)) {
        return 0;
    } else {
        return 1;
    }
}

function getClient ($clientEmail) {
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'SELECT clientId, clientFirstname, clientLastname, clientEmail, clientLevel, clientPassword FROM clients WHERE clientEmail = :clientEmail';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // Replace :clientEmail in the query above
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    // Return associate array of data
    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
    // Close the database interaction
    $stmt->closeCursor();
    // Return the data about the client
    return $clientData;
}

function getClientFromId ($clientId) {
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'SELECT clientId, clientFirstname, clientLastname, clientEmail, clientLevel, clientPassword FROM clients WHERE clientId = :clientId';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // Replace :clientEmail in the query above
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    // Return associate array of data
    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
    // Close the database interaction
    $stmt->closeCursor();
    // Return the data about the client
    return $clientData;
}

function updateAccountInfo($clientFirstname, $clientLastname, $clientEmail, $clientId) {
    $db = phpMotorsConnect();
    $sql = 'UPDATE clients SET clientFirstname = :clientFirstname, clientLastname = :clientLastname, clientEmail = :clientEmail WHERE clientId = :clientId';
    //generate a prepared statement
    $stmt = $db->prepare($sql);
    //change the value of :x to the one passed in, in a safe way
    $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
    $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    //execute my query
    $stmt->execute();
    //find number of rows affected
    $rowsChanged = $stmt->rowCount();
    //close connection
    $stmt->closeCursor();
    //return rows changed for reference
    return $rowsChanged;
}

function updatePassword($clientPassword, $clientId) {
    $db = phpMotorsConnect();
    $sql = 'UPDATE clients SET clientPassword = :clientPassword WHERE clientId = :clientId';
    //generate a prepared statement
    $stmt = $db->prepare($sql);
    //change the value of :x to the one passed in, in a safe way
    $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    //execute my query
    $stmt->execute();
    //find number of rows affected
    $rowsChanged = $stmt->rowCount();
    //close connection
    $stmt->closeCursor();
    //return rows changed for reference
    return $rowsChanged;
}