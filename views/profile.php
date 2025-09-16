<?php
session_start();

if (!isset($_COOKIE['user_type']) && !isset($_SESSION['user_type'])) {
    header('location: login.php');
}
include '../controllers/profileController.php';
$profile = [
            'user_type' => $_COOKIE['user_type'] ?? $_SESSION['user_type'],
            'full_name' => $_COOKIE['profile_name'] ?? $_SESSION['profile_name'],
            'email' => $_COOKIE['profile_email'] ?? $_SESSION['profile_email'],
            'nid' => $_COOKIE['profile_nid'] ?? $_SESSION['profile_nid'],
            'phone' => $_COOKIE['profile_phone'] ?? $_SESSION['profile_phone'],
            'date_of_birth' => $_COOKIE['profile_date_of_birth'] ?? $_SESSION['profile_date_of_birth'],
            'gender' => $_COOKIE['profile_gender'] ?? $_SESSION['profile_gender'],
            'blood_group' => $_COOKIE['profile_blood_group'] ?? $_SESSION['profile_blood_group'],
            'address' => $_COOKIE['profile_address'] ?? $_SESSION['profile_address'],
            'emergency_contact_name' => $_COOKIE['profile_emergency_contact_name'] ?? $_SESSION['profile_emergency_contact_name'] ,
            'emergency_contact_relation' => $_COOKIE['profile_emergency_contact_relationship'] ?? $_SESSION['profile_emergency_contact_relationship'] ,
            'emergency_contact_phone' => $_COOKIE['profile_emergency_contact_Phone'] ?? $_SESSION['profile_emergency_contact_Phone'],
            'profile_picture' => $_COOKIE['profile_picture'] ?? $_SESSION['profile_picture']
        ];       
include 'header.php';
?>

<link rel="stylesheet" href="../assets/css/profile_style.css">
<main class="main-content">
    <div class="profile-header">
        <div class="avatar-container">
            <img src="../assets/images/<?php echo $profile['profile_picture'] ? $profile['profile_picture'] : 'default-avatar.png'; ?>" alt="Profile Picture" class="avatar" id="avatarImage">
            <input type="file" id="avatarInput" accept="image/*" style="display: none;">
            <div class="avatar-actions" id="avatarActions" style="display: none;">
                <button id="updateAvatarBtn" class="btn btn-primary">Update</button>
                <button id="cancelAvatarBtn" class="btn btn-secondary">Cancel</button>
            </div>
            <a href="#" class="change-avatar-btn" id="changeAvatarBtn">Change Image</a>
        </div>
        <div class="profile-info">
            <h1><?php echo htmlspecialchars($profile['full_name']); ?></h1>
            <p><?php echo ucwords($profile['user_type'])?></p>
        </div>
    </div>

    <div class="profile-content">
        <div class="card">
            <div class="card-header">
                <h2>Personal Information</h2>
                <a href="#" class="btn btn-primary" id="editProfileBtn">Edit Profile</a>
            </div>
            <div class="card-body">
                <div class="info-group">
                    <label>Email:</label>
                    <span><?php echo htmlspecialchars($profile['email']); ?></span>
                </div>
                <div class="info-group">
                    <label>Date of Birth:</label>
                    <span><?php echo htmlspecialchars($profile['date_of_birth']); ?></span>
                </div>
                <div class="info-group">
                    <label>Gender:</label>
                    <span><?php echo htmlspecialchars($profile['gender']); ?></span>
                </div>
                <div class="info-group">
                    <label>Blood Group:</label>
                    <span><?php echo htmlspecialchars($profile['blood_group'] ?? 'Not specified'); ?></span>
                </div>
                <div class="info-group">
                    <label>Phone:</label>
                    <span><?php echo htmlspecialchars($profile['phone']); ?></span>
                </div>
                <div class="info-group">
                    <label>Address:</label>
                    <span><?php echo htmlspecialchars($profile['address']); ?></span>
                </div>
                <div class="info-group">
                    <label>NID:</label>
                    <span><?php echo htmlspecialchars($profile['nid'] ?? 'Not specified'); ?></span>
                </div>
            </div>
        </div>
        <?php if ($user_type === 'patient'): ?>
        <div class="card">
            <div class="card-header">
                <h2>Emergency Contact</h2>
            </div>
            <div class="card-body">
                <div class="info-group">
                    <label>Name:</label>
                    <span><?php echo htmlspecialchars($profile['emergency_contact_name'] ?? 'Not specified'); ?></span>
                </div>
                <div class="info-group">
                    <label>Relationship:</label>
                    <span><?php echo htmlspecialchars($profile['emergency_contact_relation'] ?? 'Not specified'); ?></span>
                </div>
                <div class="info-group">
                    <label>Phone:</label>
                    <span><?php echo htmlspecialchars($profile['emergency_contact_phone'] ?? 'Not specified'); ?></span>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="card">
            <div class="card-header">
                <h2>Security</h2>
            </div>
            <div class="card-body">
                <a href="#" class="btn btn-secondary" id="changePasswordBtn">Change Password</a>
            </div>
        </div>
    </div>
