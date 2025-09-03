<?php
    $username = trim($_REQUEST['username']);
    $password = trim($_REQUEST['password']);

    if ($username == 'patient' || $password == 'patient') {
        setcookie('user_type', 'patient', time() + (86400 * 30), "/");
        header('location: ../views/patient/dashboard.php');
    } elseif ($username == 'admin' || $password == 'admin') {
        setcookie('user_type', 'admin', time() + (86400 * 30), "/");
        header('location: ../views/admin/dashboard.php');
    } elseif ($username == 'receptionist' || $password == 'receptionist') {
        setcookie('user_type', 'receptionist', time() + (86400 * 30), "/");
        header('location: ../views/receptionist/dashboard.php');
    } elseif ($username == 'doctor' || $password == 'doctor') {
        setcookie('user_type', 'doctor', time() + (86400 * 30), "/");
        header('location: ../views/doctor/doctor_directory.php');
    } else {
        header('location: ../views/login.php?error=invalid_log');
    }
?>