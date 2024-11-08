<?php
require_once("../dbconnect.php"); // Włączamy plik połączenia

// Pobranie ID użytkownika i aplikacji z żądania
$userID = $_GET['userID'];
$readyapplicationID = $_GET['readyapplicationID'];

// Zapytanie do bazy danych
$query = "SELECT json FROM workspacejson WHERE userID = '$userID' AND readyapplicationID = '$readyapplicationID' ORDER BY workspacejsonID DESC LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo $row ? $row['json'] : json_encode(["status" => "no_data"]);
} else {
    echo json_encode(["status" => "error", "message" => "Błąd przy pobieraniu danych: " . mysqli_error($conn)]);
}

mysqli_close($conn); // Zamknięcie połączenia
?>
