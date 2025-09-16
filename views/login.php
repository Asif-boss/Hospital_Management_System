<?php
session_start();

if (isset($_COOKIE['user_type'])) {
    $user_type = $_COOKIE['user_type'];
    
    if ($user_type === 'patient') {
        header('location: dashboard.php');
    } elseif ($user_type === 'admin' || $user_type === 'super_admin') {
        header('location: dashboard.php');
    } elseif ($user_type === 'receptionist') {
        header('location: dashboard.php');
    } elseif ($user_type === 'doctor') {
        header('location: dashboard.php');
    }
} elseif (isset($_SESSION['user_type'])) {
    $user_type = $_SESSION['user_type'];

    if ($user_type === 'patient') {
        header('location: dashboard.php');
    } elseif ($user_type === 'admin' || $user_type === 'super_admin') {
        header('location: dashboard.php');
    } elseif ($user_type === 'receptionist') {
        header('location: dashboard.php');
    } elseif ($user_type === 'doctor') {
        header('location: dashboard.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>BD Hospital - Login</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    <div class="container">
        <h1>BD Hospital</h1>
        <p>Healthcare System</p>

        <form id="loginForm" action="../controllers/loginCheck.php" method="post">
            <h2>Login</h2>

            <?php
            if (isset($_REQUEST['success']) && $_REQUEST['success'] == "registrer") {
                echo '<div class="success-message">Successfully created your account, now login!</div>';
            }
            ?>
            <?php
            if (isset($_REQUEST['error']) && $_REQUEST['error'] == "invalid_log") {
                echo '<div class="error-message">Invalid Email or password!</div>';
            }
            ?>

            <div class="form-group">
                <label for="loginEmail">Email Address</label>
                <input type="email" id="loginEmail" name="email" placeholder="email@email.com">
                <span class="error-text" id="loginEmailError"></span>
            </div>

            <div class="form-group">
                <label for="loginPassword">Password</label>
                <input type="password" id="loginPassword" name="password" placeholder="Password">
                <span class="error-text" id="loginPasswordError"></span>
            </div>

            <div class="form-options">
                <label>
                    <input type="checkbox" name="remember">
                    Remember me
                </label>
            </div>

            <button type="submit" class="submit-btn">Login</button>
            <p><a href="register.php">Need an account? Register</a></p>
        </form>
    </div>

    <script src="../assets/js/login_validation.js"></script>
</body>
</html>