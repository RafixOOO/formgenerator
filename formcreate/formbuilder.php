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
            <option value="8">Dane osobowe(imię, nazwisko, email, numer telefonu)</option>\
            <option value="9">Organizacja</option>\
            <option value="10">pytanie(Komisja)</option>\
            <option value="11">Tabela punktów(Komisja)</option>\
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
            case "10": // Pytanie
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
            case "11": // Tabela punktów
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