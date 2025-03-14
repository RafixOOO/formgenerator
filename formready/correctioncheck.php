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
$applicationID = 0;
$sql = "SELECT applicationID FROM formbuilder.readyapplication WHERE readyID = $readyID";
$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    // Pobierz wartość applicationID
    $applicationID = $row['applicationID'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Location: reportcheck.php?ID=" . $readyID . "&finish=0");
exit;
}

// Pobranie danych wypełnionego formularza
$sql = "WITH quest_ranked AS (
    SELECT 
        qu.questID, 
        qu.quest, 
        qu.type, 
        q.number, 
        q.req, 
        b.answer, 
        b.answerconnectID, 
        a2.answer AS spr, 
        a2.reason, 
        r.readyID, 
        b.tablerow,
        ROW_NUMBER() OVER (PARTITION BY q.number ORDER BY qu.questID DESC) AS row_num
    FROM 
        questconnect q
    JOIN 
        quest qu ON q.questID = qu.questID
    JOIN 
        application a ON q.applicationID = a.applicationID
    JOIN 
        readyapplication r ON r.applicationID = a.applicationID
    JOIN 
        answerconnect b ON qu.questID = b.questID 
    LEFT JOIN 
        answercorrect a2 ON a2.answerconnectID = b.answerconnectID
    WHERE 
        b.readyID = ? 
        AND r.readyID = ?
        AND (qu.constant = 3 or qu.constant = 2)
)
SELECT 
    questID, 
    quest, 
    type, 
    number, 
    req, 
    answer, 
    answerconnectID, 
    spr, 
    reason, 
    readyID, 
    tablerow
FROM 
    quest_ranked
WHERE 
    NOT (type = 7 AND (answer = 'brak'))
ORDER BY 
    answerconnectID, 
    number;
";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $readyID,$readyID);
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
    <link rel="icon" href="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEAAAAALAAAAAABAAEAAAIA" type="image/gif">

    <title>Generator | Sprawozdanie</title>
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
            width: 90%; /* Pełna szerokość strony */
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
            width: 45%; /* Lewa kolumna: 40% szerokości */
            padding-right: 20px;
            border-right: 2px solid #000;
        }
        .right-side {
            width: 54%; /* Prawa kolumna: 60% szerokości */
            padding-left: 20px;
        }
        .reason {
            display: block;
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
            margin-bottom: 20px;
            margin-right:15%;
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
                        <?php if($data['type']==1 || $data['type']==4 || $data['type']==5 || $data['type']==6 || $data['type']==7 || $data['type']==12){ 
                                                        $val = explode("@=", $data['quest']);

                            ?>
                            <label><?php echo htmlspecialchars($val[0]); ?></label>
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
                            </div>
                        
                        <?php } ?>
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
                        <?php if($data['type']==1 || $data['type']==4 || $data['type']==5 || $data['type']==6 || $data['type']==7 || $data['type']==12){ 
                                                        $val = explode("@=", $data['quest']);

                            ?>
                        
                            <label><?php echo htmlspecialchars($val[0]); ?></label>
                            <div style="display: flex;">


                                <?php
                                    if($data["spr"]!=''){
                                        echo '<textarea type="text" rows="1" id="corrected-answer-'.$questID.'" class="form-control auto-resize1 res1' . $questID . '" name="answers['.$questID.']" oninput="checkForDifference('.$questID.')" disabled>'.$data["spr"].'</textarea>';
                                    }else{
                                        echo '<textarea type="text" rows="1" id="corrected-answer-'.$questID.'" class="form-control auto-resize1 res1' . $questID . '" name="answers['.$questID.']" oninput="checkForDifference('.$questID.')" disabled>'.htmlspecialchars($data["answer"]).'</textarea>';
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
                                if($data["reason"]!=''){
                                echo '<textarea rows="1" id="reason-'.$questID.'" class="form-control reason auto-resize res' . $questID . '" type="text" name="reasons['.$questID.']"';
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
                echo '</div>';
                                 }
                                ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Brak danych do wyświetlenia.</p>
                <?php endif; ?>
            </div>

            </div>
        </div>
        <br />

        <!-- Przycisk zapisu wyrównany do prawej -->
       
    </form>
</div>
<br />
<iframe id="dynamic-iframe" src="reportcheck.php?ID=<?php echo $readyID; ?>&finish=0" 
        style="width: 100%; border: none;" scrolling="no"></iframe>

<script>
    function adjustIframeHeight() {
        const iframe = document.getElementById('dynamic-iframe');
        
        // Ustaw wysokość, gdy iframe się załaduje
        iframe.onload = function() {
            setHeight();
        };

        function setHeight() {
            try {
                // Pobierz wysokość całej zawartości iframe
                const iframeDocument = iframe.contentWindow.document;
                const newHeight = Math.max(
                    iframeDocument.body.scrollHeight,
                    iframeDocument.documentElement.scrollHeight
                );
                iframe.style.height = newHeight + 'px';
            } catch (error) {
                console.error('Nie można uzyskać dostępu do zawartości iframe:', error);
            }
        }

        // Aktualizuj wysokość co jakiś czas (np. przy dynamicznej zawartości)
        setInterval(setHeight, 500);
    }

    document.addEventListener('DOMContentLoaded', adjustIframeHeight);
</script>

<div class="save-button-container">
        <a href="../formready/tocheck.php"><input type="button" value="Wróć" class="btn btn-danger"></a>
        </div>
</body>
</html>

<?php
?>
