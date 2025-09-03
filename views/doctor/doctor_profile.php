<?php
// require_once '../../controllers/loginCheck.php';
if (!isset($_COOKIE['user_type']) || $_COOKIE['user_type'] !== 'doctor') {
    header('Location: ../../views/login.php?error=access_denied');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Doctor Profile</title>
    <link rel="stylesheet" href="../../assets/css/doctor.css" />
</head>
<body>
<nav>
    <a href="doctor_profile.php">Profile</a> |
    <a href="edit_profile.php">Edit Profile</a> |
    <a href="prescription.php">Prescription</a> |
    <a href="lab_test.php">Lab Test Order</a> |
    <a href="doctor_directory.php">Doctor Directory</a> |
    <a href="../../controllers/logout.php" style="color:#c0392b;">Logout</a>
</nav>
<hr>
<section id="profileSummary">
    <img src="https://img.freepik.com/premium-vector/avatar-bearded-doctor-doctor-with-stethoscope-vector-illustrationxa_276184-31.jpg" alt="Profile Picture" style="width:100px;height:100px;">
    <p><strong>Name:</strong> Dr. John Doe</p>
    <p><strong>Specialty:</strong> Cardiology</p>
    <p><strong>Contact:</strong> 0123456789</p>
    <button onclick="window.location.href='edit_profile.php'">Edit Profile</button>
</section>
<script src="../../assets/js/doctor.js"></script>
</body>
</html>
