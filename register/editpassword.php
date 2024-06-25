<html>
<head>
<meta charset ="utf-8" />
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="style.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Generator | Reset Hasła</title>
</head>
<body>
<!-- 2024 Created by: Rafał Pezda-->
<!-- link: https://github.com/RafixOOO -->
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->

            <!-- Icon -->
            <div class="fadeIn first">
                Reset Hasła
            </div>

            <!-- Login Form -->
            <form action="save_editpassword.php" method="post">
            <input type="hidden" value ="" />
                <input type="password" id="password1" class="fadeIn third" name="password1" placeholder="Nowe Hasło">
                <input type="password" id="password2" class="fadeIn third" name="password2" placeholder="Powtórz Nowe Hasło">
                <input type="button" onclick="checkPassword()" class="fadeIn fourth" value="Zmień">
            </form>

        </div>

    </div>
</body>
    <script>
          function checkPassword() {
    var password1 = document.getElementById("password1").value;
    var password2 = document.getElementById("password2").value;

    // Sprawdź, czy żadne pole nie jest puste
    if (password1 === "" || password2 === "") {
        toastr.error("Wszystkie pola muszą być wypełnione.");
        return; // Zakończ funkcję, jeśli jakieś pole jest puste
    }

    // Sprawdź, czy hasła są identyczne
    if (password1 !== password2) {
        toastr.error("Hasła nie są identyczne. Proszę wprowadzić takie same hasła.");
        return; // Zakończ funkcję, jeśli hasła nie są identyczne
    }

    // Jeśli wszystkie pola są wypełnione i hasła są identyczne oraz formaty telefonu i e-mail są poprawne, wyślij formularz
    var form = document.querySelector('form'); // Pobierz formularz
    form.submit(); // Wyślij formularz
}
        </script>
</html>