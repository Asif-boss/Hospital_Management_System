<?php

if (!isset($_COOKIE['user_type']) || $_COOKIE['user_type'] !== 'doctor') {
    header('Location: ../../views/login.php?error=access_denied');
    exit;
}
include '../../views/templates/header.php';
include '../../views/templates/sidebar.php';

$doctorName = "Dr. John Doe";
$specialty = "Cardiology";
$contact = "0123456789";


session_start();
if (!isset($_SESSION['profileImg'])) {
    $_SESSION['profileImg'] = "../../assets/img/doctor.jpg";
}

$profileImg = $_SESSION['profileImg'];

$updateSuccess = false;
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contactInput = trim($_POST['contact'] ?? '');

    if (!preg_match('/^\d{11}$/', $contactInput)) {
        $errorMessage = "Please enter a valid 11-digit contact number.";
    } else {
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $file = $_FILES['profile_image'];
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            $maxSize = 5 * 1024 * 1024; // 5MB

            if (!in_array($file['type'], $allowedTypes)) {
                $errorMessage = "Only JPG, PNG, and WEBP images are allowed.";
            } elseif ($file['size'] > $maxSize) {
                $errorMessage = "Image size must be 5MB or less.";
            } elseif ($file['error'] !== UPLOAD_ERR_OK) {
                $errorMessage = "Error uploading image.";
            } else {
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $newFileName = 'doctor_' . time() . '.' . $ext;
                $destination = '../../assets/img/' . $newFileName;

                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    $_SESSION['profileImg'] = '../../assets/img/' . $newFileName;
                    $profileImg = $_SESSION['profileImg'];
                } else {
                    $errorMessage = "Failed to save uploaded image.";
                }
            }
        }

        if (!$errorMessage) {
            $contact = $contactInput;
            $updateSuccess = true;
        }
    }
}
?>
<div class="main-content">
  <header class="page-header">
    <h1>Edit Profile</h1>
  </header>
  <section class="profile-card" style="max-width:600px; margin:auto; text-align: left;">
    <?php if ($updateSuccess): ?>
      <div class="message-success">Profile updated successfully!</div>
    <?php elseif ($errorMessage): ?>
      <div class="message-error"><?= htmlspecialchars($errorMessage) ?></div>
    <?php endif; ?>

    <form method="POST" action="edit_profile.php" enctype="multipart/form-data" onsubmit="return validateEditProfile();" novalidate>
      <div style="text-align:center; margin-bottom: 20px;">
        <img id="profilePreview" src="<?= htmlspecialchars($profileImg) ?>" alt="Profile Picture" style="width: 140px; height: 140px; border-radius: 50%; object-fit: cover; border: 4px solid #16a34a;">
      </div>

      <label for="profileImage">Change Profile Image (JPG, PNG, WEBP; max 5MB):</label>
      <input type="file" id="profileImage" name="profile_image" accept="image/jpeg,image/png,image/webp" onchange="previewImage(event)">

      <label for="name">Name:</label>
      <input type="text" id="name" name="name" value="<?= htmlspecialchars($doctorName) ?>" readonly>

      <label for="specialty">Specialty:</label>
      <input type="text" id="specialty" name="specialty" value="<?= htmlspecialchars($specialty) ?>" readonly>

      <label for="contact">Contact Info:</label>
      <input type="tel" id="contact" name="contact" value="<?= htmlspecialchars($contact) ?>" required pattern="\d{11}">

      <button type="submit" class="btn primary">Save Changes</button>
      <button type="button" class="btn back-btn" onclick="window.location.href='dashboard.php'">Back / Discard</button>
    </form>
  </section>
</div>
<script src="../../assets/js/validation.js"></script>
<script src="../../assets/js/doctor.js"></script>
<script>
function previewImage(event) {
  var file = event.target.files[0];
  if (file) {
    if (file.size > 5 * 1024 * 1024) {
      alert('File size exceeds 5MB limit.');
      event.target.value = "";
      return;
    }
    var reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('profilePreview').src = e.target.result;
    };
    reader.readAsDataURL(file);
  }
}
</script>
</body>
</html>
