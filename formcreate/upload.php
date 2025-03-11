<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $uploadDir = '../img/'; // Folder docelowy
    $fileTmpPath = $_FILES['image']['tmp_name'];
    $fileName = $_FILES['image']['name'];

    // Generowanie unikalnej nazwy pliku
    $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
    $newFileName = uniqid("img_", true) . "." . $fileExt;
    $destPath = $uploadDir . $newFileName;

    // Przenoszenie pliku do katalogu ../img/
    if (move_uploaded_file($fileTmpPath, $destPath)) {
        echo json_encode(["success" => true, "imageUrl" => $destPath]);
    } else {
        echo json_encode(["success" => false, "message" => "Błąd zapisu pliku."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Nieprawidłowe żądanie."]);
}
?>
