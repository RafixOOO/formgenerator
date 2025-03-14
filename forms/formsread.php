<?php require_once("../auth.php"); ?>

<?php if (!isLoggedIn()):
    header("Location: ../index.php"); // Przekierowanie na stronę po zalogowaniu
    exit;
endif;

if (isset($_GET['ID'])) {
    // Odczytujemy wartość zmiennej
    $id = $_GET['ID'];
    $finish = $_GET['finish'];
    // Tutaj możesz wykorzystać odczytaną wartość
}
if (isLoggedIn()) {
    // Pobierz ID zalogowanego użytkownika
    $userId = $_SESSION['user_id'];

    // Ustaw ciasteczko user_id w przeglądarce
}
?>
<!DOCTYPE html>
<html lang="PL">
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
    <link rel="icon" href="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEAAAAALAAAAAABAAEAAAIA" type="image/gif">
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <style>
        .hidden-row {
            display: none;
        }

    .auto-resize {
      overflow: hidden;
      resize: none;
      box-sizing: border-box;
      width: 100%; /* Szerokość textarea, dostosuj w razie potrzeby */
      min-height: calc(1.5em + 0.75rem + 2px); /* Dostosowanie minimalnej wysokości, aby pasowała do input */
      padding: 0.375rem 0.75rem;
      font-size: 1rem;
      line-height: 1.5;
      border: 1px solid #ced4da;
      border-radius: 0.25rem;
    }
    </style>
    <!-- Toastr -->
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>
<body>
<!-- 2024 Created by: Rafał Pezda-->
<!-- link: https://github.com/RafixOOO -->
<div class="wrapper fadeInDown">
    <form method="post" action="save_read.php">
        <?php
        require_once("../dbconnect.php");

        $sql1 = "SELECT `name` FROM `application` WHERE`applicationID`=$id and `deleted`!=1 AND `datetimedo`>CURRENT_DATE";
        $result1 = $conn->query($sql1);

        while ($row = $result1->fetch_assoc()) {
            $imagePath = '../img/' . $row['name'] . '.png';
    if (file_exists($imagePath)) {
        echo '<img class="img-fluid" src="' . $imagePath . '" alt="' . $row['name'] . '">';
    }
        }


        $sql = "SELECT qu.questID, qu.quest,qu.type, `number`, `req` FROM `questconnect` q, `quest` qu, `application` a WHERE q.applicationID=a.applicationID and q.questID=qu.questID and a.applicationID=$id and (qu.constant=0 or qu.constant=2 or qu.constant=3) order by number,qu.questID; ";
        $result = $conn->query($sql);
        $number = 0;
        $gpup=1;
        $gpdown=0;
        $columns = array();
        $table_opened4 = false;
        $table_opened5 = false;
        $table_opened6 = false;
        $table_opened7 = false;
        $req = 0;
        while ($row = $result->fetch_assoc()) {

            if ($row["type"] == 8) {
                if ($number != $row["number"] and $number != 0) {
                    echo "</p>";
                }
                if ($number != $row["number"]) {
                    echo "<p>";
                    $number = $row["number"];
                }
                $userid = returniserid();
                $sqldata = 'SELECT name, surname, email, phone FROM `user` where userID=' . $userid . '';
                $result2 = $conn->query($sqldata);
                while ($row2 = $result2->fetch_assoc()) {
                    echo '<div class="mb-3" style="float:left;">
             <label for="exampleFormControlInput1" class="form-label">Imię</label>
             <input type="text" class="form-control" name="' . $row["number"] . '[]" value="' . $row2['name'] . '" readonly';

                    if ($row["req"] == 1) {
                        echo ' required';
                    }

                    echo '>
           </div> ';
                    echo '<div class="mb-3" style="float:left; margin-left:2%;">
             <label for="exampleFormControlInput1" class="form-label">Nazwisko</label>
             <input type="text" class="form-control" name="' . $row["number"] . '[]" value="' . $row2['surname'] . '"readonly';

                    if ($row["req"] == 1) {
                        echo ' required';
                    }

                    echo '>
           </div><div style="clear:both;"></div>';
                    echo '<div class="mb-3" style="float:left">
             <label for="exampleFormControlInput1" class="form-label">Email</label>
             <input type="text" class="form-control" name="' . $row["number"] . '[]" value="' . $row2['email'] . '"readonly';

                    if ($row["req"] == 1) {
                        echo ' required';
                    }

                    echo '>
           </div>';
                    echo '<div class="mb-3" style="float:left; margin-left:2%;"">
             <label for="exampleFormControlInput1" class="form-label">Telefon</label>
             <input type="text" class="form-control" name="' . $row["number"] . '[]" value="' . $row2['phone'] . '"readonly';

                    if ($row["req"] == 1) {
                        echo ' required';
                    }

                    echo '>
           </div><div style="clear:both;"></div>';
                }

            }

            if ($row["type"] == 9) {

                if ($number != $row["number"] and $number != 0) {
                    echo "</p>";
                }
                if ($number != $row["number"]) {
                    echo "<p>";
                    $number = $row["number"];
                }
                $userid = returniserid();
                echo '<label for="exampleFormControlInput1" class="form-label">Organizacja</label>';
                $sqldata = 'SELECT o.name, o.OrganizationID FROM `organizationdata` o, organizationconnect oc where o.OrganizationID=oc.OrganizationID and oc.UserID=' . $userid . ' and oc.accept=1 and o.accept=1 ;';
                $result2 = $conn->query($sqldata);
                echo '<select class="form-select form-select-lg mb-3" name="' . $row["number"] . '">';
                echo "<option value='0'>Brak</option>";
                while ($row2 = $result2->fetch_assoc()) {

                    echo "<option value='" . $row2['OrganizationID'] . "'>" . $row2['name'] . " #" . $row2['OrganizationID'] . "</option>";

                }
                echo "</select>";

            }

            if ($row["type"] != 4 and $table_opened4) {
                echo '<table class="table m' . $number . '"><thead><tr>';
                $count = count($columns);
                for ($i = 0; $i < $count; $i++) {
                    $parts = explode("@=", $columns[$i]);
                        echo '<th scope="col">' . $parts[0] . '</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
    
    
                }
                echo '</tr></thead><tbody>';

                $maxi=0;
            for ($i = 0; $i < $count; $i++) {
                $parts = explode("@=", $columns[$i]);
                $length = count($parts);
                if($length>$maxi){
                    $maxi=$length;
                }
            }
            $k=0;
            for ($i = 1; $i < $maxi; $i++) {
                echo '<tr>';
                for($k=0;$k<$count;$k++){
                    $parts = explode("@=", $columns[$k]);
                    $value = $parts[$i] ?? '';
                    $disabled = ($value !== '') ? 'readonly' : '';
                echo '<td><input type="text" class="form-control" name="' . $number . '[]" value="'.$value.'" '.$disabled.'';

                if ($req == 1) {
                    echo ' required';
                }

                echo '

                ></td>'; // Pole tekstowe w komórkach
            }
            echo '</tr>';
            }

                // Wygeneruj 10 wierszy z ukrytą klasą
                for ($i = 2; $i <= 20; $i++) {
                    echo '<tr class="hidden-row m' . $number . '">';
                    foreach ($columns as $column) {
                        echo '<td><input type="text" class="form-control" name="a' . $number . '[]"></td>'; // Pole tekstowe w komórkach
                    }
                    echo '</tr>';
                }

                echo '</tbody></table>';
                echo '<button type="button" id="showMoreRowsBtn_m' . $number . '" class="btn btn-primary show-more-rows-btn">Dodaj wiersz</button>';
                echo '<button type="button" class="btn btn-danger remove-row-btn" data-table-id="m' . $number . '">Usuń wiersz</button>';

                $table_opened4 = false;
                unset($columns);
            } else if ($row["type"] != 5 and $table_opened5) {
                echo '<table class="table m' . $number . '"><thead><tr>';
            $count = count($columns);
        for ($i = 0; $i < $count; $i++) {
            $parts = explode("@=", $columns[$i]);
                echo '<th scope="col">' . $parts[0] . '</th>'; // Wypisujemy nazwy kolumn z tablicy $columns


        }
            echo '</tr></thead><tbody>';

            
            $inne = count($columns) - 2;
            $inne1 = count($columns) - 1;
            $random_number = rand(100, 999);
            $maxi=0;
            for ($i = 0; $i < $count; $i++) {
                $parts = explode("@=", $columns[$i]);
                $length = count($parts);
                if($length>$maxi){
                    $maxi=$length;
                }
            }
            $k=0;
            for ($i = 1; $i < $maxi; $i++) {
                echo '<tr>';
                for($k=0;$k<$count;$k++){
                    $parts = explode("@=", $columns[$k]);
                    $value = $parts[$i] ?? '';
                    $disabled = ($value !== '') ? 'readonly' : '';
                    if ($k == count($columns)-1) {
                        echo '<td><input id="inputwyn_' . $random_number . '_' . $number . '" type="text" class="form-control" value="' . htmlspecialchars($value, ENT_QUOTES) . '" onchange="updateSumByTableClass4(' . $number . ')" name="' . $number . '[]" ' . $disabled . '';
                        if ($req == 1) {
                            echo ' required';
                        }
        
                        echo '
        
                        ></td>';
                    } else {
                        echo '<td><input type="text" class="form-control" name="' . $number . '[]" value="' . htmlspecialchars($value, ENT_QUOTES) . '" ' . $disabled . '';
                        if ($req == 1) {
                            echo ' required';
                        }
        
                        echo '
        
                        ></td>';
                    }
                }
                echo '</tr>';
               



                 // Pole tekstowe w komórkach
            }
                $i = 0;
                // Wygeneruj 10 wierszy z ukrytą klasą
                for ($i = 2; $i <= 20; $i++) {
                    echo '<tr class="hidden-row m' . $number . '">';
                    $random_number = rand(100, 999);
                    for ($j = 0; $j < $count; $j++) {
                        if ($i == count($columns)-1) {
                            echo '<td><input id="inputwyn_' . $random_number . '_' . $number . '" type="text" class="form-control" value="" onchange="updateSumByTableClass4(' . $number . ')" name="a' . $number . '[]"';
    
                        } else {
                            echo '<td><input type="text" class="form-control" name="a' . $number . '[]"';
                        }
                        echo '

                    ></td>'; // Pole tekstowe w komórkach
                    }
                    echo '</tr>';
                }
                $col = $count-1;
                echo '</tbody>
            <tfoot><td style="text-align:right;" colspan="' . $col . '">Suma: </td><td ><input style="text-align:right;" id="inputres_' . $number . '" type="text" class="form-control" value="" readonly></td></tfoot>
            </table>';
                echo '<button type="button" id="showMoreRowsBtn_m' . $number . '" class="btn btn-primary show-more-rows-btn">Dodaj wiersz</button>';
                echo '<button type="button" class="btn btn-danger remove-row-btn" data-table-id="m' . $number . '">Usuń wiersz</button>';

                $table_opened5 = false;
                unset($columns);
            } else if ($row["type"] != 6 and $table_opened6) {
                echo '<table class="table m' . $number . '"><thead><tr>';
            $count = count($columns) + 1;
            for ($i = 0; $i < $count; $i++) {
                if (($i < count($columns))) {
                    $parts = explode("@=", $columns[$i]);
                }     
                if (($i >= count($columns))) {
                    echo '<th scope="col">Wynik</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                } else {
                    echo '<th scope="col">' . $parts[0] . '</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                }
            }
            echo '</tr></thead><tbody>';

            $inne = count($columns) - 2;
            $inne1 = count($columns) - 1;
            $random_number = rand(100, 999);
            $maxi=0;
            for ($i = 0; $i < $count-1; $i++) {
                $parts = explode("@=", $columns[$i]);
                $length = count($parts);
                if($length>$maxi){
                    $maxi=$length;
                }
            }
            for ($i = 1; $i < $maxi; $i++) {
                echo '<tr>';
                $random_number = rand(100, 999);
                for($k=0;$k<$count;$k++){
                    if ($k < count($columns)) {
                    $parts = explode("@=", $columns[$k]);
                    $value = $parts[$i] ?? '';
                    $disabled = ($value !== '') ? 'readonly' : '';
                    
                    }
                if ($k >= count($columns)) {
                    echo '<td><input id="inputwyn_' . $random_number . '_' . $number . '" type="text" class="form-control" value="" oninput="updateSumByTableClass(' . $number . ')" ';
                } else if ($k == $inne) {
                    echo '<td><input id="input1_' . $random_number . '_' . $number . '" type="text" value="'.$value.'" class="form-control" name="' . $number . '[]" onchange="delInputs(' . $random_number . ', ' . $number . ')"';
                } else if ($k == $inne1) {
                    echo '<td><input id="input2_' . $random_number . '_' . $number . '" type="text" value="'.$value.'" class="form-control" name="' . $number . '[]" onchange="delInputs(' . $random_number . ', ' . $number . ')"';
                } else {
                    echo '<td><input type="text" class="form-control" value="'.$value.'" name="' . $number . '[]"';
                }


                if ($req == 1) {
                    echo ' required';
                }

                echo '

                       '.$disabled.' ></td>'; // Pole tekstowe w komórkach
            }
            echo '</tr>';
            }
                $i = 0;
                // Wygeneruj 10 wierszy z ukrytą klasą
                for ($i = 2; $i <= 20; $i++) {
                    echo '<tr class="hidden-row m' . $number . '">';
                    $random_number = rand(100, 999);
                    for ($j = 0; $j < $count; $j++) {
                        if ($j >= count($columns)) {
                            echo '<td><input id="inputwyn_' . $random_number . '_' . $number . '" type="text" class="form-control" value="" value="" onchange="updateSumByTableClass(' . $number . ')"';
                        } else if ($j == $inne) {
                            echo '<td><input id="input1_' . $random_number . '_' . $number . '" type="text" class="form-control" name="a' . $number . '[]" onchange="delInputs(' . $random_number . ', ' . $number . ')" ';
                        } else if ($j == $inne1) {
                            echo '<td><input id="input2_' . $random_number . '_' . $number . '" type="text" class="form-control" name="a' . $number . '[]" onchange="delInputs(' . $random_number . ', ' . $number . ')"';
                        } else {
                            echo '<td><input type="text" class="form-control" name="a' . $number . '[]"';
                        }
                        echo '

                ></td>'; // Pole tekstowe w komórkach
                    }
                    echo '</tr>';
                }
                $col = $count-1;
                echo '</tbody>
            <tfoot><td style="text-align:right;" colspan="' . $col . '">Suma: </td><td ><input style="text-align:right;" id="inputres_' . $number . '" type="text" class="form-control" value="" readonly></td></tfoot>
            </table>';
                echo '<button type="button" id="showMoreRowsBtn_m' . $number . '" class="btn btn-primary show-more-rows-btn">Dodaj wiersz</button>';
                echo '<button type="button" class="btn btn-danger remove-row-btn" data-table-id="m' . $number . '">Usuń wiersz</button>';

                $table_opened6 = false;
                unset($columns);
            } else if ($row["type"] != 7 and $table_opened7) {
                $procent = 0;
            $kwota = 0;
            echo '<table class="table m' . $number . '"><thead><tr>';
            $count = count($columns);
            for ($i = 0; $i < $count; $i++) {
                if (($i == 4)) {
                    $procent = $columns[$i]; // Wypisujemy nazwy kolumn z tablicy $columns
                } else if ($i == 5) {
                    $kwota = $columns[$i];
                } else {
                    $parts = explode("@=", $columns[$i]);
                    echo '<th scope="col">' . $parts[0] . '</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                }
            }
            echo '</tr></thead><tbody>';

            $maxi=0;
            for ($i = 0; $i < $count-1; $i++) {
                $parts = explode("@=", $columns[$i]);
                $length = count($parts);
                if($length>$maxi){
                    $maxi=$length;
                }
            }
            $random_number = rand(100, 999);
            for ($i = 1; $i < $maxi; $i++) {
                echo '<tr>';
                for($k=0;$k<$count;$k++){
                if ($k == 4 or $k == 5) {
                    echo '<td><input type="hidden" value="brak" class="form-control" name="' . $number . '[]"';
                } else if ($k == 3) {
                    echo '<td><input id="inputwyn_99_' . $number . '" type="text" class="form-control" value="" name="' . $number . '[]" oninput="updateSumByTableClass(' . $number . ')" readonly';
                } else if ($k == 1) {
                    $parts = explode("@=", $columns[$k]);
                    $value = $parts[$i] ?? '';
                    $disabled = ($value !== '') ? 'readonly' : '';
                    echo '<td><input id="input1_99_' . $number . '" type="text" class="form-control" value="'.$value.'" name="' . $number . '[]" onchange="delInputs1( 99, ' . $number . ', ' . $kwota . ', ' . $procent . ')" '.$disabled.'';
                } else if ($k == 2) {
                    $parts = explode("@=", $columns[$k]);
                    $value = $parts[$i] ?? '';
                    $disabled = ($value !== '') ? 'readonly' : '';
                    echo '<td><input id="input2_99_' . $number . '" value="'.$value.'" placeholder="Nie więcej niż ' . $procent . '% z sumy" type="text" class="form-control" name="' . $number . '[]" onchange="delInputs1( 99, ' . $number . ', ' . $kwota . ', ' . $procent . ')" '.$disabled.'';
                } else if ($k == 0) {
                    $parts = explode("@=", $columns[$k]);
                    $value = $parts[$i] ?? '';
                    $disabled = ($value !== '') ? 'readonly' : '';
                    echo '<td><input type="text" class="form-control" value="'.$value.'" name="' . $number . '[]" '.$disabled.'';
                } else {
                    echo '<td><input type="text" class="form-control" name="' . $number . '[]"';
                }
                if ($req == 1) {
                    echo ' required';
                }

                echo '

                                                ></td>';
            }
            echo '</tr>';
            }
                $i = 0;
                // Wygeneruj 10 wierszy z ukrytą klasą
                for ($i = 2; $i <= 20; $i++) {
                    echo '<tr class="hidden-row m' . $number . '">';
                    $random_number = rand(100, 999);
                    for ($j = 0; $j < $count - 2; $j++) {
                        if ($j == 3) {
                            echo '<td><input id="inputwyn_' . $random_number . '_' . $number . '" name="a' . $number . '[]" type="text" class="form-control" value="" value="" onchange="updateSumByTableClass(' . $number . ')" readonly';
                        } else if ($j == 1) {
                            echo '<td><input id="input1_' . $random_number . '_' . $number . '" type="text" class="form-control" name="a' . $number . '[]" onchange="delInputs1(' . $random_number . ', ' . $number . ', ' . $kwota . ', ' . $procent . ')" ';
                        } else if ($j == 2) {
                            echo '<td><input id="input2_' . $random_number . '_' . $number . '" type="text" class="form-control" name="a' . $number . '[]" onchange="delInputs1(' . $random_number . ', ' . $number . ', ' . $kwota . ', ' . $procent . ')"';
                        } else {
                            echo '<td><input type="text" class="form-control" name="a' . $number . '[]"';
                        }
                        echo '

                                            ></td>'; // Pole tekstowe w komórkach
                    }
                    echo '</tr>';
                }
                echo '</tbody>
                                        <tfoot><td style="text-align: right;" colspan="1">Suma:</td><td><input style="text-align:right;" id="inputres3_' . $number . '" type="text" class="form-control" value="" readonly>
                                              </td><td><input style="text-align:right;" id="inputres2_' . $number . '" type="text" placeholder="Nie więcej niż ' . $kwota . '" class="form-control" value="" readonly></td>
                                               <td ><input style="text-align:right;" id="inputres1_' . $number . '" type="text" class="form-control" value="" readonly></td></tfoot>
                                        </table>';
                echo '<button type="button" id="showMoreRowsBtn_m' . $number . '" class="btn btn-primary show-more-rows-btn">Dodaj wiersz</button>';
                echo '<button type="button" class="btn btn-danger remove-row-btn" data-table-id="m' . $number . '">Usuń wiersz</button>';

                $table_opened7 = false;
                unset($columns);
            }

            if ($row["type"] == 3) {
                if ($number != $row["number"] and $number != 0) {
                    echo "</p>";
                }
                if ($number != $row["number"]) {
                    echo "<p>";
                    $number = $row["number"];
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
                }
                if ($number != $row["number"]) {
                    echo "<p>";
                    $number = $row["number"];
                }
                echo '<div class="form-check">
        <input class="form-check-input" type="checkbox" name="' . $row["number"] . '[]" value="' . $row["questID"] . '"';

                echo '>
        <label class="form-check-label" for="' . $row["number"] . '">
            ' . $row["quest"] . '
        </label>
      </div>';
            } else if ($row["type"] == 0) {
                if ($number != $row["number"] and $number != 0) {
                    echo "</p>";
                }
                if ($number != $row["number"]) {
                    echo "<p>";
                    $number = $row["number"];
                }
                echo $row["quest"];
            } else if ($row["type"] == 1) {
                if ($number != $row["number"] and $number != 0) {
                    echo "</p>";
                }
                if ($number != $row["number"]) {
                    echo "<p>";
                    $number = $row["number"];
                }
                echo '<div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">' . $row["quest"] . '</label>
        <textarea style="width:81.5%" rows="1" id="exampleTextarea" class="form-control auto-resize res' . $row["number"] . '" type="text" name="' . $row["number"] . '"';
                if ($row["req"] == 1) {
                    echo ' required';
                }

                echo '></textarea>
                
      </div>';
      echo '<script>
document.addEventListener(\'DOMContentLoaded\', function() {
    const textarea = document.querySelector(\'.res' . $row["number"] . '\');
    
    textarea.addEventListener(\'input\', function() {
        this.style.height = \'auto\'; // Resetowanie wysokości
        this.style.height = this.scrollHeight + \'px\'; // Ustawianie wysokości na podstawie zawartości
    });

    // Początkowa zmiana wysokości na podstawie istniejącej zawartości
    textarea.style.height = \'auto\';
    textarea.style.height = textarea.scrollHeight + \'px\';
});
</script>';
            }else if ($row["type"] == 12) {
                if ($number != $row["number"] and $number != 0) {
                    echo "</p>";
                }
                if ($number != $row["number"]) {
                    echo "<p>";
                    $number = $row["number"];
                }
                if($gpup==1){
                    echo '<div style="display: flex; gap: 0.5%;">';
                    $gpup=0;
                    $gpdown=0;
                }
                echo '<div class="mb-3" style="width: 40%;">
    <label for="exampleFormControlInput1" class="form-label">' . $row["quest"] . '</label>
   <textarea id="'.$gpdown.'res' . $row["number"] . '" style="width:100%;" type="text" rows="1" id="exampleTextarea" class="form-control auto-resize res' . $row["number"] . '" name="' . $row["number"] . '[]"';

                if ($row["req"] == 1) {
                    echo ' required';
                }

                echo '></textarea>
  </div>';
                echo '<script>
document.addEventListener(\'DOMContentLoaded\', function() {
const textarea = document.getElementById(\''.$gpdown.'res' . $row["number"] . '\');

textarea.addEventListener(\'input\', function() {
    this.style.height = \'auto\'; // Resetowanie wysokości
    this.style.height = this.scrollHeight + \'px\'; // Ustawianie wysokości na podstawie zawartości
});

// Początkowa zmiana wysokości na podstawie istniejącej zawartości
textarea.style.height = \'auto\';
textarea.style.height = textarea.scrollHeight + \'px\';
});
</script>';
if($gpdown==1){
echo '</div>';
$gpup=1;
$gpdown=0;
}
$gpdown=1;
            } else if ($row["type"] == 4 or $row["type"] == 5 or $row["type"] == 6 or $row["type"] == 7) {
                $req = $row["req"];
                $number = $row["number"];
                if ($row["type"] == 4) {
                    $table_opened4 = true;
                } else if ($row["type"] == 5) {
                    $table_opened5 = true;
                } else if ($row["type"] == 6) {
                    $table_opened6 = true;
                } else if ($row["type"] == 7) {
                    $table_opened7 = true;
                }
                $columns[] = $row["quest"]; // Dodajemy nazwę kolumny do tablicy
            }


        }
        if ($table_opened4) {
            echo '<table class="table m' . $number . '"><thead><tr>';
            $count = count($columns);
        for ($i = 0; $i < $count; $i++) {
            $parts = explode("@=", $columns[$i]);
                echo '<th scope="col">' . $parts[0] . '</th>'; // Wypisujemy nazwy kolumn z tablicy $columns


        }
            echo '</tr></thead><tbody>';
            $maxi=0;
            for ($i = 0; $i < $count; $i++) {
                $parts = explode("@=", $columns[$i]);
                $length = count($parts);
                if($length>$maxi){
                    $maxi=$length;
                }
            }
            $k=0;
            for ($i = 1; $i < $maxi; $i++) {
                echo '<tr>';
                for($k=0;$k<$count;$k++){
                    $parts = explode("@=", $columns[$k]);
                    $value = $parts[$i] ?? '';
                    $disabled = ($value !== '') ? 'readonly' : '';
                echo '<td><input type="text" class="form-control" name="' . $number . '[]" value="'.$value.'" '.$disabled.'';

                if ($req == 1) {
                    echo ' required';
                }

                echo '

                ></td>'; // Pole tekstowe w komórkach
            }
            echo '</tr>';
            }

            // Wygeneruj 10 wierszy z ukrytą klasą
            for ($i = 2; $i <= 20; $i++) {
                echo '<tr class="hidden-row m' . $number . '">';
                foreach ($columns as $column) {
                    echo '<td><input type="text" class="form-control" name="a' . $number . '[]"></td>'; // Pole tekstowe w komórkach
                }
                echo '</tr>';
            }

            echo '</tbody></table>';
            echo '<button type="button" id="showMoreRowsBtn_m' . $number . '" class="btn btn-primary show-more-rows-btn">Dodaj wiersz</button>';
            echo '<button type="button" class="btn btn-danger remove-row-btn" data-table-id="m' . $number . '">Usuń wiersz</button>';

            $table_opened4 = false;
            unset($columns);
        }
        if ($table_opened5) {
            echo '<table class="table m' . $number . '"><thead><tr>';
            $count = count($columns);
        for ($i = 0; $i < $count; $i++) {
            $parts = explode("@=", $columns[$i]);
                echo '<th scope="col">' . $parts[0] . '</th>'; // Wypisujemy nazwy kolumn z tablicy $columns


        }
            echo '</tr></thead><tbody>';

            
            $inne = count($columns) - 2;
            $inne1 = count($columns) - 1;
            $random_number = rand(100, 999);
            $maxi=0;
            for ($i = 0; $i < $count; $i++) {
                $parts = explode("@=", $columns[$i]);
                $length = count($parts);
                if($length>$maxi){
                    $maxi=$length;
                }
            }
            $k=0;
            for ($i = 1; $i < $maxi; $i++) {
                echo '<tr>';
                for($k=0;$k<$count;$k++){
                    $parts = explode("@=", $columns[$k]);
                    $value = $parts[$i] ?? '';
                    $disabled = ($value !== '') ? 'readonly' : '';
                    if ($k == count($columns)-1) {
                        echo '<td><input id="inputwyn_' . $random_number . '_' . $number . '" type="text" class="form-control" value="' . htmlspecialchars($value, ENT_QUOTES) . '" onchange="updateSumByTableClass4(' . $number . ')" name="' . $number . '[]" ' . $disabled . '';
                        if ($req == 1) {
                            echo ' required';
                        }
        
                        echo '
        
                        ></td>';
                    } else {
                        echo '<td><input type="text" class="form-control" name="' . $number . '[]" value="' . htmlspecialchars($value, ENT_QUOTES) . '" ' . $disabled . '';
                        if ($req == 1) {
                            echo ' required';
                        }
        
                        echo '
        
                        ></td>';
                    }
                }
                echo '</tr>';
               



                 // Pole tekstowe w komórkach
            }
            
            $i = 0;
            // Wygeneruj 10 wierszy z ukrytą klasą
            for ($i = 2; $i <= 20; $i++) {
                echo '<tr class="hidden-row m' . $number . '">';
                $random_number = rand(100, 999);
                for ($j = 0; $j < $count; $j++) {
                    if ($j == count($columns)-1) {
                        echo '<td><input id="inputwyn_' . $random_number . '_' . $number . '" type="text" class="form-control" value="" onchange="updateSumByTableClass4(' . $number . ')" name="a' . $number . '[]"';

                    } else {
                        echo '<td><input type="text" class="form-control" name="a' . $number . '[]"';
                    }

                    echo '

                ></td>'; // Pole tekstowe w komórkach
                }
                echo '</tr>';
            }
            $col = $count-1;
            echo '</tbody>
        <tfoot><td style="text-align:right;" colspan="' . $col . '">Suma: </td><td ><input style="text-align:right;" id="inputres_' . $number . '" type="text" class="form-control" value="" readonly></td></tfoot>
        </table>';
            echo '<button type="button" id="showMoreRowsBtn_m' . $number . '" class="btn btn-primary show-more-rows-btn">Dodaj wiersz</button>';
            echo '<button type="button" class="btn btn-danger remove-row-btn" data-table-id="m' . $number . '">Usuń wiersz</button>';

            $table_opened5 = false;
            unset($columns);
        }
        if ($table_opened6) {
            echo '<table class="table m' . $number . '"><thead><tr>';
            $count = count($columns) + 1;
            for ($i = 0; $i < $count; $i++) {
                if (($i < count($columns))) {
                    $parts = explode("@=", $columns[$i]);
                }     
                if (($i >= count($columns))) {
                    echo '<th scope="col">Wynik</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                } else {
                    echo '<th scope="col">' . $parts[0] . '</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                }
            }
            echo '</tr></thead><tbody>';

            $inne = count($columns) - 2;
            $inne1 = count($columns) - 1;
            $random_number = rand(100, 999);
            $maxi=0;
            for ($i = 0; $i < $count-1; $i++) {
                $parts = explode("@=", $columns[$i]);
                $length = count($parts);
                if($length>$maxi){
                    $maxi=$length;
                }
            }
            for ($i = 1; $i < $maxi; $i++) {
                echo '<tr>';
                $random_number = rand(100, 999);
                for($k=0;$k<$count;$k++){
                    if ($k < count($columns)) {
                    $parts = explode("@=", $columns[$k]);
                    $value = $parts[$i] ?? '';
                    $disabled = ($value !== '') ? 'readonly' : '';
                    }
                if ($k >= count($columns)) {
                    echo '<td><input id="inputwyn_' . $random_number . '_' . $number . '" type="text" class="form-control" value="" oninput="updateSumByTableClass(' . $number . ')" ';
                } else if ($k == $inne) {
                    echo '<td><input id="input1_' . $random_number . '_' . $number . '" type="text" value="'.$value.'" class="form-control" name="' . $number . '[]" onchange="delInputs(' . $random_number . ', ' . $number . ')"';
                } else if ($k == $inne1) {
                    echo '<td><input id="input2_' . $random_number . '_' . $number . '" type="text" value="'.$value.'" class="form-control" name="' . $number . '[]" onchange="delInputs(' . $random_number . ', ' . $number . ')"';
                } else {
                    echo '<td><input type="text" class="form-control" value="'.$value.'" name="' . $number . '[]"';
                }


                if ($req == 1) {
                    echo ' required';
                }

                echo '

                       '.$disabled.' ></td>'; // Pole tekstowe w komórkach
            }
            echo '</tr>';
            }
            $i = 0;
            // Wygeneruj 10 wierszy z ukrytą klasą
            for ($i = 2; $i <= 20; $i++) {
                echo '<tr class="hidden-row m' . $number . '">';
                $random_number = rand(100, 999);
                for ($j = 0; $j < $count; $j++) {
                    if ($j >= count($columns)) {
                        echo '<td><input id="inputwyn_' . $random_number . '_' . $number . '" type="text" class="form-control" value="" value="" onchange="updateSumByTableClass(' . $number . ')"';
                    } else if ($j == $inne) {
                        echo '<td><input id="input1_' . $random_number . '_' . $number . '" type="text" class="form-control" name="a' . $number . '[]" onchange="delInputs(' . $random_number . ', ' . $number . ')" ';
                    } else if ($j == $inne1) {
                        echo '<td><input id="input2_' . $random_number . '_' . $number . '" type="text" class="form-control" name="a' . $number . '[]" onchange="delInputs(' . $random_number . ', ' . $number . ')"';
                    } else {
                        echo '<td><input type="text" class="form-control" name="a' . $number . '[]"';
                    }
                    echo '

                        ></td>'; // Pole tekstowe w komórkach
                }
                echo '</tr>';
            }
            $col = $count-1;
            echo '</tbody>
                    <tfoot><td style="text-align:right;" colspan="' . $col . '">Suma: </td><td ><input style="text-align:right;" id="inputres_' . $number . '" type="text" class="form-control" value="" readonly></td></tfoot>
                    </table>';
            echo '<button type="button" id="showMoreRowsBtn_m' . $number . '" class="btn btn-primary show-more-rows-btn">Dodaj wiersz</button>';
            echo '<button type="button" class="btn btn-danger remove-row-btn" data-table-id="m' . $number . '">Usuń wiersz</button>';

            $table_opened6 = false;
            unset($columns);
        }

        if ($table_opened7) {
            $procent = 0;
            $kwota = 0;
            echo '<table class="table m' . $number . '"><thead><tr>';
            $count = count($columns);
            for ($i = 0; $i < $count; $i++) {
                if (($i == 4)) {
                    $procent = $columns[$i]; // Wypisujemy nazwy kolumn z tablicy $columns
                } else if ($i == 5) {
                    $kwota = $columns[$i];
                } else {
                    $parts = explode("@=", $columns[$i]);
                    echo '<th scope="col">' . $parts[0] . '</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                }
            }
            echo '</tr></thead><tbody>';

            $maxi=0;
            for ($i = 0; $i < $count-1; $i++) {
                $parts = explode("@=", $columns[$i]);
                $length = count($parts);
                if($length>$maxi){
                    $maxi=$length;
                }
            }
            $random_number = rand(100, 999);
            for ($i = 1; $i < $maxi; $i++) {
                echo '<tr>';
                for($k=0;$k<$count;$k++){
                if ($k == 4 or $k == 5) {
                    echo '<td><input type="hidden" value="brak" class="form-control" name="' . $number . '[]"';
                } else if ($k == 3) {
                    echo '<td><input id="inputwyn_99_' . $number . '" type="text" class="form-control" value="" name="' . $number . '[]" oninput="updateSumByTableClass(' . $number . ')" readonly';
                } else if ($k == 1) {
                    $parts = explode("@=", $columns[$k]);
                    $value = $parts[$i] ?? '';
                    $disabled = ($value !== '') ? 'readonly' : '';
                    echo '<td><input id="input1_99_' . $number . '" type="text" class="form-control" value="'.$value.'" name="' . $number . '[]" onchange="delInputs1( 99, ' . $number . ', ' . $kwota . ', ' . $procent . ')" '.$disabled.'';
                } else if ($k == 2) {
                    $parts = explode("@=", $columns[$k]);
                    $value = $parts[$i] ?? '';
                    $disabled = ($value !== '') ? 'readonly' : '';
                    echo '<td><input id="input2_99_' . $number . '" value="'.$value.'" placeholder="Nie więcej niż ' . $procent . '% z sumy" type="text" class="form-control" name="' . $number . '[]" onchange="delInputs1( 99, ' . $number . ', ' . $kwota . ', ' . $procent . ')" '.$disabled.'';
                } else if ($k == 0) {
                    $parts = explode("@=", $columns[$k]);
                    $value = $parts[$i] ?? '';
                    $disabled = ($value !== '') ? 'readonly' : '';
                    echo '<td><input type="text" class="form-control" value="'.$value.'" name="' . $number . '[]" '.$disabled.'';
                } else {
                    echo '<td><input type="text" class="form-control" name="' . $number . '[]"';
                }
                if ($req == 1) {
                    echo ' required';
                }

                echo '

                                                ></td>';
            }
            echo '</tr>';
            }
            
            $i = 0;
            // Wygeneruj 10 wierszy z ukrytą klasą
            for ($i = 2; $i <= 20; $i++) {
                echo '<tr class="hidden-row m' . $number . '">';
                $random_number = rand(100, 999);
                for ($j = 0; $j < $count; $j++) {
                    if ($j == 4 or $j == 5) {
                        echo '<td><input type="hidden" value="brak" class="form-control" name="a' . $number . '[]"';
                    } else if ($j == 3) {
                        echo '<td><input id="inputwyn_' . $random_number . '_' . $number . '" name="a' . $number . '[]" type="text" class="form-control" value="" value="" onchange="updateSumByTableClass(' . $number . ')" readonly></td>';
                    } else if ($j == 1) {
                        echo '<td><input id="input1_' . $random_number . '_' . $number . '" type="text" class="form-control" name="a' . $number . '[]" onchange="delInputs1(' . $random_number . ', ' . $number . ', ' . $kwota . ', ' . $procent . ')" ></td>';
                    } else if ($j == 2) {
                        echo '<td><input id="input2_' . $random_number . '_' . $number . '" type="text" class="form-control" name="a' . $number . '[]" onchange="delInputs1(' . $random_number . ', ' . $number . ', ' . $kwota . ', ' . $procent . ')"></td>';
                    } else {
                        echo '<td><input type="text" class="form-control" name="a' . $number . '[]"></td>';
                    } // Pole tekstowe w komórkach

                }
                echo '</tr>';
            }
            echo '</tbody>
                                        <tfoot><td style="text-align: right;" colspan="1">Suma:</td><td><input style="text-align:right;" id="inputres3_' . $number . '" type="text" class="form-control" value="" readonly>
                                              </td><td><input style="text-align:right;" id="inputres2_' . $number . '" placeholder="Nie więcej niż ' . $kwota . '" type="text" class="form-control" value="" readonly></td>
                                               <td ><input style="text-align:right;" id="inputres1_' . $number . '" type="text" class="form-control" value="" readonly></td></tfoot>
                                        </table>';
            echo '<button type="button" id="showMoreRowsBtn_m' . $number . '" class="btn btn-primary show-more-rows-btn">Dodaj wiersz</button>';
            echo '<button type="button" class="btn btn-danger remove-row-btn" data-table-id="m' . $number . '">Usuń wiersz</button>';

            $table_opened7 = false;
            unset($columns);
        }
        echo "<input type='hidden' name='id' value='" . $id . "' >";
        echo "<input type='hidden' name='number1' value='" . $number . "' >"
        ?>

        <div style="text-align: right">
            <input id="saveBtn" type="button" style="background-color: red;" value="Wróć (zapisz)">
            <?php if($finish==0){ ?>
            <input type="submit" name="submit_publish" value="Wyślij">
            <?php } ?>
            <script>
function saveFormDataToDatabase() {
    const formElements = document.forms[0].elements;
    const formData = {};

    for (let i = 0; i < formElements.length; i++) {
        const element = formElements[i];
        if (element.type !== "submit" && element.type !== "button") {
            if (element.name.endsWith("[]")) {
                if (!formData[element.name]) {
                    formData[element.name] = [];
                }
                formData[element.name].push(element.value);
            } else {
                formData[element.name] = element.value;
            }
        }
    }

    // Przykładowe ID aplikacji i użytkownika - ustawione statycznie do celów testowych
    const dataToSend = {
        readyapplicationID: <?php echo $id; ?>, // Przykładowe ID aplikacji
        userID: <?php echo returniserid(); ?>,             // Przykładowe ID użytkownika
        formData: formData
    };

    fetch('save_form_data.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        readyapplicationID: <?php echo $id; ?>,
        userID: <?php echo returniserid(); ?>,
        formData: formData // tutaj twoje dane formularza
    })
})
.then(response => response.json())
.then(data => {
    console.log('Odpowiedź z serwera:', data); // Sprawdź tutaj, czy odpowiedź jest poprawna
    if (data.status === "success" || data.status === "updated" || data.status === "inserted") {
        window.location.href = "../forms/forms.php";
    } else {
        alert("Błąd podczas zapisu danych: " + (data.message || "Nieznany błąd"));
    }
})
.catch(error => {
    console.error("Błąd podczas komunikacji z serwerem:", error);
    alert("Błąd podczas zapisu danych: " + error.message);
});
}

