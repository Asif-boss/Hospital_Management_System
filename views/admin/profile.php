<?php
    if (!isset($_COOKIE['user_type'])) {
        header('location: ../login.php');
    }elseif ($_COOKIE['user_type'] !== 'admin') {
        header('location: ../login.php');
    }

    include '../templates/header.php';
?>

<div class="dashboard-layout">
    <?php include '../templates/sidebar.php'; ?>
    
    <main class="main-content">
        <div class="page-header">
            <h2><i class="fas fa-user-shield"></i> Administrator Profile</h2>
        </div>

        <div class="admin-profile-container">
            <div class="profile-left">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-user"></i> Personal Information</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($success)): ?>
                            <div class="success-message">
                                <i class="fas fa-check-circle"></i>
                                <?php echo $success; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" class="admin-profile-form" enctype="multipart/form-data">
                            <div class="admin-photo-section">
                                <div class="photo-container">
                                    <img src="https://images.pexels.com/photos/5215024/pexels-photo-5215024.jpeg?auto=compress&cs=tinysrgb&w=150&h=150&fit=crop&crop=face" alt="Admin Photo" id="adminProfileImage">
                                    <div class="photo-overlay">
                                        <i class="fas fa-camera"></i>
                                        <span>Change Photo</span>
                                    </div>
                                    <input type="file" id="adminPhotoUpload" name="profile_photo" accept="image/*" style="display: none;">
                                </div>
                                <div class="admin-badge">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>System Administrator</span>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" name="full_name" value="Administrator" required>
                                </div>
                                <div class="form-group">
                                    <label>Employee ID</label>
                                    <input type="text" name="employee_id" value="ADM-001" readonly>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input type="email" name="email" value="admin@bdhospital.com" required>
                                </div>
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="tel" name="phone" value="+880-1111111111" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Department</label>
                                    <select name="department" required>
                                        <option value="administration" selected>Administration</option>
                                        <option value="it">IT & Operations</option>
                                        <option value="hr">Human Resources</option>
                                        <option value="finance">Finance</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Access Level</label>
                                    <select name="access_level" required>
                                        <option value="admin" selected>Administrator</option>
                                        <option value="super_admin">Super Administrator</option>
                                        <option value="manager">Manager</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Office Address</label>
                                <textarea name="office_address" rows="3" required>BD Hospital, Admin Wing, Room 201
123 Medical Street, Dhaka 1000, Bangladesh</textarea>
                            </div>

                            <button type="submit" name="update_profile" class="btn btn-primary btn-block">
                                <i class="fas fa-save"></i> Update Profile
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="profile-right">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-shield-alt"></i> Security Settings</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($security_success)): ?>
                            <div class="success-message">
                                <i class="fas fa-check-circle"></i>
                                <?php echo $security_success; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" class="security-form">
                            <div class="form-group">
                                <label>Current Password</label>
                                <input type="password" name="current_password" required>
                            </div>

                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" name="new_password" required>
                            </div>

                            <div class="form-group">
                                <label>Confirm New Password</label>
                                <input type="password" name="confirm_password" required>
                            </div>

                            <div class="security-options">
                                <label class="checkbox-container">
                                    <input type="checkbox" name="two_factor" checked>
                                    <span class="checkmark"></span>
                                    Enable Two-Factor Authentication
                                </label>
                                <label class="checkbox-container">
                                    <input type="checkbox" name="login_alerts" checked>
                                    <span class="checkmark"></span>
                                    Email alerts for new logins
                                </label>
                            </div>

                            <button type="submit" name="update_security" class="btn btn-warning btn-block">
                                <i class="fas fa-key"></i> Update Security
                            </button>
                        </form>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-history"></i> Login History</h3>
                    </div>
                    <div class="card-body">
                        <div class="login-history">
                            <div class="login-item current">
                                <div class="login-info">
                                    <h4>Current Session</h4>
                                    <p>Chrome on Windows</p>
                                    <span class="login-time">Today, 9:30 AM</span>
                                </div>
                                <span class="login-status active">Active</span>
                            </div>

                            <div class="login-item">
                                <div class="login-info">
                                    <h4>Previous Login</h4>
                                    <p>Chrome on Windows</p>
                                    <span class="login-time">Yesterday, 8:45 AM</span>
                                </div>
                                <span class="login-status">Ended</span>
                            </div>

                            <div class="login-item">
                                <div class="login-info">
                                    <h4>Mobile Login</h4>
                                    <p>Safari on iPhone</p>
                                    <span class="login-time">Dec 12, 2:15 PM</span>
                                </div>
                                <span class="login-status">Ended</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-key"></i> Admin Permissions</h3>
                    </div>
                    <div class="card-body">
                        <div class="permissions-list">
                            <div class="permission-item">
                                <div class="permission-info">
                                    <h4>User Management</h4>
                                    <p>Create, edit, and delete user accounts</p>
                                </div>
                                <span class="permission-status granted">Granted</span>
                            </div>

                            <div class="permission-item">
                                <div class="permission-info">
                                    <h4>Inventory Control</h4>
                                    <p>Manage hospital inventory and supplies</p>
                                </div>
                                <span class="permission-status granted">Granted</span>
                            </div>

                            <div class="permission-item">
                                <div class="permission-info">
                                    <h4>Financial Reports</h4>
                                    <p>Access billing and financial data</p>
                                </div>
                                <span class="permission-status granted">Granted</span>
                            </div>

                            <div class="permission-item">
                                <div class="permission-info">
                                    <h4>System Configuration</h4>
                                    <p>Modify system settings and preferences</p>
                                </div>
                                <span class="permission-status limited">Limited</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="../../assets/js/validation.js"></script>
</body>
</html>
