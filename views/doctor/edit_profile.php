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
    <title>Edit Profile</title>
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
<form id="editProfileForm" method="post" action="edit_profile.php" onsubmit="return validateEditProfile()">
    <label>Name:</label><br />
    <input type="text" value="Dr. John Doe" readonly><br /><br />
    <label>Specialty:</label><br />
    <input type="text" value="Cardiology" readonly><br /><br />
    <label>Contact Info:</label><br />
    <input type="tel" id="contact" name="contact" value="0123456789" required pattern="[0-9]{11}" placeholder="Enter 11-digit number"><br /><br />
    <button type="submit">Save Changes</button>
    <button type="button" onclick="window.location.href='doctor_profile.php'">Back / Discard</button>
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $contact = trim($_POST['contact']);
    if (preg_match('/^\d{11}$/', $contact)) {
        echo "<p style='color:green;'>Profile updated successfully!</p>";
    } else {
        echo "<p style='color:red;'>Please enter a valid 11-digit contact number.</p>";
    }
}
?>
<script src="../../assets/js/doctor.js"></script>
</body>
</html>
