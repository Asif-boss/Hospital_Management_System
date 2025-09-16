<?php
require_once('db.php');

function getadminProfile($email) {  
    $con = getConnection();
    $sql = "SELECT a.*, u.profile_picture 
            FROM admins a 
            JOIN users u ON a.email = u.email 
            WHERE a.email = '{$email}'";
    $result = mysqli_query($con, $sql);
    
    return mysqli_fetch_assoc($result);
}

function updateAdminProfile($user) {
    $con = getConnection();
    $sql = "UPDATE admins SET 
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
?>