window.addEventListener('DOMContentLoaded', loadFormDataFromDatabase);

function loadFormDataFromDatabase() {
    const userID = <?php echo returniserid(); ?>; // Pobranie ID użytkownika
    const readyapplicationID = <?php echo $id; ?>; // Pobranie ID aplikacji

    fetch(`load_form_data.php?userID=${userID}&readyapplicationID=${readyapplicationID}`)
    .then(response => response.json())
    .then(formData => {
        if (formData.status === "no_data") {
            console.log("Brak danych w formData.");
            return;
        }

        console.log("Odebrane dane:", formData);

        const formElements = document.forms[0].elements;

        for (let originalName in formData) {
            const values = formData[originalName];

            const isPrefixedWithA = originalName.startsWith('a');

            if (Array.isArray(values)) {
                let index = 0;
                for (let i = 0; i < formElements.length; i++) {
                    const element = formElements[i];

                    if (!element || !element.name) continue; // Sprawdzenie, czy element istnieje

                    let normalizedName = element.name;
                    // Usuwamy 'a' z początku, ale TYLKO jeśli faktycznie tam jest
                    if (normalizedName.startsWith('a') && isNaN(normalizedName)) {
                        normalizedName = normalizedName.substring(1);
                    }


                    if (String(normalizedName) === String(originalName) && index < values.length) {
                        

                        if (!isPrefixedWithA) {
                            removeHiddenRowClass(element);
                            
                        }
                        element.value = values[index];
                        index++;
                    }
                }
            } else {
                for (let i = 0; i < formElements.length; i++) {
                    const element = formElements[i];

                    if (!element || !element.name) continue; // Sprawdzenie, czy element istnieje

                    let normalizedName = element.name;
                    if (normalizedName.startsWith('a') && isNaN(normalizedName)) {
                        normalizedName = normalizedName.substring(1);
                    }

                    if (String(normalizedName) === String(originalName) && values !== "" && String(normalizedName) !== "null") {
                        element.value = values;

                    }
                }
            }
        }

        document.getElementById('saveBtn').value = 'Wróć (zapisz)';
        document.getElementById('sendbtn').value = 'Wyślij';
    })
    .catch(error => console.error('Błąd podczas wczytywania danych:', error));
}

