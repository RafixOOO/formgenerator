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
        $sql = "INSERT INTO answerconnect (readyID, questID, answer) VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE answer=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iiss', $readyID, $questID, $answer, $answer);
        $stmt->execute();
        $stmt->close();
        
        if (!empty($reasons[$questID])) {
            $sql = "INSERT INTO deviation_reasons (readyID, questID, reason) VALUES (?, ?, ?)
                    ON DUPLICATE KEY UPDATE reason=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('iiss', $readyID, $questID, $reasons[$questID], $reasons[$questID]);
            $stmt->execute();
            $stmt->close();
        }
    }

    $sql = "UPDATE readyapplication SET status=2 WHERE readyID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $readyID);
    $stmt->execute();
    $stmt->close();

    $corrected = true;
}

// Pobranie danych wypełnionego formularza
$sql = "SELECT q.questID, q.quest, a.answer 
        FROM quest q 
        JOIN answerconnect a ON q.questID = a.questID 
        WHERE a.readyID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $readyID);
$stmt->execute();
$result = $stmt->get_result();

$filledAnswers = [];
while ($row = $result->fetch_assoc()) {
    $filledAnswers[$row['questID']] = $row;
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
        function copyToInput(questID) {
            var valueToCopy = document.getElementById('filled-answer-' + questID).value;
            document.getElementById('corrected-answer-' + questID).value = valueToCopy;
            checkForDifference(questID);
        }

        function checkForDifference(questID) {
            var originalValue = document.getElementById('filled-answer-' + questID).value;
            var correctedValue = document.getElementById('corrected-answer-' + questID).value;

            if (originalValue !== correctedValue) {
                document.getElementById('reason-' + questID).style.display = 'block';
            } else {
                document.getElementById('reason-' + questID).style.display = 'none';
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
                                <input type="text" id="filled-answer-<?php echo $questID; ?>" class="form-control" value="<?php echo htmlspecialchars($data['answer']); ?>" disabled>
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
                <h2>Poprawiony formularz</h2>
                <?php if (!empty($filledAnswers)): ?>
                    <?php foreach ($filledAnswers as $questID => $data): ?>
                        <div class="form-group">
                            <label><?php echo htmlspecialchars($data['quest']); ?></label>
                            <div style="display: flex;">
                                <input type="text" id="corrected-answer-<?php echo $questID; ?>" class="form-control" name="answers[<?php echo $questID; ?>]" value="" oninput="checkForDifference(<?php echo $questID; ?>)">
                                <textarea class="form-control reason" id="reason-<?php echo $questID; ?>" name="reasons[<?php echo $questID; ?>]" rows="1" placeholder="Opisz przyczynę odstępstw"></textarea>
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
            <button type="submit" class="btn btn-primary">Zapisz poprawiony formularz</button>
        </div>
    </form>

    <div class="text-right">
        <a href="../formready/tocheck.php"><input type="button" value="Wróć" class="btn btn-danger"></a>
    </div>
</div>

</body>
</html>
