<?php
require_once("../dbconnect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = intval($_POST['user_id']);
    $role = intval($_POST['role']);

    $stmt = $conn->prepare("UPDATE `user` SET role = ? WHERE userID = ?");
    $stmt->bind_param('ii', $role, $user_id);

    if ($stmt->execute()) {
        echo "Rola została zaktualizowana pomyślnie.";
    } else {
        echo "Błąd podczas aktualizacji roli: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
header("Location: role_user.php");
exit;
?>
