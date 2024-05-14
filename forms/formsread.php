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
        $table_opened = false;
        $req=0;
        while ($row = $result->fetch_assoc()) {

            if ($row["type"] != 4 and $table_opened) {
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

                $table_opened = false;
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
            } else if ($row["type"] == 4) {
                $req=$row["req"];
                $number=$row["number"];
                $table_opened = true;
                $columns[] = $row["quest"]; // Dodajemy nazwę kolumny do tablicy
            }


        }
         if ($table_opened) {
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

                $table_opened = false;
                unset($columns);
         }
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



</html>