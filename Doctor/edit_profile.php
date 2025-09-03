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
    <title>Edit Profile</title>
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

    <h1>Edit Profile</h1>
    <form id="editProfileForm" onsubmit="return validateEditProfile()">
        <label>Name:</label>
        <input type="text" value="Dr. John Doe" readonly><br><br>

        <label>Specialty:</label>
        <input type="text" value="Cardiology" readonly><br><br>

        <label>Profile Picture:</label>
        <input type="file" id="profilePic" accept="image/*"><br><br>
        <img id="picPreview" src="profile.jpg" alt="Profile Preview" style="width:100px;height:100px;"><br>

        <label>Contact Info:</label>
        <input type="tel" id="contact" value="0123456789" required pattern="[0-9]{10}" placeholder="Enter 10-digit number"><br><br>

        <button type="submit">Save Changes</button>
        <button type="button" class="back-btn" onclick="window.location.href='doctor_profile.php'">Back / Discard</button>
    </form>
    <div id="profileMsg"></div>
    <script src="doctor.js"></script>
</body>
</php>
