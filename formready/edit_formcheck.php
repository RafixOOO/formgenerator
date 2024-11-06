<?php

require_once("../auth.php");

if (!isLoggedIn()) {
    header("Location: ../index.php"); // Redirect to login page if not logged in
    exit;
}

require_once("../dbconnect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST["id"]);
        $min=$_POST['min1'];
        $max=$_POST['max1'];
        $points = 0;
        $id=$_POST['id'];
        $userid=returniserid();
        $status=2;

        $update = $conn->prepare("UPDATE `answerconnect` SET `answer` = ? WHERE `answerconnectID` = ?");

        for($i=$min;$i<=$max;$i++){
        $answer=$_POST[$i];
        if($answer=='Tak' || $answer=='Nie'){
            if($answer=="Nie"){
                $status=4;
            }
            $update->bind_param("si",$answer, $i);
        if ($update->execute()) {
            echo "Updated answer.";
        } else {
            echo "Error updating answer: " . $update->error;
        }
        }else{
            $answer=$userid.",".$answer;
            $update->bind_param("si", $answer, $i);
        if ($update->execute()) {
            echo "Updated answer.";
            $points += (int)$_POST[$i];
        } else {
            echo "Error updating answer: " . $update->error;
        }
        }
        

    }


        // Prepare insert statements
        $updateStatus = $conn->prepare("UPDATE `readyapplication` SET `status` = ?, `type` = ? WHERE `readyID` = ?");

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
        $updateStatus->close();
        $update->close();

        // Redirect after processing
         header("Location: tocheck.php");
         exit;
}

?>
