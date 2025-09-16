<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

// Authentication check
if (
    !isset($_SESSION['user_type']) &&
    (!isset($_COOKIE['user_type']) || ($_COOKIE['user_type'] !== 'admin' && $_COOKIE['user_type'] !== 'super_admin'))
) {
    header('location: login.php');
    exit();
}

// Doctor functions
function get_all_doctors($conn) {
    $sql = "SELECT * FROM doctors ORDER BY full_name";
    $result = mysqli_query($conn, $sql);
    $doctors = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $doctors[] = $row;
        }
    }
    return $doctors;
}

function add_doctor($conn, $data) {
    $email = $data['email'];
    $password = $data['password']; // plain text password
    $user_type = 'doctor';

    // Insert into users
    $user_sql = "INSERT INTO users (email, password, user_type) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $user_sql);
    mysqli_stmt_bind_param($stmt, "sss", $email, $password, $user_type);

    if (mysqli_stmt_execute($stmt)) {
        // Insert into doctors
        $doctor_sql = "INSERT INTO doctors 
            (full_name, date_of_birth, gender, phone, address, qualifications, specialty, consultation_fee, available_days, start_time, end_time, on_call, license_number, email, blood_group, nid) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $doctor_sql);
        mysqli_stmt_bind_param($stmt, "ssssssssssssssss", 
            $data['full_name'],
            $data['date_of_birth'],
            $data['gender'],
            $data['phone'],
            $data['address'],
            $data['qualifications'],
            $data['specialty'],
            $data['consultation_fee'],
            $data['available_days'],
            $data['start_time'],
            $data['end_time'],
            $data['on_call'],
            $data['license_number'],
            $email,
            $data['blood_group'],
            $data['nid']
        );

        if (mysqli_stmt_execute($stmt)) {
            return true;
        } else {
            die("Doctor insert error: " . mysqli_error($conn));
        }
    } else {
        die("User insert error: " . mysqli_error($conn));
    }
    return false;
}

function update_doctor($conn, $doctor_id, $data) {
    $sql = "UPDATE doctors SET 
        full_name=?, date_of_birth=?, gender=?, phone=?, address=?, 
        qualifications=?, specialty=?, consultation_fee=?, available_days=?, 
        start_time=?, end_time=?, on_call=?, license_number=?, email=?, blood_group=?, nid=? 
        WHERE id=?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssssssssssssi", 
        $data['full_name'],
        $data['date_of_birth'],
        $data['gender'],
        $data['phone'],
        $data['address'],
        $data['qualifications'],
        $data['specialty'],
        $data['consultation_fee'],
        $data['available_days'],
        $data['start_time'],
        $data['end_time'],
        $data['on_call'],
        $data['license_number'],
        $data['email'],
        $data['blood_group'],
        $data['nid'],
        $doctor_id
    );

    if (mysqli_stmt_execute($stmt)) {
        // keep users table email in sync
        $u_sql = "UPDATE users SET email=? WHERE user_type='doctor' AND email=(SELECT email FROM doctors WHERE id=?)";
        $u_stmt = mysqli_prepare($conn, $u_sql);
        mysqli_stmt_bind_param($u_stmt, "si", $data['email'], $doctor_id);
        mysqli_stmt_execute($u_stmt);

        return true;
    } else {
        die("Doctor update error: " . mysqli_error($conn));
    }
}

