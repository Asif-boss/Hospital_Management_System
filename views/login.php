<?php
if (isset($_COOKIE['user_type'])) {
    if ($_COOKIE['user_type'] === 'patient') {
        header('location: patient/dashboard.php');
    } elseif ($_COOKIE['user_type'] === 'admin') {
        header('location: admin/dashboard.php');
    } elseif ($_COOKIE['user_type'] === 'receptionist') {
        header('location: receptionist/dashboard.php');
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BD Hospital - Login</title>
    <link rel="stylesheet" href="../assets/css/login.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <i class="fas fa-hospital"></i>
            <h1>BD Hospital</h1>
            <p>Healthcare Management System</p>
        </div>

        <div class="login-tabs">
            <button class="tab-btn active" data-tab="login">Login</button>
            <button class="tab-btn" data-tab="register">Register</button>
        </div>

        <!-- Login Form -->
        <form id="loginForm" class="auth-form active" action="../controllers/loginCheck.php" method="post" enctype="multipart/form-data">
            <h2>Welcome Back</h2>

            <?php
            if (isset($_REQUEST['error'])) {
                if ($_REQUEST['error'] == "invalid_log") {
                    echo '  <div class="error-message">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Invalid username or password!
                                </div>';
                }
            }
            ?>

            <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" id="loginUsername" name="username" placeholder="Username" required>
                <span class="error-text" id="loginUsernameError"></span>
            </div>

            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="loginPassword" name="password" placeholder="Password" required>
                <span class="error-text" id="loginPasswordError"></span>
            </div>

            <div class="form-options">
                <label class="checkbox-container">
                    <input type="checkbox" name="remember">
                    <span class="checkmark"></span>
                    Remember me
                </label>
            </div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-sign-in-alt"></i>
                Login
            </button>
        </form>

        <!-- Registration Form -->
        <form id="registerForm" class="auth-form" method="POST" action="views/register.php">
            <h2>New Patient Registration</h2>

            <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" id="regName" name="name" placeholder="Full Name" required>
                <span class="error-text" id="regNameError"></span>
            </div>

            <div class="form-group">
                <i class="fas fa-envelope"></i>
                <input type="email" id="regEmail" name="email" placeholder="Email Address" required>
                <span class="error-text" id="regEmailError"></span>
            </div>

            <div class="form-group">
                <i class="fas fa-id-card"></i>
                <input type="text" id="regNid" name="nid" placeholder="National ID (NID)" required>
                <span class="error-text" id="regNidError"></span>
            </div>

            <div class="form-group">
                <i class="fas fa-phone"></i>
                <input type="tel" id="regPhone" name="phone" placeholder="Phone Number" required>
                <span class="error-text" id="regPhoneError"></span>
            </div>

            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="regPassword" name="password" placeholder="Password" required>
                <span class="error-text" id="regPasswordError"></span>
            </div>

            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="regConfirmPassword" name="confirm_password" placeholder="Confirm Password" required>
                <span class="error-text" id="regConfirmPasswordError"></span>
            </div>

            <div class="form-options">
                <label class="checkbox-container">
                    <input type="checkbox" id="agreeTerms" required>
                    <span class="checkmark"></span>
                    I agree to the <a href="#">Terms & Conditions</a>
                </label>
            </div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-user-plus"></i>
                Register
            </button>
        </form>
    </div>

    <script src="../assets/js/login_validation.js"></script>
</body>

</html>