<?php require_once("../auth.php"); ?>

<?php if (!isLoggedIn()):
    header("Location: ../index.php"); // Przekierowanie na stronę po zalogowaniu
    exit;
endif;

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
    <link rel="icon" href="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEAAAAALAAAAAABAAEAAAIA" type="image/gif">

    <title>Generator | Strona główna</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<!-- 2024 Created by: Rafał Pezda-->
<!-- link: https://github.com/RafixOOO -->
<div class="wrapper fadeInDown">
    <div class="container px-4 mx-auto">
        <form id="invoice" method="post" action="save_data.php">
            <input
                class="py-2.5 px-3.5 text-sm w-2/5 hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600"
                type="text" name="name" placeholder="Nazwa wniosku" required>
            <input
                class="py-2.5 px-3.5 text-sm w-2/5 hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600"
                type="date" name="date" required><br/>
            <div id="inRows" class="row">

            </div>
            <br/>
            <input type="hidden" name="columnCounterInput" id="columnCounterInput" value="0">
            <button class="btn bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full"
                    onclick="columnCounter++;addRow(); return false;">Add Item
            </button>
            <div style="text-align: right;">
                <a href="../forms/forms.php"><input type="button" value="Anuluj" style="background-color: red;"></a>
                <input type="submit" name="submit_draft" value="Szkic" style="background-color: green;">
                <input type="submit" name="submit_publish" value="Opublikuj">
        </form>
    </div>

</div>

