<?php
unset($_SESSION['user_id']);
unset($_SESSION['imie_nazwisko']);
unset($_SESSION['role']);
header("Location: index.html"); // Przekierowanie na stronę po zalogowaniu
exit;
?>