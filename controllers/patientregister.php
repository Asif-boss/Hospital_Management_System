
<?php
require_once('../models/userModel.php');
require_once('../models/patientModel.php');

$name = trim($_REQUEST['name']);
$nid = trim($_REQUEST['nid']);
$email = trim($_REQUEST['email']);
$password = trim($_REQUEST['password']);
$phone = trim($_REQUEST['phone']);
$date_of_birth = $_REQUEST['date_of_birth'];
$gender = $_REQUEST['gender'];
$blood_group = $_REQUEST['blood_group'];

if (userExistsByNID($nid)){
    header('location: ../views/register.php?error=used_nid');
}
if (userExistsByEmail($email)){
    header('location: ../views/register.php?error=used_email');
}
$user = [
    'full_name' => $name,
    'nid' => $nid,
    'email' => $email,
    'password' => $password,
    'phone' => $phone,
    'date_of_birth' => $date_of_birth,
    'blood_group' => $blood,
    'gender' => $gender,
    'user_type' => 'patient'
];

if (create_user($user) && create_patient($user)) {
    header('location: ../views/login.php?success=registrer');
}
?>