</main>

<!-- Edit Profile Modal -->
<div id="editProfileModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Personal Information</h2>
        <form id="editProfileForm">
            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($profile['full_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="date_of_birth">Date of Birth:</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($profile['date_of_birth']); ?>">
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender">
                    <option value="male" <?php echo $profile['gender'] == 'male' ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?php echo $profile['gender'] == 'female' ? 'selected' : ''; ?>>Female</option>
                    <option value="other" <?php echo $profile['gender'] == 'other' ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="blood_group">Blood Group:</label>
                <select id="blood_group" name="blood_group">
                    <option value="">Select Blood Group</option>
                    <option value="A+" <?php echo ($profile['blood_group'] ?? '') == 'A+' ? 'selected' : ''; ?>>A+</option>
                    <option value="A-" <?php echo ($profile['blood_group'] ?? '') == 'A-' ? 'selected' : ''; ?>>A-</option>
                    <option value="B+" <?php echo ($profile['blood_group'] ?? '') == 'B+' ? 'selected' : ''; ?>>B+</option>
                    <option value="B-" <?php echo ($profile['blood_group'] ?? '') == 'B-' ? 'selected' : ''; ?>>B-</option>
                    <option value="AB+" <?php echo ($profile['blood_group'] ?? '') == 'AB+' ? 'selected' : ''; ?>>AB+</option>
                    <option value="AB-" <?php echo ($profile['blood_group'] ?? '') == 'AB-' ? 'selected' : ''; ?>>AB-</option>
                    <option value="O+" <?php echo ($profile['blood_group'] ?? '') == 'O+' ? 'selected' : ''; ?>>O+</option>
                    <option value="O-" <?php echo ($profile['blood_group'] ?? '') == 'O-' ? 'selected' : ''; ?>>O-</option>
                </select>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($profile['phone']); ?>">
            </div>
            <div class="form-group">
                <label for="nid">NID:</label>
                <input type="text" id="nid" name="nid" value="<?php echo htmlspecialchars($profile['nid'] ?? ''); ?>">
            </div>
            <?php if ($user_type === 'patient'): ?>
            <div class="form-group">
                <label for="emergency_contact_name">Emergency Contact Name:</label>
                <input type="text" id="emergency_contact_name" name="emergency_contact_name" value="<?php echo htmlspecialchars($profile['emergency_contact_name'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="emergency_contact_relation">Emergency Contact Relationship:</label>
                <input type="text" id="emergency_contact_relation" name="emergency_contact_relation" value="<?php echo htmlspecialchars($profile['emergency_contact_relation'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="emergency_contact_phone">Emergency Contact Phone:</label>
                <input type="tel" id="emergency_contact_phone" name="emergency_contact_phone" value="<?php echo htmlspecialchars($profile['emergency_contact_phone'] ?? ''); ?>">
            </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea id="address" name="address"><?php echo htmlspecialchars($profile['address']); ?></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <button type="button" class="btn btn-secondary" id="cancelEditProfile">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Change Password Modal -->
<div id="changePasswordModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Change Password</h2>
        <form id="changePasswordForm">
            <div class="form-group">
                <label for="current_password">Current Password:</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Password</button>
                <button type="button" class="btn btn-secondary" id="cancelChangePassword">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script src="../assets/js/profile.js"></script>
</body>
</html>