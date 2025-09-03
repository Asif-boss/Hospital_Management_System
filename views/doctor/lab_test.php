<?php
// require_once '../../controllers/loginCheck.php';
if (!isset($_COOKIE['user_type']) || $_COOKIE['user_type'] !== 'doctor') {
    header('Location: ../../views/login.php?error=access_denied');
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient = trim($_POST["testPatient"]);
    $testName = trim($_POST["testName"]);
    $testDescription = trim($_POST["testDescription"]);
    $testDate = trim($_POST["testDate"]);
    $errorMessage = "";

    // Validate inputs
    if (strlen($patient) < 2) {
        $errorMessage = "Patient name too short";
    } elseif (strlen($testName) < 2) {
        $errorMessage = "Test name too short";
    } elseif (strlen($testDescription) < 2) {
        $errorMessage = "Test description too short";
    } elseif (empty($testDate)) {
        $errorMessage = "Test date is required";
    }

    // Redirect with error or success
    if ($errorMessage) {
        header("Location: lab_test.php?error=$errorMessage");
        exit;
    } else {
        header("Location: lab_test.php?success=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Lab Test Order</title>
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
    echo "<p style='color:green;'>Lab test order submitted successfully!</p>";
}
?>
<form id="labTestForm" method="post" action="lab_test.php" onsubmit="return validateLabTest()">
    <label>Patient Name:</label><br />
    <input type="text" id="testPatient" name="testPatient" required><br />
    
    <label>Test Name:</label><br />
    <input type="text" id="testName" name="testName" required><br />
    
    <label>Test Description:</label><br />
    <input type="text" id="testDescription" name="testDescription" required><br />
    
    <label>Test Date:</label><br />
    <input type="date" id="testDate" name="testDate" required><br /><br />
    
    <button type="submit">Order Lab Test</button>
</form>
<script src="../../assets/js/doctor.js"></script>
</body>
</html>
