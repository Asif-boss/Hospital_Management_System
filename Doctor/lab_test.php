<?php
if (!isset($_COOKIE["doctor_logged_in"])
    || $_COOKIE["doctor_logged_in"] !== "1")
{
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE php>
<php lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lab Test Order</title>
    <link rel="stylesheet" href="doc_styles.css">
</head>
<body>
    <nav>
        <a href="doctor_profile.php">Profile</a> |
        <a href="edit_profile.php">Edit Profile</a> |
        <a href="prescription.php">Prescription</a> |
        <a href="lab_test.php">Lab Test Order</a> |
        <a href="doctor_directory.php">Doctor Directory</a> |
        <a href="logout.php" style="color:#c0392b;">Logout</a>
    </nav>
    <hr>

    <section id="labTest">
        <h1>Order Lab Test</h1>
        <form id="labTestForm" onsubmit="return validateLabTest()">
            <label>Patient Name:</label>
            <input type="text" id="labPatient" required><br>
            <label>Test Type:</label>
            <input type="text" id="labType" required><br>
            <label>Instructions:</label>
            <input type="text" id="labInstructions"><br>
            <button type="submit">Order Test</button>
        </form>
        <div id="labTestMsg"></div>
    </section>
    <script src="doctor.js"></script>
</body>
</php>
