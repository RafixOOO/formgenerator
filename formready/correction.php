<?php
// Połączenie z bazą danych
require_once("../dbconnect.php");
require_once("../auth.php");

if (!isLoggedIn()) {
    header("Location: ../index.php"); // Przekierowanie do logowania
    exit;
}

// Sprawdzenie, czy formularz jest wypełniony
$readyID = intval($_GET['ID']);  // ID wniosku do pobrania
$corrected = false; // Flaga, czy formularz jest poprawiony

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obsługa zapisu poprawionego formularza
    $answers = $_POST['answers'];  // Pobrane odpowiedzi z formularza
    $reasons = $_POST['reasons'];  // Pobrane przyczyny odstępstw
    $readyID = intval($_POST['readyID']);
    
    foreach ($answers as $questID => $answer) {
        if ($reasons[$questID] != "") {
            // Najpierw sprawdzamy, czy rekord z danym answerconnectID istnieje
            $sqlCheck = "SELECT COUNT(*) FROM answercorrect WHERE answerconnectID = ?";
            $stmtCheck = $conn->prepare($sqlCheck);
            $stmtCheck->bind_param('i', $questID);
            $stmtCheck->execute();
            $stmtCheck->bind_result($count);
            $stmtCheck->fetch();
            $stmtCheck->close();
        
            if ($count > 0) {
                // Jeśli rekord istnieje, wykonujemy aktualizację
                $sqlUpdate = "UPDATE answercorrect SET reason = ?, answer = ? WHERE answerconnectID = ?";
                $stmtUpdate = $conn->prepare($sqlUpdate);
                $stmtUpdate->bind_param('ssi', $reasons[$questID], $answer, $questID);
                $stmtUpdate->execute();
                $stmtUpdate->close();
            } else {
                // Jeśli rekord nie istnieje, wykonujemy INSERT
                $sqlInsert = "INSERT INTO answercorrect (answerconnectID, reason, answer) VALUES (?, ?, ?)";
                $stmtInsert = $conn->prepare($sqlInsert);
                $stmtInsert->bind_param('iss', $questID, $reasons[$questID], $answer);
                $stmtInsert->execute();
                $stmtInsert->close();
            }
        }
    }

    //$sql = "UPDATE readyapplication SET status=3 WHERE readyID=?";
    //$stmt = $conn->prepare($sql);
    //$stmt->bind_param('i', $readyID);
    //$stmt->execute();
    //$stmt->close();

    $corrected = true;
    header("Location: formready.php");
exit;
}

// Pobranie danych wypełnionego formularza
$sql = "SELECT q.questID, q.quest, a.answer , a.answerconnectID, a2.answer as spr , a2.reason 
        FROM quest q 
        JOIN answerconnect a ON q.questID = a.questID 
        left join answercorrect a2 on a2.answerconnectID = a.answerconnectID 
        WHERE a.readyID = ? and q.`type` in (1,4,5,6)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $readyID);
$stmt->execute();
$result = $stmt->get_result();

