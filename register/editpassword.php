<html>
<head>
<meta charset ="utf-8" />
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="style.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Generator | Rejestracja</title>
</head>
<body>
<!-- 2024 Created by: Rafał Pezda-->
<!-- link: https://github.com/RafixOOO -->
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->

            <!-- Icon -->
            <div class="fadeIn first">
                Register
            </div>

            <!-- Login Form -->
            <form action="../index.php" method="post">
                <input type="password" id="number" class="fadeIn third" name="password1" placeholder="6-CYFROWY KODU">
                <input type="password" id="password1" class="fadeIn third" name="password1" placeholder="Noew Hasło">
                <input type="password" id="password2" class="fadeIn third" name="password2" placeholder="Powtórz Nowe Hasło">
                <input type="button" onclick="checkPassword()" class="fadeIn fourth" value="Zmień">
            </form>
            <div id="formFooter">
                <a class="underlineHover" href="../index.php">Posiadasz konto?</a>
                </div>

        </div>

    </div>
    <?php
                // Sprawdzanie czy parametr error jest ustawiony i równy 'email_exists'
                if(isset($_GET['error']) && $_GET['error'] == 'email_exists') {
                    echo '<script>toastr.error("Podany email już istnieje.");</script>';
                }
                // Sprawdzanie czy parametr error jest ustawiony i równy 'password_error'
                if(isset($_GET['error']) && $_GET['error'] == 'password_error') {
                    echo '<script>toastr.error("Błąd podczas dodawania hasła.");</script>';
                }
                // Sprawdzanie czy parametr error jest ustawiony i równy 'user_error'
                if(isset($_GET['error']) && $_GET['error'] == 'user_error') {
                    echo '<script>toastr.error("Błąd podczas dodawania użytkownika.");</script>';
                }
                // Sprawdzanie czy parametr success jest ustawiony i równy 'registration_success'
                if(isset($_GET['success']) && $_GET['success'] == 'registration_success') {
                    echo '<script>toastr.success("Rejestracja zakończona sukcesem.");</script>';
                }
                ?>
</body>
    <script>
          function checkPassword() {
    var name = document.getElementById("name").value;
    var surname = document.getElementById("surname").value;
    var phone = document.getElementById("phone").value;
    var email = document.getElementById("email").value;
    var password1 = document.getElementById("password1").value;
    var password2 = document.getElementById("password2").value;

    // Sprawdź, czy żadne pole nie jest puste
    if (name === "" || surname === "" || phone === "" || email === "" || password1 === "" || password2 === "") {
        toastr.error("Wszystkie pola muszą być wypełnione.");
        return; // Zakończ funkcję, jeśli jakieś pole jest puste
    }

    // Sprawdź, czy hasła są identyczne
    if (password1 !== password2) {
        toastr.error("Hasła nie są identyczne. Proszę wprowadzić takie same hasła.");
        return; // Zakończ funkcję, jeśli hasła nie są identyczne
    }

    // Sprawdź poprawność formatu telefonu (cyfry i opcjonalny znak "+")
    var phoneRegex = /^\+?[0-9]+$/;
    if (!phoneRegex.test(phone)) {
        toastr.error("Nieprawidłowy format numeru telefonu.");
        return; // Zakończ funkcję, jeśli numer telefonu jest w nieprawidłowym formacie
    }

    // Sprawdź poprawność formatu adresu e-mail
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        toastr.error("Nieprawidłowy format adresu e-mail.");
        return; // Zakończ funkcję, jeśli adres e-mail jest w nieprawidłowym formacie
    }

    // Jeśli wszystkie pola są wypełnione i hasła są identyczne oraz formaty telefonu i e-mail są poprawne, wyślij formularz
    var form = document.querySelector('form'); // Pobierz formularz
    form.submit(); // Wyślij formularz
}
        </script>
</html>