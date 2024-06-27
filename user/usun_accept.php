<?php
require_once("../auth.php");

if (!isLoggedIn()) {
    header("Location: ../index.php"); // Przekierowanie na stronę po zalogowaniu
    exit;
}

require_once("../dbconnect.php");

$id=urldecode($_GET['ID']);

$sql1 = "UPDATE `organizationdata` SET `accept`='2' WHERE OrganizationID=$id";

if ($conn->query($sql1) === TRUE) {
    header("Location: accept.php");
    exit;   // Zakończenie połączenia z bazą danych
} else {
    echo "Błąd: " . $sql1 . "<br>" . $conn->error;
}