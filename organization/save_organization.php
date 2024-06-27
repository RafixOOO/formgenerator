<?php
require_once("../auth.php");

if (!isLoggedIn()) {
    header("Location: ../index.php"); // Przekierowanie na stronę po zalogowaniu
    exit;
}

require_once("../dbconnect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $create = $_POST['create'];
    $applicationID=0;
    $id=returniserid();
    
    $sql = "INSERT INTO `organizationdata`( `Name`, `accept`) VALUES ('$create','0');";

    if ($conn->query($sql) === TRUE) {
        $applicationID = $conn->insert_id;
    } else {
        echo "Błąd: " . $sql . "<br>" . $conn->error;
    }
    
     $sql1 = "INSERT INTO `organizationconnect`(`UserID`, `role`, `OrganizationID`, `accept`) VALUES ('$id','3','$applicationID','1');";

    if ($conn->query($sql1) === TRUE) {
        header("Location: organization.php");
        exit;   // Zakończenie połączenia z bazą danych
    } else {
        echo "Błąd: " . $sql1 . "<br>" . $conn->error;
    }
}