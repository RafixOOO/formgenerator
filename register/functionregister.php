<?php
require_once("../dbconnect.php");

// Pobieranie danych z formularza
$name = $_POST["name"];
$surname = $_POST["surname"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$password1 = $_POST["password1"];

// Sprawdzanie czy email istnieje już w bazie danych
$sql_check_email = "SELECT * FROM `user` WHERE `email` = '$email'";
$result_check_email = $conn->query($sql_check_email);

if ($result_check_email->num_rows > 0) {
        header("Location: " . $_SERVER['HTTP_REFERER'] . "?error=email_exists");
        exit;
} else {
    // Haszowanie hasła
    $hashed_password = password_hash($password1, PASSWORD_DEFAULT);
    
    // Dodawanie użytkownika do tabeli 'user'
    $sql_user = "INSERT INTO `user` (`name`, `surname`, `phone`, `email`) VALUES ('$name', '$surname', '$phone', '$email')";
    
    if ($conn->query($sql_user) === TRUE) {
        // Pobieranie ID nowo dodanego użytkownika
        $userID = $conn->insert_id;
        
        // Dodawanie hasła do tabeli 'password'
        $sql_password = "INSERT INTO `password` (`passwordID`, `password`) VALUES ('$userID', '$hashed_password')";
        
        if ($conn->query($sql_password) === TRUE) {
            header("Location: ../index.php?success=registration_success");
            exit;
        } else {
           header("Location: register.php?error=password_error");
            exit;
        }
    } else {
        header("Location: register.php?error=user_error");
        exit;
    }
}
    