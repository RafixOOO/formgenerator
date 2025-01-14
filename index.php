<!DOCTYPE html>
<html lang="PL">
<head>
    <meta charset="utf-8"/>

    <link href="style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="style.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Generator | Logowanie</title>
    <link rel="icon" href="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEAAAAALAAAAAABAAEAAAIA" type="image/gif">

    <style>
        .code-input-container {
            display: flex;
        }

        .code-input {
            resize: none; /* Wyłączenie możliwości zmiany rozmiaru */
            /* Pozostałe style */
            width: calc(100% / 6 - 10px);
            height: 50px;
            box-sizing: border-box;
            margin-right: 5px;
            padding: 5px;
            font-size: 24px;
            text-align: center;
        }
    </style>
</head>
<body>
<!-- 2024 Created by: Rafał Pezda-->
<!-- link: https://github.com/RafixOOO -->
<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first">
            <img src="img/Fundacja-SMK-CMYK-logotyp.jpg" id="icon" alt="User Icon"/>
        </div>

        <!-- Login Form -->
        <form action="login.php" method="post">
            <input type="text" id="login" class="fadeIn second" name="login" placeholder="Email">
            <input type="password" id="password" class="fadeIn third" name="password" placeholder="Hasło">
            <input type="submit" class="fadeIn fourth" value="Zaloguj się">
        </form>

        <!-- Remind Passowrd -->
        <div id="formFooter">
            <a class="underlineHover" data-toggle="modal" data-target="#forgotPasswordModal" href="#">Zapomniałeś
                hasła?</a>
            <a class="underlineHover" href="register/register.php">Zarejestruj się</a>
        </div>

    </div>
</div>
<div
    class="modal fade"
    id="editModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="editModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editModalLabel">Weryfikacja emaila</h4>
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <div class="code-input-container">
                    <textarea id="code1" class="code-input" maxlength="1"></textarea>
                    <textarea id="code2" class="code-input" maxlength="1"></textarea>
                    <textarea id="code3" class="code-input" maxlength="1"></textarea>
                    <textarea id="code4" class="code-input" maxlength="1"></textarea>
                    <textarea id="code5" class="code-input" maxlength="1"></textarea>
                    <textarea id="code6" class="code-input" maxlength="1"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="resendButton">
                    Wyślij kod Ponownie
                </button>
                <button type="button" id="verifyButton" class="btn btn-success">
                    <i class="fas fa-location-arrow" style="margin-right:5px"></i> Zweryfikuj
                </button>
            </div>
        </div>
    </div>
</div>
<div
    class="modal fade"
    id="forgotPasswordModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="editModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editModalLabel">Reset hasła</h4>
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <div class="code-input-container">
                    <input type="text" id="email" placeholder="Adres Email">
                </div>
            </div>
            <div class="modal-footer">

                <button type="button" id="resetpassword" class="btn btn-success">
                    <i class="fas fa-location-arrow" style="margin-right:5px"></i> Resetuj
                </button>
            </div>
        </div>
    </div>
</div>
<script>
 function verify(){
        var button = $(this);
            var countdown = 60;
            var originalText = 'Wyślij kod';

            // Wyłącz przycisk
            button.prop("disabled", true).addClass('btn-disabled');

            // Aktualizuj tekst przycisku co sekundę
            var timer = setInterval(function () {
                if (countdown > 0) {
                    countdown--;
                    button.html('Wyślij ponownie za ' + countdown + 's');
                } else {
                    clearInterval(timer);
                    button.prop("disabled", false).removeClass('btn-disabled').html(originalText);
                }
            }, 1000);

            // Wygeneruj kod weryfikacyjny
            verifycode = Math.floor(100000 + Math.random() * 900000);

            // Przykład użycia $.ajax do wysłania kodu weryfikacyjnego
            $.ajax({
                url: 'mail/verifyemail.php',
                method: 'POST',
                data: {
                    verification_code: verifycode
                },
                success: function (response) {
                    console.log("Sukces:", response);
                    // Dodaj kod obsługi sukcesu, na przykład odświeżenie interfejsu użytkownika
                },
                error: function (xhr, status, error) {
                    console.error("Błąd:", error);
                    // Dodaj kod obsługi błędu, na przykład informacja użytkownikowi o problemie
                }
            });
    }
    </script>
<?php
$show_modal = false;
if (isset($_GET['error']) && $_GET['error'] === 'verify') {
    $show_modal = true;
    echo "<script>verify();</script>";

}

