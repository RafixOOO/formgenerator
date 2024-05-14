<?php require_once("../auth.php"); ?>

<?php if (!isLoggedIn()):
    header("Location: ../index.php"); // Przekierowanie na stronę po zalogowaniu
    exit;
endif;

if (isset($_GET['ID'])) {
    // Odczytujemy wartość zmiennej
    $id = $_GET['ID'];
    // Tutaj możesz wykorzystać odczytaną wartość
}
?>
<html>
<head>
    <meta charset="utf-8"/>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/v/bs5/dt-2.0.5/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.5/datatables.min.js"></script>
    <title>Generator | Strona główna</title>
    <style>
        .hidden-row {
            display: none;
        }
    </style>

</head>
<body>
<!-- 2024 Created by: Rafał Pezda-->
<!-- link: https://github.com/RafixOOO -->
<div class="wrapper fadeInDown">
    <form>
        <?php
        require_once("../dbconnect.php");

        $sql = "SELECT qu.questID, qu.quest,qu.type, q.`number`, q.`req` FROM `questconnect` q, `quest` qu, `application` a, readyapplication r WHERE q.applicationID=a.applicationID and q.questID=qu.questID and r.applicationID=a.applicationID and r.readyID=$id order by number;";
        $result = $conn->query($sql);
        $number = 0;
        $columns = array();
        $table_opened = false;
        $req = 0;
        while ($row = $result->fetch_assoc()) {

            if ($row["type"] != 4 and $table_opened) {
                $quest=$row['questID'];
                $sql1 = "SELECT `answerconnectID`,`readyID`, `questID`, `tablerow`, `answer` FROM `answerconnect` WHERE readyID=$id and tablerow is not null order by tablerow, questid;";
                $result1 = $conn->query($sql1);
                $table=0;
                echo '<table class="table"><thead><tr>';
                echo '<th scope="col">#</th>'; // Dodajemy kolumnę numeracji
                foreach ($columns as $column) {
                    echo '<th scope="col">' . $column . '</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                }
                echo '</tr></thead><tbody>';
                $up=0;
                $down=1;
                while ($row1 = $result1->fetch_assoc()) {
                    if($down!=$row["tablerow"]){
                        echo '</tr>';
                        $down=$row["tablerow"];
                    }
                    
                    if($up!=$row["tablerow"]){
                        echo '<tr>';
                        $up=$row["tablerow"];
                    }
                
                echo '<th scope="row">'.$row["tablerow"].'</th>'; // Numeracja wierszy
                    echo '<td><input type="text" class="form-control" name="' . $number . '[]" value="'.$row1["answer"].'" disabled';

                    if ($req == 1) {
                        echo ' required';
                    }

                    echo '

                    ></td>'; // Pole tekstowe w komórkach
                }
                echo '</tbody></table>';

                $table_opened = false;
                unset($columns);
            }

            if ($row["type"] == 3) {
                $quest=$row['questID'];
                $sql1 = "SELECT `answerconnectID`,`readyID`, `questID`, `tablerow`, `answer` FROM `answerconnect` WHERE readyID=$id and questID=$quest";
                $result1 = $conn->query($sql1);
                $selected = 0;
                while ($row1 = $result1->fetch_assoc()) {
                        $selected = $row1["answerconnectID"];
                        break;
                    }
                

                if ($number != $row["number"] and $number != 0) {
                    echo "</p>";
                } else {
                    $number = $row["number"];
                }
                if ($number != $row["number"]) {
                    echo "<p>";
                }
                echo '<div class="form-check">
        <input class="form-check-input" type="radio" name="' . $row["number"] . '" value="' . $row["questID"] . '" disabled';

                if ($row["req"] == 1) {
                    echo ' required';
                }

                if ($selected != '0') {
                    echo ' checked'; // Jeśli pole jest wybrane, dodaj atrybut checked i disabled
                }

                echo '>
        <label class="form-check-label" for="' . $row["number"] . '">
            ' . $row["quest"] . '
        </label>
      </div>';
            } else if ($row["type"] == 2) {
                $quest=$row['questID'];
                $sql1 = "SELECT `answerconnectID`,`readyID`, `questID`, `tablerow`, `answer` FROM `answerconnect` WHERE readyID=$id and questID=$quest";
                $result1 = $conn->query($sql1);
                $selected = 0;
                while ($row1 = $result1->fetch_assoc()) {
                        $selected = $row1["answerconnectID"];
                        break;
                    }
                
                if ($number != $row["number"] and $number != 0) {
                    echo "</p>";
                } else {
                    $number = $row["number"];
                }
                if ($number != $row["number"]) {
                    echo "<p>";
                }
                echo '<div class="form-check">
        <input class="form-check-input" type="checkbox" name="' . $row["number"] . '[]" value="' . $row["questID"] . '" disabled';

                if ($row["req"] == 1) {
                    echo ' required';
                }

                if ($selected != '0') {
                    echo ' checked'; // Jeśli pole jest wybrane, dodaj atrybut checked i disabled
                }

                echo '>
        <label class="form-check-label" for="' . $row["number"] . '">
            ' . $row["quest"] . '
        </label>
      </div>';
            } else if ($row["type"] == 0) {
                if ($number != $row["number"] and $number != 0) {
                    echo "</p>";
                } else {
                    $number = $row["number"];
                }
                if ($number != $row["number"]) {
                    echo "<p>";
                }
                echo $row["quest"];
            } else if ($row["type"] == 1) {
                $quest=$row['questID'];
                $sql1 = "SELECT `answerconnectID`,`readyID`, `questID`, `tablerow`, `answer` FROM `answerconnect` WHERE readyID=$id and questID=$quest";
                $result1 = $conn->query($sql1);
                $selected = 0;
                while ($row1 = $result1->fetch_assoc()) {
                    $selected = $row1["answer"];
                    break;
                }
                if ($number != $row["number"] and $number != 0) {
                    echo "</p>";
                } else {
                    $number = $row["number"];
                }
                if ($number != $row["number"]) {
                    echo "<p>";
                }
                echo '<div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">' . $row["quest"] . '</label>
        <input type="text" class="form-control" name="' . $row["number"] . ' " value="'.$selected.'" disabled';

                if ($row["req"] == 1) {
                    echo ' required';
                }

                echo '>
      </div>';
            } else if ($row["type"] == 4) {
                $req = $row["req"];
                $number = $row["number"];
                $table_opened = true;
                $columns[] = $row["quest"]; // Dodajemy nazwę kolumny do tablicy
            }


        }
        if ($table_opened) {
            $sql1 = "SELECT `answerconnectID`,`readyID`, `questID`, `tablerow`, `answer` FROM `answerconnect` WHERE readyID=$id and tablerow is not null order by tablerow, questid;";
            $result1 = $conn->query($sql1);
            $table=0;
            echo '<table class="table"><thead><tr>';
            echo '<th scope="col">#</th>'; // Dodajemy kolumnę numeracji
                foreach ($columns as $column) {
                    echo '<th scope="col">' . $column . '</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                }
                echo '</tr></thead><tbody>';
                $up=0;
                $down=1;
                while ($row1 = $result1->fetch_assoc()) {
                    if($down!=$row1["tablerow"]){
                        echo '</tr>';
                        $down=$row1["tablerow"];
                    }

                    if($up!=$row1["tablerow"]){
                        echo '<tr>';
                        $up=$row1["tablerow"];
                        echo '<th scope="row">'.$row1["tablerow"].'</th>';
                    }

                 // Numeracja wierszy
                    echo '<td><input type="text" class="form-control" name="' . $number . '[]" value="'.$row1["answer"].'" disabled';

                    if ($req == 1) {
                        echo ' required';
                    }

                    echo '

                    ></td>'; // Pole tekstowe w komórkach
                }
                echo '</tbody></table>';
        }

        ?>
    </form>
    <div style="text-align: right;">
        <a href="../formready/formready.php"><input type="button" value="Wróć" style="background-color: red;"></a>
        </div>
</div>
</body>
</html>