</body>
<script>

    var columnCounter = 0;

    function addRow() {
        var newColumn = document.createElement('div');
        newColumn.setAttribute("class", "column");
        newColumn.innerHTML = '<br />\ <input type="hidden" name="checkbox_' + columnCounter + '" value="0">\
<input type="checkbox" id="checkbox_' + columnCounter + '" name="checkbox_' + columnCounter + '" class="ml-2 rounded border-neutral-200 focus:ring-neutral-600" value="1">\
<label for="checkbox_' + columnCounter + '" class="ml-1 text-sm text-neutral-600">Sprawozdanie</label>\
<input type="hidden" name="checkboxrep_' + columnCounter + '" value="0">\
<input type="checkbox" id="checkboxrep_' + columnCounter + '" name="checkboxrep_' + columnCounter + '" class="ml-2 rounded border-neutral-200 focus:ring-neutral-600" value="1" checked>\
<label for="checkboxrep_' + columnCounter + '" class="ml-1 text-sm text-neutral-600">Raport</label>\
        <br />\
    <button type="button" class="btn bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" name="up" onclick="upnode(this.parentNode)">↑</button>\
        <button type="button" class="btn bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" name="down" onclick="downnode(this.parentNode)">↓</button>\
    <button class="btn bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="removeRow(this.parentNode)">-</button>\
        <select class="py-2.5 px-3.5 text-sm w-2/5 hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600" name="type_' + columnCounter + '" onchange="showFields(this, \'field_' + columnCounter + '[]\');toggleCheckbox(this, \'checkbox_' + columnCounter + '\',\'checkboxrep_' + columnCounter + '\');" required>\
            <option value="" disabled selected>Wybierz opcję</option>\
            <optgroup label="Opcje">\
            <option value="3">Jednokrotny wybór</option>\
            <option value="2">Wielokrotny wybór</option>\
            <option value="1">Pytanie</option>\
            <option value="12">Grupa pytań</option>\
            <option value="0">Etykieta</option>\
            <option value="4">Tabela</option>\
            <option value="5">Tabela Obliczeń(Suma)</option>\
            <option value="6">Tabela Obliczeń(Różnica)</option>\
            <option value="7">Tabela Budżetowa</option>\
            </optgroup>\
            <optgroup label="Opcje dynamiczne">\
            <option value="8">Dane osobowe(imię, nazwisko, email, numer telefonu)</option>\
            <option value="9">Organizacja</option>\
            </optgroup>\
            <optgroup label="Komisja">\
            <option value="10">Pytanie</option>\
            <option value="11">Tabela punktów</option>\
            </optgroup>\
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

    function toggleCheckbox(selectElement, checkboxId, checkboxrepId) {
    const checkbox = document.getElementById(checkboxId);
    const checkboxrep = document.getElementById(checkboxrepId);
    if (selectElement.value === "10" || selectElement.value === "11" || selectElement.value === "8" || selectElement.value === "9") {
        checkbox.disabled = true; // Wyłącz checkbox
        checkbox.checked = false; // Odznacz checkbox
        checkboxrep.disabled = true; // Wyłącz checkbox
        checkboxrep.checked = false; // Odznacz checkbox
    } else {
        checkbox.disabled = false; // Włącz checkbox
        checkboxrep.disabled = false;
    }
}

    function upnode(button) {
        var currentColumn = button;
        var previousColumn = currentColumn.previousElementSibling;

        if (previousColumn !== null) {
            currentColumn.parentNode.insertBefore(currentColumn, previousColumn);
            updateFields(currentColumn);
            updateFields(previousColumn);
        }
    }

    function downnode(button) {
        var currentColumn = button;
        var nextColumn = currentColumn.nextElementSibling;

        if (nextColumn !== null) {
            currentColumn.parentNode.insertBefore(nextColumn, currentColumn);
            updateFields(currentColumn);
            updateFields(nextColumn);
        }
    }

    function updateFields(column) {
    var select = column.querySelector('select[name^="type_"]');
    var required = column.querySelector('select[name^="required_"]');
    var specificFieldsContainer = column.querySelector('.specificFields');
    var specificFields = specificFieldsContainer.querySelectorAll('input[name^="field_"]');

    if (select) {
        var index = Array.prototype.indexOf.call(select.parentNode.parentNode.children, select.parentNode) + 1;
        select.name = 'type_' + index;
        select.setAttribute('onchange', 'showFields(this, "field_' + index + '[]")');
    }
    if (required) {
        required.name = 'required_' + index;
    }
    specificFields.forEach(function (field) {
        var baseName = field.name.split('_')[0];
        field.name = baseName + '_' + index + '[]';
    });
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
            case "12": // grupa pytań
                var textField = document.createElement('input');
                textField.setAttribute("type", "text");
                textField.setAttribute("class", "py-2.5 px-3.5 text-sm w-full hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600");
                textField.setAttribute("name", clasa);
                textField.setAttribute("placeholder", "Pole tekstowe");
                textField.setAttribute("required", "required");
                specificFieldsDiv.appendChild(textField);

                var textField = document.createElement('input');
                textField.setAttribute("type", "text");
                textField.setAttribute("class", "py-2.5 px-3.5 text-sm w-full hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600");
                textField.setAttribute("name", clasa);
                textField.setAttribute("placeholder", "Pole tekstowe");
                textField.setAttribute("required", "required");
                specificFieldsDiv.appendChild(textField);
                break;
            case "1": // Tekst
            case "0": // Tekstarea
            case "10": // Pytanie
                var textField = document.createElement('input');
                textField.setAttribute("type", "text");
                textField.setAttribute("class", "py-2.5 px-3.5 text-sm w-full hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600");
                textField.setAttribute("name", clasa);
                textField.setAttribute("placeholder", "Pole tekstowe");
                textField.setAttribute("required", "required");
                specificFieldsDiv.appendChild(textField);
                break;
            case "2":
            case "3":// Jednokrotny wybór
            case "4": // Tabela
            case "5": // Tabela suma
            case "6": // Tabela różnica
            case "11": // Tabela punktów
                var textField = document.createElement('input');
                textField.setAttribute("type", "text");
                textField.setAttribute("class", "py-2.5 px-3.5 text-sm w-full hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600");
                textField.setAttribute("name", clasa);
                textField.setAttribute("placeholder", "Pole tekstowe");
                textField.setAttribute("required", "required");


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
                    textField.setAttribute("required", "required");
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
                textField.setAttribute("value", "Rodzaj kosztu");

                var textField1 = document.createElement('input');
                textField1.setAttribute("type", "text");
                textField1.setAttribute("class", "py-2.5 px-3.5 text-sm w-full hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600");
                textField1.setAttribute("name", clasa);
                textField1.setAttribute("value", "Wartość w PLN");

                var textField2 = document.createElement('input');
                textField2.setAttribute("type", "text");
                textField2.setAttribute("class", "py-2.5 px-3.5 text-sm w-full hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600");
                textField2.setAttribute("name", clasa);
                textField2.setAttribute("value", "Z dotacji z PLN");

                var textField3 = document.createElement('input');
                textField3.setAttribute("type", "text");
                textField3.setAttribute("class", "py-2.5 px-3.5 text-sm w-full hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600");
                textField3.setAttribute("name", clasa);
                textField3.setAttribute("value", "Środki własne w PLN");

                var textField4 = document.createElement('input');
                textField4.setAttribute("type", "text");
                textField4.setAttribute("class", "py-2.5 px-3.5 text-sm w-full hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600");
                textField4.setAttribute("name", clasa);
                textField4.setAttribute("placeholder", "wpisz ile % mogą stanowić koszty administracyjne");
                textField4.setAttribute("required", "");

                var textField5 = document.createElement('input');
                textField5.setAttribute("type", "text");
                textField5.setAttribute("class", "py-2.5 px-3.5 text-sm w-full hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600");
                textField5.setAttribute("name", clasa);
                textField5.setAttribute("placeholder", "wpisz maksymalną kwote dofinansowania");
                textField5.setAttribute("required", "");

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
            case "8": // dane

                var textField = document.createElement('input');
                textField.setAttribute("type", "hidden");
                textField.setAttribute("class", "py-2.5 px-3.5 text-sm w-full hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600");
                textField.setAttribute("name", clasa);
                textField.setAttribute("placeholder", "Pole tekstowe");
                textField.setAttribute("value", "Dane");
                specificFieldsDiv.appendChild(textField);

                break;
            case "9": // organizacja

                var textField = document.createElement('input');
                textField.setAttribute("type", "hidden");
                textField.setAttribute("class", "py-2.5 px-3.5 text-sm w-full hover:bg-gray-50 outline-none placeholder-neutral-400 border border-neutral-200 rounded-lg focus-within:border-neutral-600");
                textField.setAttribute("name", clasa);
                textField.setAttribute("placeholder", "Pole tekstowe");
                textField.setAttribute("value", "Organizacja");
                specificFieldsDiv.appendChild(textField);

                break;
            default:
                break;
        }
    }


</script>
</html>