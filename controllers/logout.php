<?php
    setcookie('user_type', $_COOKIE['user_type'], time() - 10, "/");
    header('location: ../views/login.php');
?>