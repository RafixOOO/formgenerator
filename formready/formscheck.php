<?php require_once("../auth.php"); ?>

<?php $isPdfGenerationRequest = isset($_GET['source']) && $_GET['source'] === 'pdf_generation';

if (!$isPdfGenerationRequest && !isLoggedIn()) {
    header("Location: ../index.php");
    exit;
}
$id = '';
if (isset($_GET['ID'])) {
    // Odczytujemy wartość zmiennej
    $id = $_GET['ID'];
    // Tutaj możesz wykorzystać odczytaną wartość
}
?>
<!DOCTYPE html>
<html lang="PL">

<head>
    <meta charset="utf-8" />

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

        .auto-resize {
            overflow: hidden;
            resize: none;
            box-sizing: border-box;
            width: 100%;
            /* Szerokość textarea, dostosuj w razie potrzeby */
            min-height: calc(1.5em + 0.75rem + 2px);
            /* Dostosowanie minimalnej wysokości, aby pasowała do input */
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }
        @media print {
        body {
            margin: 0;
            padding: 0;
        }

        .pdf-container {
            width: 100%;
            page-break-inside: avoid; /* Zapobiega łamaniu wewnątrz kontenera */
        }

        .form-section {
            page-break-inside: avoid; /* Zapobiega łamaniu sekcji formularza */
        }

        /* Zapewnia, że marginesy są brane pod uwagę */
        .pdf-margin {
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Stylizacja dla inputów, aby dobrze wyglądały w PDF */
        input, select, textarea {
            width: 100%;
            box-sizing: border-box; /* Uwzględnia padding i border w szerokości */
        }

        /* Kontrolowanie łamania stron w dużych blokach tekstu */
        .avoid-break {
            page-break-inside: avoid; /* Unikaj łamania wewnątrz elementu */
        }
    }
        .hide-in-pdf {
            display: none;
        }
        .pdf-margin {
            margin: 20px; /* Dodaje marginesy */
        }
        #generate-pdf {
            background-color: #28a745; /* Zielony kolor */
            color: white; /* Kolor tekstu */
            border: none; /* Brak ramki */
            border-radius: 5px; /* Zaokrąglone narożniki */
            padding: 10px 20px; /* Padding wewnętrzny */
            font-size: 16px; /* Rozmiar czcionki */
            cursor: pointer; /* Kursor wskaźnika */
            transition: background-color 0.3s ease; /* Animacja koloru tła */
        }

        /* Stylizacja przycisku na hover */
        #generate-pdf:hover {
            background-color: #218838; /* Ciemniejszy zielony kolor przy najechaniu */
        }

        /* Stylizacja przycisku na active (kliknięty) */
        #generate-pdf:active {
            background-color: #1e7e34; /* Jeszcze ciemniejszy zielony kolor przy kliknięciu */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Cień */
        }

        /* Wyrównanie przycisku do prawej strony */
        .button-container {
            text-align: right; /* Wyrównuje przyciski do prawej strony */
        }
    </style>

</head>