/**
 * Funkcja usuwa klasę hidden-row z TR, jeśli input znajduje się w jego wnętrzu
 */
function removeHiddenRowClass(inputElement) {
    let trElement = inputElement.closest('tr'); // Znajdź najbliższy <tr>

if (trElement) {
    let tableElement = trElement.closest('table'); // Sprawdź, czy <tr> jest w tabeli

    if (tableElement && trElement.classList.contains('hidden-row')) {
         // Sprawdź, czy inputElement znajduje się w pierwszej kolumnie wiersza
         let firstCell = trElement.querySelector('td'); // Pierwsza komórka w wierszu (jeśli jest)
        
        // Jeśli pierwsza komórka istnieje i zawiera inputElement, oznacza to, że jest w pierwszej kolumnie
        if (firstCell && firstCell.contains(inputElement)) {
            var number = inputElement.getAttribute('name'); // Pobierz całe 'name' z input

        // Usuń pierwszą literę 'a' (jeśli istnieje) oraz ostatnie 2 znaki
        var truncatedNumber = number.startsWith('a') ? number.substring(1, number.length - 2) : number.substring(0, number.length - 2);

        // Zbudowanie id przycisku z numerem
        var showMoreRowsBtn = document.getElementById('showMoreRowsBtn_m' + truncatedNumber);

        // Jeśli przycisk istnieje, kliknij go
        if (showMoreRowsBtn) {
            showMoreRowsBtn.click(); // Kliknij przycisk
            console.log('Kliknięto przycisk "Pokaż więcej wierszy" o id: showMoreRowsBtn_m' + truncatedNumber);
        } else {
            console.log('Nie znaleziono przycisku o id: showMoreRowsBtn_m' + truncatedNumber);
        }
        }        
    }
}
}


