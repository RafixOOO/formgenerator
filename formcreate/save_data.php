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
    $userID = returniserid();
    $applicationID='';

    if (isset($_POST['submit_draft'])) {

        $sql = "INSERT INTO `application`(`name`, `userID`, `datetimedo`, `deleted`) VALUES ('$name','$userID','$date','2');";

        if ($conn->query($sql) === TRUE) {
            $applicationID = $conn->insert_id;
        } else {
            echo "Błąd: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['submit_publish'])) {

        $sql = "INSERT INTO `application`(`name`, `userID`, `datetimedo`, `deleted`) VALUES ('$name','$userID','$date','0');";

        if ($conn->query($sql) === TRUE) {
            $applicationID = $conn->insert_id;
        } else {
            echo "Błąd: " . $sql . "<br>" . $conn->error;
        }
    }
   $type = "type_";
$req = "required_";
$field = "field_";
$number=1;
$idlastfield='';
$columnCounterValue = $_POST['columnCounterInput'];
echo $columnCounterValue+1;

    for ($i=0;$i<=$columnCounterValue;++$i) {
        if (isset($_POST[$type . $i])) {
            
            $typeValue = $_POST[$type . $i];
            $reqvalue =  $_POST[$req . $i];
            if (isset($_POST[$field . $i])) {
            $fieldvalue =  $_POST[$field . $i];
            
        foreach ($fieldvalue as $value) {
                echo $value;
                $sql1 = "INSERT INTO `quest`(`quest`, `type`) VALUES ('$value','$typeValue');";
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
    
    

  header("Location: ../forms/forms.php");
  exit;   // Zakończenie połączenia z bazą danych

}
?>
