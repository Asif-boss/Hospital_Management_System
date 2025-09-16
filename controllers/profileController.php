<?php
// Start the session to access user data
session_start();

// Include necessary model files
require_once('../models/userModel.php');
require_once('../models/patientModel.php');
require_once('../models/doctorModel.php');
require_once('../models/adminModel.php');
require_once('../models/receptionistModel.php');

// Simple function to clean input data to prevent SQL injection and XSS attacks
function sanitize($data) {
    $con = getConnection(); // Get database connection from db.php
    // Escape special characters for SQL and HTML
    return htmlspecialchars(mysqli_real_escape_string($con, $data));
}

// Step 1: Initialize session or cookie data for the logged-in user
if (isset($_SESSION['user_type']) && isset($_SESSION['email'])) {
    $user_type = $_SESSION['user_type'];
    $email = $_SESSION['email'];

    // Fetch profile based on user type
    if ($user_type === 'patient') {
        $user = getPatientProfile($email);
        $_SESSION['profile_name'] = $user['full_name'];
        $_SESSION['profile_email'] = $user['email'];
        $_SESSION['profile_nid'] = $user['nid'];
        $_SESSION['profile_phone'] = $user['phone'];
        $_SESSION['profile_date_of_birth'] = $user['date_of_birth'];
        $_SESSION['profile_gender'] = $user['gender'];
        $_SESSION['profile_blood_group'] = $user['blood_group'];
        $_SESSION['profile_address'] = $user['address'];
        $_SESSION['profile_emergency_contact_name'] = $user['emergency_contact_name'];
        $_SESSION['profile_emergency_contact_relationship'] = $user['emergency_contact_relation'];
        $_SESSION['profile_emergency_contact_Phone'] = $user['emergency_contact_phone'];
        $_SESSION['profile_picture'] = $user['profile_picture'];
    } elseif ($user_type === 'admin' || $user_type === 'super_admin') {
        $user = getAdminProfile($email);
        $_SESSION['profile_name'] = $user['full_name'];
        $_SESSION['profile_email'] = $user['email'];
        $_SESSION['profile_nid'] = $user['nid'];
        $_SESSION['profile_phone'] = $user['phone'];
        $_SESSION['profile_date_of_birth'] = $user['date_of_birth'];
        $_SESSION['profile_gender'] = $user['gender'];
        $_SESSION['profile_blood_group'] = $user['blood_group'];
        $_SESSION['profile_address'] = $user['address'];
        $_SESSION['profile_picture'] = $user['profile_picture'];
    } elseif ($user_type === 'receptionist') {
        $user = getReceptionistProfile($email);
        $_SESSION['profile_name'] = $user['full_name'];
        $_SESSION['profile_email'] = $user['email'];
        $_SESSION['profile_nid'] = $user['nid'];
        $_SESSION['profile_phone'] = $user['phone'];
        $_SESSION['profile_date_of_birth'] = $user['date_of_birth'];
        $_SESSION['profile_gender'] = $user['gender'];
        $_SESSION['profile_blood_group'] = $user['blood_group'];
        $_SESSION['profile_address'] = $user['address'];
        $_SESSION['profile_picture'] = $user['profile_picture'];
    } elseif ($user_type === 'doctor') {
        $user = getDoctorProfile($email);
        $_SESSION['profile_name'] = $user['full_name'];
        $_SESSION['profile_email'] = $user['email'];
        $_SESSION['profile_nid'] = $user['nid'];
        $_SESSION['profile_phone'] = $user['phone'];
        $_SESSION['profile_date_of_birth'] = $user['date_of_birth'];
        $_SESSION['profile_gender'] = $user['gender'];
        $_SESSION['profile_blood_group'] = $user['blood_group'];
        $_SESSION['profile_address'] = $user['address'];
        $_SESSION['profile_picture'] = $user['profile_picture'];
    }
} elseif (isset($_COOKIE['user_type']) && isset($_SESSION['email'])) {
    $user_type = $_COOKIE['user_type'];
    $email = $_SESSION['email'];

    // Fetch profile and set cookies (30 days expiry)
    if ($user_type === 'patient') {
        $user = getPatientProfile($email);
        setcookie('profile_name', $user['full_name'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_email', $user['email'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_nid', $user['nid'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_phone', $user['phone'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_date_of_birth', $user['date_of_birth'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_gender', $user['gender'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_blood_group', $user['blood_group'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_address', $user['address'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_emergency_contact_name', $user['emergency_contact_name'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_emergency_contact_relationship', $user['emergency_contact_relation'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_emergency_contact_Phone', $user['emergency_contact_phone'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_picture', $user['profile_picture'], time() + (30 * 24 * 60 * 60), '/');
    } elseif ($user_type === 'admin' || $user_type === 'super_admin') {
        $user = getAdminProfile($email);
        setcookie('profile_name', $user['full_name'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_email', $user['email'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_nid', $user['nid'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_phone', $user['phone'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_date_of_birth', $user['date_of_birth'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_gender', $user['gender'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_blood_group', $user['blood_group'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_address', $user['address'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_picture', $user['profile_picture'], time() + (30 * 24 * 60 * 60), '/');
    } elseif ($user_type === 'receptionist') {
        $user = getReceptionistProfile($email);
        setcookie('profile_name', $user['full_name'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_email', $user['email'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_nid', $user['nid'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_phone', $user['phone'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_date_of_birth', $user['date_of_birth'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_gender', $user['gender'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_blood_group', $user['blood_group'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_address', $user['address'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_picture', $user['profile_picture'], time() + (30 * 24 * 60 * 60), '/');
    } elseif ($user_type === 'doctor') {
        $user = getDoctorProfile($email);
        setcookie('profile_name', $user['full_name'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_email', $user['email'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_nid', $user['nid'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_phone', $user['phone'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_date_of_birth', $user['date_of_birth'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_gender', $user['gender'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_blood_group', $user['blood_group'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_address', $user['address'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('profile_picture', $user['profile_picture'], time() + (30 * 24 * 60 * 60), '/');
    }
} else {
    // If no user_type is set, redirect to logout
    header('location: logout.php');
    exit;
}

// Step 2: Handle profile update form submission
if (isset($_POST['update_profile'])) {
    $user_type = $_SESSION['user_type'] ?? $_COOKIE['user_type'];
    $email = $_SESSION['profile_email'] ?? $_COOKIE['profile_email'];

    // Collect form data and clean it
    $user = [
        'email' => $email,
        'full_name' => sanitize($_POST['full_name']),
        'date_of_birth' => sanitize($_POST['date_of_birth']),
        'gender' => sanitize($_POST['gender']),
        'blood_group' => sanitize($_POST['blood_group']),
        'nid' => sanitize($_POST['nid']),
        'phone' => sanitize($_POST['phone']),
        'address' => sanitize($_POST['address']),
    ];

    // Update session data
    $_SESSION['profile_name'] = $user['full_name'];
    $_SESSION['profile_date_of_birth'] = $user['date_of_birth'];
    $_SESSION['profile_gender'] = $user['gender'];
    $_SESSION['profile_blood_group'] = $user['blood_group'];
    $_SESSION['profile_nid'] = $user['nid'];
    $_SESSION['profile_phone'] = $user['phone'];
    $_SESSION['profile_address'] = $user['address'];

    // Update cookie data (1-hour expiry for simplicity)
    setcookie('profile_name', $user['full_name'], time() + 3600, '/');
    setcookie('profile_date_of_birth', $user['date_of_birth'], time() + 3600, '/');
    setcookie('profile_gender', $user['gender'], time() + 3600, '/');
    setcookie('profile_blood_group', $user['blood_group'], time() + 3600, '/');
    setcookie('profile_nid', $user['nid'], time() + 3600, '/');
    setcookie('profile_phone', $user['phone'], time() + 3600, '/');
    setcookie('profile_address', $user['address'], time() + 3600, '/');

    // Handle patient-specific fields
    if ($user_type === 'patient') {
        $user['emergency_contact_name'] = sanitize($_POST['emergency_contact_name'] ?? '');
        $user['emergency_contact_relation'] = sanitize($_POST['emergency_contact_relation'] ?? '');
        $user['emergency_contact_phone'] = sanitize($_POST['emergency_contact_phone'] ?? '');
        
        $_SESSION['profile_emergency_contact_name'] = $user['emergency_contact_name'];
        $_SESSION['profile_emergency_contact_relationship'] = $user['emergency_contact_relation'];
        $_SESSION['profile_emergency_contact_Phone'] = $user['emergency_contact_phone'];
        
        setcookie('profile_emergency_contact_name', $user['emergency_contact_name'], time() + 3600, '/');
        setcookie('profile_emergency_contact_relationship', $user['emergency_contact_relation'], time() + 3600, '/');
        setcookie('profile_emergency_contact_Phone', $user['emergency_contact_phone'], time() + 3600, '/');
    }

    // Update database based on user type
    $success = false;
    $con = getConnection(); // Get database connection for error logging
    if ($user_type === 'patient') {
        $success = updatePatientProfile($user);
        if (!$success) {
            echo 'Failed to update patient profile: ' . mysqli_error($con); // Log SQL error
        }
    } elseif ($user_type === 'doctor') {
        $success = updateDoctorProfile($user);
        if (!$success) {
            echo 'Failed to update doctor profile: ' . mysqli_error($con); // Log SQL error
        }
    } elseif ($user_type === 'admin' || $user_type === 'super_admin') {
        $success = updateAdminProfile($user);
        if (!$success) {
            echo 'Failed to update admin profile: ' . mysqli_error($con); // Log SQL error
        }
    } elseif ($user_type === 'receptionist') {
        $success = updateReceptionistProfile($user);
        if (!$success) {
            echo 'Failed to update receptionist profile: ' . mysqli_error($con); // Log SQL error
        }
    } else {
        echo 'Invalid user type';
    }

    // Return success message if update worked
    if ($success) {
        echo 'Profile updated successfully';
    }
    exit;
}

// Step 3: Handle password change form submission
if (isset($_POST['change_password'])) {
    $email = $_SESSION['profile_email'] ?? $_COOKIE['profile_email'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if new password is at least 6 characters
    if (strlen($new_password) < 6) {
        echo 'New password must be at least 6 characters long';
        exit;
    }

    // Check if new password matches confirm password
    if ($new_password !== $confirm_password) {
        echo 'New password and confirm password do not match';
        exit;
    }

    // Verify current password
    $user = ['email' => $email, 'password' => $current_password];
    if (!checkUserPassword($user)) {
        echo 'Current password is incorrect';
        exit;
    }

    // Update password
    $user = ['email' => $email, 'currentpassword' => $current_password, 'newpassword' => $new_password];
    $success = updateUserPassword($user);

    // Return message to the JavaScript
    echo $success ? 'Password updated successfully' : 'Failed to update password';
    exit;
}

if (isset($_FILES['avatar'])) {
    $email = $_SESSION['profile_email'] ?? $_COOKIE['profile_email'];
    $user = getUserByEmail($email);
    $user_id = $user['id'];

    $file = $_FILES['avatar'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($ext, $allowed)) {
        echo 'Invalid image type';
        exit;
    }
    $filename = $user_id . '.' . $ext;
    $destination = dirname(__DIR__) . '/assets/images/' . $filename;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        if (updateUserProfilePicture($email, $filename)) {
            $_SESSION['profile_picture'] = $filename;
            setcookie('profile_picture', $filename, time() + 3600, '/');
            echo 'Profile picture updated successfully';
        } else {
            echo 'Failed to update profile picture in database: ' . mysqli_error(getConnection());
        }
    } else {
        echo 'Failed to upload profile picture';
    }
    exit;
}
?>