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
            <h2><i class="fas fa-crown"></i> Super Administrator Panel</h2>
            <div class="access-warning">
                <i class="fas fa-shield-alt"></i>
                <span>High-level system access - Use with caution</span>
            </div>
        </div>

        <div class="superadmin-container">
            <div class="superadmin-left">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-database"></i> Publish Doctor to National DB</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($publish_success)): ?>
                            <div class="success-message">
                                <i class="fas fa-check-circle"></i>
                                <?php echo $publish_success; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" class="publish-form">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Doctor License No.</label>
                                    <input type="text" name="license_no" placeholder="BD-12345" required>
                                </div>
                                <div class="form-group">
                                    <label>Verification Status</label>
                                    <select name="verification_status" required>
                                        <option value="verified" selected>Verified</option>
                                        <option value="pending">Pending Review</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Doctor Name</label>
                                    <input type="text" name="doctor_name" placeholder="Dr. John Smith" required>
                                </div>
                                <div class="form-group">
                                    <label>Specialty</label>
                                    <input type="text" name="specialty" placeholder="Cardiology" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Medical College</label>
                                    <input type="text" name="medical_college" placeholder="Dhaka Medical College" required>
                                </div>
                                <div class="form-group">
                                    <label>Graduation Year</label>
                                    <input type="number" name="graduation_year" min="1980" max="2024" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Additional Certifications</label>
                                <textarea name="certifications" rows="3" placeholder="List any additional certifications..."></textarea>
                            </div>

                            <div class="form-group">
                                <label>Upload Credentials</label>
                                <input type="file" name="credentials" accept=".pdf,.jpg,.jpeg,.png" multiple>
                                <small>Upload medical license, certificates (PDF, JPG, PNG)</small>
                            </div>

                            <button type="submit" name="publish_doctor" class="btn btn-success btn-block">
                                <i class="fas fa-upload"></i> Publish to National Database
                            </button>
                        </form>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-cogs"></i> System Management</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($backup_success)): ?>
                            <div class="success-message">
                                <i class="fas fa-check-circle"></i>
                                <?php echo $backup_success; ?>
                            </div>
                        <?php endif; ?>

                        <div class="system-actions">
                            <div class="action-group">
                                <h4><i class="fas fa-database"></i> Database Management</h4>
                                <div class="action-buttons">
                                    <form method="POST" style="display: inline;">
                                        <button type="submit" name="system_backup" class="btn btn-primary">
                                            <i class="fas fa-download"></i> Create Backup
                                        </button>
                                    </form>
                                    <button class="btn btn-warning" onclick="optimizeDatabase()">
                                        <i class="fas fa-tools"></i> Optimize DB
                                    </button>
                                    <button class="btn btn-info" onclick="viewLogs()">
                                        <i class="fas fa-file-alt"></i> View Logs
                                    </button>
                                </div>
                            </div>

                            <div class="action-group">
                                <h4><i class="fas fa-users-cog"></i> User Management</h4>
                                <div class="action-buttons">
                                    <button class="btn btn-success" onclick="createUser()">
                                        <i class="fas fa-user-plus"></i> Create User
                                    </button>
                                    <button class="btn btn-primary" onclick="manageRoles()">
                                        <i class="fas fa-key"></i> Manage Roles
                                    </button>
                                    <button class="btn btn-warning" onclick="auditUsers()">
                                        <i class="fas fa-search"></i> Audit Users
                                    </button>
                                </div>
                            </div>

                            <div class="action-group">
                                <h4><i class="fas fa-server"></i> System Health</h4>
                                <div class="system-metrics">
                                    <div class="metric-item">
                                        <span class="metric-label">Server Uptime:</span>
                                        <span class="metric-value">99.9%</span>
                                    </div>
                                    <div class="metric-item">
                                        <span class="metric-label">Database Size:</span>
                                        <span class="metric-value">2.4 GB</span>
                                    </div>
                                    <div class="metric-item">
                                        <span class="metric-label">Active Sessions:</span>
                                        <span class="metric-value">24</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="superadmin-right">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-chart-bar"></i> National DB Statistics</h3>
                    </div>
                    <div class="card-body">
                        <div class="national-stats">
                            <div class="national-stat">
                                <div class="stat-icon">
                                    <i class="fas fa-user-md"></i>
                                </div>
                                <div class="stat-data">
                                    <h3>12,456</h3>
                                    <p>Registered Doctors</p>
                                </div>
                            </div>

                            <div class="national-stat">
                                <div class="stat-icon">
                                    <i class="fas fa-hospital"></i>
                                </div>
                                <div class="stat-data">
                                    <h3>1,234</h3>
                                    <p>Hospitals</p>
                                </div>
                            </div>

                            <div class="national-stat">
                                <div class="stat-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="stat-data">
                                    <h3>98.5%</h3>
                                    <p>Verification Rate</p>
                                </div>
                            </div>
                        </div>

                        <div class="recent-publications">
                            <h4>Recent Publications</h4>
                            <div class="publication-item">
                                <div class="pub-info">
                                    <h5>Dr. Ahmed Rahman</h5>
                                    <p>Neurology • BD-98765</p>
                                </div>
                                <span class="pub-status verified">Verified</span>
                            </div>
                            <div class="publication-item">
                                <div class="pub-info">
                                    <h5>Dr. Fatima Khan</h5>
                                    <p>Pediatrics • BD-54321</p>
                                </div>
                                <span class="pub-status pending">Pending</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-exclamation-triangle"></i> System Alerts</h3>
                    </div>
                    <div class="card-body">
                        <div class="system-alerts">
                            <div class="system-alert critical">
                                <div class="alert-icon">
                                    <i class="fas fa-server"></i>
                                </div>
                                <div class="alert-content">
                                    <h4>High CPU Usage</h4>
                                    <p>Server load at 85% - Monitor closely</p>
                                    <span class="alert-time">5 minutes ago</span>
                                </div>
                            </div>

                            <div class="system-alert warning">
                                <div class="alert-icon">
                                    <i class="fas fa-hdd"></i>
                                </div>
                                <div class="alert-content">
                                    <h4>Storage Space</h4>
                                    <p>Database storage at 75% capacity</p>
                                    <span class="alert-time">1 hour ago</span>
                                </div>
                            </div>

                            <div class="system-alert info">
                                <div class="alert-icon">
                                    <i class="fas fa-sync"></i>
                                </div>
                                <div class="alert-content">
                                    <h4>Backup Completed</h4>
                                    <p>Daily backup finished successfully</p>
                                    <span class="alert-time">3 hours ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-chart-line"></i> Performance Metrics</h3>
                    </div>
                    <div class="card-body">
                        <div class="performance-metrics">
                            <div class="performance-item">
                                <div class="metric-header">
                                    <span class="metric-name">Response Time</span>
                                    <span class="metric-value good">245ms</span>
                                </div>
                                <div class="metric-bar">
                                    <div class="metric-progress" style="width: 75%;"></div>
                                </div>
                            </div>

                            <div class="performance-item">
                                <div class="metric-header">
                                    <span class="metric-name">Memory Usage</span>
                                    <span class="metric-value warning">68%</span>
                                </div>
                                <div class="metric-bar">
                                    <div class="metric-progress warning" style="width: 68%;"></div>
                                </div>
                            </div>

                            <div class="performance-item">
                                <div class="metric-header">
                                    <span class="metric-name">Database Load</span>
                                    <span class="metric-value good">42%</span>
                                </div>
                                <div class="metric-bar">
                                    <div class="metric-progress" style="width: 42%;"></div>
                                </div>
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
