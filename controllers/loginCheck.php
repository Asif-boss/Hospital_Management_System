
<?php
session_start();

require_once('../models/userModel.php');

$email = trim($_REQUEST['email']);
$password = trim($_REQUEST['password']);
$remember = isset($_POST['remember']);

$user = ['email' => $email, 'password' => $password];
$status = loginUser($user);

if ($status) {
    $user = getUserByEmail($email);
    $user_type = $user['user_type'];

    if ($remember) {
        setcookie('user_type', $user_type, time() + (30 * 24 * 60 * 60), '/');
        setcookie('email', $email, time() + (30 * 24 * 60 * 60), '/');
    } else {
        $_SESSION['user_type'] = $user_type;
        $_SESSION['email'] = $email;
    }

    switch ($user_type) {
        case 'patient':
            header('Location: ../views/dashboard.php');
            exit;
        case 'admin':
            header('Location: ../views/dashboard.php');
            exit;
        case 'super_admin':
            header('Location: ../views/dashboard.php');
            exit;
        case 'receptionist':
            header('Location: ../views/dashboard.php');
            exit;
        case 'doctor':
            header('Location: ../views/dashboard.php');
            exit;
    }
} else {
    header('location: ../views/login.php?error=invalid_log');
}
?>