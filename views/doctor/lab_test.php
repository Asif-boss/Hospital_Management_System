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
    $testName = trim($_POST['test_name'] ?? '');
    $testDescription = trim($_POST['test_description'] ?? '');
    $testDate = trim($_POST['test_date'] ?? '');

    if ($patientName && $testName && $testDate) {
        // Save lab test order to DB here
        $successMessage = "Lab test order submitted successfully!";
    } else {
        $errorMessage = "Please fill in required fields (Patient Name, Test Name, Test Date).";
    }
}
?>
<div class="main-content">
  <header class="page-header">
    <h1>Lab Test Order</h1>
  </header>

  <section class="profile-card" style="max-width:600px; margin:auto;">
    <?php if ($successMessage): ?>
      <div class="message-success"><?= htmlspecialchars($successMessage) ?></div>
    <?php elseif ($errorMessage): ?>
      <div class="message-error"><?= htmlspecialchars($errorMessage) ?></div>
    <?php endif; ?>

    <form method="POST" action="lab_test.php" novalidate>
      <label for="patient_name">Patient Name:</label>
      <input type="text" id="patient_name" name="patient_name" placeholder="Enter patient name" required>

      <label for="test_name">Test Name:</label>
      <input type="text" id="test_name" name="test_name" placeholder="Enter test name" required>

      <label for="test_description">Test Description:</label>
      <textarea id="test_description" name="test_description" placeholder="Enter test description (optional)" rows="3"></textarea>

      <label for="test_date">Test Date:</label>
      <input type="date" id="test_date" name="test_date" required>

      <button type="submit" class="btn primary">Order Lab Test</button>
      <button type="button" class="btn back-btn" onclick="window.location.href='dashboard.php'">Back / Discard</button>
    </form>
  </section>
</div>
<script src="../../assets/js/validation.js"></script>
</body>
</html>
