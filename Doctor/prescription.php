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
    <title>Prescription</title>
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

    <section id="prescription">
        <h1>Create Prescription</h1>
        <form id="prescriptionForm" onsubmit="return validatePrescription()">
            <label>Patient Name:</label>
            <input type="text" id="presPatient" required><br>
            <label>Medicine:</label>
            <input type="text" id="presMedicine" required><br>
            <label>Dosage:</label>
            <input type="text" id="presDosage" required><br>
            <label>Notes:</label>
            <input type="text" id="presNotes"><br>
            <button type="submit">Send Prescription</button>
        </form>
        <div id="prescriptionMsg"></div>
    </section>
    <script src="doctor.js"></script>
</body>
</php>
