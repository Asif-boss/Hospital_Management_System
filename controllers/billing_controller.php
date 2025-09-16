<?php
require_once __DIR__ . '/../models/billing_model.php';
if (isset($_GET['action']) && $_GET['action']==='view' && isset($_GET['id'])) {
    $bill = get_bill_by_id((int)$_GET['id']);
    header('Content-Type: application/json');
    echo json_encode($bill ? ['success'=>true,'bill'=>$bill] : ['success'=>false]);
    exit;
}
include __DIR__ . '/../views/billing_list.php';
?>
