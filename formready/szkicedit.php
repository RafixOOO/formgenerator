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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<!-- 2024 Created by: Rafał Pezda-->
<!-- link: https://github.com/RafixOOO -->
<div class="wrapper fadeInDown">
    <div class="container px-4 mx-auto">
        <form id="invoice" method="post" action="save_szkic.php">
        <?php
        require_once("../dbconnect.php");
                $sql1 ="SELECT `name`, `datetimedo` FROM `application` WHERE `applicationID` = $id";
                $result1 = $conn->query($sql1);
                while ($row1 = $result1->fetch_assoc()) {
                    $date = substr($row1['datetimedo'], 0, 10); // Wyodrębnienie części daty w formacie YYYY-MM-DD
        echo '<input
            class="py-2.5 px-3.5 text-sm w-2/5 hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600"
            type="text" name="name" value="' . htmlspecialchars($row1['name']) . '" placeholder="Nazwa wniosku" required>';

        echo '<input
            class="py-2.5 px-3.5 text-sm w-2/5 hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600"
            type="date" name="date" value="' . htmlspecialchars($date) . '" required><br/>';
                }
                ?>
            <div id="inRows" class="row">
                <?php

                $sql = "SELECT q.quest, q.type, qu.number, qu.applicationID, qu.req from application a, questconnect qu, quest q where a.applicationID=qu.applicationID and qu.questID=q.questID and a.applicationID=$id order by qu.number, qu.questconnectID; ";
                $result = $conn->query($sql);
                $num=0;
                $check=0;
                               while ($row = $result->fetch_assoc()) {

                    if ($num != $row['number']) {
                        if ($check == 2 or $check == 3 or $check == 4 or $check == 5 or $check == 6) {
                           echo "<script>
    var fieldsDiv = document.getElementById('" . $num . "');

    var addButton = document.createElement('button');
    addButton.setAttribute('type', 'button');
    addButton.setAttribute('class', 'btn bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded');

    addButton.textContent = '+ Dodaj pole';

    var removeButton = document.createElement('button');
    removeButton.setAttribute('type', 'button');
    removeButton.setAttribute('class', 'btn bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded');
    addButton.setAttribute('id', 'addButton_".$num."'); // Dodanie atrybutu id
    removeButton.textContent = '- Usuń pole';

    fieldsDiv.appendChild(addButton);
    fieldsDiv.appendChild(removeButton);

    addButton.addEventListener('click', function () {
        var newTextField = document.createElement('input');
        newTextField.setAttribute('type', 'text');
        newTextField.setAttribute('class', 'py-2.5 px-3.5 text-sm w-full hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600');
        newTextField.setAttribute('name', 'field_" . $num . "[]');
        newTextField.setAttribute('placeholder', 'Pole tekstowe');

        var lastTextField = document.querySelector('input[name=\"field_" . $num . "[]\"]:last-of-type');

        // Wstawiamy nowe pole tekstowe przed addButton lub jego następnym rodzeństwem

            lastTextField.parentNode.insertBefore(newTextField, lastTextField.nextSibling);
        
    });

    removeButton.addEventListener('click', function () {
        var lastTextField = document.querySelector('input[name=\"field_" . $num . "[]\"]:last-of-type');
        if (lastTextField) {
            lastTextField.parentNode.removeChild(lastTextField);
        }
    });
</script>";


                        }
                        $check = $row['type'];
                        if ($num != 0) {
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                        $num = $row['number'];
                        echo '<div class="column"><br />';
                        echo '<button class="btn bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="removeRow(this.parentNode)">-</button>';
                        echo '<select class="py-2.5 px-3.5 text-sm w-2/5 hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600" name="type_' . $row['number'] . '" onchange="showFields(this, \'field_' . $row['number'] . '[]\')">';
                        echo '<option value="2"' . ($row['type'] == 2 ? ' selected' : '') . '>Jednokrotny wybór</option>';
                        echo '<option value="3"' . ($row['type'] == 3 ? ' selected' : '') . '>Wielokrotny wybór</option>';
                        echo '<option value="1"' . ($row['type'] == 1 ? ' selected' : '') . '>Tekst</option>';
                        echo '<option value="0"' . ($row['type'] == 0 ? ' selected' : '') . '>Tekst bez pola</option>';
                        echo '<option value="4"' . ($row['type'] == 4 ? ' selected' : '') . '>Tabela</option>';
                        echo '<option value="5"' . ($row['type'] == 5 ? ' selected' : '') . '>Tabela Suma</option>';
                        echo '<option value="6"' . ($row['type'] == 6 ? ' selected' : '') . '>Tabela Róźnica</option>';
                        echo '<option value="7"' . ($row['type'] == 7 ? ' selected' : '') . '>Tabela Budżetowa</option>';
                        echo '</select>';
                        echo '<select class="py-2.5 px-3.5 text-sm w-1/6 hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600" name="required_' . $row['number'] . '">';
                        echo '<option value="1"' . ($row['req'] == 1 ? ' selected' : '') . '>Wymagane</option>';
                        echo '<option value="0"' . ($row['req'] == 0 ? ' selected' : '') . '>Opcjonalne</option>';
                        echo '</select>';
                        echo '<div class="specificFields">';
                        echo '<div id="'.$num.'" class="flex flex-col">';
                    }
                    echo " <input type='text' class='py-2.5 px-3.5 text-sm w-full hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600' name='field_" . $row['number'] . "[]' value='" . $row['quest'] . "'>";
                    $num = $row['number'];


                }

                if ($num == 2 or $num == 3 or $num == 4 or $num == 5 or $num == 6) {
                    echo "<script>
    var fieldsDiv = document.getElementById('" . $num . "');

    var addButton = document.createElement('button');
    addButton.setAttribute('type', 'button');
    addButton.setAttribute('class', 'btn bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded');

    addButton.textContent = '+ Dodaj pole';

    var removeButton = document.createElement('button');
    removeButton.setAttribute('type', 'button');
    removeButton.setAttribute('class', 'btn bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded');
    addButton.setAttribute('id', 'addButton_".$num."'); // Dodanie atrybutu id
    removeButton.textContent = '- Usuń pole';

    fieldsDiv.appendChild(addButton);
    fieldsDiv.appendChild(removeButton);

    addButton.addEventListener('click', function () {
        var newTextField = document.createElement('input');
        newTextField.setAttribute('type', 'text');
        newTextField.setAttribute('class', 'py-2.5 px-3.5 text-sm w-full hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600');
        newTextField.setAttribute('name', 'field_" . $num . "[]');
        newTextField.setAttribute('placeholder', 'Pole tekstowe');

        var lastTextField = document.querySelector('input[name=\"field_" . $num . "[]\"]:last-of-type');

        // Wstawiamy nowe pole tekstowe przed addButton lub jego następnym rodzeństwem

            lastTextField.parentNode.insertBefore(newTextField, lastTextField.nextSibling);

    });

    removeButton.addEventListener('click', function () {
        var lastTextField = document.querySelector('input[name=\"field_" . $num . "[]\"]:last-of-type');
        if (lastTextField) {
            lastTextField.parentNode.removeChild(lastTextField);
        }
    });
</script>";
                }
            if ($num != 0) {
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
?>
            </div>
            <br/>
            <input type="hidden" name="columnCounterInput" id="columnCounterInput" value="<?php echo $num; ?>">
            <input type="hidden" name="ID" id="ID" value="<?php echo $id; ?>">
            <button class="btn bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full"
                    onclick="columnCounter++;addRow(); return false;">Add Item
            </button>
            <div style="text-align: right;">
                <a href="../formready/szkic.php"><input type="button" value="Anuluj" style="background-color: red;"></a>
                <input type="submit" name="submit_draft" value="Szkic" style="background-color: green;">
                <input type="submit" name="submit_publish" value="Opublikuj">
        </form>
    </div>

</div>

</body>
<script>

    var columnCounter = <?php echo $num; ?>;

    function addRow() {
        var newColumn = document.createElement('div');
        newColumn.setAttribute("class", "column");
        newColumn.innerHTML = '<br />\
        <button class="btn bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="removeRow(this.parentNode)">-</button>\
            <select class="py-2.5 px-3.5 text-sm w-2/5 hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600" name="type_' + columnCounter + '" onchange="showFields(this, \'field_' + columnCounter + '[]\')">\
                <option value="2">Jednokrotny wybór</option>\
                <option value="3">Wielokrotny wybór</option>\
                <option value="1">Tekst</option>\
                <option value="0">Tekst bez pola</option>\
                <option value="4">Tabela</option>\
                <option value="5">Tabela Suma</option>\
                <option value="6">Tabela Róźnica</option>\
                <option value="7">Tabela Budżetowa</option>\
            </select>\
            <select class="py-2.5 px-3.5 text-sm w-1/6 hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600" name="required_' + columnCounter + '">\
                <option value="1">Wymagane</option>\
                <option value="0">Opcjonalne</option>\
            </select>\
        <div class="specificFields"></div>';

        document.getElementById('inRows').appendChild(newColumn);
        var inputElement = document.getElementById('columnCounterInput');
        if (inputElement) {
            // Pobierz jego wartość
            var currentValue = parseInt(inputElement.value);

            // Jeśli udało się przekonwertować wartość na liczbę
            if (!isNaN(currentValue)) {
                // Dodaj 1 do aktualnej wartości
                currentValue++;

                // Ustaw nową wartość w elemencie input
                inputElement.value = currentValue;
            }
        }
    }

    function removeRow(node) {
        return node.remove()
    }

    function showFields(select, clasa) {
        var selectedValue = select.value;
        var specificFieldsDiv = select.nextElementSibling.nextElementSibling; // Znajdujemy element div po select

        // Usuwamy wszystkie dzieci z diva
        while (specificFieldsDiv.firstChild) {
            specificFieldsDiv.removeChild(specificFieldsDiv.firstChild);
        }

        // Tworzymy odpowiednie pola w zależności od wybranego typu
        switch (selectedValue) {
            case "1": // Tekst
            case "0": // Tekstarea
                var textField = document.createElement('input');
                textField.setAttribute("type", "text");
                textField.setAttribute("class", "py-2.5 px-3.5 text-sm w-full hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600");
                textField.setAttribute("name", clasa);
                textField.setAttribute("placeholder", "Pole tekstowe");
                specificFieldsDiv.appendChild(textField);
                break;
            case "2":
            case "3":// Jednokrotny wybór
            case "4": // Tabela
            case "5": // Tabela suma
            case "6": // Tabela różnica
                var textField = document.createElement('input');
                textField.setAttribute("type", "text");
                textField.setAttribute("class", "py-2.5 px-3.5 text-sm w-full hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600");
                textField.setAttribute("name", clasa);
                textField.setAttribute("placeholder", "Pole tekstowe");

                var addButton = document.createElement('button');
                addButton.setAttribute("type", "button");
                addButton.setAttribute("class", "btn bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded");
                addButton.textContent = "+ Dodaj pole";

                var removeButton = document.createElement('button');
                removeButton.setAttribute("type", "button");
                removeButton.setAttribute("class", "btn bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded");
                removeButton.textContent = "- Usuń pole";

                var fieldsDiv = document.createElement('div');
                fieldsDiv.setAttribute("class", "flex flex-col");

                fieldsDiv.appendChild(textField);
                fieldsDiv.appendChild(addButton);
                fieldsDiv.appendChild(removeButton);

                specificFieldsDiv.appendChild(fieldsDiv);

                // Dodanie obsługi zdarzeń dla przycisków dodawania/usuwania pól w tabeli
                addButton.addEventListener("click", function () {
                    var newTextField = document.createElement('input');
                    newTextField.setAttribute("type", "text");
                    newTextField.setAttribute("class", "py-2.5 px-3.5 text-sm w-full hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600");
                    newTextField.setAttribute("name", clasa);
                    newTextField.setAttribute("placeholder", "Pole tekstowe");
                    fieldsDiv.insertBefore(newTextField, addButton);
                });

                removeButton.addEventListener("click", function () {
                    if (fieldsDiv.childNodes.length > 3) { // Sprawdzamy, czy jest więcej niż dwa elementy w divie (pola tekstowe i przyciski)
                        fieldsDiv.removeChild(fieldsDiv.childNodes[fieldsDiv.childNodes.length - 3]); // Usuwamy ostatnie dodane pole tekstowe
                    }

                });

                break;
            case "7": // Tabela budżetowa
                var textField = document.createElement('input');
                textField.setAttribute("type", "text");
                textField.setAttribute("class", "py-2.5 px-3.5 text-sm w-full hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600");
                textField.setAttribute("name", clasa);
                textField.setAttribute("placeholder", "Nazwa");

                var textField1 = document.createElement('input');
                textField1.setAttribute("type", "text");
                textField1.setAttribute("class", "py-2.5 px-3.5 text-sm w-full hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600");
                textField1.setAttribute("name", clasa);
                textField1.setAttribute("placeholder", "Pole");

                var textField2 = document.createElement('input');
                textField2.setAttribute("type", "text");
                textField2.setAttribute("class", "py-2.5 px-3.5 text-sm w-full hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600");
                textField2.setAttribute("name", clasa);
                textField2.setAttribute("placeholder", "Pole");

                var textField3 = document.createElement('input');
                textField3.setAttribute("type", "text");
                textField3.setAttribute("class", "py-2.5 px-3.5 text-sm w-full hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600");
                textField3.setAttribute("name", clasa);
                textField3.setAttribute("placeholder", "Pole");

                var textField4 = document.createElement('input');
                textField4.setAttribute("type", "text");
                textField4.setAttribute("class", "py-2.5 px-3.5 text-sm w-full hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600");
                textField4.setAttribute("name", clasa);
                textField4.setAttribute("placeholder", "Procent");

                var textField5 = document.createElement('input');
                textField5.setAttribute("type", "text");
                textField5.setAttribute("class", "py-2.5 px-3.5 text-sm w-full hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600");
                textField5.setAttribute("name", clasa);
                textField5.setAttribute("placeholder", "Kwota");

                var addButton = document.createElement('button');
                addButton.setAttribute("type", "button");
                addButton.setAttribute("class", "btn bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded");
                addButton.textContent = "+ Dodaj pole";

                var removeButton = document.createElement('button');
                removeButton.setAttribute("type", "button");
                removeButton.setAttribute("class", "btn bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded");
                removeButton.textContent = "- Usuń pole";

                var fieldsDiv = document.createElement('div');
                fieldsDiv.setAttribute("class", "flex flex-col");

                fieldsDiv.appendChild(textField);
                fieldsDiv.appendChild(textField1);
                fieldsDiv.appendChild(textField2);
                fieldsDiv.appendChild(textField3);
                fieldsDiv.appendChild(textField4);
                fieldsDiv.appendChild(textField5);

                specificFieldsDiv.appendChild(fieldsDiv);

                // Dodanie obsługi zdarzeń dla przycisków dodawania/usuwania pól w tabeli
                addButton.addEventListener("click", function () {
                    var newTextField = document.createElement('input');
                    newTextField.setAttribute("type", "text");
                    newTextField.setAttribute("class", "py-2.5 px-3.5 text-sm w-full hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600");
                    newTextField.setAttribute("name", clasa);
                    newTextField.setAttribute("placeholder", "Pole tekstowe");
                    fieldsDiv.insertBefore(newTextField, addButton);
                });

                removeButton.addEventListener("click", function () {
                    if (fieldsDiv.childNodes.length > 3) { // Sprawdzamy, czy jest więcej niż dwa elementy w divie (pola tekstowe i przyciski)
                        fieldsDiv.removeChild(fieldsDiv.childNodes[fieldsDiv.childNodes.length - 3]); // Usuwamy ostatnie dodane pole tekstowe
                    }

                });

                break;
            default:

                var fieldsDiv = document.querySelector('.flex.flex-col');

                var addButton = document.createElement('button');
                addButton.setAttribute("type", "button");
                addButton.setAttribute("class", "btn bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded");
                addButton.textContent = "+ Dodaj pole";

                var removeButton = document.createElement('button');
                removeButton.setAttribute("type", "button");
                removeButton.setAttribute("class", "btn bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded");
                removeButton.textContent = "- Usuń pole";

                fieldsDiv.appendChild(addButton);
                fieldsDiv.appendChild(removeButton);

            addButton.addEventListener("click", function () {
                    var newTextField = document.createElement('input');
                    newTextField.setAttribute("type", "text");
                    newTextField.setAttribute("class", "py-2.5 px-3.5 text-sm w-full hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600");
                    newTextField.setAttribute("name", clasa);
                    newTextField.setAttribute("placeholder", "Pole tekstowe");
                    fieldsDiv.insertBefore(newTextField, addButton);
                });

                removeButton.addEventListener("click", function () {
                    if (fieldsDiv.childNodes.length > 3) { // Sprawdzamy, czy jest więcej niż dwa elementy w divie (pola tekstowe i przyciski)
                        fieldsDiv.removeChild(fieldsDiv.childNodes[fieldsDiv.childNodes.length - 3]); // Usuwamy ostatnie dodane pole tekstowe
                    }

                });
                break;
        }
    }

</script>
</html>