<?php
require_once("../dbconnect.php"); // Włączamy plik połączenia

// Pobierz dane JSON z żądania
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (isset($data['readyapplicationID'], $data['userID'], $data['formData'])) {
    $readyapplicationID = $data['readyapplicationID'];
    $userID = $data['userID'];
    $jsonData = mysqli_real_escape_string($conn, json_encode($data['formData']));

    // Sprawdzenie, czy rekord już istnieje
    $checkQuery = "SELECT COUNT(*) as count FROM workspacejson WHERE readyapplicationID = '$readyapplicationID' AND userID = '$userID'";
    $checkResult = mysqli_query($conn, $checkQuery);
    $row = mysqli_fetch_assoc($checkResult);

    if ($row['count'] > 0) {
        // Jeśli rekord istnieje, zaktualizuj go
        $query = "UPDATE workspacejson SET json = '$jsonData' WHERE readyapplicationID = '$readyapplicationID' AND userID = '$userID'";
        if (mysqli_query($conn, $query)) {
            echo json_encode(["status" => "updated"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Nie udało się zaktualizować danych. Błąd: " . mysqli_error($conn)]);
        }
    } else {
        // Jeśli rekord nie istnieje, dodaj nowy
        $query = "INSERT INTO workspacejson (readyapplicationID, json, userID) VALUES ('$readyapplicationID', '$jsonData', '$userID')";
        if (mysqli_query($conn, $query)) {
            echo json_encode(["status" => "inserted"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Nie udało się zapisać danych. Błąd: " . mysqli_error($conn)]);
        }
    }
} else {
    echo json_encode(["status" => "error", "message" => "Brak wymaganych danych."]);
}

mysqli_close($conn); // Zamknięcie połączenia
?>
