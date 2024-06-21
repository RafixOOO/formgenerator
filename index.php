<html>
<head>
    <meta charset="utf-8"/>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="style.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"
            integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css"
          integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>Generator | Logowanie</title>
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
            <a class="underlineHover" href="#">Zapomniałeś hasła?</a>
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
        <form method="post" action="xx">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editModalLabel">Weryfikacja emaila</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <div class="code-input-container">
                        <textarea id="code1" class="code-input" maxlength="1" ></textarea>
                        <textarea id="code2" class="code-input" maxlength="1" ></textarea>
                        <textarea id="code3" class="code-input" maxlength="1" ></textarea>
                        <textarea id="code4" class="code-input" maxlength="1" ></textarea>
                        <textarea id="code5" class="code-input" maxlength="1" ></textarea>
                        <textarea id="code6" class="code-input" maxlength="1" ></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                     <button type="button" class="btn btn-default" id="resendButton">
        Wyślij kod
    </button>
                    <button type="submit" name="submit" class="btn btn-success">
                        <i class="fas fa-location-arrow " style="margin-right:5px"></i> Zweryfikuj
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php

$show_modal = false;
if (isset($_GET['error']) && $_GET['error'] === 'verify') {
    $show_modal = true;
}

// Sprawdzanie czy parametr error jest ustawiony i równy 'invalid_password'
if (isset($_GET['error']) && $_GET['error'] == 'invalid_password') {
    echo '<script>toastr.error("Nieprawidłowe hasło.");</script>';
}
// Sprawdzanie czy parametr error jest ustawiony i równy 'user_not_found'
if (isset($_GET['error']) && $_GET['error'] == 'user_not_found') {
    echo '<script>toastr.error("Użytkownik o podanym loginie nie istnieje.");</script>';
}
?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Script to trigger the modal -->
<?php if ($show_modal): ?>
<script type="text/javascript">
  $(document).ready(function() {
    $('#editModal').modal('show');
  });
</script>
<?php endif; ?>

</body>
    <script>
     $(document).ready(function(){
         $("#resendButton").click(function(){
             var button = $(this);
             var countdown = 60;
             var originalText = 'Wyślij kod';

             // Disable the button
             button.prop("disabled", true).addClass('btn-disabled');

             // Update the button text every second
             var timer = setInterval(function(){
                 if (countdown > 0) {
                     countdown--;
                     button.html('Wyślij ponownie za ' + countdown + 's');
                 } else {
                     clearInterval(timer);
                     button.prop("disabled", false).removeClass('btn-disabled').html(originalText);
                 }
             }, 1000);

             // $.ajax({
             //     url: '../mail/verifymail.php',
             //     method: 'POST',
             //     data: { user_id: userId },
             //     success: function(response) {
             //         // Handle success
             //     }
             // });
         });
     });

    document.addEventListener('DOMContentLoaded', function() {
        var inputs = document.querySelectorAll('.code-input');

        inputs.forEach(function(input, index) {
            input.addEventListener('input', function() {
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