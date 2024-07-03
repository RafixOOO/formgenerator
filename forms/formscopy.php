<?php 

require_once("../auth.php");

if (!isLoggedIn()) {
    header("Location: ../index.php"); // Przekierowanie na stronę po zalogowaniu
    exit;
}

require_once("../dbconnect.php");

if (isset($_GET['ID'])) {
    // Odczytujemy wartość zmiennej
    $id = $_GET['ID'];
    $applicationID = 0;
    $name='';
    $date='';
    $userID = returniserid();

    $sql2 = "SELECT * FROM `application` where `applicationID`=$id";
    $result = $conn->query($sql2);
    while ($row = $result->fetch_assoc()) {
        $name=$row['name'];
        $date=$row['datetimedo'];
    }


    $sql1 = "INSERT INTO `application`(`name`, `userID`, `datetimedo`, `deleted`) VALUES ('$name','$userID','$date','2');";

        if ($conn->query($sql1) === TRUE) {
            $applicationID = $conn->insert_id;
        } else {
            echo "Błąd: " . $sql1 . "<br>" . $conn->error;
        }


    $sql = "INSERT INTO questconnect (`applicationID`, `questID`, `number`, `req`)
            SELECT $applicationID, `questID`, `number`, `req`
            FROM questconnect
            WHERE applicationID = $id";

if ($conn->query($sql) === TRUE) {
    echo "Dane zostały skopiowane pomyślnie.";
} else {
    echo "Błąd: " . $sql . "<br>" . $conn->error;
}
header("Location: forms.php");
exit;
} else {
echo "Nieprawidłowy parametr ID.";
}