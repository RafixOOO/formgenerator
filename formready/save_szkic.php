<?php

require_once("../auth.php");

if (!isLoggedIn()) {
    header("Location: ../index.php"); // Przekierowanie na stronę po zalogowaniu
    exit;
}

require_once("../dbconnect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $applicationID = $_POST['ID'];
    $userID = returniserid();
    $sql='';

    if (isset($_POST['submit_draft'])) {
    $sql = "UPDATE `application`
            SET `name` = ?,
                `userID` = ?,
                `datetime` = CURRENT_DATE,
                `datetimedo` = ?,
                `deleted` = '2'
            WHERE `applicationID` = ?";
} elseif (isset($_POST['submit_publish'])) {
    $sql = "UPDATE `application`
            SET `name` = ?,
                `userID` = ?,
                `datetime` = CURRENT_DATE,
                `datetimedo` = ?,
                `deleted` = '0'
            WHERE `applicationID` = ?";
}

// Przygotowanie i wykonanie zapytania UPDATE
$stmt = $conn->prepare($sql);
$stmt->bind_param("sisi", $name, $userID, $date, $applicationID);

if ($stmt->execute()) {
    echo "Rekord został pomyślnie zaktualizowany.";
} else {
    echo "Błąd: " . $stmt->error;
}

$conn->begin_transaction();

try {
    $stmt->execute();

    // Przygotowanie zapytania usuwającego dane z tabeli questconnect
    $delsql1 = "DELETE FROM questconnect WHERE applicationID = ?;";

    // Przygotowanie i wykonanie zapytania usuwającego questconnect
    $stmt1 = $conn->prepare($delsql1);
    $stmt1->bind_param("i", $applicationID);
    $stmt1->execute();

    // Zatwierdzenie transakcji, jeśli wszystko przebiegło pomyślnie
    $conn->commit();

    echo "Dane zostały pomyślnie usunięte";
} catch (Exception $e) {
    // W przypadku błędu cofnięcie transakcji
    $conn->rollback();
    echo "Błąd: " . $e->getMessage();
}

   $type = "type_";
$req = "required_";
$field = "field_";
$checkbox="checkbox_";
$checkboxrep="checkboxrep_";
$number=1;
$idlastfield='';
$columnCounterValue = $_POST['columnCounterInput'];
echo $columnCounterValue+1;
    $i=0;
    for ($i=0;$i<=$columnCounterValue;$i++) {
        if (isset($_POST[$type . $i])) {

            $typeValue = $_POST[$type . $i];
            $reqvalue =  $_POST[$req . $i];
            if (isset($_POST[$field . $i])) {
            $fieldvalue =  $_POST[$field . $i];
            $checkboxrep=$_POST[$checkboxrep . $i];
            $checkboxspr= $_POST[$checkbox . $i];
            if($checkboxrep==1 && $checkboxspr==1){
                $checkboxvalue=3;
            }
            else if($checkboxrep==1 && $checkboxspr==0){
                $checkboxvalue=2;
            }else if($checkboxrep==0 && $checkboxspr==1){
                $checkboxvalue=1;
            }else{
                $checkboxvalue=0;
            }

        foreach ($fieldvalue as $value) {
                echo $value;
                $sql1 = "INSERT INTO `quest`(`quest`, `type`, `constant`) VALUES ('$value','$typeValue','$checkboxvalue');";
                if ($conn->query($sql1) === TRUE) {
                    $idlastfield = $conn->insert_id;
                }
                else{
                    echo "Błąd: " . $sql . "<br>" . $conn->error;
                }


                $sql2 = "INSERT INTO `questconnect`(`applicationID`, `questID`, `number`, `req`) VALUES ('$applicationID','$idlastfield','$i','$reqvalue');";
                if ($conn->query($sql2) === TRUE) {
                } else {
                                    echo "Błąd: " . $sql . "<br>" . $conn->error;
                                }

            }
        }

    }
}



  header("Location: ../formready/szkic.php");
 exit;   // Zakończenie połączenia z bazą danych

}
?>
