<?php

require_once('db.php');

function loginUser($user) {
    $con = getConnection();
    $sql = "select * from users where email='{$user['email']}' and password='{$user['password']}'";
    $result = mysqli_query($con, $sql);
    $count = mysqli_num_rows($result);

    if ($count == 1) {
        return true;
    } else {
        return false;
    }
}

function checkUserPassword($user) {
    $con = getConnection();
    $sql = "select * from users where email='{$user['email']}' and password='{$user['password']}'";
    $result = mysqli_query($con, $sql);
    $count = mysqli_num_rows($result);

    if ($count == 1) {
        return true;
    } else {
        return false;
    }
}

function updateUserPassword($user) {
    $con = getConnection();
    
    $sql = "select * from users where email='{$user['email']}' and password='{$user['currentpassword']}'";
    $result = mysqli_query($con, $sql);
    $count = mysqli_num_rows($result);

    if ($count == 1) {
        $sql = "UPDATE users SET password='{$user['newpassword']}' WHERE email='{$user['email']}'";
        return mysqli_query($con, $sql);
        
    } else {
        return false;
    }
}

function getUserByEmail($email) {
    $con = getConnection();
    $sql = "select * from users where email='{$email}'";
    $result = mysqli_query($con, $sql);
    $user = mysqli_fetch_assoc($result);
    return $user;
}

function userExistsByEmail($email) {
    $con = getConnection();
    $sql = "select * from users where email='{$email}'";
    $result = mysqli_query($con, $sql);
    $count = mysqli_num_rows($result);
    if ($count == 1) {
        return true;
        
    } else {
        return false;
    }
}

function create_user($user) {
    $con = getConnection();
    $sql = "INSERT INTO users (email, password, user_type) VALUES ('{$user['email']}', '{$user['password']}', '{$user['user_type']}')";
    if (mysqli_query($con, $sql)) {
        mysqli_close($con); 
        return true;
    }
    return false;
}

function updateUserProfilePicture($email, $filename) {
    $con = getConnection();
    $sql = "UPDATE users SET profile_picture='{$filename}' WHERE email='{$email}'";
    return mysqli_query($con, $sql);
}



// function user_exists_by_nid($conn, $nid) {
//     $sql = "SELECT COUNT(*) FROM users WHERE nid = '$nid'";
//     $result = mysqli_query($conn, $sql);
//     return mysqli_fetch_column($result) > 0;
// }

// function log_activity($user_id, $action, $details) {
//     $con = getConnection();
//     $sql = "INSERT INTO activity_logs (user_id, action, details) VALUES ($user_id, '$action', '$details')";
//     return mysqli_query($con, $sql);
// }


?>