<body>
    <!-- 2024 Created by: Rafał Pezda-->
    <!-- link: https://github.com/RafixOOO -->
    <div class="wrapper fadeInDown">
        <div id="form" class="pdf-container">
        <form >
        <div class="button-container">
            <button id="generate-pdf" type="button">Generuj PDF</button>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <script>
       document.getElementById('generate-pdf').addEventListener('click', function() {
    var form = document.getElementById('form');
    
    // Dodaj marginesy i ukryj przyciski
    form.classList.add('pdf-margin');
    document.querySelectorAll('button').forEach(function(button) {
        button.classList.add('hide-in-pdf');
    });

    // Konfiguracja dla html2pdf
    var opt = {
        margin:       [0.5, 0.5, 0.5, 0.5], // Marginesy: [top, left, bottom, right]
        filename:     'form.pdf',
        image:        { type: 'jpeg', quality: 0.98 }, // Typ i jakość obrazu
        html2canvas:  { scale: 2, useCORS: true }, // Skala i wsparcie CORS
        jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' } // Rozmiar i orientacja strony
    };

    // Generowanie PDF
    html2pdf().from(form).set(opt).save().finally(function() {
        // Usuń marginesy i przywróć przyciski po zakończeniu
        form.classList.remove('pdf-margin');
        document.querySelectorAll('button').forEach(function(button) {
            button.classList.remove('hide-in-pdf');
        });
    });
});

    </script>
            <?php
            require_once("../dbconnect.php");

            $sql = "SELECT qu.questID, qu.quest,qu.type, q.`number`, q.`req` FROM `questconnect` q, `quest` qu, `application` a, readyapplication r WHERE q.applicationID=a.applicationID and q.questID=qu.questID and r.applicationID=a.applicationID and r.readyID=$id order by number;";
            $result = $conn->query($sql);
            $number = 0;
            $columns = array();
            $columns1 = array();
            $table_opened4 = false;
            $table_opened5 = false;
            $table_opened6 = false;
            $table_opened7 = false;
            $table_opened11 = false;
            $table_opened12 = false;
            $req = 0;
            while ($row = $result->fetch_assoc()) {

                if ($row["type"] != 4 and $table_opened4) {
                    $quest = $row['questID'];
                    $sql1 = "SELECT a.`answerconnectID`,a.`readyID`, a.`questID`, a.`tablerow`, a.`answer` FROM `answerconnect` a, quest q, questconnect qu WHERE a.questID=q.questID and qu.questID=q.questID and qu.number=$number and readyID=$id and tablerow is not null order by tablerow, questid;";
                    $result1 = $conn->query($sql1);
                    $table = 0;
                    echo '<table class="table"><thead><tr>';
                    echo '<th scope="col">#</th>'; // Dodajemy kolumnę numeracji
                    foreach ($columns as $column) {
                        echo '<th scope="col">' . $column . '</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                    }
                    echo '</tr></thead><tbody>';
                    $up = 0;
                    $down = 1;

                    while ($row1 = $result1->fetch_assoc()) {
                        if ($down != $row1["tablerow"]) {
                            echo '</tr>';
                            $down = $row1["tablerow"];
                        }

                        if ($up != $row1["tablerow"]) {
                            echo '<tr>';
                            echo '<th scope="row">' . $row1["tablerow"] . '</th>';
                            $up = $row1["tablerow"];
                        }

                        // Numeracja wierszy
                        echo '<td><input type="text" class="form-control" name="' . $number . '[]" value="' . $row1["answer"] . '" disabled';

                        if ($req == 1) {
                            echo ' required';
                        }

                        echo '

                    ></td>'; // Pole tekstowe w komórkach
                    }
                    echo '</tbody></table>';

                    $table_opened4 = false;
                    unset($columns);
                } else if ($row["type"] != 5 and $table_opened5) {
                    $answer1 = 0;
                    $answer2 = 0;
                    $sum1 = 0;
                    $sum3 = 0;
                    $sql1 = "SELECT a.`answerconnectID`,a.`readyID`, a.`questID`, a.`tablerow`, a.`answer` FROM `answerconnect` a, quest q, questconnect qu WHERE a.questID=q.questID and qu.questID=q.questID and qu.number=$number and readyID=$id and tablerow is not null order by tablerow, questid;";
                    $result1 = $conn->query($sql1);
                    $table = 0;
                    echo '<table class="table"><thead><tr>';
                    echo '<th scope="col">#</th>'; // Dodajemy kolumnę numeracji
                    $count = count($columns) + 1;
                    for ($i = 0; $i < $count; $i++) {
                        if (($i >= count($columns))) {
                            echo '<th scope="col">Wynik</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                        } else {
                            echo '<th scope="col">' . $columns[$i] . '</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                        }
                    }
                    echo '</tr></thead><tbody>';
                    $up = 0;
                    $i = 1;
                    $ac1 = count($columns) - 1;
                    $ac2 = count($columns);
                    while ($row1 = $result1->fetch_assoc()) {
                        if ($ac1 == $i) {
                            $answer1 = (int)$row1["answer"];
                        } else if ($ac2 == $i) {
                            $answer2 = (int)$row1["answer"];
                        }
                        if ($i == $count) {
                            $a = (int)$answer1 + (int)$answer2;
                            echo '<td><input type="text" class="form-control" name="' . $number . '[]" value="' . $a . '" disabled></td>';
                            $sum3 += $a;
                        }
                        if ($up == 0) {
                            echo '<tr>';
                            echo '<th scope="row">' . $row1["tablerow"] . '</th>';
                            $up++;
                        }
                        if ($i >= $count) {
                            $i = 1;
                            if ($up !== 1) {
                                echo '</tr>';
                            }
                            echo '<tr>';
                            echo '<th scope="row">' . $row1["tablerow"] . '</th>';
                            $up++;
                        }


                        // Numeracja wierszy
                        echo '<td><input type="text" class="form-control" name="' . $number . '[]" value="' . $row1["answer"] . '" disabled></td>';

                        $i++;
                    }
                    $a = (int)$answer1 + (int)$answer2;
                    echo '<td><input type="text" class="form-control" name="' . $number . '[]" value="' . $a . '" disabled></td>';
                    $sum3 += $a;
                    echo '</tbody>
                <tfoot><td style="text-align:right;" colspan="' . $count . '">Suma: </td><td ><input style="text-align:right;" id="inputres1_' . $number . '" type="text" class="form-control" value="' . $sum3 . '" readonly></td></tfoot>

                </table>';

                    $table_opened5 = false;
                    unset($columns);
                } else if ($row["type"] != 6 and $table_opened6) {
                    $answer1 = 0;
                    $answer2 = 0;
                    $sum1 = 0;
                    $sum3 = 0;
                    $sql1 = "SELECT a.`answerconnectID`,a.`readyID`, a.`questID`, a.`tablerow`, a.`answer` FROM `answerconnect` a, quest q, questconnect qu WHERE a.questID=q.questID and qu.questID=q.questID and qu.number=$number and readyID=$id and tablerow is not null order by tablerow, questid;";
                    $result1 = $conn->query($sql1);
                    $table = 0;
                    echo '<table class="table"><thead><tr>';
                    echo '<th scope="col">#</th>'; // Dodajemy kolumnę numeracji
                    $count = count($columns) + 1;
                    for ($i = 0; $i < $count; $i++) {
                        if (($i >= count($columns))) {
                            echo '<th scope="col">Wynik</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                        } else {
                            echo '<th scope="col">' . $columns[$i] . '</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                        }
                    }
                    echo '</tr></thead><tbody>';
                    $up = 0;
                    $i = 1;
                    $ac1 = count($columns) - 1;
                    $ac2 = count($columns);
                    while ($row1 = $result1->fetch_assoc()) {
                        if ($ac1 == $i) {
                            $answer1 = (int)$row1["answer"];
                        } else if ($ac2 == $i) {
                            $answer2 = (int)$row1["answer"];
                        }
                        if ($i == $count) {
                            $a = (int)$answer1 - (int)$answer2;
                            echo '<td><input type="text" class="form-control" name="' . $number . '[]" value="' . $a . '" disabled></td>';
                            $sum3 += $a;
                        }
                        if ($up == 0) {
                            echo '<tr>';
                            echo '<th scope="row">' . $row1["tablerow"] . '</th>';
                            $up++;
                        }
                        if ($i >= $count) {
                            $i = 1;
                            if ($up !== 1) {
                                echo '</tr>';
                            }
                            echo '<tr>';
                            echo '<th scope="row">' . $row1["tablerow"] . '</th>';
                            $up++;
                        }


                        // Numeracja wierszy
                        echo '<td><input type="text" class="form-control" name="' . $number . '[]" value="' . $row1["answer"] . '" disabled></td>';

                        $i++;
                    }
                    $a = (int)$answer1 - (int)$answer2;
                    echo '<td><input type="text" class="form-control" name="' . $number . '[]" value="' . $a . '" disabled></td>';
                    $sum3 += $a;
                    echo '</tbody>
                <tfoot><td style="text-align:right;" colspan="' . $count . '">Suma: </td><td ><input style="text-align:right;" id="inputres1_' . $number . '" type="text" class="form-control" value="' . $sum3 . '" readonly></td></tfoot>

                </table>';

                    $table_opened5 = false;
                    unset($columns);
                } else if ($row["type"] != 7 and $table_opened7) {
                    $sum1 = 0;
                    $sum2 = 0;
                    $sum3 = 0;
                    $sql1 = "SELECT a.`answerconnectID`,a.`readyID`, a.`questID`, a.`tablerow`, a.`answer` FROM `answerconnect` a, quest q, questconnect qu WHERE a.questID=q.questID and qu.questID=q.questID and qu.number=$number and readyID=$id and tablerow is not null and answer!='brak'  order by tablerow, questid;";
                    $result1 = $conn->query($sql1);
                    $table = 0;
                    echo '<table class="table"><thead><tr>';
                    echo '<th scope="col">#</th>'; // Dodajemy kolumnę numeracji
                    $count = count($columns) - 2;
                    for ($i = 0; $i < $count; $i++) {
                        echo '<th scope="col">' . $columns[$i] . '</th>';
                    }
                    echo '</tr></thead><tbody>';
                    $up = 0;
                    $i = 1;
                    while ($row1 = $result1->fetch_assoc()) {
                        if ($up == 0) {
                            echo '<tr>';
                            echo '<th scope="row">' . $row1["tablerow"] . '</th>';
                            $up++;
                        }
                        if ($i > $count) {
                            $i = 1;
                            if ($up !== 1) {
                                echo '</tr>';
                            }
                            echo '<tr>';
                            echo '<th scope="row">' . $row1["tablerow"] . '</th>';
                            $up++;
                        }
                        if ($i == 2) {
                            $sum1 += (int)$row1["answer"];
                        } else if ($i == 3) {
                            $sum2 += (int)$row1["answer"];
                        } else if ($i == 4) {
                            $sum3 += (int)$row1["answer"];
                        }

                        // Numeracja wierszy
                        echo '<td><input type="text" class="form-control" name="' . $number . '[]" value="' . $row1["answer"] . '" disabled></td>';
                        $i++;
                    }
                    echo '</tbody>
            <tfoot><td style="text-align: right;" colspan="2">Suma:</td><td><input style="text-align:right;" id="inputres3_' . $number . '" type="text" class="form-control" value="' . $sum1 . '" readonly>
                                                </td><td><input style="text-align:right;" id="inputres2_' . $number . '" type="text" class="form-control" value="' . $sum2 . '" readonly></td>
                                                <td ><input style="text-align:right;" id="inputres1_' . $number . '" type="text" class="form-control" value="' . $sum3 . '" readonly></td></tfoot>

            </table>';

                    $table_opened7 = false;
                    unset($columns);
                }

                if ($row["type"] == 8) {
                    $selected = '';
                    $tablerow = 0;
                    $quest = $row['questID'];
                    $sql1 = "SELECT `answerconnectID`,`readyID`, `questID`, `tablerow`, `answer` FROM `answerconnect` WHERE readyID = $id and questID = $quest";
                    $result1 = $conn->query($sql1);
                    while ($row1 = $result1->fetch_assoc()) {
                        $selected = $row1["answer"];
                        $tablerow = $row1["tablerow"];

                        if ($tablerow == 1) {

                            echo '<div class="mb-3" style="float:left;">
            <label for="exampleFormControlInput1" class="form - label">Imię</label>
            <input type="text" class="form-control" name="' . $row["number"] . ' " value="' . $selected . '" disabled';

                            if ($row["req"] == 1) {
                                echo ' required';
                            }

                            echo '>
          </div>';
                        } else if ($tablerow == 2) {
                            echo '<div class="mb-3" style="float:left; margin-left:2%;">
            <label for="exampleFormControlInput1" class="form - label">Nazwisko</label>
            <input type="text" class="form-control" name="' . $row["number"] . ' " value="' . $selected . '" disabled';

                            if ($row["req"] == 1) {
                                echo ' required';
                            }

                            echo '>
          </div> <div style="clear:both;"></div>';
                        } else if ($tablerow == 3) {

                            echo '<div class="mb-3" style="float:left;">
            <label for="exampleFormControlInput1" class="form - label">Email</label>
            <input type="text" class="form-control" name="' . $row["number"] . ' " value="' . $selected . '" disabled';

                            if ($row["req"] == 1) {
                                echo ' required';
                            }

                            echo '>
          </div>';
                        } else if ($tablerow == 4) {

                            echo '<div class="mb-3" style="float:left; margin-left:2%;">
            <label for="exampleFormControlInput1" class="form - label">Telefon</label>
            <input type="text" class="form-control" name="' . $row["number"] . ' " value="' . $selected . '" disabled';

                            if ($row["req"] == 1) {
                                echo ' required';
                            }

                            echo '>
          </div> <div style="clear:both;"></div>';
                        }
                    }
                }

                if ($row["type"] == 9) {
                    $selected = '';
                    $organ = '';
                    $quest = $row['questID'];
                    $sql1 = "SELECT `answerconnectID`,`readyID`, `questID`, `tablerow`, `answer` FROM `answerconnect` WHERE readyID = $id and questID = $quest";
                    $result1 = $conn->query($sql1);
                    while ($row1 = $result1->fetch_assoc()) {
                        $selected = $row1["answer"];
                    }

                    $sqldata = 'SELECT o.name, o.OrganizationID FROM `organizationdata` o, organizationconnect oc where o.OrganizationID=oc.OrganizationID and o.OrganizationID=' . $selected . ' and oc.accept=1 and o.accept=1 ;';
                    $result2 = $conn->query($sqldata);
                    while ($row2 = $result2->fetch_assoc()) {
                        $organ = $row2['name'] . " #" . $row2['OrganizationID'];
                    }

                    echo '<div class="mb-3">
        <label for="exampleFormControlInput1" class="form - label">Organizacja</label>
        <input type="text" class="form-control" name="' . $row["number"] . ' " value="' . $organ . '" disabled';
                    if ($row["req"] == 1) {
                        echo ' required';
                    }

                    echo '>
      </div>';
                }

                if ($row["type"] == 3) {
                    $quest = $row['questID'];
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
                    $quest = $row['questID'];
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
        <input class="form-check-input" type="checkbox" name="' . $row["number"] . '" value="' . $row["questID"] . '" disabled';

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
                    echo "<div>" . $row["quest"];
                } else if ($row["type"] == 1) {
                    $quest = $row['questID'];
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
       <textarea type="text" rows="1" id="exampleTextarea" class="form-control auto-resize res' . $row["number"] . '" name="' . $row["number"] . ' " disabled';

                    if ($row["req"] == 1) {
                        echo ' required';
                    }

                    echo '>' . $selected . '</textarea>
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
                } else if ($row["type"] == 4 or $row["type"] == 5 or $row["type"] == 6 or $row["type"] == 7 or $row["type"] == 11 or $row["type"] == 10) {
                    $req = $row["req"];
                    $number = $row["number"];
                    if ($row["type"] == 4) {
                        $table_opened4 = true;
                        $columns[] = $row["quest"];
                    } else if ($row["type"] == 5) {
                        $table_opened5 = true;
                        $columns[] = $row["quest"];
                    } else if ($row["type"] == 6) {
                        $table_opened6 = true;
                        $columns[] = $row["quest"];
                    } else if ($row["type"] == 7) {
                        $table_opened7 = true;
                        $columns[] = $row["quest"];
                    } else if ($row["type"] == 11) {
                        $table_opened11 = true;
                        $columns[] = $row["quest"];
                    } else if ($row["type"] == 10) {
                        $table_opened12 = true;
                        $columns1[] = $row["quest"];
                    }
                    // Dodajemy nazwę kolumny do tablicy
                }
            }
            if ($table_opened4) {
                $sql1 = "SELECT a.`answerconnectID`,a.`readyID`, a.`questID`, a.`tablerow`, a.`answer` FROM `answerconnect` a, quest q, questconnect qu WHERE a.questID=q.questID and qu.questID=q.questID and qu.number=$number and readyID=$id and tablerow is not null order by tablerow, questid;";
                $result1 = $conn->query($sql1);
                $table = 0;
                echo '<table class="table"><thead><tr>';
                echo '<th scope="col">#</th>'; // Dodajemy kolumnę numeracji
                foreach ($columns as $column) {
                    echo '<th scope="col">' . $column . '</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                }
                echo '</tr></thead><tbody>';
                $up = 0;
                $down = 1;
                while ($row1 = $result1->fetch_assoc()) {
                    if ($down != $row1["tablerow"]) {
                        echo '</tr>';
                        $down = $row1["tablerow"];
                    }

                    if ($up != $row1["tablerow"]) {
                        echo '<tr>';
                        $up = $row1["tablerow"];
                        echo '<th scope="row">' . $row1["tablerow"] . '</th>';
                    }

                    // Numeracja wierszy
                    echo '<td><input type="text" class="form-control" name="' . $number . '[]" value="' . $row1["answer"] . '" disabled';

                    if ($req == 1) {
                        echo ' required';
                    }

                    echo '

                    ></td>'; // Pole tekstowe w komórkach
                }
                echo '</tbody></table>';
                $table_opened4 = false;
                unset($columns);
            }
            if ($table_opened6) {
                $answer1 = 0;
                $answer2 = 0;
                $sum1 = 0;
                $sum3 = 0;
                $sql1 = "SELECT a.`answerconnectID`,a.`readyID`, a.`questID`, a.`tablerow`, a.`answer` FROM `answerconnect` a, quest q, questconnect qu WHERE a.questID=q.questID and qu.questID=q.questID and qu.number=$number and readyID=$id and tablerow is not null order by tablerow, questid;";
                $result1 = $conn->query($sql1);
                $table = 0;
                echo '<table class="table"><thead><tr>';
                echo '<th scope="col">#</th>'; // Dodajemy kolumnę numeracji
                $count = count($columns) + 1;
                for ($i = 0; $i < $count; $i++) {
                    if (($i >= count($columns))) {
                        echo '<th scope="col">Wynik</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                    } else {
                        echo '<th scope="col">' . $columns[$i] . '</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                    }
                }
                echo '</tr></thead><tbody>';
                $up = 0;
                $i = 1;
                $ac1 = count($columns) - 1;
                $ac2 = count($columns);
                while ($row1 = $result1->fetch_assoc()) {
                    if ($ac1 == $i) {
                        $answer1 = (int)$row1["answer"];
                    } else if ($ac2 == $i) {
                        $answer2 = (int)$row1["answer"];
                    }
                    if ($i == $count) {
                        $a = (int)$answer1 - (int)$answer2;
                        echo '<td><input type="text" class="form-control" name="' . $number . '[]" value="' . $a . '" disabled></td>';
                        $sum3 += $a;
                    }
                    if ($up == 0) {
                        echo '<tr>';
                        echo '<th scope="row">' . $row1["tablerow"] . '</th>';
                        $up++;
                    }
                    if ($i >= $count) {
                        $i = 1;
                        if ($up !== 1) {
                            echo '</tr>';
                        }
                        echo '<tr>';
                        echo '<th scope="row">' . $row1["tablerow"] . '</th>';
                        $up++;
                    }


                    // Numeracja wierszy
                    echo '<td><input type="text" class="form-control" name="' . $number . '[]" value="' . $row1["answer"] . '" disabled></td>';

                    $i++;
                }
                $a = (int)$answer1 - (int)$answer2;
                echo '<td><input type="text" class="form-control" name="' . $number . '[]" value="' . $a . '" disabled></td>';
                $sum3 += $a;
                echo '</tbody>
            <tfoot><td style="text-align:right;" colspan="' . $count . '">Suma: </td><td ><input style="text-align:right;" id="inputres1_' . $number . '" type="text" class="form-control" value="' . $sum3 . '" readonly></td></tfoot>

            </table>';

                $table_opened5 = false;
                unset($columns);
            }
            if ($table_opened5) {
                $answer1 = 0;
                $answer2 = 0;
                $sum1 = 0;
                $sum3 = 0;
                $sql1 = "SELECT a.`answerconnectID`,a.`readyID`, a.`questID`, a.`tablerow`, a.`answer` FROM `answerconnect` a, quest q, questconnect qu WHERE a.questID=q.questID and qu.questID=q.questID and qu.number=$number and readyID=$id and tablerow is not null order by tablerow, questid;";
                $result1 = $conn->query($sql1);
                $table = 0;
                echo '<table class="table"><thead><tr>';
                echo '<th scope="col">#</th>'; // Dodajemy kolumnę numeracji
                $count = count($columns) + 1;
                for ($i = 0; $i < $count; $i++) {
                    if (($i >= count($columns))) {
                        echo '<th scope="col">Wynik</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                    } else {
                        echo '<th scope="col">' . $columns[$i] . '</th>'; // Wypisujemy nazwy kolumn z tablicy $columns
                    }
                }
                echo '</tr></thead><tbody>';
                $up = 0;
                $i = 1;
                $ac1 = count($columns) - 1;
                $ac2 = count($columns);
                while ($row1 = $result1->fetch_assoc()) {
                    if ($ac1 == $i) {
                        $answer1 = (int)$row1["answer"];
                    } else if ($ac2 == $i) {
                        $answer2 = (int)$row1["answer"];
                    }
                    if ($i == $count) {
                        $a = (int)$answer1 + (int)$answer2;
                        echo '<td><input type="text" class="form-control" name="' . $number . '[]" value="' . $a . '" disabled></td>';
                        $sum3 += $a;
                    }
                    if ($up == 0) {
                        echo '<tr>';
                        echo '<th scope="row">' . $row1["tablerow"] . '</th>';
                        $up++;
                    }
                    if ($i >= $count) {
                        $i = 1;
                        if ($up !== 1) {
                            echo '</tr>';
                        }
                        echo '<tr>';
                        echo '<th scope="row">' . $row1["tablerow"] . '</th>';
                        $up++;
                    }


                    // Numeracja wierszy
                    echo '<td><input type="text" class="form-control" name="' . $number . '[]" value="' . $row1["answer"] . '" disabled></td>';

                    $i++;
                }
                $a = (int)$answer1 + (int)$answer2;
                echo '<td><input type="text" class="form-control" name="' . $number . '[]" value="' . $a . '" disabled></td>';
                $sum3 += $a;
                echo '</tbody>
            <tfoot><td style="text-align:right;" colspan="' . $count . '">Suma: </td><td ><input style="text-align:right;" id="inputres1_' . $number . '" type="text" class="form-control" value="' . $sum3 . '" readonly></td></tfoot>

            </table>';

                $table_opened5 = false;
                unset($columns);
            }
            if ($table_opened7) {
                $sum1 = 0;
                $sum2 = 0;
                $sum3 = 0;
                $sql1 = "SELECT `answerconnectID`,`readyID`, `questID`, `tablerow`, `answer` FROM `answerconnect` WHERE readyID=$id and tablerow is not null and answer!='brak'  order by tablerow, questid;";
                $result1 = $conn->query($sql1);
                $table = 0;
                echo '<table class="table"><thead><tr>';
                echo '<th scope="col">#</th>'; // Dodajemy kolumnę numeracji
                $count = count($columns) - 2;
                for ($i = 0; $i < $count; $i++) {
                    echo '<th scope="col">' . $columns[$i] . '</th>';
                }
                echo '</tr></thead><tbody>';
                $up = 0;
                $i = 1;
                while ($row1 = $result1->fetch_assoc()) {
                    if ($up == 0) {
                        echo '<tr>';
                        echo '<th scope="row">' . $row1["tablerow"] . '</th>';
                        $up++;
                    }
                    if ($i > $count) {
                        $i = 1;
                        if ($up !== 1) {
                            echo '</tr>';
                        }
                        echo '<tr>';
                        echo '<th scope="row">' . $row1["tablerow"] . '</th>';
                        $up++;
                    }
                    if ($i == 2) {
                        $sum1 += (int)$row1["answer"];
                    } else if ($i == 3) {
                        $sum2 += (int)$row1["answer"];
                    } else if ($i == 4) {
                        $sum3 += (int)$row1["answer"];
                    }

                    // Numeracja wierszy
                    echo '<td><input type="text" class="form-control" name="' . $number . '[]" value="' . $row1["answer"] . '" disabled></td>';
                    $i++;
                }
                echo '</tbody>
            <tfoot><td style="text-align: right;" colspan="2">Suma:</td><td><input style="text-align:right;" id="inputres3_' . $number . '" type="text" class="form-control" value="' . $sum1 . '" readonly>
                                                </td><td><input style="text-align:right;" id="inputres2_' . $number . '" type="text" class="form-control" value="' . $sum2 . '" readonly></td>
                                                <td ><input style="text-align:right;" id="inputres1_' . $number . '" type="text" class="form-control" value="' . $sum3 . '" readonly></td></tfoot>

            </table>';

                $table_opened7 = false;
                unset($columns);
            }

            echo "</form>";
            if (returnRole() == 2 or returnRole() == 3) {
                $ql = "select q.quest, q.`type`,a.answer,a.answerconnectID from quest q, answerconnect a where q.questID =a.questID and a.readyID = $id order by a.answerconnectID ";
                $result1 = $conn->query($ql);
                $tablefirst = false;
                $tablelast = false;
                $osoba = '';
                $values2 = '0';
                $first=false;
                while ($row = $result1->fetch_assoc()) {
                    if (strpos($row['answer'], ',') !== false && $first==false) {
                        $values2 = explode(',', $row['answer']);
                        $first=true;

                    } 
                    if ($row['type'] == 10) {
                        if ($tablelast == true) {
                            echo '</tbody></table>';
                            echo "Osoba sprawdzająca: ".$osoba;
                            $tablelast = false;
                        }
                        $tablefirst = false;
                        echo '<div class="mb-3">';
                        echo '<label class="form-label">' . $row['quest'] . '</label>';
                        echo '<div>';

                        // Wybór "Tak"
                        echo '<input type="radio" value="Tak"';
                        if ($row['answer'] == 'Tak') {
                            echo ' checked';
                        }
                        echo ' disabled>';
                        echo '<label>Tak</label><br />';

                        // Wybór "Nie"
                        echo '<input type="radio" value="Nie"';
                        if ($row['answer'] == 'Nie') {
                            echo ' checked';
                        }
                        echo ' disabled>';
                        echo '<label >Nie</label>';
                        echo '</div>';
                        echo '</div>';
                    }
                    if ($row['type'] == 11) {
                        $values2 = explode(',', $row['answer']);
                        $tablelast = true;
                        if ($tablefirst == false) {
                            echo '<table class="table"><thead><tr>';
                            echo '<th>Nazwa</th>';
                            echo '<th>Punkty</th>';
                            echo '</tr></thead><tbody>';
                            $tablefirst = true;
                        }

                        echo '<tr>'; // Otwórz nowy wiersz
                        echo '<td>' . $row['quest'] . '</td>'; // Nazwa kolumny
                        echo '<td><input type="number" value="' . trim($values2[1]) . '" disabled></td>'; // Pole do wpisania punktów
                        echo '</tr>'; // Zamknij wiersz
                        $ql1 = "select name, surname from user where userID=".trim($values2[0])." ";
                        $result2 = $conn->query($ql1);
                        while ($row1 = $result2->fetch_assoc()) {
                                $osoba=$row1['name'].' '. $row1['surname'];
                        }
                    }
                }
                echo '</tbody></table>';
                if($osoba!=''){
                echo "Osoba sprawdzająca: ".$osoba;
                echo "<hr />";
                }
            }
            $userid=returniserid();
            $status='';
            $sql1 = "SELECT SUBSTRING_INDEX(a.answer, ',', 1) AS first_value, r.status
                FROM answerconnect a, quest q, readyapplication r 
                WHERE a.questID = q.questID and r.readyID=a.readyID and a.readyID = ? and SUBSTRING_INDEX(a.answer, ',', 1)=? AND q.type = 11 group by  SUBSTRING_INDEX(a.answer, ',', 1);";
                    $stmt = $conn->prepare($sql1);
                    $stmt->bind_param("is", $id, $userid); // Assuming $key is the quest name or identifier
                    $stmt->execute();
                    $values2 = '';
                    $result1 = $stmt->get_result();
                    if ($row1 = $result1->fetch_assoc()) {
                        $values2 = $row1['first_value'];
                        $status = $row1['status'];
                    }
            echo "<form method='post' action='save_formcheck.php'>";
            if (isset($values2[0]) && !empty($values2[0])) {
                $wartosc2 = trim($values2[0]);
            } else {
                $wartosc2 = 0; // Przypisanie wartości domyślnej
            }
            if($wartosc2!=$userid && $status==0){
            if ($table_opened11 or $table_opened12) {
                if ($table_opened12) {
                    $i=1;
                    foreach ($columns1 as $column) {
                        echo '<div class="mb-3">';
                        echo '<label class="form-label">' . $column . '</label>';
                        echo '<div>';

                        // Wybór "Tak"
                        echo '<input type="radio" id="yes_' . $column . '" name="b[' . $column . ']" value="Tak" required>';
                        echo '<label for="yes_' . $i . '">Tak</label><br />';

                        // Wybór "Nie"
                        echo '<input type="radio" id="no_' . $column . '" name="b[' . $column . ']" value="Nie" required>';
                        echo '<label for="no_' . $i . '">Nie</label>';
                        $i++;
                        echo '</div>';
                        echo '</div>';
                    }
                    $table_opened12 = false;
                    unset($columns1);
                }
                if ($table_opened11) {
                    echo '<table class="table"><thead><tr>';
                    echo '<th>Nazwa</th>';
                    echo '<th>Punkty</th>';
                    echo '</tr></thead><tbody>';

                    // Każdy element w $columns tworzy nowy wiersz w tabeli
                    foreach ($columns as $column) {
                        echo '<tr>'; // Otwórz nowy wiersz
                        echo '<td>' . $column . '</td>'; // Nazwa kolumny
                        echo '<td><input type="number" name="b[' . $column . ']" required></td>'; // Pole do wpisania punktów
                        echo '</tr>'; // Zamknij wiersz
                    }

                    echo '</tbody></table>';
                    $table_opened11 = false;
                    unset($columns);
                }
                echo "<input type='hidden' name='id' value='" . $id . "'>";
                echo '<input type="submit" value="Zapisz">';
            }
            echo "</form>";
        }else{
            $ql = "select q.quest, q.`type`,a.answer,a.answerconnectID from quest q, answerconnect a where q.questID =a.questID and a.readyID = $id and SUBSTRING_INDEX(a.answer, ',', 1)=$userid order by a.answerconnectID ";
            $result1 = $conn->query($ql);
            $tablefirst = false;
            $tablelast = false;
            $osoba = '';
            $values2 = '0';
            $first=false;
            while ($row = $result1->fetch_assoc()) {
                if (strpos($row['answer'], ',') !== false && $first==false) {
                    $values2 = explode(',', $row['answer']);
                    $first=true;

                } 
                if ($row['type'] == 10) {
                    if ($tablelast == true) {
                        echo '</tbody></table>';
                        echo "Osoba sprawdzająca: ".$osoba;
                        $tablelast = false;
                    }
                    $tablefirst = false;
                    echo '<div class="mb-3">';
                    echo '<label class="form-label">' . $row['quest'] . '</label>';
                    echo '<div>';

                    // Wybór "Tak"
                    echo '<input type="radio" value="Tak"';
                    if ($row['answer'] == 'Tak') {
                        echo ' checked';
                    }
                    echo ' disabled>';
                    echo '<label>Tak</label><br />';

                    // Wybór "Nie"
                    echo '<input type="radio" value="Nie"';
                    if ($row['answer'] == 'Nie') {
                        echo ' checked';
                    }
                    echo ' disabled>';
                    echo '<label >Nie</label>';
                    echo '</div>';
                    echo '</div>';
                }
                if ($row['type'] == 11) {
                    $values2 = explode(',', $row['answer']);
                    $tablelast = true;
                    if ($tablefirst == false) {
                        echo '<table class="table"><thead><tr>';
                        echo '<th>Nazwa</th>';
                        echo '<th>Punkty</th>';
                        echo '</tr></thead><tbody>';
                        $tablefirst = true;
                    }

                    echo '<tr>'; // Otwórz nowy wiersz
                    echo '<td>' . $row['quest'] . '</td>'; // Nazwa kolumny
                    echo '<td><input type="number" value="' . trim($values2[1]) . '" disabled></td>'; // Pole do wpisania punktów
                    echo '</tr>'; // Zamknij wiersz
                    $ql1 = "select name, surname from user where userID=".trim($values2[0])." ";
                    $result2 = $conn->query($ql1);
                    while ($row1 = $result2->fetch_assoc()) {
                            $osoba=$row1['name'].' '. $row1['surname'];
                    }
                }
            }
            echo '</tbody></table>';
            if($osoba!=''){
            echo "Osoba sprawdzająca: ".$osoba;
            echo "<hr />";
            }
        }
            ?>
</div>
            <div style="text-align: right;">
                <a href="../formready/tocheck.php"><input type="button" value="Wróć" style="background-color: red;"></a>
            </div>
    </div>
</body>
</html>