function get_doctor_by_id($conn, $doctor_id) {
    $sql = "SELECT * FROM doctors WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $doctor_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function get_doctors_count($conn) {
    $sql = "SELECT COUNT(*) as count FROM doctors";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

function get_specialties_count($conn) {
    $sql = "SELECT COUNT(DISTINCT specialty) as count FROM doctors";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_doctor'])) {
        $data = [
            'full_name' => $_POST['full_name'],
            'date_of_birth' => $_POST['date_of_birth'],
            'gender' => $_POST['gender'],
            'phone' => $_POST['phone'],
            'address' => $_POST['address'],
            'qualifications' => $_POST['qualifications'],
            'specialty' => $_POST['specialty'],
            'consultation_fee' => $_POST['consultation_fee'],
            'available_days' => !empty($_POST['available_days']) ? implode(',', $_POST['available_days']) : '',
            'start_time' => $_POST['start_time'],
            'end_time' => $_POST['end_time'],
            'on_call' => isset($_POST['on_call']) ? 1 : 0,
            'license_number' => $_POST['license_number'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'blood_group' => $_POST['blood_group'],
            'nid' => $_POST['nid']
        ];
        if (add_doctor($conn, $data)) {
            $success_message = "Doctor added successfully!";
        } else {
            $error_message = "Error adding doctor: " . mysqli_error($conn);
        }
    }

    if (isset($_POST['update_doctor'])) {
        $doctor_id = $_POST['doctor_id'];
        $data = [
            'full_name' => $_POST['full_name'],
            'date_of_birth' => $_POST['date_of_birth'],
            'gender' => $_POST['gender'],
            'phone' => $_POST['phone'],
            'address' => $_POST['address'],
            'qualifications' => $_POST['qualifications'],
            'specialty' => $_POST['specialty'],
            'consultation_fee' => $_POST['consultation_fee'],
            'available_days' => !empty($_POST['available_days']) ? implode(',', $_POST['available_days']) : '',
            'start_time' => $_POST['start_time'],
            'end_time' => $_POST['end_time'],
            'on_call' => isset($_POST['on_call']) ? 1 : 0,
            'license_number' => $_POST['license_number'],
            'email' => $_POST['email'],
            'blood_group' => $_POST['blood_group'],
            'nid' => $_POST['nid']
        ];
        if (update_doctor($conn, $doctor_id, $data)) {
            $success_message = "Doctor updated successfully!";
        } else {
            $error_message = "Error updating doctor: " . mysqli_error($conn);
        }
    }
}

// Fetch data
$doctors = get_all_doctors($conn);
$doctors_count = get_doctors_count($conn);
$specialties_count = get_specialties_count($conn);
?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e6ed;
        }

        .page-header h2 {
            color: #2c3e50;
            font-size: 24px;
            font-weight: 600;
        }

        .page-header h2 i {
            margin-right: 10px;
            color: #3498db;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn i {
            margin-right: 8px;
        }

        .btn-primary {
            background-color: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .btn-success {
            background-color: #27ae60;
            color: white;
        }

        .btn-success:hover {
            background-color: #219653;
        }

        .btn-danger {
            background-color: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 13px;
        }

        .doctor-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
        }

        .stat-card.primary {
            border-left: 4px solid #3498db;
        }

        .stat-card.success {
            border-left: 4px solid #27ae60;
        }

        .stat-card.info {
            border-left: 4px solid #17a2b8;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 20px;
        }

        .stat-card.primary .stat-icon {
            background-color: rgba(52, 152, 219, 0.2);
            color: #3498db;
        }

        .stat-card.success .stat-icon {
            background-color: rgba(39, 174, 96, 0.2);
            color: #27ae60;
        }

        .stat-card.info .stat-icon {
            background-color: rgba(23, 162, 184, 0.2);
            color: #17a2b8;
        }

        .stat-info h3 {
            font-size: 24px;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .stat-info p {
            color: #7f8c8d;
            margin-bottom: 5px;
        }

        .doctor-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .dashboard-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
        }

        .card-header {
            padding: 15px 20px;
            border-bottom: 1px solid #e0e6ed;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h3 {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
        }

        .card-header h3 i {
            margin-right: 10px;
            color: #7f8c8d;
        }

        .card-body {
            padding: 20px;
        }

        .doctor-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .doctor-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: transform 0.3s ease;
            border-left: 4px solid #3498db;
        }

        .doctor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .doctor-info {
            padding: 15px;
        }

        .doctor-info h4 {
            font-size: 18px;
            margin-bottom: 5px;
            color: #2c3e50;
        }

        .doctor-info p {
            color: #7f8c8d;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .doctor-meta {
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-bottom: 10px;
        }

        .doctor-meta span {
            font-size: 13px;
            display: flex;
            align-items: center;
        }

        .doctor-meta i {
            margin-right: 8px;
            width: 16px;
            color: #3498db;
        }

        .doctor-actions {
            padding: 15px;
            border-top: 1px solid #e0e6ed;
            display: flex;
            gap: 10px;
        }

        .success-message {
            background-color: rgba(39, 174, 96, 0.1);
            border-left: 3px solid #27ae60;
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 6px;
            display: flex;
            align-items: center;
        }

        .success-message i {
            color: #27ae60;
            margin-right: 10px;
        }

        .error-message {
            background-color: rgba(231, 76, 60, 0.1);
            border-left: 3px solid #e74c3c;
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 6px;
            display: flex;
            align-items: center;
        }

        .error-message i {
            color: #e74c3c;
            margin-right: 10px;
        }

        .add-doctor-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 5px;
            font-weight: 500;
            color: #2c3e50;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 10px;
            border: 1px solid #e0e6ed;
            border-radius: 6px;
            font-size: 14px;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 5px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            overflow: auto;
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 700px;
            position: relative;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            position: absolute;
            right: 20px;
            top: 15px;
        }

        .close:hover {
            color: #000;
        }

        .modal-header {
            padding: 10px 0;
            border-bottom: 1px solid #e0e6ed;
            margin-bottom: 20px;
        }

        .modal-header h3 {
            color: #2c3e50;
            font-size: 20px;
        }
    </style>

    <?php include 'header.php'; ?>
    
    <main class="main-content">
        <div class="page-header">
            <h2><i class="fas fa-user-md"></i> Doctor Management</h2>
        </div>

        <div class="doctor-stats">
            <div class="stat-card primary">
                <div class="stat-icon">
                    <i class="fas fa-user-md"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $doctors_count; ?></h3>
                    <p>Total Doctors</p>
                    <span class="stat-change">All specialties</span>
                </div>
            </div>
            <div class="stat-card success">
                <div class="stat-icon">
                    <i class="fas fa-stethoscope"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $specialties_count; ?></h3>
                    <p>Specialties</p>
                    <span class="stat-change">Medical fields</span>
                </div>
            </div>
            <div class="stat-card info">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $doctors_count; ?></h3>
                    <p>Active Doctors</p>
                    <span class="stat-change">Currently available</span>
                </div>
            </div>
        </div>

        <div class="doctor-container">
            <div class="doctor-left">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-list"></i> Doctor Directory</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($success_message)): ?>
                            <div class="success-message">
                                <i class="fas fa-check-circle"></i>
                                <?php echo $success_message; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($error_message)): ?>
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>

                        <div class="doctor-grid" id="doctorGrid">
                            <?php foreach ($doctors as $doctor): ?>
                            <div class="doctor-card">
                                <div class="doctor-info">
                                    <h4><?php echo htmlspecialchars($doctor['full_name']); ?></h4>
                                    <p><?php echo htmlspecialchars($doctor['specialty']); ?> Specialist</p>
                                    <div class="doctor-meta">
                                        <span><i class="fas fa-id-badge"></i> License: <?php echo htmlspecialchars($doctor['license_number']); ?></span>
                                        <span><i class="fas fa-phone"></i> <?php echo htmlspecialchars($doctor['phone']); ?></span>
                                        <span><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($doctor['email']); ?></span>
                                        <span><i class="fas fa-money-bill-wave"></i> Fee: $<?php echo $doctor['consultation_fee']; ?></span>
                                        <span><i class="fas fa-clock"></i> Available: <?php echo str_replace(',', ', ', $doctor['available_days']); ?></span>
                                        <span><i class="fas fa-tint"></i> Blood Group: <?php echo htmlspecialchars($doctor['blood_group']); ?></span>
                                        <span><i class="fas fa-id-card"></i> NID: <?php echo htmlspecialchars($doctor['nid']); ?></span>
                                    </div>
                                </div>
                                <div class="doctor-actions">
                                    <button class="btn btn-sm btn-outline-success" onclick="openEditModal(<?php echo $doctor['id']; ?>)">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="doctor-right">
                <div class="dashboard-card" id="add-doctor-form">
                    <div class="card-header">
                        <h3><i class="fas fa-user-plus"></i> Add New Doctor</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" class="add-doctor-form">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="full_name" required>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Date of Birth</label>
                                    <input type="date" name="date_of_birth" required>
                                </div>
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="tel" name="phone" required>
                                </div>
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input type="email" name="email" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" required>
                            </div>

                            <div class="form-group">
                                <label>Address</label>
                                <textarea name="address" rows="3" required></textarea>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Specialty</label>
                                    <input type="text" name="specialty" required>
                                </div>
                                <div class="form-group">
                                    <label>Consultation Fee ($)</label>
                                    <input type="number" name="consultation_fee" step="0.01" min="0" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Qualifications</label>
                                <textarea name="qualifications" rows="3" required></textarea>
                            </div>

                            <div class="form-group">
                                <label>License Number</label>
                                <input type="text" name="license_number" required>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Blood Group</label>
                                    <select name="blood_group">
                                        <option value="">Select Blood Group</option>
                                        <option value="A+">A+</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B-">B-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                        <option value="O+">O+</option>
                                        <option value="O-">O-</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>NID</label>
                                    <input type="text" name="nid">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Available Days</label>
                                <div class="checkbox-group">
                                    <?php 
                                    $days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
                                    foreach ($days as $day): ?>
                                    <div class="checkbox-item">
                                        <input type="checkbox" name="available_days[]" value="<?php echo $day; ?>" id="day_<?php echo $day; ?>">
                                        <label for="day_<?php echo $day; ?>"><?php echo ucfirst($day); ?></label>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Start Time</label>
                                    <input type="time" name="start_time" required>
                                </div>
                                <div class="form-group">
                                    <label>End Time</label>
                                    <input type="time" name="end_time" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="checkbox-item">
                                    <input type="checkbox" name="on_call" id="on_call" value="1">
                                    <label for="on_call">Available for on-call duty</label>
                                </div>
                            </div>

                            <button type="submit" name="add_doctor" class="btn btn-success btn-block">
                                <i class="fas fa-user-plus"></i> Add Doctor
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Edit Doctor Modal -->
    <div id="editDoctorModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <div class="modal-header">
                <h3><i class="fas fa-edit"></i> Edit Doctor</h3>
            </div>
            <form method="POST" class="add-doctor-form">
                <input type="hidden" name="doctor_id" id="edit_doctor_id">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" id="edit_full_name" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Date of Birth</label>
                        <input type="date" name="date_of_birth" id="edit_date_of_birth" required>
                    </div>
                    <div class="form-group">
                        <label>Gender</label>
                        <select name="gender" id="edit_gender" required>
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="tel" name="phone" id="edit_phone" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" id="edit_email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" id="edit_address" rows="3" required></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Specialty</label>
                        <input type="text" name="specialty" id="edit_specialty" required>
                    </div>
                    <div class="form-group">
                        <label>Consultation Fee ($)</label>
                        <input type="number" name="consultation_fee" id="edit_consultation_fee" step="0.01" min="0" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Qualifications</label>
                    <textarea name="qualifications" id="edit_qualifications" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label>License Number</label>
                    <input type="text" name="license_number" id="edit_license_number" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Blood Group</label>
                        <select name="blood_group" id="edit_blood_group">
                            <option value="">Select Blood Group</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>NID</label>
                        <input type="text" name="nid" id="edit_nid">
                    </div>
                </div>

                <div class="form-group">
                    <label>Available Days</label>
                    <div class="checkbox-group" id="edit_available_days">
                        <?php 
                        $days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
                        foreach ($days as $day): ?>
                        <div class="checkbox-item">
                            <input type="checkbox" name="available_days[]" value="<?php echo $day; ?>" id="edit_day_<?php echo $day; ?>">
                            <label for="edit_day_<?php echo $day; ?>"><?php echo ucfirst($day); ?></label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Start Time</label>
                        <input type="time" name="start_time" id="edit_start_time" required>
                    </div>
                    <div class="form-group">
                        <label>End Time</label>
                        <input type="time" name="end_time" id="edit_end_time" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox-item">
                        <input type="checkbox" name="on_call" id="edit_on_call" value="1">
                        <label for="edit_on_call">Available for on-call duty</label>
                    </div>
                </div>

                <button type="submit" name="update_doctor" class="btn btn-success btn-block">
                    <i class="fas fa-save"></i> Update Doctor
                </button>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id) {
            const doctor = <?php echo json_encode($doctors); ?>.find(d => d.id == id);
            if (!doctor) return;

            // Fill fields
            document.getElementById("edit_doctor_id").value = doctor.id;
            document.getElementById("edit_full_name").value = doctor.full_name;
            document.getElementById("edit_date_of_birth").value = doctor.date_of_birth;
            document.getElementById("edit_gender").value = doctor.gender;
            document.getElementById("edit_phone").value = doctor.phone;
            document.getElementById("edit_email").value = doctor.email;
            document.getElementById("edit_license_number").value = doctor.license_number;
            document.getElementById("edit_specialty").value = doctor.specialty;
            document.getElementById("edit_consultation_fee").value = doctor.consultation_fee;
            document.getElementById("edit_address").value = doctor.address;
            document.getElementById("edit_qualifications").value = doctor.qualifications;
            document.getElementById("edit_start_time").value = doctor.start_time;
            document.getElementById("edit_end_time").value = doctor.end_time;
            document.getElementById("edit_on_call").checked = doctor.on_call == 1;
            document.getElementById("edit_blood_group").value = doctor.blood_group || '';
            document.getElementById("edit_nid").value = doctor.nid || '';

            // Reset all checkboxes first
            document.querySelectorAll("[id^=edit_day_]").forEach(cb => cb.checked = false);

            // Re-check selected days
            if (doctor.available_days) {
                doctor.available_days.split(",").forEach(day => {
                    const checkbox = document.getElementById("edit_day_" + day.trim());
                    if (checkbox) checkbox.checked = true;
                });
            }

            document.getElementById("editDoctorModal").style.display = "block";
        }

        function closeEditModal() {
            document.getElementById("editDoctorModal").style.display = "none";
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            var modal = document.getElementById('editDoctorModal');
            if (event.target == modal) {
                closeEditModal();
            }
        }
    </script>
</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>