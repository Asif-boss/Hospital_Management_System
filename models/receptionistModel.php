<?php

require_once('db.php');

function getReceptionistProfile($email) {  
    $con = getConnection();
    $sql = "SELECT r.*, u.profile_picture 
            FROM receptionists r 
            JOIN users u ON r.email = u.email 
            WHERE r.email = '{$email}'";
    $result = mysqli_query($con, $sql);
    
    return mysqli_fetch_assoc($result);
}

function updateReceptionistProfile($user) {
    $con = getConnection();
    $sql = "UPDATE receptionists SET 
            full_name = '{$user['full_name']}', 
            date_of_birth = '{$user['date_of_birth']}', 
            gender = '{$user['gender']}', 
            blood_group = '{$user['blood_group']}', 
            nid = '{$user['nid']}', 
            phone = '{$user['phone']}', 
            address = '{$user['address']}'
            WHERE email = '{$user['email']}'";
    return mysqli_query($con, $sql);
}