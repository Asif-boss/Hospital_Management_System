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

// Authentication check - only super_admin can access
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'super_admin') {
    header('location: login.php');
    exit();
}

// Admin functions
function get_all_admins($conn) {
    $sql = "SELECT a.*, u.user_type FROM admins a LEFT JOIN users u ON a.email = u.email ORDER BY a.full_name";
    $result = mysqli_query($conn, $sql);
    $admins = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $admins[] = $row;
        }
    }
    return $admins;
}

function add_admin($conn, $data) {
    // Insert into users table (plain text password)
    $email = mysqli_real_escape_string($conn, $data['email']);
    $password = mysqli_real_escape_string($conn, $data['password']); // No hashing
    $user_type = mysqli_real_escape_string($conn, $data['user_type']);
    
    $user_sql = "INSERT INTO users (email, password, user_type) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $user_sql);
    if (!$stmt) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, "sss", $email, $password, $user_type);
    
    if (mysqli_stmt_execute($stmt)) {
        // Insert into admins table
        $admin_sql = "INSERT INTO admins 
            (full_name, date_of_birth, gender, phone, address, email, blood_group, nid) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $admin_sql);
        if (!$stmt) {
            // Rollback: delete user entry if admin insertion fails
            $delete_sql = "DELETE FROM users WHERE email = ?";
            $delete_stmt = mysqli_prepare($conn, $delete_sql);
            mysqli_stmt_bind_param($delete_stmt, "s", $email);
            mysqli_stmt_execute($delete_stmt);
            return false;
        }
        mysqli_stmt_bind_param($stmt, "ssssssss", 
            mysqli_real_escape_string($conn, $data['full_name']),
            mysqli_real_escape_string($conn, $data['date_of_birth']),
            mysqli_real_escape_string($conn, $data['gender']),
            mysqli_real_escape_string($conn, $data['phone']),
            mysqli_real_escape_string($conn, $data['address']),
            $email,
            mysqli_real_escape_string($conn, $data['blood_group']),
            mysqli_real_escape_string($conn, $data['nid'])
        );
        
        return mysqli_stmt_execute($stmt);
    }
    return false;
}

function update_admin($conn, $admin_id, $data) {
    // Get current admin details
    $current_admin = get_admin_by_id($conn, $admin_id);
    if (!$current_admin) {
        return false; // Admin not found
    }
    $old_email = $current_admin['email'];
    
    // Update admins table
    $sql = "UPDATE admins SET 
        full_name=?, date_of_birth=?, gender=?, phone=?, address=?, 
        email=?, blood_group=?, nid=? 
        WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, "ssssssssi", 
    $data['full_name'],
    $data['date_of_birth'],
    $data['gender'],
    $data['phone'],
    $data['address'],
    $data['email'],
    $data['blood_group'],
    $data['nid'],
    $admin_id
    );
    if (mysqli_stmt_execute($stmt)) {
        // Check if user exists in users table
        $user_check_sql = "SELECT id FROM users WHERE email = ? AND user_type IN ('admin', 'super_admin')";
        $user_check_stmt = mysqli_prepare($conn, $user_check_sql);
        if (!$user_check_stmt) {
            return false;
        }
        mysqli_stmt_bind_param($user_check_stmt, "s", $old_email);
        mysqli_stmt_execute($user_check_stmt);
        $user_result = mysqli_stmt_get_result($user_check_stmt);
        
        if (mysqli_num_rows($user_result) > 0) {
            // Update users table
            $user_sql = "UPDATE users SET email=?, user_type=? WHERE email=?";
            $user_stmt = mysqli_prepare($conn, $user_sql);
            mysqli_stmt_bind_param($user_stmt, "sss", 
                $data['email'],
                $data['user_type'],
                $old_email
            );

            return mysqli_stmt_execute($user_stmt);
        } else {
            // If no user entry exists, create one (unlikely but possible)
            $user_sql = "INSERT INTO users (email, password, user_type) VALUES (?, ?, ?)";
            $user_stmt = mysqli_prepare($conn, $user_sql);
            if (!$user_stmt) {
                return false;
            }
            $default_password = "default_password"; // Placeholder, should be handled separately
            mysqli_stmt_bind_param($user_stmt, "sss", 
                mysqli_real_escape_string($conn, $data['email']),
                $default_password,
                mysqli_real_escape_string($conn, $data['user_type'])
            );
            return mysqli_stmt_execute($user_stmt);
        }
    }
    return false;
}

