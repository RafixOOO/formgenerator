<?php
require_once("../dbconnect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = intval($_POST['user_id']);

    $stmt = $conn->prepare("UPDATE `organizationconnect` SET accept = 2 WHERE organizationconnectID = ?");
    $stmt->bind_param('i', $user_id);

    if ($stmt->execute()) {
        echo "Rola została zaktualizowana pomyślnie.";
    } else {
        echo "Błąd podczas aktualizacji roli: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
header("Location: organizationsetting.php");
exit;
?>