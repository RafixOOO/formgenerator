<?php

require_once("../auth.php");

if (!isLoggedIn()) {
    header("Location: ../index.php"); // Przekierowanie na stronę po zalogowaniu
    exit;
}

require_once("../dbconnect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = returniserid();
    $idapp = $_POST['id'];
    $number = $_POST['number1'];
    $readyID = 0;

    $sqlcheck="select * from readyapplication where userID=$userID and applicationId=$idapp and status=0;";
    $result = $conn->query($sqlcheck);

    if ($result->num_rows > 0) {
        // Jeśli są wiersze, przekierowanie na inną stronę
        header("Location: forms.php");
        exit;
    }
    

    $sql = "INSERT INTO readyapplication (userID, applicationID, status, type) VALUES (?, ?, '0', '0')";

    // Przygotowanie zapytania
    $stmt = $conn->prepare($sql);

    // Sprawdzenie, czy zapytanie zostało poprawnie przygotowane
    if ($stmt) {
        // Wiązanie parametrów
        $stmt->bind_param("ii", $userID, $idapp);

        // Wykonanie zapytania
        if ($stmt->execute()) {
            $readyID = $conn->insert_id;
        } else {
            // Błąd podczas wykonywania zapytania
            echo "Error: " . $conn->error;
        }

        // Zamknięcie prepared statement
        $stmt->close();
    } else {
        // Błąd podczas przygotowywania zapytania
        echo "Error: " . $conn->error;
    }

    for ($i = 1; $i <= $number; $i++) {
        $sel = "SELECT qu.questID, qu.number, q.type FROM `questconnect` qu, quest q WHERE qu.questID=q.questID and qu.applicationID=$idapp and qu.number=$i ORDER BY qu.questID;";
        $result = $conn->query($sel);
        while ($row = $result->fetch_assoc()) {
            if ($row['type'] == 1 or $row['type'] == 9) { // Używamy operatora porównania '=='
                $fieldvalue = $_POST['' . $i];
                if ($fieldvalue != '') {
                    $quest = $row['questID'];
                    // Używamy zapytania przygotowanego, aby zabezpieczyć się przed SQL Injection
                    $ins = "INSERT INTO `answerconnect`(`readyID`, `questID`, `answer`) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($ins);
                    if (!$stmt) {
                        // Obsługa błędów
                        echo "Błąd przy przygotowywaniu zapytania: " . $conn->error;
                    } else {
                        // Przypisanie wartości do zapytania
                        $stmt->bind_param("iis", $readyID, $quest, $fieldvalue);
                        // Wykonanie zapytania
                        $stmt->execute();
                        if ($stmt->affected_rows === 0) {
                            // Obsługa błędów
                            echo "Błąd podczas wykonywania zapytania: " . $stmt->error;
                        }
                        // Zamknięcie zapytania
                        $stmt->close();
                    }
                    $pause = false;
                    $pause1 = false;
                }
            } else if ($row['type'] == 3) {
                $fieldvalue = $_POST['' . $i];
                if ($fieldvalue != '') {
                    $ins = "INSERT INTO `answerconnect`(`readyID`, `questID`) VALUES (?, ?)";
                    $stmt = $conn->prepare($ins);
                    if (!$stmt) {
                        // Obsługa błędów
                        echo "Błąd przy przygotowywaniu zapytania: " . $conn->error;
                    } else {
                        // Przypisanie wartości do zapytania
                        $stmt->bind_param("ii", $readyID, $fieldvalue);
                        // Wykonanie zapytania
                        $stmt->execute();
                        if ($stmt->affected_rows === 0) {
                            // Obsługa błędów
                            echo "Błąd podczas wykonywania zapytania: " . $stmt->error;
                        }
                        // Zamknięcie zapytania
                        $stmt->close();
                    }
                }
                break;
            } else if ($row['type'] == 2) {
                $fieldvalue = $_POST['' . $i];
                foreach ($fieldvalue as $value) {
                    if ($value != '') {
                        $ins = "INSERT INTO `answerconnect`(`readyID`, `questID`) VALUES (?, ?)";
                        $stmt = $conn->prepare($ins);
                        if (!$stmt) {
                            // Obsługa błędów
                            echo "Błąd przy przygotowywaniu zapytania: " . $conn->error;
                        } else {
                            // Przypisanie wartości do zapytania
                            $stmt->bind_param("ii", $readyID, $value);
                            // Wykonanie zapytania
                            $stmt->execute();
                            if ($stmt->affected_rows === 0) {
                                // Obsługa błędów
                                echo "Błąd podczas wykonywania zapytania: " . $stmt->error;
                            }
                            // Zamknięcie zapytania
                            $stmt->close();
                        }
                    }

                }
                break;

            } else if ($row['type'] == 4 or $row['type'] == 5 or $row['type'] == 6 or $row['type'] == 7 or $row['type'] == 8 or $row['type'] == 12) {
                $type=$row['type'];
                $fieldvalue = $_POST['' . $i];
                $count = 0;
                $min = 0;
                $sel = "Select CASE 
        WHEN q.type = 7 THEN COUNT(*) - 2
        ELSE COUNT(*)
    END AS record_count, min(qu.questID) as minquest FROM `questconnect` qu, quest q WHERE qu.questID=q.questID AND qu.applicationID=$idapp AND qu.number=$i;";
                $result = $conn->query($sel);
                while ($row = $result->fetch_assoc()) {
                    $count = $row["record_count"];
                    $min = $row["minquest"];
                    $j = 1;
                    $quest1 = $min;
                    $k = 1;
                }
                foreach ($fieldvalue as $value) {

                    if ($k > $count) {
                        $k = 1;
                        $j++;
                        $quest1 = $min;
                    }

                    if ($value != '' and $type != 12) {
                        $ins = "INSERT INTO `answerconnect`(`readyID`, `questID`, `answer`,`tablerow`) VALUES (?,?,?,?)";
                        $stmt = $conn->prepare($ins);
                        if (!$stmt) {
                            // Obsługa błędów
                            echo "Błąd przy przygotowywaniu zapytania: " . $conn->error;
                        } else {
                            // Przypisanie wartości do zapytania
                            $stmt->bind_param("iisi", $readyID, $quest1, $value, $j);
                            // Wykonanie zapytania
                            $stmt->execute();
                            if ($stmt->affected_rows === 0) {
                                // Obsługa błędów
                                echo "Błąd podczas wykonywania zapytania: " . $stmt->error;
                            }
                            // Zamknięcie zapytania
                            $stmt->close();
                        }
                    } else if ($value != '' and $type == 12) {
                        $ins = "INSERT INTO `answerconnect`(`readyID`, `questID`, `answer`) VALUES (?,?,?)";
                        $stmt = $conn->prepare($ins);
                        if (!$stmt) {
                            // Obsługa błędów
                            echo "Błąd przy przygotowywaniu zapytania: " . $conn->error;
                        } else {
                            // Przypisanie wartości do zapytania
                            $stmt->bind_param("iis", $readyID, $quest1, $value);
                            // Wykonanie zapytania
                            $stmt->execute();
                            if ($stmt->affected_rows === 0) {
                                // Obsługa błędów
                                echo "Błąd podczas wykonywania zapytania: " . $stmt->error;
                            }
                            // Zamknięcie zapytania
                            $stmt->close();
                        }
                    }
                    $k++;
                    $quest1++;


                }
                break;

            }

        }


    }

    header("Location: forms.php");
    exit;

}


