<?php
session_start();
//function logUserActivity($username, $operation) {
 //   $logFilePath = 'C:\xampp\htdocs\messer\dziennik.log';
  //  $logMessage = "[" . date('Y-m-d H:i:s') . "],$username,$operation" . PHP_EOL;

    // Otwarcie pliku dziennika w trybie dołączania
 //   $file = fopen($logFilePath, 'a');

    // Zapisanie komunikatu do pliku dziennika
  //  fwrite($file, $logMessage);

    // Zamknięcie pliku dziennika
  //  fclose($file);
//}


function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function returniserid(){
    return ($_SESSION['user_id']);

}

function returnImieNazwisko(){
    return ($_SESSION['imie_nazwisko']);
}

function returnRole(){
    return ($_SESSION['role']);

}