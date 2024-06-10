<?php

require_once("../auth.php");

if (!isLoggedIn()) {
    header("Location: ../index.php"); // Przekierowanie na stronę po zalogowaniu
    exit;
}

require_once("../dbconnect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputNumber = intval($_POST["inputNumber"]);
    $id = intval($_POST["id"]);
    echo $inputNumber;
    echo $id;
    // Przygotowanie zapytania
    $sql = "UPDATE `readyapplication` SET `type` = ? WHERE `readyID` = ?";
    $stmt = $conn->prepare($sql);

    // Sprawdzenie, czy zapytanie zostało poprawnie przygotowane
    if ($stmt) {
        // Wiązanie parametrów
        $stmt->bind_param("ii", $inputNumber, $id);

        // Wykonanie zapytania
        if ($stmt->execute()) {
            echo "Dane zostały pomyślnie zaktualizowane";
        } else {
            // Błąd podczas wykonywania zapytania
            echo "Error: " . $stmt->error;
        }

        // Zamknięcie prepared statement
        $stmt->close();
    } else {
        // Błąd podczas przygotowywania zapytania
        echo "Error: " . $conn->error;
    }
}

//header("Location: tocheck.php");
//exit;
?>
