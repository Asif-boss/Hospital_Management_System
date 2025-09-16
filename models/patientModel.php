<?php

require_once('db.php');

function getPatientProfile($email) {  
    $con = getConnection();
    $sql = "SELECT p.*, u.profile_picture 
            FROM patients p 
            JOIN users u ON p.email = u.email 
            WHERE p.email = '{$email}'";
    $result = mysqli_query($con, $sql);
    
    return mysqli_fetch_assoc($result);
}

function updatePatientProfile($user) {
    $con = getConnection();
    $sql = "UPDATE patients SET 
            full_name = '{$user['full_name']}', 
            date_of_birth = '{$user['date_of_birth']}', 
            gender = '{$user['gender']}', 
            blood_group = '{$user['blood_group']}', 
            nid = '{$user['nid']}', 
            phone = '{$user['phone']}', 
            address = '{$user['address']}',
            emergency_contact_name = '{$user['emergency_contact_name']}', 
            emergency_contact_relation = '{$user['emergency_contact_relation']}', 
            emergency_contact_phone = '{$user['emergency_contact_phone']}'
            WHERE email='{$user['email']}'";
    return mysqli_query($con, $sql);
}

function userExistsByNID($nid) {
    $con = getConnection();
    $sql = "select * from patients where nid='{$nid}'";
    $result = mysqli_query($con, $sql);
    $count = mysqli_num_rows($result);
    if ($count == 1) {
        return true;
        
    } else {
        return false;
    }
}

function create_patient($user){
    $con = getConnection();
    echo $user['date_of_birth'];
    $sql = "INSERT INTO patients (full_name, nid, email, phone, date_of_birth, gender, blood_group)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    
    mysqli_stmt_bind_param(
        $stmt,
        "sssssss",
        $user['full_name'],
        $user['nid'],
        $user['email'],
        $user['phone'],
        $user['date_of_birth'],
        $user['gender'],
        $user['blood_group']
    );

    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        return true;
    } else {
        return false;
    }
}
?>