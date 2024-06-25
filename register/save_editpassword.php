<?php
require_once("../dbconnect.php");

$id = $_POST["ID"];
$password1 = $_POST["password1"];
$hashed_password = password_hash($password1, PASSWORD_DEFAULT);

// Aktualizacja hasła w tabeli 'password'
$sql_update_password = "UPDATE `password` SET `password`='$hashed_password' WHERE `passwordID`='$id'";

if ($conn->query($sql_update_password) === TRUE) {
    header("Location: ../index.php?success=password_change");
    exit;
} else {
    header("Location: ../index.php?error=blad");
    exit;
}

$conn->close();
?>
