<?php

require_once("../auth.php");

if (!isLoggedIn()) {
    header("Location: ../index.php"); // Przekierowanie na stronę po zalogowaniu
    exit;
}

require_once("../dbconnect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = returniserid();
    $idapp = $_POST['id'];
    $number = $_POST['number'];
    $readyID=0;
    
     $sql = "INSERT INTO readyapplication (userID, applicationID, status, type) VALUES (?, ?, '0', '0')";
        
        // Przygotowanie zapytania
        $stmt = $conn->prepare($sql);
        
        // Sprawdzenie, czy zapytanie zostało poprawnie przygotowane
        if ($stmt) {
            // Wiązanie parametrów
            $stmt->bind_param("ii", $userID, $idapp);
            
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


?>