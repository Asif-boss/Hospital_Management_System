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
    $patient = trim($_POST['patient_name'] ?? '');
    $testName = trim($_POST['test_name'] ?? '');
    $testDescription = trim($_POST['test_description'] ?? '');
    $testDate = trim($_POST['test_date'] ?? '');
    if (strlen($patient) < 2 || strlen($testName) < 2 || strlen($testDescription) < 2 || $testDate == "") {
        $errorMessage = "All fields must be filled correctly.";
    } else {
        $successMessage = "Lab test order submitted successfully!";
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
    <form method="POST" action="lab_test.php" onsubmit="return validateLabTest();" novalidate>
      <label for="testPatient">Patient Name:</label>
      <input type="text" id="testPatient" name="patient_name" required>
      <label for="testName">Test Name:</label>
      <input type="text" id="testName" name="test_name" required>
      <label for="testDescription">Test Description:</label>
      <textarea id="testDescription" name="test_description" rows="3"></textarea>
      <label for="testDate">Test Date:</label>
      <input type="date" id="testDate" name="test_date" required>
      <button type="submit" class="btn primary">Order Lab Test</button>
      <button type="button" class="btn back-btn" onclick="window.location.href='dashboard.php'">Back / Discard</button>
    </form>
  </section>
</div>
<script src="../../assets/js/validation.js"></script>
<script src="../../assets/js/doctor.js"></script>
</body>
</html>
