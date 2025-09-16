<?php
require_once __DIR__ . '/../models/claims_model.php';
if(isset($_GET['action']) && $_GET['action']==='view' && isset($_GET['id'])){
    $c=get_claim_by_id((int)$_GET['id']);
    header('Content-Type: application/json');
    echo json_encode($c?['success'=>true,'claim'=>$c]:['success'=>false]);
    exit;
}
include __DIR__ . '/../views/claims_list.php';
?>
