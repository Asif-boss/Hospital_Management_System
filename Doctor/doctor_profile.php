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
    <title>Doctor Profile</title>
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

    <section id="profileSummary">
        <img src="profile.jpg" alt="Profile Picture" style="width:100px;height:100px;">
        <p><strong>Name:</strong> Dr. John Doe</p>
        <p><strong>Specialty:</strong> Cardiology</p>
        <p><strong>Contact:</strong> 0123456789</p>
        <button onclick="window.location.href='edit_profile.php'">Edit Profile</button>
    </section>
    <hr>

    <section id="availability">
        <h2>My Availability</h2>
        <form id="availabilityForm" onsubmit="return validateAvailability()">
            <label>Date:</label>
            <input type="date" id="availDate" required>
            <label>Time Slot:</label>
            <input type="time" id="availTime" required>
            <button type="submit">Add Availability</button>
        </form>
        <ul id="availabilityList"></ul>
    </section>

    <script src="doctor.js"></script>
</body>
</php>
