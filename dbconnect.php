<?php
$servername = "localhost"; // Nazwa hosta
$username = "root"; // Nazwa użytkownika
$password = ""; // Hasło użytkownika
$database = "formbuilder"; // Nazwa bazy danych

// Tworzenie połączenia
$conn = mysqli_connect($servername, $username, $password, $database);

// Sprawdzanie połączenia
if (!$conn) {
    die("Połączenie nieudane: " . mysqli_connect_error());
}
?>