function delete_admin($conn, $admin_id) {
    // Get admin email for users table deletion
    $admin = get_admin_by_id($conn, $admin_id);
    if (!$admin) {
        return false;
    }
    $email = $admin['email'];
    
    // Delete from admins table
    $sql = "DELETE FROM admins WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, "i", $admin_id);
    
    if (mysqli_stmt_execute($stmt)) {
        // Delete from users table
        $user_sql = "DELETE FROM users WHERE email=? AND user_type IN ('admin', 'super_admin')";
        $user_stmt = mysqli_prepare($conn, $user_sql);
        if (!$user_stmt) {
            return false;
        }
        mysqli_stmt_bind_param($user_stmt, "s", $email);
        return mysqli_stmt_execute($user_stmt);
    }
    return false;
}

function get_admin_by_id($conn, $admin_id) {
    $sql = "SELECT * FROM admins WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, "i", $admin_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function get_admins_count($conn) {
    $sql = "SELECT COUNT(*) as count FROM admins";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        return 0;
    }
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_admin'])) {
        $data = [
            'full_name' => $_POST['full_name'],
            'date_of_birth' => $_POST['date_of_birth'],
            'gender' => $_POST['gender'],
            'phone' => $_POST['phone'],
            'address' => $_POST['address'],
            'email' => $_POST['email'],
            'blood_group' => $_POST['blood_group'] ?: null,
            'nid' => $_POST['nid'] ?: null,
            'password' => $_POST['password'],
            'user_type' => $_POST['user_type']
        ];
        
        if (add_admin($conn, $data)) {
            $success_message = "Admin added successfully!";
        } else {
            $error_message = "Error adding admin: " . mysqli_error($conn);
        }
    }

    if (isset($_POST['update_admin'])) {
        $admin_id = $_POST['admin_id'];
        $data = [
            'full_name' => $_POST['full_name'],
            'date_of_birth' => $_POST['date_of_birth'],
            'gender' => $_POST['gender'],
            'phone' => $_POST['phone'],
            'address' => $_POST['address'],
            'email' => $_POST['email'],
            'blood_group' => $_POST['blood_group'] ?: null,
            'nid' => $_POST['nid'] ?: null,
            'user_type' => $_POST['user_type']
        ];
        
        if (update_admin($conn, $admin_id, $data)) {
            $success_message = "Admin updated successfully!";
        } else {
            $error_message = "Error updating admin: " . mysqli_error($conn);
        }
    }

    if (isset($_POST['delete_admin'])) {
        $admin_id = $_POST['admin_id'];
        if (delete_admin($conn, $admin_id)) {
            $success_message = "Admin deleted successfully!";
        } else {
            $error_message = "Error deleting admin: " . mysqli_error($conn);
        }
    }
}

