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
        <div class="dashboard-welcome">
            <div class="welcome-card">
                <div class="welcome-text">
                    <h2>Welcome to Admin Panel</h2>
                    <p>Hospital Operations • People • Inventory • Security</p>
                </div>
                <div class="welcome-image">
                    <i class="fas fa-hospital-user"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stats">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>1,245</h3>
                    <p>Total Patients</p>
                    <span class="stat-change positive">+12% this month</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="fas fa-user-md"></i>
                </div>
                <div class="stat-info">
                    <h3>45</h3>
                    <p>Medical Staff</p>
                    <span class="stat-change positive">+3 new hires</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="stat-info">
                    <h3>892</h3>
                    <p>Inventory Items</p>
                    <span class="stat-change negative">-23 low stock</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon danger">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-info">
                    <h3>$45,230</h3>
                    <p>Monthly Revenue</p>
                    <span class="stat-change positive">+8% from last month</span>
                </div>
            </div>
        </div>

        <div class="dashboard-content">
            <div class="content-left">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-chart-line"></i> Today's Overview</h3>
                    </div>
                    <div class="card-body">
                        <div class="overview-metrics">
                            <div class="metric-item">
                                <div class="metric-icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="metric-data">
                                    <span class="metric-number">24</span>
                                    <span class="metric-label">Appointments Today</span>
                                </div>
                            </div>
                            <div class="metric-item">
                                <div class="metric-icon">
                                    <i class="fas fa-bed"></i>
                                </div>
                                <div class="metric-data">
                                    <span class="metric-number">87%</span>
                                    <span class="metric-label">Bed Occupancy</span>
                                </div>
                            </div>
                            <div class="metric-item">
                                <div class="metric-icon">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <div class="metric-data">
                                    <span class="metric-number">12</span>
                                    <span class="metric-label">New Registrations</span>
                                </div>
                            </div>
                            <div class="metric-item">
                                <div class="metric-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="metric-data">
                                    <span class="metric-number">5</span>
                                    <span class="metric-label">Critical Alerts</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-exclamation-triangle"></i> System Alerts</h3>
                        <a href="#" class="view-all">Manage All</a>
                    </div>
                    <div class="card-body">
                        <div class="alert-item critical">
                            <div class="alert-icon">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <div class="alert-info">
                                <h4>Low Stock Alert</h4>
                                <p>Surgical masks running low - 15 units remaining</p>
                                <span class="alert-time">5 minutes ago</span>
                            </div>
                            <button class="btn btn-sm btn-primary">Reorder</button>
                        </div>
                        <div class="alert-item warning">
                            <div class="alert-icon">
                                <i class="fas fa-user-clock"></i>
                            </div>
                            <div class="alert-info">
                                <h4>Staff Schedule Conflict</h4>
                                <p>Dr. Johnson has overlapping appointments</p>
                                <span class="alert-time">15 minutes ago</span>
                            </div>
                            <button class="btn btn-sm btn-outline-primary">Resolve</button>
                        </div>
                        <div class="alert-item info">
                            <div class="alert-icon">
                                <i class="fas fa-server"></i>
                            </div>
                            <div class="alert-info">
                                <h4>System Maintenance</h4>
                                <p>Scheduled maintenance tonight at 2:00 AM</p>
                                <span class="alert-time">2 hours ago</span>
                            </div>
                            <button class="btn btn-sm btn-outline-secondary">Acknowledge</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-right">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-chart-pie"></i> Department Statistics</h3>
                    </div>
                    <div class="card-body">
                        <div class="department-stats">
                            <div class="dept-item">
                                <div class="dept-info">
                                    <h4>Emergency</h4>
                                    <span class="dept-count">18 patients</span>
                                </div>
                                <div class="dept-status busy">Busy</div>
                            </div>
                            <div class="dept-item">
                                <div class="dept-info">
                                    <h4>Surgery</h4>
                                    <span class="dept-count">4 operations</span>
                                </div>
                                <div class="dept-status normal">Normal</div>
                            </div>
                            <div class="dept-item">
                                <div class="dept-info">
                                    <h4>ICU</h4>
                                    <span class="dept-count">12/15 beds</span>
                                </div>
                                <div class="dept-status busy">Near Full</div>
                            </div>
                            <div class="dept-item">
                                <div class="dept-info">
                                    <h4>Pharmacy</h4>
                                    <span class="dept-count">156 prescriptions</span>
                                </div>
                                <div class="dept-status normal">Normal</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-tasks"></i> Quick Actions</h3>
                    </div>
                    <div class="card-body">
                        <div class="quick-actions">
                            <a href="staff.php" class="action-item">
                                <div class="action-icon">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <span>Add New Staff</span>
                            </a>
                            <a href="inventory.php" class="action-item">
                                <div class="action-icon">
                                    <i class="fas fa-plus-circle"></i>
                                </div>
                                <span>Add Inventory</span>
                            </a>
                            <a href="doctor_registry.php" class="action-item">
                                <div class="action-icon">
                                    <i class="fas fa-user-md"></i>
                                </div>
                                <span>Register Doctor</span>
                            </a>
                            <a href="#" class="action-item">
                                <div class="action-icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <span>Generate Report</span>
                            </a>
                            <a href="#" class="action-item">
                                <div class="action-icon">
                                    <i class="fas fa-cog"></i>
                                </div>
                                <span>System Settings</span>
                            </a>
                            <a href="superadmin.php" class="action-item">
                                <div class="action-icon">
                                    <i class="fas fa-crown"></i>
                                </div>
                                <span>Super Admin</span>
                            </a>
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