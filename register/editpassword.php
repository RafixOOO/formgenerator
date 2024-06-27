<?php
function decrypt_data($encrypted_data, $key)
{
    $encrypted_data = base64_decode($encrypted_data);
    $ivlen = openssl_cipher_iv_length($cipher = "AES-256-CBC");
    $iv = substr($encrypted_data, 0, $ivlen);
    $ciphertext = substr($encrypted_data, $ivlen);
    $original_data = openssl_decrypt($ciphertext, $cipher, $key, $options = 0, $iv);
    return $original_data;
}

$key = "e1f7e2b9a8b4d5e7c6a9d4b7e1f7a2b9";  // Ten sam klucz używany do szyfrowania

$encrypted_data = urldecode($_GET['ID']);  // Pobierz zaszyfrowane dane z URL
$decrypted_data = decrypt_data($encrypted_data, $key);
$data = json_decode($decrypted_data, true);

if ($data) {
    $current_time = time();
    if ($current_time > $data['expiry']) {
        header("Location: ../index.php?error=expire");
        exit;
    }
} else {
    header("Location: ../index.php?error=blad");
    exit;
}
?>

<!DOCTYPE html>
<html lang="PL">
<head>
    <meta charset="utf-8"/>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="style.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"
            integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css"
          integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
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
            <input type="hidden" id="ID" name="ID" value="<?php echo $data['id']; ?>"/>
            <input type="password" id="password1" class="fadeIn third" name="password1" placeholder="Nowe Hasło">
            <input type="password" id="password2" class="fadeIn third" name="password2"
                   placeholder="Powtórz Nowe Hasło">
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