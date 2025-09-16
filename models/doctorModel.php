<?php

require_once('db.php');

function getDoctorProfile($email) {  
    $con = getConnection();
    $sql = "SELECT d.*, u.profile_picture 
            FROM doctors d 
            JOIN users u ON d.email = u.email 
            WHERE d.email = '{$email}'";
    $result = mysqli_query($con, $sql);
    
    return mysqli_fetch_assoc($result);
}

function updateDoctorProfile($user) {
    $con = getConnection();
    $sql = "UPDATE doctors SET 
            full_name = '{$user['full_name']}',
            date_of_birth = '{$user['date_of_birth']}',
            gender = '{$user['gender']}',
            blood_group = '{$user['blood_group']}',
            nid = '{$user['nid']}',
            phone = '{$user['phone']}',
            address = '{$user['address']}'
            WHERE email='{$user['email']}'";
    return mysqli_query($con, $sql);
}