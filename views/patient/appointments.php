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
        <div class="page-header">
            <h2><i class="fas fa-calendar-alt"></i> Appointment Management</h2>
            <button class="btn btn-primary" onclick="openAppointmentModal()">
                <i class="fas fa-plus"></i> Book New Appointment
            </button>
        </div>

        <div class="appointments-container">
            <div class="appointments-left">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>Find a Doctor</h3>
                    </div>
                    <div class="card-body">
                        <div class="doctor-search">
                            <input type="text" placeholder="Search by name or specialty" class="search-input">
                            <div class="search-filters">
                                <select class="filter-select">
                                    <option value="">All Specialties</option>
                                    <option value="cardiology">Cardiology</option>
                                    <option value="dermatology">Dermatology</option>
                                    <option value="neurology">Neurology</option>
                                    <option value="pediatrics">Pediatrics</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="doctors-list">
                            <div class="doctor-card">
                                <img src="https://images.pexels.com/photos/5214997/pexels-photo-5214997.jpeg?auto=compress&cs=tinysrgb&w=100&h=100&fit=crop&crop=face" alt="Doctor">
                                <div class="doctor-info">
                                    <h4>Dr. Sarah Johnson</h4>
                                    <p>Cardiology</p>
                                    <div class="doctor-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <span>(4.9)</span>
                                    </div>
                                    <button class="btn btn-sm btn-primary">View Profile</button>
                                </div>
                            </div>
                            
                            <div class="doctor-card">
                                <img src="https://images.pexels.com/photos/5215024/pexels-photo-5215024.jpeg?auto=compress&cs=tinysrgb&w=100&h=100&fit=crop&crop=face" alt="Doctor">
                                <div class="doctor-info">
                                    <h4>Dr. Michael Brown</h4>
                                    <p>General Medicine</p>
                                    <div class="doctor-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <span>(4.6)</span>
                                    </div>
                                    <button class="btn btn-sm btn-primary">View Profile</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="appointments-right">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>Your Appointments</h3>
                        <div class="appointment-tabs">
                            <button class="tab-btn active" data-tab="upcoming">Upcoming</button>
                            <button class="tab-btn" data-tab="past">Past</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="appointments-list" id="upcomingAppointments">
                            <div class="appointment-item">
                                <div class="appointment-date">
                                    <span class="day">15</span>
                                    <span class="month">Dec</span>
                                    <span class="year">2024</span>
                                </div>
                                <div class="appointment-details">
                                    <h4>Dr. Sarah Johnson</h4>
                                    <p>Cardiology - Routine Checkup</p>
                                    <div class="appointment-meta">
                                        <span class="time"><i class="fas fa-clock"></i> 10:30 AM</span>
                                        <span class="location"><i class="fas fa-map-marker-alt"></i> Room 204</span>
                                    </div>
                                </div>
                                <div class="appointment-actions">
                                    <span class="status confirmed">Confirmed</span>
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline-primary">Reschedule</button>
                                        <button class="btn btn-sm btn-outline-danger">Cancel</button>
                                    </div>
                                </div>
                            </div>

                            <div class="appointment-item">
                                <div class="appointment-date">
                                    <span class="day">18</span>
                                    <span class="month">Dec</span>
                                    <span class="year">2024</span>
                                </div>
                                <div class="appointment-details">
                                    <h4>Dr. Michael Brown</h4>
                                    <p>General Medicine - Follow-up</p>
                                    <div class="appointment-meta">
                                        <span class="time"><i class="fas fa-clock"></i> 2:15 PM</span>
                                        <span class="location"><i class="fas fa-map-marker-alt"></i> Room 105</span>
                                    </div>
                                </div>
                                <div class="appointment-actions">
                                    <span class="status pending">Pending</span>
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline-primary">Reschedule</button>
                                        <button class="btn btn-sm btn-outline-danger">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="appointments-list hidden" id="pastAppointments">
                            <div class="appointment-item">
                                <div class="appointment-date">
                                    <span class="day">10</span>
                                    <span class="month">Dec</span>
                                    <span class="year">2024</span>
                                </div>
                                <div class="appointment-details">
                                    <h4>Dr. Emily Davis</h4>
                                    <p>Dermatology - Consultation</p>
                                    <div class="appointment-meta">
                                        <span class="time"><i class="fas fa-clock"></i> 11:00 AM</span>
                                        <span class="location"><i class="fas fa-map-marker-alt"></i> Room 301</span>
                                    </div>
                                </div>
                                <div class="appointment-actions">
                                    <span class="status completed">Completed</span>
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline-primary">View Report</button>
                                        <button class="btn btn-sm btn-outline-secondary">Rebook</button>
                                    </div>
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