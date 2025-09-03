<?php

if (!isset($_COOKIE['user_type']) || $_COOKIE['user_type'] !== 'doctor') {
    header('Location: ../../views/login.php?error=access_denied');
    exit;
}
include '../../views/templates/header.php';
include '../../views/templates/sidebar.php';

// Sample: Fetch existing doctor data for the form (replace with real data retrieval)
$doctorName = "Dr. John Doe";
$specialty = "Cardiology";
$contact = "0123456789";

// Handle form submission
$updateSuccess = false;
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contactInput = trim($_POST['contact'] ?? '');
    if (preg_match('/^\d{11}$/', $contactInput)) {
        // Save updated contact (replace with actual DB update)
        $contact = $contactInput;
        $updateSuccess = true;
    } else {
        $errorMessage = "Please enter a valid 11-digit contact number.";
    }
}
?>
<div class="main-content">
  <header class="page-header">
    <h1>Edit Profile</h1>
  </header>

  <section class="profile-card" style="max-width:600px; margin:auto;">
    <?php if ($updateSuccess): ?>
      <div class="message-success">Profile updated successfully!</div>
    <?php elseif ($errorMessage): ?>
      <div class="message-error"><?= htmlspecialchars($errorMessage) ?></div>
    <?php endif; ?>

    <form method="POST" action="edit_profile.php" novalidate>
      <label for="name">Name:</label><br>
      <input type="text" id="name" name="name" value="<?= htmlspecialchars($doctorName) ?>" readonly><br><br>

      <label for="specialty">Specialty:</label><br>
      <input type="text" id="specialty" name="specialty" value="<?= htmlspecialchars($specialty) ?>" readonly><br><br>

      <label for="contact">Contact Info:</label><br>
      <input type="tel" id="contact" name="contact" value="<?= htmlspecialchars($contact) ?>" placeholder="Enter 11-digit contact number" required pattern="\d{11}"><br><br>

      <button type="submit" class="btn primary">Save Changes</button>
      <button type="button" class="btn back-btn" style="margin-left: 15px;" onclick="window.location.href='dashboard.php'">Back / Discard</button>
    </form>
  </section>
</div>
<script src="../../assets/js/validation.js"></script>
</body>
</html>
