<?php
//require_once '../../controllers/loginCheck.php';
if (!isset($_COOKIE['user_type']) || $_COOKIE['user_type'] !== 'doctor') {
    header('Location: ../../views/login.php?error=access_denied');
    exit;
}
include '../../views/templates/header.php';
include '../../views/templates/sidebar.php';
?>
<div class="main-content">
  <header class="page-header">
    <h1>Doctor Dashboard</h1>
  </header>

  <section id="profileSummary" class="profile-card">
    <img src="../../assets/img/doctor.jpg" alt="Doctor Profile Picture" class="profile-img" />
    <h2>Dr. John Doe</h2>
    <p class="specialty">Cardiology</p>
    <p class="contact"><strong>Contact:</strong> 0123456789</p>
    <button class="btn primary" onclick="window.location.href='edit_profile.php'">Edit Profile</button>
  </section>
</div>

<script src="../../assets/js/validation.js"></script>
</body>
</html>