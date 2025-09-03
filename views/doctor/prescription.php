<?php

if (!isset($_COOKIE['user_type']) || $_COOKIE['user_type'] !== 'doctor') {
    header('Location: ../../views/login.php?error=access_denied');
    exit;
}
include '../../views/templates/header.php';
include '../../views/templates/sidebar.php';

// Handle form submission
$successMessage = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientName = trim($_POST['patient_name'] ?? '');
    $medicine = trim($_POST['medicine'] ?? '');
    $dosage = trim($_POST['dosage'] ?? '');
    
    if ($patientName && $medicine && $dosage) {
        // Here you would save the prescription to DB
        $successMessage = "Prescription submitted successfully!";
    } else {
        $errorMessage = "Please fill in all fields.";
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

    <form method="POST" action="prescription.php" novalidate>
      <label for="patient_name">Patient Name:</label>
      <input type="text" id="patient_name" name="patient_name" placeholder="Enter patient name" required>

      <label for="medicine">Medicine:</label>
      <input type="text" id="medicine" name="medicine" placeholder="Enter medicine prescribed" required>

      <label for="dosage">Dosage:</label>
      <input type="text" id="dosage" name="dosage" placeholder="Enter dosage instructions" required>

      <button type="submit" class="btn primary">Send Prescription</button>
      <button type="button" class="btn back-btn" onclick="window.location.href='dashboard.php'">Back / Discard</button>
    </form>
  </section>
</div>
<script src="../../assets/js/validation.js"></script>
</body>
</html>