// Wczytaj dane automatycznie po załadowaniu strony
document.getElementById('saveBtn').addEventListener('click', saveFormDataToDatabase);
</script>
        </div>
    </form>
</div>
</body>
            <script>
    var showMoreRowsBtns = document.querySelectorAll('.show-more-rows-btn');

    showMoreRowsBtns.forEach(function (btn) {
        var tableId = btn.getAttribute('id').split('_').pop(); // Pobierz numer ID tabeli
        var showMoreRowsBtn = document.getElementById('showMoreRowsBtn_' + tableId);
        var removeRowBtns = document.querySelectorAll('.remove-row-btn[data-table-id="' + tableId + '"]');
        var hiddenRows = document.querySelectorAll('.hidden-row.' + tableId);
        console.log("Table ID:", tableId);


        // Każdy przycisk dostaje osobny currentIndex
        showMoreRowsBtn.currentIndex = 0;
        console.log("Początkowy currentIndex dla tabeli " + tableId + ": " + showMoreRowsBtn.currentIndex);

        // Funkcja do pokazywania ukrytego wiersza
        function showNextHiddenRow() {
            if (showMoreRowsBtn.currentIndex < hiddenRows.length) {
                hiddenRows[showMoreRowsBtn.currentIndex].style.display = 'table-row';
                showMoreRowsBtn.currentIndex++;
                if (showMoreRowsBtn.currentIndex >= hiddenRows.length) {
                    showMoreRowsBtn.style.display = 'none'; // Ukryj przycisk, jeśli pokazano wszystkie wiersze
                }
            }
        }

        // Obsługa kliknięcia przycisku "Pokaż więcej wierszy"
        showMoreRowsBtn.addEventListener('click', function () {
            showNextHiddenRow();

            // Pobierz referencję do nowo dodanego wiersza
            var newlyAddedRow = hiddenRows[showMoreRowsBtn.currentIndex - 1];

            // Zmiana nazwy inputów w dodanym wierszu
            var inputs = newlyAddedRow.querySelectorAll('input');
            inputs.forEach(function (input) {
                var currentName = input.getAttribute('name');
                var newName = currentName.substring(1); // Usuń pierwszą literę 'a'
                input.setAttribute('name', newName);
            });
        });

        // Obsługa kliknięcia przycisku "Usuń wiersz"
        removeRowBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                if (showMoreRowsBtn.currentIndex <= 10) {
                    showMoreRowsBtn.style.display = '';
                }
                if (showMoreRowsBtn.currentIndex !== 0) {
                    --showMoreRowsBtn.currentIndex;
                    hiddenRows[showMoreRowsBtn.currentIndex].style.display = 'none';

                    // Zmiana nazwy inputów w usuwanym wierszu
                    var inputs = hiddenRows[showMoreRowsBtn.currentIndex].querySelectorAll('input');
                    inputs.forEach(function (input) {
                        var currentName = input.getAttribute('name');
                        var newName = 'a' + currentName; // Dodaj literkę 'a' na początku
                        input.setAttribute('name', newName);
                    });
                }
            });
        });
    });



