<?php
require_once __DIR__ . '/db_connect.php';

function get_all_bills() {
    $conn = db_connect();
    $sql = "SELECT id, patient_id, amount, insurance_info, status FROM billing ORDER BY id DESC";
    $res = mysqli_query($conn, $sql);
    $rows = [];
    if ($res) {
        while ($r = mysqli_fetch_assoc($res)) {
            $rows[] = $r;
        }
        mysqli_free_result($res);
    }
    mysqli_close($conn);
    return $rows;
}

function get_bill_by_id($id) {
    $conn = db_connect();
    $stmt = mysqli_prepare($conn, "SELECT * FROM billing WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($res);
    mysqli_free_result($res);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $row ? $row : null;
}
?>
