<?php
// config.php - Database configuration
$servername = "localhost";
$username = "root";
$password = "";
// $dbname = "demo_hospital";
$dbname = "hospital";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// staff_functions.php - Model functions
function get_all_staff($conn) {
    $sql = "SELECT * FROM staff ORDER BY full_name";
    $result = mysqli_query($conn, $sql);
    $staff = [];
    
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $staff[] = $row;
        }
    }
    return $staff;
}

function add_staff($conn, $full_name, $role, $department, $phone, $email, $credentials) {
    $sql = "INSERT INTO staff (full_name, role, department, phone, email, credentials_license) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssss", $full_name, $role, $department, $phone, $email, $credentials);
    return mysqli_stmt_execute($stmt);
}

function update_staff($conn, $staff_id, $full_name, $role, $department, $phone, $email, $credentials) {
    $sql = "UPDATE staff SET full_name=?, role=?, department=?, phone=?, email=?, credentials_license=? WHERE staff_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssi", $full_name, $role, $department, $phone, $email, $credentials, $staff_id);
    return mysqli_stmt_execute($stmt);
}

function get_staff_by_id($conn, $staff_id) {
    $sql = "SELECT * FROM staff WHERE staff_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $staff_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function get_staff_count_by_role($conn, $role) {
    $sql = "SELECT COUNT(*) as count FROM staff WHERE role = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $role);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

function get_total_staff($conn) {
    $sql = "SELECT COUNT(*) as count FROM staff";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

// Process form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_staff'])) {
        $full_name = $_POST['full_name'];
        $role = $_POST['role'];
        $department = $_POST['department'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $credentials = $_POST['credentials'];
        
        if (add_staff($conn, $full_name, $role, $department, $phone, $email, $credentials)) {
            $success_message = "Staff member added successfully!";
        } else {
            $error_message = "Error adding staff member: " . mysqli_error($conn);
        }
    }
    
    if (isset($_POST['update_staff'])) {
        $staff_id = $_POST['staff_id'];
        $full_name = $_POST['full_name'];
        $role = $_POST['role'];
        $department = $_POST['department'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $credentials = $_POST['credentials'];
        
        if (update_staff($conn, $staff_id, $full_name, $role, $department, $phone, $email, $credentials)) {
            $success_message = "Staff member updated successfully!";
        } else {
            $error_message = "Error updating staff member: " . mysqli_error($conn);
        }
    }
}

// Handle AJAX request for staff data
if (isset($_GET['ajax']) && $_GET['ajax'] == "staff" && isset($_GET['staff_id'])) {
    $staff_id = intval($_GET['staff_id']);
    $staff = get_staff_by_id($conn, $staff_id);
    echo json_encode($staff);
    exit;
}

// Get staff data
$staff_members = get_all_staff($conn);
$nurse_count = get_staff_count_by_role($conn, 'Nurse');
$support_count = get_staff_count_by_role($conn, 'Support Staff');
$total_staff = get_total_staff($conn);
?>

<?php
// auth_check.php - Authentication check
session_start();
if (!isset($_SESSION['user_type']) && (!isset($_COOKIE['user_type']) || $_COOKIE['user_type'] !== 'admin' && $_COOKIE['user_type'] !== 'super_admin')) {
    header('location: login.php'); exit();
}
if (isset($_COOKIE['user_type']) && $_COOKIE['user_type'] !== 'admin'  && $_COOKIE['user_type'] !== 'super_admin') {
    header('location: login.php'); exit();
}
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] !== 'admin' && $_SESSION['user_type'] !== 'super_admin') {
    header('location: login.php'); exit();
}
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

        /* .main-content {
            padding: 20px;
            max-width: 1400px;
            margin: 0 auto;
        } */

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

        .header-actions {
            display: flex;
            gap: 15px;
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

        .btn-outline-primary {
            background-color: transparent;
            border: 1px solid #3498db;
            color: #3498db;
        }

        .btn-outline-primary:hover {
            background-color: #3498db;
            color: white;
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

        .staff-stats {
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

        .stat-card.success {
            border-left: 4px solid #27ae60;
        }

        .stat-card.warning {
            border-left: 4px solid #f39c12;
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

        .stat-card.success .stat-icon {
            background-color: rgba(39, 174, 96, 0.2);
            color: #27ae60;
        }

        .stat-card.warning .stat-icon {
            background-color: rgba(243, 156, 18, 0.2);
            color: #f39c12;
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

        .stat-change {
            font-size: 12px;
            font-weight: 500;
        }

        .staff-container {
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

        .staff-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .staff-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: transform 0.3s ease;
            border-left: 4px solid #3498db;
        }

        .staff-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .staff-info {
            padding: 15px;
        }

        .staff-info h4 {
            font-size: 18px;
            margin-bottom: 5px;
            color: #2c3e50;
        }

        .staff-info p {
            color: #7f8c8d;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .staff-meta {
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-bottom: 10px;
        }

        .staff-meta span {
            font-size: 13px;
            display: flex;
            align-items: center;
        }

        .staff-meta i {
            margin-right: 8px;
            width: 16px;
            color: #3498db;
        }

        .staff-actions {
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

        .add-staff-form {
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

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        /* Modal Styles */
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
            max-width: 600px;
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
        <!-- Staff Stats -->
        <div class="page-header"><h2><i class="fas fa-users"></i> Staff Management</h2></div>
        <div class="staff-stats">
            <div class="stat-card success"><div class="stat-icon"><i class="fas fa-user-nurse"></i></div><div class="stat-info"><h3><?php echo $nurse_count; ?></h3><p>Nurses</p></div></div>
            <div class="stat-card warning"><div class="stat-icon"><i class="fas fa-users-cog"></i></div><div class="stat-info"><h3><?php echo $support_count; ?></h3><p>Support Staff</p></div></div>
            <div class="stat-card info"><div class="stat-icon"><i class="fas fa-users"></i></div><div class="stat-info"><h3><?php echo $total_staff; ?></h3><p>Total Staff</p></div></div>
        </div>

        <div class="staff-container">
            <!-- Staff Directory -->
            <div class="staff-left">
                <div class="dashboard-card"><div class="card-header"><h3><i class="fas fa-list"></i> Staff Directory</h3></div>
                    <div class="card-body">
                        <?php if (isset($success_message)) echo "<div class='success-message'><i class='fas fa-check-circle'></i>$success_message</div>"; ?>
                        <?php if (isset($error_message)) echo "<div class='error-message'><i class='fas fa-exclamation-circle'></i>$error_message</div>"; ?>
                        <div class="staff-grid" id="staffGrid">
                            <?php foreach ($staff_members as $staff): ?>
                            <div class="staff-card">
                                <div class="staff-info">
                                    <h4><?= htmlspecialchars($staff['full_name']); ?></h4>
                                    <p><?= htmlspecialchars($staff['role']); ?> - <?= htmlspecialchars($staff['department']); ?></p>
                                    <div class="staff-meta">
                                        <span><i class="fas fa-id-badge"></i> ID: <?= $staff['staff_id']; ?></span>
                                        <span><i class="fas fa-phone"></i> <?= htmlspecialchars($staff['phone']); ?></span>
                                        <span><i class="fas fa-envelope"></i> <?= htmlspecialchars($staff['email']); ?></span>
                                    </div>
                                </div>
                                <div class="staff-actions">
                                    <button class="btn btn-sm btn-outline-success" onclick="openEditModal(<?= $staff['staff_id']; ?>)">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Staff Form -->
            <div class="staff-right">
                <div class="dashboard-card" id="add-staff-form">
                    <div class="card-header"><h3><i class="fas fa-user-plus"></i> Add New Staff</h3></div>
                    <div class="card-body">
                        <form method="POST" class="add-staff-form">
                            <div class="form-group"><label>Full Name</label><input type="text" name="full_name" required></div>
                            <div class="form-row">
                                <div class="form-group"><label>Role</label><select name="role" required><option value="">Select</option><option>Nurse</option><option>Technician</option><option>Administrator</option><option>Support Staff</option></select></div>
                                <div class="form-group"><label>Department</label><select name="department" required><option value="">Select</option><option>Cardiology</option><option>General Medicine</option><option>Emergency</option><option>ICU</option><option>Surgery</option><option>Laboratory</option><option>Pharmacy</option><option>Administration</option></select></div>
                            </div>
                            <div class="form-row"><div class="form-group"><label>Phone</label><input type="tel" name="phone" required></div><div class="form-group"><label>Email</label><input type="email" name="email" required></div></div>
                            <div class="form-group"><label>Credentials</label><input type="text" name="credentials"></div>
                            <button type="submit" name="add_staff" class="btn btn-success btn-block"><i class="fas fa-user-plus"></i> Add Staff Member</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Edit Staff Modal -->
    <div id="editStaffModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <div class="modal-header"><h3><i class="fas fa-edit"></i> Edit Staff Member</h3></div>
            <form method="POST" class="add-staff-form" id="editStaffForm">
                <input type="hidden" name="staff_id" id="edit_staff_id">
                <div class="form-group"><label>Full Name</label><input type="text" name="full_name" id="edit_full_name" required></div>
                <div class="form-row"><div class="form-group"><label>Role</label><select name="role" id="edit_role" required><option>Nurse</option><option>Technician</option><option>Administrator</option><option>Support Staff</option></select></div>
                <div class="form-group"><label>Department</label><select name="department" id="edit_department" required><option>Cardiology</option><option>General Medicine</option><option>Emergency</option><option>ICU</option><option>Surgery</option><option>Laboratory</option><option>Pharmacy</option><option>Administration</option></select></div></div>
                <div class="form-row"><div class="form-group"><label>Phone</label><input type="tel" name="phone" id="edit_phone" required></div><div class="form-group"><label>Email</label><input type="email" name="email" id="edit_email" required></div></div>
                <div class="form-group"><label>Credentials</label><input type="text" name="credentials" id="edit_credentials"></div>
                <button type="submit" name="update_staff" class="btn btn-success btn-block"><i class="fas fa-save"></i> Update Staff Member</button>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(staffId) {
            document.getElementById('editStaffModal').style.display = 'block';
            fetch('<?= $_SERVER['PHP_SELF']; ?>?ajax=staff&staff_id=' + staffId)
            .then(res => res.json())
            .then(data => {
                document.getElementById('edit_staff_id').value = data.staff_id;
                document.getElementById('edit_full_name').value = data.full_name;
                document.getElementById('edit_role').value = data.role;
                document.getElementById('edit_department').value = data.department;
                document.getElementById('edit_phone').value = data.phone;
                document.getElementById('edit_email').value = data.email;
                document.getElementById('edit_credentials').value = data.credentials_license;
            });
        }
        function closeEditModal() {
            document.getElementById('editStaffModal').style.display = 'none';
        }
        window.onclick = function(e) {
            let modal = document.getElementById('editStaffModal');
            if (e.target == modal) closeEditModal();
        }
    </script>
</body>
</html>

<?php mysqli_close($conn); ?>