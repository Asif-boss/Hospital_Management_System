<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    setcookie('last_visit', date('Y-m-d H:i:s'), time() + 3600);
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Hospital System</title>
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<header class="site-header">
<h1>Hospital System</h1>
<nav>
<a href="/controller/doctor_controller.php">Doctors</a> |
<a href="/controller/billing_controller.php">Billing</a> |
<a href="/controller/claims_controller.php">Claims</a>
</nav>
</header>
<main>
