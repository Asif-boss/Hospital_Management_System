<?php
// require_once '../../controllers/loginCheck.php';
if (!isset($_COOKIE['user_type']) || $_COOKIE['user_type'] !== 'doctor') {
    header('Location: ../../views/login.php?error=access_denied');
    exit;
}


// if (!isset($_COOKIE['user_type'])) {
//     header('location: ../login.php');
// } elseif ($_COOKIE['user_type'] !== 'doctor') {
//     header('location: ../login.php');
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Doctor Directory</title>
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
    <section id="doctorProfiles">
        <h1>Doctor Directory</h1>
        <input type="text" id="doctorSearchInput" placeholder="Search by ID or Name" onkeyup="filterDoctors()" style="width:60%; padding:6px; margin-bottom:15px;" />
        <br />
        <label for="specialtyFilter">Filter by Specialty:</label>
        <select id="specialtyFilter" onchange="filterDoctors()">
            <option value="all">All</option>
            <option value="cardiology">Cardiology</option>
            <option value="dermatology">Dermatology</option>
            <option value="neurology">Neurology</option>
            <option value="pediatrics">Pediatrics</option>
        </select>
        <div id="doctorDirectory">
            <ul>
                <li data-id="D001" data-name="Dr. John Doe" data-specialty="cardiology">
                    <strong>Dr. John Doe</strong> (Cardiology) <br>
                    Qualifications: MD, PhD <br>
                    Availability: Mon-Fri 9am - 3pm <br>
                    <button class="bookBtn">Book Appointment</button>
                </li>
                <li data-id="D002" data-name="Dr. Jane Smith" data-specialty="dermatology">
                    <strong>Dr. Jane Smith</strong> (Dermatology) <br>
                    Qualifications: MD <br>
                    Availability: Tue-Thu 10am - 4pm <br>
                    <button class="bookBtn">Book Appointment</button>
                </li>
                <li data-id="D003" data-name="Dr. Robert Lee" data-specialty="neurology">
                    <strong>Dr. Robert Lee</strong> (Neurology) <br>
                    Qualifications: MD, Neurology Specialist <br>
                    Availability: Wed-Fri 8am - 2pm <br>
                    <button class="bookBtn">Book Appointment</button>
                </li>
            </ul>
        </div>
    </section>
    <script src="../../assets/JS/doctor.js"></script>
</body>

</html>