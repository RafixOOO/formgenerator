<?php

require_once("../auth.php");

if (!isLoggedIn()) {
    header("Location: ../index.php"); // Redirect to login page if not logged in
    exit;
}

require_once("../dbconnect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST["id"]);
    if (isset($_POST['b'])) {
        $answers = $_POST['b'];
        $apkid = '';
        $type = '';
        $i = 1;
        $points = 0;
        $userid=returniserid();

        // Get the application ID
        $sql1 = "SELECT `applicationID` FROM `readyapplication` WHERE `readyID` = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("i", $id);
        $stmt1->execute();
        $status=2;
        $result1 = $stmt1->get_result();
        if ($row1 = $result1->fetch_assoc()) {
            $apkid = $row1['applicationID'];
        } else {
            // Handle case where readyID does not match any record
            echo "Invalid readyID.";
            exit;
        }
        $stmt1->close();

        // Prepare insert statements
        $insertAnswer10 = $conn->prepare("INSERT INTO `answerconnect`(`readyID`, `questID`, `answer`) VALUES (?, ?, ?)");
        $insertAnswer11 = $conn->prepare("INSERT INTO `answerconnect`(`readyID`, `questID`, `tablerow`, `answer`) VALUES (?, ?, ?, ?)");
        $updateStatus = $conn->prepare("UPDATE `readyapplication` SET `status` = ?, `type` = ? WHERE `readyID` = ?");

        foreach ($answers as $key => $value) {
            if($value=="Nie"){
                $status=4;
            }
            // Get the quest ID and type
            $sql = "SELECT q.`questID`, q.`type` FROM `quest` q JOIN `questconnect` qc ON q.questID = qc.questID WHERE qc.applicationID = ? AND q.quest = ? AND (q.type = 10 OR q.type = 11)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $apkid, $key); // Assuming $key is the quest name or identifier
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $questID = $row['questID'];
                $type = $row['type'];
            } else {
                // Handle case where no matching quest is found
                echo "No matching quest found for value: " . htmlspecialchars($key);
                continue;
            }
            $stmt->close();

            if ($type == 10) {
                // Insert answer for type 10
                $insertAnswer10->bind_param("iis", $id, $questID, $value);
                if ($insertAnswer10->execute()) {
                    echo "Updated type 10 answer.";
                } else {
                    echo "Error updating type 10 answer: " . $insertAnswer10->error;
                }
            } else if ($type == 11) {
                // Insert answer for type 11
                $valueall=$userid.",".$value;
                $insertAnswer11->bind_param("iiis", $id, $questID, $i, $valueall);
                if ($insertAnswer11->execute()) {
                    echo "Updated type 11 answer.";
                    $points += (int)$value; // Accumulate points
                    $i++;
                } else {
                    echo "Error updating type 11 answer: " . $insertAnswer11->error;
                }
            }
        }

        if($_POST['action'] == 'Zatwierdź'){
        // Update status and points for the application
        $updateStatus->bind_param("iii", $status,$points, $id);
        if ($updateStatus->execute()) {
            echo "Updated points and status";
        } else {
            echo "Error updating points and status: " . $updateStatus->error;
        }
    }
        // Close prepared statements
        $insertAnswer10->close();
        $insertAnswer11->close();
        $updateStatus->close();

        // Redirect after processing
         header("Location: tocheck.php");
         exit;
    }
}

?>
