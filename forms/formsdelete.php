<?php

require_once("../auth.php");

if (!isLoggedIn()) {
    header("Location: ../index.php"); // Przekierowanie na stronę po zalogowaniu
    exit;
}

require_once("../dbconnect.php");

if (isset($_GET['ID'])) {
    // Odczytujemy wartość zmiennej
    $id = $_GET['ID'];
    $sql = "UPDATE `application` SET `deleted`='1' WHERE `applicationID`=?";

    // Przygotowanie zapytania
    $stmt = $conn->prepare($sql);

    // Sprawdzenie, czy zapytanie zostało poprawnie przygotowane
    if ($stmt) {
        // Wiązanie parametrów
        $stmt->bind_param("i", $id);

        // Wykonanie zapytania
        if ($stmt->execute()) {
            $readyID = $conn->insert_id;
        } else {
            // Błąd podczas wykonywania zapytania
            echo "Error: " . $conn->error;
        }

        // Zamknięcie prepared statement
        $stmt->close();
    } else {
        // Błąd podczas przygotowywania zapytania
        echo "Error: " . $conn->error;
    }
}
    
    header("Location: forms.php");
    exit;