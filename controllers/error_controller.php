<?php
$type = isset($_GET['type']) ? $_GET['type'] : '404';
include __DIR__ . '/../views/error_page.php';
?>
