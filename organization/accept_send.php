<?php
require_once("../dbconnect.php");
    $user_id = urldecode($_GET['ID']);;

    $stmt = $conn->prepare("UPDATE `organizationconnect` SET accept = 1 WHERE organizationconnectID = ?");
    $stmt->bind_param('i', $user_id);

    if ($stmt->execute()) {
        echo "Rola została zaktualizowana pomyślnie.";
    } else {
        echo "Błąd podczas aktualizacji roli: " . $stmt->error;
    }
    
    $previousPage = $_SERVER['HTTP_REFERER'];
    header("Location: $previousPage");
    exit();
?>