// Fetch data
$admins = get_all_admins($conn);
$admins_count = get_admins_count($conn);
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

        .admin-stats {
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

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 20px;
            background-color: rgba(52, 152, 219, 0.2);
            color: #3498db;
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

        .admin-container {
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

        .admin-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .admin-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: transform 0.3s ease;
            border-left: 4px solid #3498db;
        }

        .admin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .admin-info {
            padding: 15px;
        }

        .admin-info h4 {
            font-size: 18px;
            margin-bottom: 5px;
            color: #2c3e50;
        }

        .admin-info p {
            color: #7f8c8d;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .admin-meta {
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-bottom: 10px;
        }

        .admin-meta span {
            font-size: 13px;
            display: flex;
            align-items: center;
        }

        .admin-meta i {
            margin-right: 8px;
            width: 16px;
            color: #3498db;
        }

        .admin-actions {
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

        .add-admin-form {
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

        @media (max-width: 1024px) {
            .admin-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .admin-grid {
                grid-template-columns: 1fr;
            }

            .admin-stats {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .modal-content {
                width: 95%;
                margin: 10% auto;
                padding: 15px;
            }
        }
    </style>
    <?php include 'header.php'; ?>
    
    <main class="main-content">
        <div class="page-header">
            <h2><i class="fas fa-user-shield"></i> Admin Management</h2>
        </div>

        <div class="admin-stats">
            <div class="stat-card primary">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $admins_count; ?></h3>
                    <p>Total Admins</p>
                    <span class="stat-change">Admin & Super Admin</span>
                </div>
            </div>
        </div>

        <div class="admin-container">
            <div class="admin-left">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-list"></i> Admin Directory</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($success_message)): ?>
                            <div class="success-message">
                                <i class="fas fa-check-circle"></i>
                                <?php echo htmlspecialchars($success_message); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($error_message)): ?>
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                <?php echo htmlspecialchars($error_message); ?>
                            </div>
                        <?php endif; ?>

                        <div class="admin-grid" id="adminGrid">
                            <?php foreach ($admins as $admin): ?>
                            <div class="admin-card">
                                <div class="admin-info">
                                    <h4><?php echo htmlspecialchars($admin['full_name']); ?></h4>
                                    <p><?php echo htmlspecialchars(ucfirst($admin['user_type'] ?? 'N/A')); ?></p>
                                    <div class="admin-meta">
                                        <span><i class="fas fa-id-badge"></i> ID: <?php echo htmlspecialchars($admin['id']); ?></span>
                                        <span><i class="fas fa-envelope"></i> Email: <?php echo htmlspecialchars($admin['email']); ?></span>
                                        <span><i class="fas fa-phone"></i> Phone: <?php echo htmlspecialchars($admin['phone']); ?></span>
                                        <span><i class="fas fa-tint"></i> Blood Group: <?php echo htmlspecialchars($admin['blood_group'] ?? 'N/A'); ?></span>
                                        <span><i class="fas fa-id-card"></i> NID: <?php echo htmlspecialchars($admin['nid'] ?? 'N/A'); ?></span>
                                    </div>
                                </div>
                                <div class="admin-actions">
                                    <button class="btn btn-sm btn-outline-success" onclick="openEditModal(<?php echo $admin['id']; ?>)">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="admin_id" value="<?php echo $admin['id']; ?>">
                                        <button type="submit" name="delete_admin" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this admin?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-right">
                <div class="dashboard-card" id="add-admin-form">
                    <div class="card-header">
                        <h3><i class="fas fa-user-plus"></i> Add New Admin</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" class="add-admin-form">
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
                                <label>Address</label>
                                <textarea name="address" rows="3" required></textarea>
                            </div>

                            <div class="form-group">
                                <label>User Type</label>
                                <select name="user_type" required>
                                    <option value="">Select User Type</option>
                                    <option value="admin">Admin</option>
                                    <option value="super_admin">Super Admin</option>
                                </select>
                            </div>

                            <button type="submit" name="add_admin" class="btn btn-success btn-block">
                                <i class="fas fa-user-plus"></i> Add Admin
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Edit Admin Modal -->
    <div id="editAdminModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <div class="modal-header">
                <h3><i class="fas fa-edit"></i> Edit Admin</h3>
            </div>
            <form method="POST" class="add-admin-form">
                <input type="hidden" name="admin_id" id="edit_admin_id">
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
                    <label>Address</label>
                    <textarea name="address" id="edit_address" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label>User Type</label>
                    <select name="user_type" id="edit_user_type" required>
                        <option value="">Select User Type</option>
                        <option value="admin">Admin</option>
                        <option value="super_admin">Super Admin</option>
                    </select>
                </div>

                <button type="submit" name="update_admin" class="btn btn-success btn-block">
                    <i class="fas fa-save"></i> Update Admin
                </button>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id) {
            const admin = <?php echo json_encode($admins); ?>.find(a => a.id == id);
            if (!admin) {
                alert('Admin not found');
                return;
            }

            document.getElementById("edit_admin_id").value = admin.id;
            document.getElementById("edit_full_name").value = admin.full_name;
            document.getElementById("edit_date_of_birth").value = admin.date_of_birth;
            document.getElementById("edit_gender").value = admin.gender;
            document.getElementById("edit_phone").value = admin.phone;
            document.getElementById("edit_email").value = admin.email;
            document.getElementById("edit_blood_group").value = admin.blood_group || '';
            document.getElementById("edit_nid").value = admin.nid || '';
            document.getElementById("edit_address").value = admin.address;
            document.getElementById("edit_user_type").value = admin.user_type || '';

            document.getElementById("editAdminModal").style.display = "block";
        }

        function closeEditModal() {
            document.getElementById("editAdminModal").style.display = "none";
        }

        window.onclick = function(event) {
            var modal = document.getElementById('editAdminModal');
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