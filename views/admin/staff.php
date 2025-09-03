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
            <h2><i class="fas fa-users"></i> Staff Management</h2>
            <div class="header-actions">
                <button class="btn btn-outline-primary" onclick="exportStaffReport()">
                    <i class="fas fa-download"></i> Export Report
                </button>
                <button class="btn btn-primary" onclick="openAddStaffModal()">
                    <i class="fas fa-user-plus"></i> Add Staff
                </button>
            </div>
        </div>

        <div class="staff-stats">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="fas fa-user-md"></i>
                </div>
                <div class="stat-info">
                    <h3>25</h3>
                    <p>Doctors</p>
                    <span class="stat-change">Active staff</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="fas fa-user-nurse"></i>
                </div>
                <div class="stat-info">
                    <h3>45</h3>
                    <p>Nurses</p>
                    <span class="stat-change">On duty</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="fas fa-users-cog"></i>
                </div>
                <div class="stat-info">
                    <h3>18</h3>
                    <p>Support Staff</p>
                    <span class="stat-change">Administrative</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon info">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <h3>88</h3>
                    <p>Total Staff</p>
                    <span class="stat-change">All departments</span>
                </div>
            </div>
        </div>

        <div class="staff-container">
            <div class="staff-left">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-list"></i> Staff Directory</h3>
                        <div class="view-options">
                            <button class="view-btn active" data-view="cards">
                                <i class="fas fa-th"></i>
                            </button>
                            <button class="view-btn" data-view="table">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (isset($add_success)): ?>
                            <div class="success-message">
                                <i class="fas fa-check-circle"></i>
                                <?php echo $add_success; ?>
                            </div>
                        <?php endif; ?>

                        <div class="staff-grid" id="staffGrid">
                            <div class="staff-card">
                                <div class="staff-photo">
                                    <img src="https://images.pexels.com/photos/5214997/pexels-photo-5214997.jpeg?auto=compress&cs=tinysrgb&w=100&h=100&fit=crop&crop=face" alt="Staff">
                                    <div class="status-indicator online"></div>
                                </div>
                                <div class="staff-info">
                                    <h4>Dr. Sarah Johnson</h4>
                                    <p>Senior Cardiologist</p>
                                    <div class="staff-meta">
                                        <span><i class="fas fa-id-badge"></i> EMP-001</span>
                                        <span><i class="fas fa-phone"></i> +880-1111111111</span>
                                        <span><i class="fas fa-envelope"></i> sarah@bdhospital.com</span>
                                    </div>
                                    <div class="staff-schedule">
                                        <span class="schedule-status on-duty">On Duty</span>
                                        <span class="shift-time">9:00 AM - 5:00 PM</span>
                                    </div>
                                </div>
                                <div class="staff-actions">
                                    <button class="btn btn-sm btn-outline-primary" onclick="viewStaffProfile('001')">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <button class="btn btn-sm btn-outline-success" onclick="editStaff('001')">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                </div>
                            </div>

                            <div class="staff-card">
                                <div class="staff-photo">
                                    <img src="https://images.pexels.com/photos/5215024/pexels-photo-5215024.jpeg?auto=compress&cs=tinysrgb&w=100&h=100&fit=crop&crop=face" alt="Staff">
                                    <div class="status-indicator online"></div>
                                </div>
                                <div class="staff-info">
                                    <h4>Dr. Michael Brown</h4>
                                    <p>General Practitioner</p>
                                    <div class="staff-meta">
                                        <span><i class="fas fa-id-badge"></i> EMP-002</span>
                                        <span><i class="fas fa-phone"></i> +880-2222222222</span>
                                        <span><i class="fas fa-envelope"></i> michael@bdhospital.com</span>
                                    </div>
                                    <div class="staff-schedule">
                                        <span class="schedule-status on-duty">On Duty</span>
                                        <span class="shift-time">8:00 AM - 4:00 PM</span>
                                    </div>
                                </div>
                                <div class="staff-actions">
                                    <button class="btn btn-sm btn-outline-primary" onclick="viewStaffProfile('002')">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <button class="btn btn-sm btn-outline-success" onclick="editStaff('002')">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                </div>
                            </div>

                            <div class="staff-card">
                                <div class="staff-photo">
                                    <img src="https://images.pexels.com/photos/5452293/pexels-photo-5452293.jpeg?auto=compress&cs=tinysrgb&w=100&h=100&fit=crop&crop=face" alt="Staff">
                                    <div class="status-indicator offline"></div>
                                </div>
                                <div class="staff-info">
                                    <h4>Nurse Emily Davis</h4>
                                    <p>Head Nurse - ICU</p>
                                    <div class="staff-meta">
                                        <span><i class="fas fa-id-badge"></i> EMP-003</span>
                                        <span><i class="fas fa-phone"></i> +880-3333333333</span>
                                        <span><i class="fas fa-envelope"></i> emily@bdhospital.com</span>
                                    </div>
                                    <div class="staff-schedule">
                                        <span class="schedule-status off-duty">Off Duty</span>
                                        <span class="shift-time">Next: 6:00 AM - 2:00 PM</span>
                                    </div>
                                </div>
                                <div class="staff-actions">
                                    <button class="btn btn-sm btn-outline-primary" onclick="viewStaffProfile('003')">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <button class="btn btn-sm btn-outline-success" onclick="editStaff('003')">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="staff-right">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-calendar-alt"></i> Schedule Management</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($schedule_success)): ?>
                            <div class="success-message">
                                <i class="fas fa-check-circle"></i>
                                <?php echo $schedule_success; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" class="schedule-form">
                            <div class="form-group">
                                <label>Staff Member</label>
                                <select name="staff_id" required>
                                    <option value="">Select Staff</option>
                                    <option value="001">Dr. Sarah Johnson</option>
                                    <option value="002">Dr. Michael Brown</option>
                                    <option value="003">Nurse Emily Davis</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" name="schedule_date" required>
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
                                <label>Department</label>
                                <select name="department" required>
                                    <option value="">Select Department</option>
                                    <option value="cardiology">Cardiology</option>
                                    <option value="general">General Medicine</option>
                                    <option value="emergency">Emergency</option>
                                    <option value="icu">ICU</option>
                                    <option value="surgery">Surgery</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Notes</label>
                                <textarea name="notes" rows="3" placeholder="Additional notes..."></textarea>
                            </div>

                            <button type="submit" name="update_schedule" class="btn btn-primary btn-block">
                                <i class="fas fa-calendar-plus"></i> Update Schedule
                            </button>
                        </form>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-user-plus"></i> Add New Staff</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" class="add-staff-form">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="staff_name" required>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Role</label>
                                    <select name="role" required>
                                        <option value="">Select Role</option>
                                        <option value="doctor">Doctor</option>
                                        <option value="nurse">Nurse</option>
                                        <option value="technician">Technician</option>
                                        <option value="admin">Administrator</option>
                                        <option value="support">Support Staff</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Department</label>
                                    <select name="department" required>
                                        <option value="">Select Department</option>
                                        <option value="cardiology">Cardiology</option>
                                        <option value="general">General Medicine</option>
                                        <option value="emergency">Emergency</option>
                                        <option value="icu">ICU</option>
                                        <option value="surgery">Surgery</option>
                                        <option value="laboratory">Laboratory</option>
                                        <option value="pharmacy">Pharmacy</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="tel" name="phone" required>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Credentials/License</label>
                                <input type="text" name="credentials" placeholder="Medical license, certifications...">
                            </div>

                            <button type="submit" name="add_staff" class="btn btn-success btn-block">
                                <i class="fas fa-user-plus"></i> Add Staff Member
                            </button>
                        </form>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-clock"></i> Today's Schedule</h3>
                    </div>
                    <div class="card-body">
                        <div class="schedule-timeline">
                            <div class="schedule-item">
                                <div class="schedule-time">9:00 AM</div>
                                <div class="schedule-details">
                                    <h4>Dr. Sarah Johnson</h4>
                                    <p>Cardiology Department</p>
                                    <span class="schedule-status active">Currently On Duty</span>
                                </div>
                            </div>

                            <div class="schedule-item">
                                <div class="schedule-time">8:00 AM</div>
                                <div class="schedule-details">
                                    <h4>Dr. Michael Brown</h4>
                                    <p>General Medicine</p>
                                    <span class="schedule-status active">Currently On Duty</span>
                                </div>
                            </div>

                            <div class="schedule-item">
                                <div class="schedule-time">6:00 AM</div>
                                <div class="schedule-details">
                                    <h4>Nurse Emily Davis</h4>
                                    <p>ICU Department</p>
                                    <span class="schedule-status upcoming">Starts in 2 hours</span>
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
