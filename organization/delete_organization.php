<?php
require_once("../dbconnect.php");

$id=urldecode($_GET['ID']);

$sql1 = "UPDATE `organizationdata` SET `accept`='2' WHERE OrganizationID=$id";

if ($conn->query($sql1) === TRUE) {
    header("Location: organization.php");
    exit;   // Zakończenie połączenia z bazą danych
} else {
    echo "Błąd: " . $sql1 . "<br>" . $conn->error;
}
header("Location: organization.php");
exit;