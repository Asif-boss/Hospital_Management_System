<?php
    if (!isset($_COOKIE['user_type'])) {
        header('location: ../login.php');
    }elseif ($_COOKIE['user_type'] !== 'patient') {
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
                    <h2>Welcome back!!!</h2>
                    <p>Here's your health overview for today</p>
                </div>
                <div class="welcome-image">
                    <i class="fas fa-heartbeat"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stats">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <h3>2</h3>
                    <p>Upcoming Appointments</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-file-medical"></i>
                </div>
                <div class="stat-info">
                    <h3>5</h3>
                    <p>Medical Records</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-prescription-bottle"></i>
                </div>
                <div class="stat-info">
                    <h3>3</h3>
                    <p>Active Prescriptions</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-info">
                    <h3>$150</h3>
                    <p>Outstanding Bills</p>
                </div>
            </div>
        </div>

        <div class="dashboard-content">
            <div class="content-left">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-calendar-alt"></i> Upcoming Appointments</h3>
                        <a href="appointments.php" class="view-all">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="appointment-item">
                            <div class="appointment-date">
                                <span class="day">15</span>
                                <span class="month">Dec</span>
                            </div>
                            <div class="appointment-info">
                                <h4>Dr. Sarah Johnson</h4>
                                <p>Cardiology - Routine Checkup</p>
                                <span class="appointment-time">10:30 AM</span>
                            </div>
                            <div class="appointment-status">
                                <span class="status confirmed">Confirmed</span>
                            </div>
                        </div>
                        <div class="appointment-item">
                            <div class="appointment-date">
                                <span class="day">18</span>
                                <span class="month">Dec</span>
                            </div>
                            <div class="appointment-info">
                                <h4>Dr. Michael Brown</h4>
                                <p>General Medicine - Follow-up</p>
                                <span class="appointment-time">2:15 PM</span>
                            </div>
                            <div class="appointment-status">
                                <span class="status pending">Pending</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-pills"></i> Current Medications</h3>
                        <a href="history.php" class="view-all">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="medication-item">
                            <div class="med-info">
                                <h4>Lisinopril 10mg</h4>
                                <p>Take once daily with food</p>
                            </div>
                            <div class="med-schedule">
                                <span class="next-dose">Next: 8:00 AM</span>
                            </div>
                        </div>
                        <div class="medication-item">
                            <div class="med-info">
                                <h4>Metformin 500mg</h4>
                                <p>Take twice daily with meals</p>
                            </div>
                            <div class="med-schedule">
                                <span class="next-dose">Next: 12:00 PM</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-right">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-heartbeat"></i> Health Overview</h3>
                    </div>
                    <div class="card-body">
                        <div class="health-metric">
                            <div class="metric-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="metric-info">
                                <span class="metric-value">120/80</span>
                                <span class="metric-label">Blood Pressure</span>
                                <span class="metric-status normal">Normal</span>
                            </div>
                        </div>
                        <div class="health-metric">
                            <div class="metric-icon">
                                <i class="fas fa-weight"></i>
                            </div>
                            <div class="metric-info">
                                <span class="metric-value">70 kg</span>
                                <span class="metric-label">Weight</span>
                                <span class="metric-status normal">Healthy</span>
                            </div>
                        </div>
                        <div class="health-metric">
                            <div class="metric-icon">
                                <i class="fas fa-thermometer-half"></i>
                            </div>
                            <div class="metric-info">
                                <span class="metric-value">98.6°F</span>
                                <span class="metric-label">Temperature</span>
                                <span class="metric-status normal">Normal</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-bell"></i> Recent Activities</h3>
                    </div>
                    <div class="card-body">
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-calendar-check text-success"></i>
                            </div>
                            <div class="activity-info">
                                <p>Appointment scheduled with Dr. Sarah</p>
                                <span class="activity-time">2 hours ago</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-file-medical text-info"></i>
                            </div>
                            <div class="activity-info">
                                <p>Lab results uploaded</p>
                                <span class="activity-time">1 day ago</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-prescription text-primary"></i>
                            </div>
                            <div class="activity-info">
                                <p>New prescription added</p>
                                <span class="activity-time">3 days ago</span>
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