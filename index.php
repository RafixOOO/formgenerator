<html>
<head>
    <meta charset ="utf-8" />    
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="style.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Generator | Logowanie</title>
</head>
<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->

            <!-- Icon -->
            <div class="fadeIn first">
                <img src="img/Fundacja-SMK-CMYK-logotyp.jpg" id="icon" alt="User Icon" />
            </div>

            <!-- Login Form -->
            <form action="login.php" method="post">
                <input type="text" id="login" class="fadeIn second" name="login" placeholder="login">
                <input type="password" id="password" class="fadeIn third" name="password" placeholder="password">
                <input type="submit" class="fadeIn fourth" value="Log In">
            </form>

            <!-- Remind Passowrd -->
            <div id="formFooter">
                <a class="underlineHover" href="#">Forgot Password?</a>
                <a class="underlineHover" href="register/register.php">Register</a>
            </div>

        </div>
    </div>
    <?php
                    // Sprawdzanie czy parametr error jest ustawiony i równy 'invalid_password'
                    if(isset($_GET['error']) && $_GET['error'] == 'invalid_password') {
                        echo '<script>toastr.error("Nieprawidłowe hasło.");</script>';
                    }
                    // Sprawdzanie czy parametr error jest ustawiony i równy 'user_not_found'
                    if(isset($_GET['error']) && $_GET['error'] == 'user_not_found') {
                        echo '<script>toastr.error("Użytkownik o podanym loginie nie istnieje.");</script>';
                    }
                    ?>
</body>
</html>