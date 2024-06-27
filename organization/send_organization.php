<?php
require_once("../auth.php");

if (!isLoggedIn()) {
    header("Location: ../index.php"); // Przekierowanie na stronę po zalogowaniu
    exit;
}

require_once("../dbconnect.php");

$id=urldecode($_GET['ID']);
$iduser=returniserid();

$sql1 = "INSERT INTO `organizationconnect`(`UserID`, `role`, `OrganizationID`, `accept`) VALUES ('$iduser','0','$id','0');";

if ($conn->query($sql1) === TRUE) {
    header("Location: organization.php");
    exit;   // Zakończenie połączenia z bazą danych
} else {
    echo "Błąd: " . $sql1 . "<br>" . $conn->error;
}