// Sprawdzanie czy parametr error jest ustawiony i równy 'invalid_password'
if (isset($_GET['error']) && $_GET['error'] == 'invalid_password') {
    echo '<script>toastr.error("Nieprawidłowe hasło.");</script>';
}

if (isset($_GET['error']) && $_GET['error'] == 'expire') {
    echo '<script>toastr.error("Link wygasł.");</script>';
}

if (isset($_GET['error']) && $_GET['error'] == 'blad') {
    echo '<script>toastr.error("Błąd.");</script>';
}
// Sprawdzanie czy parametr error jest ustawiony i równy 'user_not_found'
if (isset($_GET['error']) && $_GET['error'] == 'user_not_found') {
    echo '<script>toastr.error("Użytkownik o podanym loginie nie istnieje.");</script>';
}
if (isset($_GET['success']) && $_GET['success'] == 'password_change') {
    echo '<script>toastr.success("Hasło zostało zmienione.");</script>';
}
?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Script to trigger the modal -->
<?php if ($show_modal): ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#editModal').modal('show');
        });
    </script>
<?php endif; ?>

</body>
<script>
    var verifycode; // Zmienna przechowująca wygenerowany kod weryfikacyjny
    $(document).ready(function () {
        // Obsługa kliknięcia przycisku "Wyślij kod"
        $("#resendButton").click(function () {
            verify();
        });

        // Obsługa kliknięcia przycisku "Zweryfikuj"
        $("#verifyButton").click(function () {
            // Pobierz wartości kodów z pól
            var code1 = $("#code1").val();
            var code2 = $("#code2").val();
            var code3 = $("#code3").val();
            var code4 = $("#code4").val();
            var code5 = $("#code5").val();
            var code6 = $("#code6").val();

            // Połącz wszystkie kody w jedną zmienną
            var codefull = code1 + code2 + code3 + code4 + code5 + code6;
            console.log(codefull);
            console.log(verifycode);
            // Sprawdź czy wprowadzony kod weryfikacyjny jest poprawny
            if (verifycode == codefull) {
                // Wykonaj żądanie AJAX do skryptu PHP 'verify.php' w celu zapisania danych
                $.ajax({
                    url: 'verify.php', // Zmień na odpowiedni adres URL do skryptu PHP zapisującego dane
                    method: 'POST',
                    success: function (response) {
                        console.log("Sukces:", response);
                        // Przekieruj użytkownika na stronę "forms/forms.php"
                        window.location.href = "forms/forms.php";
                        toastr.success('Dane zapisano pomyślnie!');
                    },
                    error: function (xhr, status, error) {
                        console.error("Błąd:", error);
                        // Dodaj kod obsługi błędu - na przykład, wyświetlenie komunikatu toastr z błędem
                        toastr.error('Wystąpił błąd podczas zapisywania danych.');
                    }
                });
            } else {
                // Wyświetl komunikat o błędnym kodzie weryfikacyjnym za pomocą Toastr
                toastr.error('Zły kod weryfikacyjny.');
            }
        });

        $("#resetpassword").click(function () {

            var button = $(this);
            var countdown = 60;
            var originalText = 'Resetuj';

            // Wyłącz przycisk
            button.prop("disabled", true).addClass('btn-disabled');

            // Aktualizuj tekst przycisku co sekundę
            var timer = setInterval(function () {
                if (countdown > 0) {
                    countdown--;
                    button.html('Wyślij ponownie za ' + countdown + 's');
                } else {
                    clearInterval(timer);
                    button.prop("disabled", false).removeClass('btn-disabled').html(originalText);
                }
            }, 1000);

            // Pobierz wartości kodów z pól
            var email = $("#email").val();

            $.ajax({
                url: 'mail/resetpassword.php', // Zmień na odpowiedni adres URL do skryptu PHP zapisującego dane
                method: 'POST',
                data: {
                    email: email
                },
                success: function (response) {
                    console.log("Sukces:", response);
                },
                error: function (xhr, status, error) {
                    console.error("Błąd:", error);
                    // Dodaj kod obsługi błędu - na przykład, wyświetlenie komunikatu toastr z błędem
                    toastr.error('Wystąpił błąd podczas zapisywania danych.');
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        var inputs = document.querySelectorAll('.code-input');

        inputs.forEach(function (input, index) {
            input.addEventListener('input', function () {
                if (this.value.length >= 1) {
                    // Przejdź do następnego pola, jeśli aktualne ma długość co najmniej 1
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                }
            });
        });
    });
</script>
</html>