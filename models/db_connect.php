<?php
function db_connect() {
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'hospital';

    $conn = mysqli_connect($host, $user, $pass, $dbname);
    if (!$conn) {
        die('Database connection failed: ' . mysqli_connect_error());
    }
    mysqli_set_charset($conn, 'utf8mb4');
    return $conn;
}
?>
