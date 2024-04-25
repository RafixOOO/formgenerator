<?php
// Rozpoczęcie sesji
session_start();

require_once("dbconnect.php"); 

// Pobieranie danych z formularza
$login = $_POST["login"];
$password = $_POST["password"];

// Zabezpieczenie przed atakami SQL injection
$login = mysqli_real_escape_string($conn, $login);
$password = mysqli_real_escape_string($conn, $password);

// Zapytanie SQL w celu sprawdzenia czy użytkownik o podanym loginie istnieje
$sql = "SELECT * FROM user WHERE email = '$login'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Użytkownik o podanym loginie istnieje, sprawdzanie hasła
 $row = $result->fetch_assoc();
    $userID = $row["userID"]; // Pobranie ID użytkownika
    $_SESSION["imie_nazwisko"] = $row["name"] . " " . $row["surname"];
    $_SESSION["role"]=$row["role"];
    $sql = "SELECT password FROM password WHERE passwordID = $userID"; // Poprawione zapytanie SQL
    $result_password = $conn->query($sql); // Wykonanie zapytania
    if ($result_password->num_rows > 0) {
        $row_password = $result_password->fetch_assoc();
        if (password_verify($password, $row_password["password"])) {
            // Poprawne logowanie
            $_SESSION["user_id"] = $row["userID"]; // Zapisanie ID użytkownika do sesji
            header("Location: forms/forms.php"); // Przekierowanie na stronę po zalogowaniu
            exit; // Warto dodać exit, aby zapobiec dalszemu wykonywaniu kodu
        } else {
            // Nieprawidłowe hasło
            header("Location: index.php?error=invalid_password");
            exit;
        }
    } else {
        // Hasło dla danego użytkownika nie zostało znalezione
        header("Location: index.php?error=password_not_found");
        exit;
    }
} else {
    // Użytkownik o podanym loginie nie istnieje
    header("Location: index.php?error=user_not_found");
    exit;
}