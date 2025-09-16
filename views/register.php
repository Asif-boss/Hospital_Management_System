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
        header('location: directory.php');
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
        header('location: directory.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>BD Hospital - Register</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    <div class="container">
        <h1>BD Hospital</h1>
        <p>Healthcare System</p>

        <form id="registerForm" action="../controllers/patientregister.php" method="post">
            <h2>Register</h2>
            <?php
            if (isset($_REQUEST['error']) && $_REQUEST['error'] == "used_nid") {
                echo '<div class="error-message">NID has been used!!!</div>';
            }
            if (isset($_REQUEST['error']) && $_REQUEST['error'] == "used_email") {
                echo '<div class="error-message">Email has been used!!!</div>';
            }
            ?>
            <div class="form-group">
                <label for="regName">Name</label>
                <input type="text" id="regName" name="name" placeholder="Full Name">
                <span class="error-text" id="regNameError"></span>
            </div>

            <div class="form-group">
                <label for="regEmail">Email Address</label>
                <input type="email" id="regEmail" name="email" placeholder="email@email.com">
                <span class="error-text" id="regEmailError"></span>
            </div>

            <div class="form-group">
                <label for="regNid">National ID</label>
                <input type="text" id="regNid" name="nid" placeholder="12345678901234567">
                <span class="error-text" id="regNidError"></span>
            </div>

            <div class="form-group">
                <label for="regPhone">Phone Number</label>
                <input type="tel" id="regPhone" name="phone" placeholder="01234567899">
                <span class="error-text" id="regPhoneError"></span>
            </div>

            <div class="form-group">
                <label for="regPassword">Password</label>
                <input type="password" id="regPassword" name="password" placeholder="Password">
                <span class="error-text" id="regPasswordError"></span>
            </div>

            <div class="form-group">
                <label for="regConfirmPassword">Confirm Password</label>
                <input type="password" id="regConfirmPassword" name="confirm_password" placeholder="Confirm Password">
                <span class="error-text" id="regConfirmPasswordError"></span>
            </div>

            <div class="form-group">
                <label for="regDob">Date of Birth</label>
                <input type="date" id="regDob" name="date_of_birth">
                <span class="error-text" id="regDobError"></span>
            </div>

            <div class="form-group">
                <label for="regGender">Gender</label>
                <select id="regGender" name="gender">
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
                <span class="error-text" id="regGenderError"></span>
            </div>

            <div class="form-group">
                <label for="regBloodGroup">Blood Group</label>
                <select id="regBloodGroup" name="blood_group">
                    <option value="">Select Blood Group</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                </select>
                <span class="error-text" id="regBloodGroupError"></span>
            </div>

            <div class="form-options">
                <label>
                    <input type="checkbox" id="agreeTerms">
                    I agree to the Terms & Conditions
                </label>
                <span class="error-text" id="conditionsError"></span>
            </div>

            <button type="submit" class="submit-btn">Register</button>
            <p><a href="login.php">Already have an account? Login</a></p>
        </form>
    </div>

    <script src="../assets/js/registration_validation.js"></script>
</body>
</html>