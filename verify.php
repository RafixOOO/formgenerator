<?php

require_once("auth.php");

if (!isLoggedIn()) {
    header("Location: ../index.php"); // Przekierowanie na stronę po zalogowaniu
    exit;
}

require_once("dbconnect.php");
$id=returniserid();
$sql = "UPDATE `user` SET `verify` = 1 WHERE `userID` = ?";
    $stmt = $conn->prepare($sql);

    // Sprawdzenie, czy zapytanie zostało poprawnie przygotowane
    if ($stmt) {
        // Wiązanie parametrów
        $stmt->bind_param("i", $id);

        // Wykonanie zapytania
        if ($stmt->execute()) {
            echo "Dane zostały pomyślnie zaktualizowane";
        } else {
            // Błąd podczas wykonywania zapytania
            echo "Error: " . $stmt->error;
        }
    }