</script>
<script>

    function delInputs(index, number) {
        // Pobierz wartości z obu pól tekstowych
        var input1Value = parseFloat(document.getElementById("input1_" + index + "_" + number).value);
        var input2Value = parseFloat(document.getElementById("input2_" + index + "_" + number).value);

        // Upewnij się, że wartości są liczbami, a nie NaN
        if (!isNaN(input1Value) && !isNaN(input2Value)) {
            // Dodaj wartość z input1 do wartości w input2
            var result = input1Value - input2Value;
            // Ustaw wynik jako wartość pola tekstowego wynikowego
            document.getElementById("inputwyn_" + index + "_" + number).value = result;
            updateSumByTableClass4(number);
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

    function updateSumByTableClass4(index) {
        // Pobierz wszystkie pola inputwyn w tabeli o podanej klasie
        var inputwynFields = document.querySelectorAll('.table.m' + index + ' input[id^="inputwyn_"]:not([name^="a"])');

        var totalSum = 0;

        // Iteruj przez wszystkie pola inputwyn i sumuj ich wartości
        inputwynFields.forEach(function (inputwynField) {
            var value = parseFloat(inputwynField.value);
            if (!isNaN(value)) {
                console.log(totalSum);
                totalSum += value;
            }
        });

        // Ustaw sumę w inpucie na dole
        document.getElementById('inputres_' + index).value = totalSum;
    }

    function updateSumByTableClass(index) {
        // Pobierz wszystkie pola inputwyn w tabeli o podanej klasie
        var inputwynFields = document.querySelectorAll('.table.m' + index + ' input[id^="inputwyn_"]');
        var totalSum = 0;

        // Iteruj przez wszystkie pola inputwyn i sumuj ich wartości
        inputwynFields.forEach(function (inputwynField) {
            var value = parseFloat(inputwynField.value);
            if (!isNaN(value)) {
                console.log(totalSum);
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
        inputwynFields.forEach(function (inputwynField) {
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
        inputwynFields.forEach(function (inputwynField) {
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
        var value = parseFloat(input.value);
        var submitButton = document.getElementsByName('submit_publish')[0];

        if (value > kwota) {
            // Jeśli wartość jest większa niż kwota, ustaw kolor tła na czerwono
            submitButton.disabled = true;
            input.style.backgroundColor = 'red';
            toastr.options.timeOut = 5000;
            toastr.error("Suma dotacji przekracza próg " + kwota + "zł", "aktualnie jest " + value + "zł");
        } else {
            submitButton.disabled = false;
            // W przeciwnym razie ustaw kolor tła na biało
            input.style.backgroundColor = '';
        }
    }

    function checksum(procent, number) {
        var input1 = parseFloat(document.getElementById("input2_99_" + number).value);
        var input2 = parseFloat(document.getElementById('inputres2_' + number).value);
        var inputField1 = document.getElementById("input2_99_" + number);
        var submitButton = document.getElementsByName('submit_publish')[0];
        var result = input1 / input2 * 100;
        // Sprawdzenie, czy wynik dzielenia jest większy od procent
        if (result > procent) {
            inputField1.style.backgroundColor = 'red';
            submitButton.disabled = true;
            toastr.options.timeOut = 5000;
            toastr.error("Procent kosztów administracyjnych przekracza próg " + procent + "%", "aktualnie jest " + result + "%");
        } else {
            submitButton.disabled = false;
            inputField1.style.backgroundColor = '';
            tooltipText.parentElement.classList.remove('show');
        }

    }
</script>

</html>