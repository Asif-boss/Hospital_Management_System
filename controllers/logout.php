<?php
session_start();

// if (isset($_COOKIE['user_type'])) {
    setcookie('user_type', $user_type, time() - (30 * 24 * 60 * 60), '/');
    setcookie('email', $email, time() - (30 * 24 * 60 * 60), '/');
// } elseif (isset($_SESSION['user_type'])) {
    session_destroy();
// }
$cookie_names = [
    'user_type', 'profile_name', 'profile_email', 'profile_nid', 'profile_phone',
    'profile_date_of_birth', 'profile_gender', 'profile_blood_group', 'profile_address',
    'profile_emergency_contact_name', 'profile_emergency_contact_relationship',
    'profile_emergency_contact_Phone', 'profile_picture'
];

foreach ($cookie_names as $cookie) {
    setcookie($cookie, '', time() - 3600, '/');
}
header('location: ../views/login.php');

?>