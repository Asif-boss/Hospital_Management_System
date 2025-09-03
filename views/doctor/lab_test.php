<?php
// require_once '../../controllers/loginCheck.php';
if (!isset($_COOKIE['user_type']) || $_COOKIE['user_type'] !== 'doctor') {
    header('Location: ../../views/login.php?error=access_denied');
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient = trim($_POST["presPatient"]);
    $medicine = trim($_POST["presMedicine"]);
    $dosage = trim($_POST["presDosage"]);
    $errorMessage = "";
    if (strlen($patient) < 2) {
        $errorMessage = "Patient name too short";
    } elseif (strlen($medicine) < 2) {
        $errorMessage = "Medicine name too short";
    } elseif (strlen($dosage) < 2) {
        $errorMessage = "Dosage too short";
    }
    if ($errorMessage) {
        header("Location: prescription.php?error=$errorMessage");
        exit;
    } else {
        header("Location: prescription.php?success=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Prescription</title>
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
<?php
if (isset($_GET["error"])) {
    echo "<p style='color:red;'>" . $_GET["error"] . "</p>";
}
if (isset($_GET["success"])) {
    echo "<p style='color:green;'>Prescription submitted successfully!</p>";
}
?>
<form id="prescriptionForm" method="post" action="prescription.php" onsubmit="return validatePrescription()">
    <label>Patient Name:</label><br />
    <input type="text" id="presPatient" name="presPatient" required><br />
    <label>Medicine:</label><br />
    <input type="text" id="presMedicine" name="presMedicine" required><br />
    <label>Dosage:</label><br />
    <input type="text" id="presDosage" name="presDosage" required><br /><br />
    <button type="submit">Send Prescription</button>
</form>
<script src="../../assets/js/doctor.js"></script>
</body>
</html>