$filledAnswers = [];
while ($row = $result->fetch_assoc()) {
    $filledAnswers[$row['answerconnectID']] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sprawozdanie z realizacji inicjatywy PFR</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .auto-resize {
            display: none;
            margin-left: 10px;
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

    .auto-resize1 {
            margin-left: 10px;
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
        .container-fluid {
            margin-top: 20px;
            width: 70%; /* Pełna szerokość strony */
        }
        .header-title {
            text-align: center; /* Wycentrowanie tytułu */
            font-size: 24px;
            font-weight: bold;
        }
        .description {
            text-align: center; /* Wycentrowanie opisu */
            font-size: 14px;
            margin-top: 10px;
            margin-bottom: 30px;
        }
        .left-side {
            width: 40%; /* Lewa kolumna: 40% szerokości */
            padding-right: 20px;
            border-right: 2px solid #000;
        }
        .right-side {
            width: 60%; /* Prawa kolumna: 60% szerokości */
            padding-left: 20px;
        }
        .copy-button {
            cursor: pointer;
            font-size: 18px;
            color: blue;
            margin-left: 10px;
        }
        .copy-button:hover {
            color: darkblue;
        }
        .reason {
            display: none;
            margin-left: 10px;
            width: 100%;
        }
        textarea {
            resize: vertical;
            height: auto;
            min-height: 1.5em;
        }
        .form-control {
            width: 100%; /* Szerokie pola formularza */
        }
        .form-group {
            margin-bottom: 15px;
        }
        .row {
            display: flex;
        }
        .save-button-container {
            text-align: right; /* Przycisk zapisu wyrównany do prawej */
            margin-top: 20px;
        }
    </style>
    <script>
        function copyToInput(answerconnectID) {
            var valueToCopy = document.getElementById('filled-answer-' + answerconnectID).value;
            document.getElementById('corrected-answer-' + answerconnectID).value = valueToCopy;
            checkForDifference(answerconnectID);
        }

        function checkForDifference(answerconnectID) {
            var originalValue = document.getElementById('filled-answer-' + answerconnectID).value;
            var correctedValue = document.getElementById('corrected-answer-' + answerconnectID).value;

            if (originalValue !== correctedValue) {
    const reasonField = document.getElementById('reason-' + answerconnectID);
    reasonField.style.display = 'block';
    reasonField.setAttribute('required', ''); // Ustawia wymaganie pola
} else {
    const reasonField = document.getElementById('reason-' + answerconnectID);
    reasonField.style.display = 'none';
    reasonField.removeAttribute('required'); // Usuwa wymaganie pola
}
        }
    </script>
</head>
<body>

<div class="container-fluid">
    <!-- Tytuł strony -->
    <h1 class="header-title">Sprawozdanie z realizacji inicjatywy PFR</h1>
    
    <!-- Opis poniżej tytułu -->
    <div class="description">
        1. Syntetyczny opis zrealizowanych działań (opis powinien zawierać informację o zrealizowanych działaniach, z uwzględnieniem stopnia oraz skali ich wykonania, a także wyjaśnić ewentualne odstępstwa w ich realizacji).
    </div>

    <?php if ($corrected): ?>
        <div class="alert alert-success">Wniosek został poprawiony i zapisany.</div>
    <?php endif; ?>

    <form action="" method="POST">
        <input type="hidden" name="readyID" value="<?php echo $readyID; ?>">

        <div class="row">
            <!-- Wypełniony formularz po lewej -->
            <div class="left-side">
                <h2>Wypełniony formularz</h2>
                <?php if (!empty($filledAnswers)): ?>
                    <?php foreach ($filledAnswers as $questID => $data): ?>
                        <div class="form-group">
                            <label><?php echo htmlspecialchars($data['quest']); ?></label>
                            <div style="display: flex;">

                                <?php
                                echo '<textarea rows="1" type="text" rows="2" id="filled-answer-'.$questID.'" class="form-control auto-resize1 res3' . $questID . '" disabled>'.htmlspecialchars($data["answer"]).'</textarea>';

                                echo '<script>
                                document.addEventListener(\'DOMContentLoaded\', function() {
                                    const textarea = document.querySelector(\'.res3' . $questID . '\');
                                    
                                    textarea.addEventListener(\'input\', function() {
                                        this.style.height = \'auto\'; // Resetowanie wysokości
                                        this.style.height = this.scrollHeight + \'px\'; // Ustawianie wysokości na podstawie zawartości
                                    });
                                
                                    // Początkowa zmiana wysokości na podstawie istniejącej zawartości
                                    textarea.style.height = \'auto\';
                                    textarea.style.height = textarea.scrollHeight + \'px\';
                                });
                                </script>';
                                ?>
                                <span class="copy-button" onclick="copyToInput(<?php echo $questID; ?>)" title="Skopiuj do poprawionego formularza">📋</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Brak danych do wyświetlenia.</p>
                <?php endif; ?>
            </div>

            <!-- Pusty formularz po prawej do wypełnienia -->
            <div class="right-side">
                <h2>Sprawozdanie</h2>
                <?php if (!empty($filledAnswers)): ?>
                    <?php foreach ($filledAnswers as $questID => $data): ?>
                        <div class="form-group">
                            <label><?php echo htmlspecialchars($data['quest']); ?></label>
                            <div style="display: flex;">


                                <?php
                                if(empty($data['spr'])){
                                    echo '<textarea type="text" rows="1" id="corrected-answer-'.$questID.'" class="form-control auto-resize1 res1' . $questID . '" name="answers['.$questID.']" oninput="checkForDifference('.$questID.')"></textarea>';
                                }else{
                                    echo '<textarea type="text" rows="1" id="corrected-answer-'.$questID.'" class="form-control auto-resize1 res1' . $questID . '" name="answers['.$questID.']" oninput="checkForDifference('.$questID.')" disabled>'.$data["spr"].'</textarea>';
                                }
                               

                                echo '<script>
                                document.addEventListener(\'DOMContentLoaded\', function() {
                                    const textarea = document.querySelector(\'.res1' . $questID . '\');
                                    
                                    textarea.addEventListener(\'input\', function() {
                                        this.style.height = \'auto\'; // Resetowanie wysokości
                                        this.style.height = this.scrollHeight + \'px\'; // Ustawianie wysokości na podstawie zawartości
                                    });
                                
                                    // Początkowa zmiana wysokości na podstawie istniejącej zawartości
                                    textarea.style.height = \'auto\';
                                    textarea.style.height = textarea.scrollHeight + \'px\';
                                });
                                </script>';

                                if(empty($data['reason'])){
                                echo '<textarea rows="1" id="reason-'.$questID.'" class="form-control reason auto-resize res' . $questID . '" type="text" name="reasons['.$questID.']"';
                                echo 'placeholder="Opisz przyczynę odstępstw"></textarea>';
                                }else{
                                    echo '<textarea style="display:block;" rows="1" id="'.$questID.'" class="form-control reason auto-resize res' . $questID . '" type="text" name="reasons['.$questID.']"';
                                echo 'placeholder="Opisz przyczynę odstępstw" disabled>'.$data["reason"].'</textarea>';
                                }
                                
                      echo '<script>
                document.addEventListener(\'DOMContentLoaded\', function() {
                    const textarea = document.querySelector(\'.res' . $questID . '\');
                    
                    textarea.addEventListener(\'input\', function() {
                        this.style.height = \'auto\'; // Resetowanie wysokości
                        this.style.height = this.scrollHeight + \'px\'; // Ustawianie wysokości na podstawie zawartości
                    });
                
                    // Początkowa zmiana wysokości na podstawie istniejącej zawartości
                    textarea.style.height = \'auto\';
                    textarea.style.height = textarea.scrollHeight + \'px\';
                });
                </script>';
                                ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Brak danych do wyświetlenia.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Przycisk zapisu wyrównany do prawej -->
        <div class="save-button-container">
            <button type="submit" class="btn btn-primary">Zapisz sprawozdanie</button>
        </div>
    </form>

    <div class="text-right">
        <a href="../formready/formready.php"><input type="button" value="Wróć" class="btn btn-danger"></a>
    </div>
</div>

</body>
</html>
