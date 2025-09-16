<?php
require_once __DIR__ . '/../models/doctor_model.php';
if (isset($_GET['action']) && $_GET['action']==='view' && isset($_GET['id'])) {
    $doc = get_doctor_by_id((int)$_GET['id']);
    header('Content-Type: application/json');
    echo json_encode($doc ? ['success'=>true,'doctor'=>$doc] : ['success'=>false]);
    exit;
}
include __DIR__ . '/../views/doctor_list.php';
?>
