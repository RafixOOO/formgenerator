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
    <form method="post" action="save_read.php">
        <?php
        require_once("../dbconnect.php");

        $sql = "SELECT qu.questID, qu.quest,qu.type, `number`, `req` FROM `questconnect` q, `quest` qu, `application` a WHERE q.applicationID=a.applicationID and q.questID=qu.questID and a.applicationID=$id order by number,qu.questID; ";
        $result = $conn->query($sql);
        $number = 0;
        $columns = array();
        $table_opened4 = false;
        $table_opened5 = false;
        $table_opened6 = false;
        $table_opened7 = false;
        $req=0;
        while ($row = $result->fetch_assoc()) {

            if ($row["type"] != 4 and $table_opened4) {
                echo '<table class="table m'.$number.'"><thead><tr>';
                echo '<th scope="col">#</th>'; // Dodajemy kolumnę numeracji
                foreach ($columns as $column) {
                    echo '<th scope="col">' . $column . '</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                }
                echo '</tr></thead><tbody>';

                echo '<tr>';
                echo '<th scope="row">1</th>'; // Numeracja wierszy
                foreach ($columns as $column) {
                    echo '<td><input type="text" class="form-control" name="' . $number . '[]"';

                    if ($req == 1) {
                    echo ' required';
                    }

                    echo '

                    ></td>'; // Pole tekstowe w komórkach
                 }
                echo '</tr>';

                // Wygeneruj 10 wierszy z ukrytą klasą
                for ($i = 2; $i <= 20; $i++) {
                    echo '<tr class="hidden-row m'.$number.'">';
                    echo '<th scope="row">' . $i . '</th>'; // Numeracja wierszy
                    foreach ($columns as $column) {
                        echo '<td><input type="text" class="form-control" name="a' . $number . '[]"></td>'; // Pole tekstowe w komórkach
                    }
                    echo '</tr>';
                }

                echo '</tbody></table>';
                echo '<button type="button" id="showMoreRowsBtn_m'.$number.'" class="btn btn-primary show-more-rows-btn">Dodaj wiersz</button>';
                echo '<button type="button" class="btn btn-danger remove-row-btn" data-table-id="m'.$number.'">Usuń wiersz</button>';

                $table_opened4 = false;
                unset($columns);
            } else if($row["type"] != 5 and $table_opened5){
                echo '<table class="table m'.$number.'"><thead><tr>';
                echo '<th scope="col">#</th>'; // Dodajemy kolumnę numeracji
                $count = count($columns)+1;
                for ($i = 0; $i < $count; $i++) {
                    if(($i >= count($columns))){
                        echo '<th scope="col">Wynik</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                    }else{
                        echo '<th scope="col">' . $columns[$i]. '</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                    }


                }
                echo '</tr></thead><tbody>';

                echo '<tr>';
                echo '<th scope="row">1</th>'; // Numeracja wierszy
                $inne=count($columns)-2;
                $inne1=count($columns)-1;
                $random_number = rand(100, 999);
                for ($i = 0; $i < $count; $i++) {
                    if($i>=count($columns)){
                        echo '<td><input id="inputwyn_' . $random_number . '_'.$number.'" type="text" class="form-control" value="" oninput="updateSumByTableClass('.$number.')" ';
                    }else if($i==$inne) {
                   echo '<td><input id="input1_' . $random_number . '_' . $number . '" type="text" class="form-control" name="' . $number . '[]" onchange="addInputs(' . $random_number . ', ' . $number . ')"';
                    } else if($i==$inne1) {
                  echo '<td><input id="input2_' . $random_number . '_' . $number . '" type="text" class="form-control" name="' . $number . '[]" onchange="addInputs(' . $random_number . ', ' . $number . ')"';

                    } else{
                        echo '<td><input type="text" class="form-control" name="' . $number . '[]"';
                    }


                    if ($req == 1) {
                    echo ' required';
                    }

                    echo '

                    ></td>'; // Pole tekstowe w komórkach
                }
                echo '</tr>';
                $i=0;
                // Wygeneruj 10 wierszy z ukrytą klasą
                for ($i = 2; $i <= 20; $i++) {
                    echo '<tr class="hidden-row m'.$number.'">';
                    echo '<th scope="row">' . $i . '</th>'; // Numeracja wierszy
                     $random_number = rand(100, 999);
                     for ($j = 0; $j < $count; $j++) {
                    if($j>=count($columns)){
                        echo '<td><input id="inputwyn_' . $random_number . '_'.$number.'" type="text" class="form-control" value="" value="" onchange="updateSumByTableClass('.$number.')"';
                    }else if($j==$inne) {
                echo '<td><input id="input1_' . $random_number . '_' . $number . '" type="text" class="form-control" name="' . $number . '[]" onchange="addInputs(' . $random_number . ', ' . $number . ')" ';
                    } else if($j==$inne1) {
                  echo '<td><input id="input2_' . $random_number . '_' . $number . '" type="text" class="form-control" name="' . $number . '[]" onchange="addInputs(' . $random_number . ', ' . $number . ')"';

                    } else{
                        echo '<td><input type="text" class="form-control" name="' . $number . '[]"';
                    } echo '

                    ></td>'; // Pole tekstowe w komórkach
                    }
                    echo '</tr>';
                }
                $col=$count;
                echo '</tbody>
                <tfoot><td style="text-align:right;" colspan="'.$col.'">Suma: </td><td ><input style="text-align:right;" id="inputres_'.$number.'" type="text" class="form-control" value="" readonly></td></tfoot>
                </table>';
                echo '<button type="button" id="showMoreRowsBtn_m'.$number.'" class="btn btn-primary show-more-rows-btn">Dodaj wiersz</button>';
                echo '<button type="button" class="btn btn-danger remove-row-btn" data-table-id="m'.$number.'">Usuń wiersz</button>';

                $table_opened5 = false;
                unset($columns);
            }else if($row["type"] != 6 and $table_opened6){
                echo '<table class="table m'.$number.'"><thead><tr>';
                echo '<th scope="col">#</th>'; // Dodajemy kolumnę numeracji
                $count = count($columns)+1;
                for ($i = 0; $i < $count; $i++) {
                    if(($i >= count($columns))){
                        echo '<th scope="col">Wynik</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                    }else{
                        echo '<th scope="col">' . $columns[$i]. '</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                    }


                }
                echo '</tr></thead><tbody>';

                echo '<tr>';
                echo '<th scope="row">1</th>'; // Numeracja wierszy
                $inne=count($columns)-2;
                $inne1=count($columns)-1;
                $random_number = rand(100, 999);
                for ($i = 0; $i < $count; $i++) {
                    if($i>=count($columns)){
                        echo '<td><input id="inputwyn_' . $random_number . '_'.$number.'" type="text" class="form-control" value="" oninput="updateSumByTableClass('.$number.')" ';
                    }else if($i==$inne) {
                   echo '<td><input id="input1_' . $random_number . '_' . $number . '" type="text" class="form-control" name="' . $number . '[]" onchange="delInputs(' . $random_number . ', ' . $number . ')"';
                    } else if($i==$inne1) {
                  echo '<td><input id="input2_' . $random_number . '_' . $number . '" type="text" class="form-control" name="' . $number . '[]" onchange="delInputs(' . $random_number . ', ' . $number . ')"';

                    } else{
                        echo '<td><input type="text" class="form-control" name="' . $number . '[]"';
                    }


                    if ($req == 1) {
                    echo ' required';
                    }

                    echo '

                    ></td>'; // Pole tekstowe w komórkach
                }
                echo '</tr>';
                $i=0;
                // Wygeneruj 10 wierszy z ukrytą klasą
                for ($i = 2; $i <= 20; $i++) {
                    echo '<tr class="hidden-row m'.$number.'">';
                    echo '<th scope="row">' . $i . '</th>'; // Numeracja wierszy
                     $random_number = rand(100, 999);
                     for ($j = 0; $j < $count; $j++) {
                    if($j>=count($columns)){
                        echo '<td><input id="inputwyn_' . $random_number . '_'.$number.'" type="text" class="form-control" value="" value="" onchange="updateSumByTableClass('.$number.')"';
                    }else if($j==$inne) {
                echo '<td><input id="input1_' . $random_number . '_' . $number . '" type="text" class="form-control" name="' . $number . '[]" onchange="delInputs(' . $random_number . ', ' . $number . ')" ';
                    } else if($j==$inne1) {
                  echo '<td><input id="input2_' . $random_number . '_' . $number . '" type="text" class="form-control" name="' . $number . '[]" onchange="delInputs(' . $random_number . ', ' . $number . ')"';

                    } else{
                        echo '<td><input type="text" class="form-control" name="' . $number . '[]"';
                    } echo '

                    ></td>'; // Pole tekstowe w komórkach
                    }
                    echo '</tr>';
                }
                $col=$count;
                echo '</tbody>
                <tfoot><td style="text-align:right;" colspan="'.$col.'">Suma: </td><td ><input style="text-align:right;" id="inputres_'.$number.'" type="text" class="form-control" value="" readonly></td></tfoot>
                </table>';
                echo '<button type="button" id="showMoreRowsBtn_m'.$number.'" class="btn btn-primary show-more-rows-btn">Dodaj wiersz</button>';
                echo '<button type="button" class="btn btn-danger remove-row-btn" data-table-id="m'.$number.'">Usuń wiersz</button>';

                $table_opened6 = false;
                unset($columns);
            }
            else if($row["type"] != 7 and $table_opened7){
                $procent=0;
             $kwota=0;
                            echo '<table class="table m'.$number.'"><thead><tr>';
                                            echo '<th scope="col">#</th>'; // Dodajemy kolumnę numeracji
                                            $count = count($columns);
                                            for ($i = 0; $i < $count; $i++) {
                                                if(($i == 4)){
                                                    $procent= $columns[$i];// Wypisujemy nazwy kolumn z tablicy $columns
                                                }else if($i == 5){
                                                    $kwota=$columns[$i];
                                                }else{
                                                    echo '<th scope="col">' . $columns[$i]. '</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                                                }


                                            }
                                            echo '</tr></thead><tbody>';

                                            echo '<tr>';
                                            echo '<th scope="row">1</th>'; // Numeracja wierszy
                                            $random_number = rand(100, 999);
                                            for ($i = 0; $i < $count-2; $i++) {
                                                if($i==3){
                                                    echo '<td><input id="inputwyn_99_'.$number.'" type="text" class="form-control" value="" oninput="updateSumByTableClass('.$number.')" readonly';
                                                }else if($i==1) {
                                            echo '<td><input id="input1_99_' . $number . '" type="text" class="form-control" name="' . $number . '[]" onchange="delInputs1( 99, ' . $number . ', ' . $kwota . ', ' . $procent . ')"';
                                                } else if($i==2) {
                                            echo '<td><input id="input2_99_' . $number . '" placeholder="Nie więcej niż '.$procent.'% z sumy" type="text" class="form-control" name="' . $number . '[]" onchange="delInputs1( 99, ' . $number . ', ' . $kwota . ', ' . $procent . ')"';

                                                } else if($i==0){
                                                    echo '<td><input type="text" class="form-control" value="Koszta administracyjne" name="' . $number . '[]" readonly';
                                                }else{
                                                    echo '<td><input type="text" class="form-control" name="' . $number . '[]"';

                                                }
                                                if ($req == 1) {
                                                    echo ' required';
                                                    }

                                                    echo '

                                                    ></td>';


                                            }
                                            echo '</tr>';
                                            $i=0;
                                            // Wygeneruj 10 wierszy z ukrytą klasą
                                            for ($i = 2; $i <= 20; $i++) {
                                                echo '<tr class="hidden-row m'.$number.'">';
                                                echo '<th scope="row">' . $i . '</th>'; // Numeracja wierszy
                                                $random_number = rand(100, 999);
                                                for ($j = 0; $j < $count-2; $j++) {
                                                if($j==3){
                                                    echo '<td><input id="inputwyn_' . $random_number . '_'.$number.'" type="text" class="form-control" value="" value="" onchange="updateSumByTableClass('.$number.')" readonly';
                                                }else if($j==1) {
                                            echo '<td><input id="input1_' . $random_number . '_' . $number . '" type="text" class="form-control" name="' . $number . '[]" onchange="delInputs1(' . $random_number . ', ' . $number . ', ' . $kwota . ', ' . $procent . ')" ';
                                                } else if($j==2) {
                                            echo '<td><input id="input2_' . $random_number . '_' . $number . '" type="text" class="form-control" name="' . $number . '[]" onchange="delInputs1(' . $random_number . ', ' . $number . ', ' . $kwota . ', ' . $procent . ')"';

                                                } else{
                                                    echo '<td><input type="text" class="form-control" name="' . $number . '[]"';
                                                } echo '

                                                ></td>'; // Pole tekstowe w komórkach
                                                }
                                                echo '</tr>';
                                            }
                                            echo '</tbody>
                                            <tfoot><td style="text-align: right;" colspan="2">Suma:</td><td><input style="text-align:right;" id="inputres3_'.$number.'" type="text" class="form-control" value="" readonly>
                                                  </td><td><input style="text-align:right;" id="inputres2_'.$number.'" type="text" placeholder="Nie więcej niż '.$kwota.'" class="form-control" value="" readonly></td>
                                                   <td ><input style="text-align:right;" id="inputres1_'.$number.'" type="text" class="form-control" value="" readonly></td></tfoot>
                                            </table>';
                                            echo '<button type="button" id="showMoreRowsBtn_m'.$number.'" class="btn btn-primary show-more-rows-btn">Dodaj wiersz</button>';
                                            echo '<button type="button" class="btn btn-danger remove-row-btn" data-table-id="m'.$number.'">Usuń wiersz</button>';

                                            $table_opened7 = false;
                                            unset($columns);
            }

            if ($row["type"] == 3) {
                if ($number != $row["number"] and $number != 0) {
                    echo "</p>";
                } else {
                    $number = $row["number"];
                }
                if ($number != $row["number"]) {
                    echo "<p>";
                }
                echo '<div class="form-check">
        <input class="form-check-input" type="radio" name="' . $row["number"] . '" value="' . $row["questID"] . '"';

                if ($row["req"] == 1) {
                    echo ' required';
                }

                echo '>
        <label class="form-check-label" for="' . $row["number"] . '">
            ' . $row["quest"] . '
        </label>
      </div>';
            } else if ($row["type"] == 2) {
                if ($number != $row["number"] and $number != 0) {
                    echo "</p>";
                } else {
                    $number = $row["number"];
                }
                if ($number != $row["number"]) {
                    echo "<p>";
                }
                echo '<div class="form-check">
        <input class="form-check-input" type="checkbox" name="' .$row["number"] . '[]" value="' . $row["questID"] . '"';

                if ($row["req"] == 1) {
                    echo ' required';
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
        <input type="text" class="form-control" name="' . $row["number"] . '"';

                if ($row["req"] == 1) {
                    echo ' required';
                }

                echo '>
      </div>';
            } else if ($row["type"] == 4 or $row["type"] == 5 or $row["type"] == 6 or $row["type"] == 7) {
                $req=$row["req"];
                $number=$row["number"];
                if($row["type"]==4){
                    $table_opened4 = true;
                } else if($row["type"]==5){
                    $table_opened5 = true;
                }else if($row["type"]==6){
                    $table_opened6 = true;
                    }else if($row["type"]==7){
                    $table_opened7 = true;
                    }
                $columns[] = $row["quest"]; // Dodajemy nazwę kolumny do tablicy
            }


        }
         if ($table_opened4) {
             echo '<table class="table m'.$number.'"><thead><tr>';
             echo '<th scope="col">#</th>'; // Dodajemy kolumnę numeracji
                foreach ($columns as $column) {
                    echo '<th scope="col">' . $column . '</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                }
                echo '</tr></thead><tbody>';

                echo '<tr>';
                echo '<th scope="row">1</th>'; // Numeracja wierszy
                foreach ($columns as $column) {
                    echo '<td><input type="text" class="form-control" name="' . $number . '[]"';

                    if ($req == 1) {
                        echo ' required';
                    }

                    echo '

                    ></td>'; // Pole tekstowe w komórkach
                }
                echo '</tr>';

                // Wygeneruj 10 wierszy z ukrytą klasą
                for ($i = 2; $i <= 20; $i++) {
                    echo '<tr class="hidden-row m'.$number.'">';
                    echo '<th scope="row">' . $i . '</th>'; // Numeracja wierszy
                    foreach ($columns as $column) {
                        echo '<td><input type="text" class="form-control" name="a' . $number . '[]"></td>'; // Pole tekstowe w komórkach
                    }
                    echo '</tr>';
                }

                echo '</tbody></table>';
                echo '<button type="button" id="showMoreRowsBtn_m'.$number.'" class="btn btn-primary show-more-rows-btn">Dodaj wiersz</button>';
                echo '<button type="button" class="btn btn-danger remove-row-btn" data-table-id="m'.$number.'">Usuń wiersz</button>';

                $table_opened4 = false;
                unset($columns);
         }
         if($table_opened5){
             echo '<table class="table m'.$number.'"><thead><tr>';
             echo '<th scope="col">#</th>'; // Dodajemy kolumnę numeracji
            $count = count($columns)+1;
            for ($i = 0; $i < $count; $i++) {
                if(($i >= count($columns))){
                    echo '<th scope="col">Wynik</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                }else{
                    echo '<th scope="col">' . $columns[$i]. '</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                }


            }
            echo '</tr></thead><tbody>';

            echo '<tr>';
            echo '<th scope="row">1</th>'; // Numeracja wierszy
            $inne=count($columns)-2;
            $inne1=count($columns)-1;
            $random_number = rand(100, 999);
            for ($i = 0; $i < $count; $i++) {
                if($i>=count($columns)){
                    echo '<td><input id="inputwyn_' . $random_number . '_'.$number.'" type="text" class="form-control" value="" value="" onchange="updateSumByTableClass('.$number.')"';
                }else if($i==$inne) {
            echo '<td><input id="input1_' . $random_number . '_' . $number . '" type="text" class="form-control" name="' . $number . '[]" onchange="addInputs(' . $random_number . ', ' . $number . ')"';
                } else if($i==$inne1) {
            echo '<td><input id="input2_' . $random_number . '_' . $number . '" type="text" class="form-control" name="' . $number . '[]" onchange="addInputs(' . $random_number . ', ' . $number . ')"';

                } else{
                    echo '<td><input type="text" class="form-control" name="' . $number . '[]"';
                }


                if ($req == 1) {
                echo ' required';
                }

                echo '

                ></td>'; // Pole tekstowe w komórkach
            }
            echo '</tr>';
            $i=0;
            // Wygeneruj 10 wierszy z ukrytą klasą
            for ($i = 2; $i <= 20; $i++) {
                echo '<tr class="hidden-row m'.$number.'">';
                echo '<th scope="row">' . $i . '</th>'; // Numeracja wierszy
                $random_number = rand(100, 999);
                for ($j = 0; $j < $count; $j++) {
                if($j>=count($columns)){
                    echo '<td><input id="inputwyn_' . $random_number . '_'.$number.'" type="text" class="form-control" value="" onchange="updateSumByTableClass('.$number.')"';
                }else if($j==$inne) {
            echo '<td><input id="input1_' . $random_number . '_' . $number . '" type="text" class="form-control" name="' . $number . '[]" onchange="addInputs(' . $random_number . ', ' . $number . ')"';
                } else if($j==$inne1) {
            echo '<td><input id="input2_' . $random_number . '_' . $number . '" type="text" class="form-control" name="' . $number . '[]" onchange="addInputs(' . $random_number . ', ' . $number . ')"';

                } else{
                    echo '<td><input type="text" class="form-control" name="' . $number . '[]"';
                } echo '

                ></td>'; // Pole tekstowe w komórkach
                }
                echo '</tr>';
            }
            $col=$count;
            echo '</tbody>
            <tfoot><td style="text-align:right;" colspan="'.$col.'">Suma: </td><td ><input style="text-align:right;" id="inputres_'.$number.'" type="text" class="form-control" value="" readonly></td></tfoot>
            </table>';
            echo '<button type="button" id="showMoreRowsBtn_m'.$number.'" class="btn btn-primary show-more-rows-btn">Dodaj wiersz</button>';
            echo '<button type="button" class="btn btn-danger remove-row-btn" data-table-id="m'.$number.'">Usuń wiersz</button>';

            $table_opened5 = false;
            unset($columns);
         }
         if($table_opened6){
                        echo '<table class="table m'.$number.'"><thead><tr>';
                        echo '<th scope="col">#</th>'; // Dodajemy kolumnę numeracji
                        $count = count($columns)+1;
                        for ($i = 0; $i < $count; $i++) {
                            if(($i >= count($columns))){
                                echo '<th scope="col">Wynik</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                            }else{
                                echo '<th scope="col">' . $columns[$i]. '</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                            }


                        }
                        echo '</tr></thead><tbody>';

                        echo '<tr>';
                        echo '<th scope="row">1</th>'; // Numeracja wierszy
                        $inne=count($columns)-2;
                        $inne1=count($columns)-1;
                        $random_number = rand(100, 999);
                        for ($i = 0; $i < $count; $i++) {
                            if($i>=count($columns)){
                                echo '<td><input id="inputwyn_' . $random_number . '_'.$number.'" type="text" class="form-control" value="" oninput="updateSumByTableClass('.$number.')" ';
                            }else if($i==$inne) {
                        echo '<td><input id="input1_' . $random_number . '_' . $number . '" type="text" class="form-control" name="' . $number . '[]" onchange="delInputs(' . $random_number . ', ' . $number . ')"';
                            } else if($i==$inne1) {
                        echo '<td><input id="input2_' . $random_number . '_' . $number . '" type="text" class="form-control" name="' . $number . '[]" onchange="delInputs(' . $random_number . ', ' . $number . ')"';

                            } else{
                                echo '<td><input type="text" class="form-control" name="' . $number . '[]"';
                            }


                            if ($req == 1) {
                            echo ' required';
                            }

                            echo '

                            ></td>'; // Pole tekstowe w komórkach
                        }
                        echo '</tr>';
                        $i=0;
                        // Wygeneruj 10 wierszy z ukrytą klasą
                        for ($i = 2; $i <= 20; $i++) {
                            echo '<tr class="hidden-row m'.$number.'">';
                            echo '<th scope="row">' . $i . '</th>'; // Numeracja wierszy
                            $random_number = rand(100, 999);
                            for ($j = 0; $j < $count; $j++) {
                            if($j>=count($columns)){
                                echo '<td><input id="inputwyn_' . $random_number . '_'.$number.'" type="text" class="form-control" value="" value="" onchange="updateSumByTableClass('.$number.')"';
                            }else if($j==$inne) {
                        echo '<td><input id="input1_' . $random_number . '_' . $number . '" type="text" class="form-control" name="' . $number . '[]" onchange="delInputs(' . $random_number . ', ' . $number . ')" ';
                            } else if($j==$inne1) {
                        echo '<td><input id="input2_' . $random_number . '_' . $number . '" type="text" class="form-control" name="' . $number . '[]" onchange="delInputs(' . $random_number . ', ' . $number . ')"';

                            } else{
                                echo '<td><input type="text" class="form-control" name="' . $number . '[]"';
                            } echo '

                            ></td>'; // Pole tekstowe w komórkach
                            }
                            echo '</tr>';
                        }
                        $col=$count;
                        echo '</tbody>
                        <tfoot><td style="text-align:right;" colspan="'.$col.'">Suma: </td><td ><input style="text-align:right;" id="inputres_'.$number.'" type="text" class="form-control" value="" readonly></td></tfoot>
                        </table>';
                        echo '<button type="button" id="showMoreRowsBtn_m'.$number.'" class="btn btn-primary show-more-rows-btn">Dodaj wiersz</button>';
                        echo '<button type="button" class="btn btn-danger remove-row-btn" data-table-id="m'.$number.'">Usuń wiersz</button>';

                        $table_opened6 = false;
                        unset($columns);
                    }

         if($table_opened7){
             $procent=0;
             $kwota=0;
                            echo '<table class="table m'.$number.'"><thead><tr>';
                                            echo '<th scope="col">#</th>'; // Dodajemy kolumnę numeracji
                                            $count = count($columns);
                                            for ($i = 0; $i < $count; $i++) {
                                                if(($i == 4)){
                                                    $procent= $columns[$i];// Wypisujemy nazwy kolumn z tablicy $columns
                                                }else if($i == 5){
                                                    $kwota=$columns[$i];
                                                }else{
                                                    echo '<th scope="col">' . $columns[$i]. '</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                                                }


                                            }
                                            echo '</tr></thead><tbody>';

                                            echo '<tr>';
                                            echo '<th scope="row">1</th>'; // Numeracja wierszy
                                            $random_number = rand(100, 999);
                                            for ($i = 0; $i < $count-2; $i++) {
                                                if($i==3){
                                                    echo '<td><input id="inputwyn_99_'.$number.'" type="text" class="form-control" value="" oninput="updateSumByTableClass('.$number.')" readonly';
                                                }else if($i==1) {
                                            echo '<td><input id="input1_99_' . $number . '" type="text" class="form-control" name="' . $number . '[]" onchange="delInputs1( 99, ' . $number . ', ' . $kwota . ', ' . $procent . ')"';
                                                } else if($i==2) {
                                            echo '<td><input id="input2_99_' . $number . '" placeholder="Nie więcej niż '.$procent.'% z sumy" type="text" class="form-control" name="' . $number . '[]" onchange="delInputs1( 99, ' . $number . ', ' . $kwota . ', ' . $procent . ')"';

                                                } else if($i==0){
                                                    echo '<td><input type="text" class="form-control" value="Koszta administracyjne" name="' . $number . '[]" readonly';
                                                }else{
                                                    echo '<td><input type="text" class="form-control" name="' . $number . '[]"';

                                                }
                                                if ($req == 1) {
                                                    echo ' required';
                                                    }

                                                    echo '

                                                    ></td>';


                                            }
                                            echo '</tr>';
                                            $i=0;
                                            // Wygeneruj 10 wierszy z ukrytą klasą
                                            for ($i = 2; $i <= 20; $i++) {
                                                echo '<tr class="hidden-row m'.$number.'">';
                                                echo '<th scope="row">' . $i . '</th>'; // Numeracja wierszy
                                                $random_number = rand(100, 999);
                                                for ($j = 0; $j < $count-2; $j++) {
                                                if($j==3){
                                                    echo '<td><input id="inputwyn_' . $random_number . '_'.$number.'" type="text" class="form-control" value="" value="" onchange="updateSumByTableClass('.$number.')" readonly';
                                                }else if($j==1) {
                                            echo '<td><input id="input1_' . $random_number . '_' . $number . '" type="text" class="form-control" name="' . $number . '[]" onchange="delInputs1(' . $random_number . ', ' . $number . ', ' . $kwota . ', ' . $procent . ')" ';
                                                } else if($j==2) {
                                            echo '<td><input id="input2_' . $random_number . '_' . $number . '" type="text" class="form-control" name="' . $number . '[]" onchange="delInputs1(' . $random_number . ', ' . $number . ', ' . $kwota . ', ' . $procent . ')"';

                                                } else{
                                                    echo '<td><input type="text" class="form-control" name="' . $number . '[]"';
                                                } echo '

                                                ></td>'; // Pole tekstowe w komórkach
                                                }
                                                echo '</tr>';
                                            }
                                            echo '</tbody>
                                            <tfoot><td style="text-align: right;" colspan="2">Suma:</td><td><input style="text-align:right;" id="inputres3_'.$number.'" type="text" class="form-control" value="" readonly>
                                                  </td><td><input style="text-align:right;" id="inputres2_'.$number.'" placeholder="Nie więcej niż '.$kwota.'" type="text" class="form-control" value="" readonly></td>
                                                   <td ><input style="text-align:right;" id="inputres1_'.$number.'" type="text" class="form-control" value="" readonly></td></tfoot>
                                            </table>';
                                            echo '<button type="button" id="showMoreRowsBtn_m'.$number.'" class="btn btn-primary show-more-rows-btn">Dodaj wiersz</button>';
                                            echo '<button type="button" class="btn btn-danger remove-row-btn" data-table-id="m'.$number.'">Usuń wiersz</button>';

                                            $table_opened7 = false;
                                            unset($columns);
         }
         echo "<input type='hidden' name='id' value='".$id."' >";
         echo "<input type='hidden' name='number' value='".$number."' >"
        ?>


        <div style="text-align: right;">
            <a href="../forms/forms.php"><input type="button" value="Anuluj" style="background-color: red;"></a>
            <input type="submit" name="submit_publish" value="Wyślij">
        </div>
    </form>
</div>
</body>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    var showMoreRowsBtns = document.querySelectorAll('.show-more-rows-btn');
    showMoreRowsBtns.forEach(function(btn) {
        var tableId = btn.getAttribute('id').split('_').pop(); // Pobierz numer ID tabeli
        var showMoreRowsBtn = document.getElementById('showMoreRowsBtn_' + tableId);
        var removeRowBtns = document.querySelectorAll('.remove-row-btn[data-table-id="' + tableId + '"]');
        var hiddenRows = document.querySelectorAll('.hidden-row.' + tableId);
        var currentIndex = 0; // Zmienna do śledzenia bieżącego indeksu ukrytego wiersza

        // Funkcja do pokazywania ukrytego wiersza
        function showNextHiddenRow() {
            if (currentIndex < hiddenRows.length) {
                hiddenRows[currentIndex].style.display = 'table-row';
                currentIndex++;
                if (currentIndex >= hiddenRows.length) {
                    showMoreRowsBtn.style.display = 'none'; // Ukryj przycisk, jeśli pokazano wszystkie wiersze
                }
            }
        }

        // Po kliknięciu przycisku pokaż więcej wierszy
        showMoreRowsBtn.addEventListener('click', function() {
            showNextHiddenRow();

            // Pobierz referencję do nowo dodanego wiersza
            var newlyAddedRow = hiddenRows[currentIndex - 1];

            // Zmiana nazwy inputów w dodanym wierszu
            var inputs = newlyAddedRow.querySelectorAll('input[type="text"]');
            inputs.forEach(function(input) {
                var currentName = input.getAttribute('name');
                var newName = currentName.substring(1); // Usuń pierwszą literę 'a'
                input.setAttribute('name', newName);
            });
        });

        // Dodaj obsługę kliknięcia przycisku usuwania wiersza
        removeRowBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                if(currentIndex <= 10) {
                    showMoreRowsBtn.style.display = '';
                }
                if(currentIndex !== 0) {
                    --currentIndex;
                    hiddenRows[currentIndex].style.display = 'none';

                    // Zmiana nazwy inputów w usuwanym wierszu
                    var inputs = hiddenRows[currentIndex].querySelectorAll('input[type="text"]');
                    inputs.forEach(function(input) {
                        var currentName = input.getAttribute('name');
                        var newName = 'a' + currentName; // Dodaj literkę 'a' na początku
                        input.setAttribute('name', newName);
                    });
                }
            });
        });
    });
});


</script>

    <script>
function addInputs(index, number) {
    // Pobierz wartości z obu pól tekstowych
    var input1Value = parseFloat(document.getElementById("input1_" + index + "_" + number).value);
    var input2Value = parseFloat(document.getElementById("input2_" + index + "_" + number).value);

    // Upewnij się, że wartości są liczbami, a nie NaN
    if (!isNaN(input1Value) && !isNaN(input2Value)) {
        // Dodaj wartość z input1 do wartości w input2
        var result = input1Value + input2Value;
        // Ustaw wynik jako wartość pola tekstowego wynikowego
        document.getElementById("inputwyn_" + index + "_" + number).value = result;
        updateSumByTableClass(number);
    }
}

    function delInputs(index, number, kwota, procent) {
        // Pobierz wartości z obu pól tekstowych
        var input1Value = parseFloat(document.getElementById("input1_" + index + "_" + number).value);
        var input2Value = parseFloat(document.getElementById("input2_" + index + "_" + number).value);

        // Upewnij się, że wartości są liczbami, a nie NaN
        if (!isNaN(input1Value) && !isNaN(input2Value)) {
            // Dodaj wartość z input1 do wartości w input2
            var result = input1Value - input2Value;
            // Ustaw wynik jako wartość pola tekstowego wynikowego
            document.getElementById("inputwyn_" + index + "_" + number).value = result;
        }
    }

        function delInputs1(index, number, kwota, procent) {
            // Pobierz wartości z obu pól tekstowych
            var input1Value = parseFloat(document.getElementById("input1_" + index + "_" + number).value);
            var input2Value = parseFloat(document.getElementById("input2_" + index + "_" + number).value);

            // Upewnij się, że wartości są liczbami, a nie NaN
            if (!isNaN(input1Value) && !isNaN(input2Value)) {
                // Dodaj wartość z input1 do wartości w input2
                var result = input1Value - input2Value;
                // Ustaw wynik jako wartość pola tekstowego wynikowego
                document.getElementById("inputwyn_" + index + "_" + number).value = result;
                updateSumByTableClass(number);
                updateSumByTableClass1(number);
                updateSumByTableClass2(number);
                checkkwota(kwota, number);
                checksum(procent, number);
            }
        }

    function updateSumByTableClass(index) {
        // Pobierz wszystkie pola inputwyn w tabeli o podanej klasie
        var inputwynFields = document.querySelectorAll('.table.m' + index + ' input[id^="inputwyn_"]');
        var totalSum = 0;

        // Iteruj przez wszystkie pola inputwyn i sumuj ich wartości
        inputwynFields.forEach(function(inputwynField) {
            var value = parseFloat(inputwynField.value);
            if (!isNaN(value)) {
                totalSum += value;
            }
        });

        // Ustaw sumę w inpucie na dole
        document.getElementById('inputres1_' + index).value = totalSum;
    }

    function updateSumByTableClass1(index) {
        // Pobierz wszystkie pola inputwyn w tabeli o podanej klasie
        var inputwynFields = document.querySelectorAll('.table.m' + index + ' input[id^="input1_"]');
        var totalSum = 0;

        // Iteruj przez wszystkie pola inputwyn i sumuj ich wartości
        inputwynFields.forEach(function(inputwynField) {
            var value = parseFloat(inputwynField.value);
            if (!isNaN(value)) {
                totalSum += value;
            }
        });

        // Ustaw sumę w inpucie na dole
        document.getElementById('inputres3_' + index).value = totalSum;
    }
    function updateSumByTableClass2(index) {
        // Pobierz wszystkie pola inputwyn w tabeli o podanej klasie
        var inputwynFields = document.querySelectorAll('.table.m' + index + ' input[id^="input2_"]');
        var totalSum = 0;

        // Iteruj przez wszystkie pola inputwyn i sumuj ich wartości
        inputwynFields.forEach(function(inputwynField) {
            var value = parseFloat(inputwynField.value);
            if (!isNaN(value)) {
                totalSum += value;
            }
        });

        // Ustaw sumę w inpucie na dole
        document.getElementById('inputres2_' + index).value = totalSum;
    }

    function checkkwota(kwota, index) {
        var input = document.getElementById('inputres2_' + index);
        var value=parseFloat(input.value);

        if (value > kwota) {
            // Jeśli wartość jest większa niż kwota, ustaw kolor tła na czerwono
            input.style.backgroundColor = 'red';
        } else {
            // W przeciwnym razie ustaw kolor tła na biało
            input.style.backgroundColor = '';
        }
    }

    function checksum(procent, number) {
        var input1 = parseFloat(document.getElementById("input2_99_" + number).value);
        var input2 = parseFloat(document.getElementById('inputres2_' + number).value);
        var inputField1 = document.getElementById("input2_99_" + number);
            var result = input1 / input2 * 100;
            // Sprawdzenie, czy wynik dzielenia jest większy od procent
            if (result > procent) {
                inputField1.style.backgroundColor = 'red';
            } else {
                inputField1.style.backgroundColor = '';
            }

    }
</script>

</html>