<?php

if (!isset($_COOKIE['user_type']) || $_COOKIE['user_type'] !== 'doctor') {
    header('Location: ../../views/login.php?error=access_denied');
    exit;
}
include '../../views/templates/header.php';
include '../../views/templates/sidebar.php';

$successMessage = "";
$errorMessage = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $p = trim($_POST['patient_name'] ?? '');
    $m = trim($_POST['medicine'] ?? '');
    $d = trim($_POST['dosage'] ?? '');
    if (strlen($p) < 2 || strlen($m) < 2 || strlen($d) < 2) {
        $errorMessage = "All fields must be at least 2 characters.";
    } else {
        $successMessage = "Prescription submitted successfully!";
    }
}
?>
<div class="main-content">
  <header class="page-header">
    <h1>Prescription</h1>
  </header>
  <section class="profile-card" style="max-width:600px; margin:auto;">
    <?php if ($successMessage): ?>
      <div class="message-success"><?= htmlspecialchars($successMessage) ?></div>
    <?php elseif ($errorMessage): ?>
      <div class="message-error"><?= htmlspecialchars($errorMessage) ?></div>
    <?php endif; ?>
    <form method="POST" action="prescription.php" onsubmit="return validatePrescription();" novalidate>
      <label for="presPatient">Patient Name:</label>
      <input type="text" id="presPatient" name="patient_name" required>
      <label for="presMedicine">Medicine:</label>
      <input type="text" id="presMedicine" name="medicine" required>
      <label for="presDosage">Dosage:</label>
      <input type="text" id="presDosage" name="dosage" required>
      <button type="submit" class="btn primary">Send Prescription</button>
      <button type="button" class="btn back-btn" onclick="window.location.href='dashboard.php'">Back / Discard</button>
    </form>
  </section>
</div>
<script src="../../assets/js/validation.js"></script>
<script src="../../assets/js/doctor.js"></script>
</body>
</html>
