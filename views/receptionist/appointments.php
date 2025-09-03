<?php
if (!isset($_COOKIE['user_type'])) {
    header('location: ../login.php');
} elseif ($_COOKIE['user_type'] !== 'receptionist') {
    header('location: ../login.php');
}

include '../templates/header.php';
?>

<div class="dashboard-layout">
    <?php include '../templates/sidebar.php'; ?>
    <main class="main-content">
        <div class="page-header">
            <h2><i class="fas fa-calendar-alt"></i> Appointment Management</h2>
            <div class="header-actions">
                <button class="btn btn-primary" onclick="showNewAppointment()">
                    <i class="fas fa-plus"></i> New Appointment
                </button>
                <div class="period-selector">
                    <select onchange="filterAppointments(this.value)">
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="appointments-container">
            <div class="appointments-left">
                <!-- Doctor Search -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-user-md"></i> Available Doctors</h3>
                    </div>
                    <div class="card-body">
                        <div class="doctor-search">
                            <input type="text" class="search-input" placeholder="Search doctors...">
                            <div class="search-filters">
                                <select class="filter-select">
                                    <option value="">All Specialties</option>
                                    <option value="cardiology">Cardiology</option>
                                    <option value="pediatrics">Pediatrics</option>
                                    <option value="orthopedics">Orthopedics</option>
                                    <option value="neurology">Neurology</option>
                                    <option value="oncology">Oncology</option>
                                </select>
                                <select class="filter-select">
                                    <option value="">All Shifts</option>
                                    <option value="morning">Morning</option>
                                    <option value="afternoon">Afternoon</option>
                                    <option value="evening">Evening</option>
                                </select>
                            </div>
                        </div>

                        <div class="doctors-list">
                            <div class="doctor-card" onclick="selectDoctor('dr-rahman')">
                                <img src="https://images.pexels.com/photos/5215024/pexels-photo-5215024.jpeg?auto=compress&cs=tinysrgb&w=100&h=100&fit=crop" alt="Dr. Rahman">
                                <div class="doctor-info">
                                    <h4>Dr. Rahman</h4>
                                    <p>Cardiologist</p>
                                    <div class="doctor-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <span>(4.8)</span>
                                    </div>
                                    <span class="availability">Available: 9:00 AM - 5:00 PM</span>
                                </div>
                            </div>

                            <div class="doctor-card" onclick="selectDoctor('dr-fatima')">
                                <img src="https://images.pexels.com/photos/5452293/pexels-photo-5452293.jpeg?auto=compress&cs=tinysrgb&w=100&h=100&fit=crop" alt="Dr. Fatima">
                                <div class="doctor-info">
                                    <h4>Dr. Fatima</h4>
                                    <p>Pediatrician</p>
                                    <div class="doctor-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <span>(4.9)</span>
                                    </div>
                                    <span class="availability">Available: 8:00 AM - 4:00 PM</span>
                                </div>
                            </div>

                            <div class="doctor-card" onclick="selectDoctor('dr-islam')">
                                <img src="https://images.pexels.com/photos/6129507/pexels-photo-6129507.jpeg?auto=compress&cs=tinysrgb&w=100&h=100&fit=crop" alt="Dr. Islam">
                                <div class="doctor-info">
                                    <h4>Dr. Islam</h4>
                                    <p>Orthopedic Surgeon</p>
                                    <div class="doctor-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <span>(4.6)</span>
                                    </div>
                                    <span class="availability">Available: 10:00 AM - 6:00 PM</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="appointments-right">
                <!-- Appointment Tabs -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <div class="appointment-tabs">
                            <button class="tab-btn active" onclick="switchTab('all')">All Appointments</button>
                            <button class="tab-btn" onclick="switchTab('today')">Today</button>
                            <button class="tab-btn" onclick="switchTab('upcoming')">Upcoming</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="appointmentsList" class="appointments-list">
                            <div class="appointment-item">
                                <div class="appointment-info">
                                    <h4>Ahmed Hassan</h4>
                                    <p>Dr. Rahman - Cardiology</p>
                                    <div class="appointment-meta">
                                        <span><i class="fas fa-calendar"></i> Jan 15, 2025</span>
                                        <span><i class="fas fa-clock"></i> 10:30 AM</span>
                                        <span><i class="fas fa-phone"></i> +88 01712-345678</span>
                                    </div>
                                </div>
                                <div class="appointment-actions">
                                    <span class="status confirmed">Confirmed</span>
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline-primary" onclick="editAppointment('apt-001')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary" onclick="rescheduleAppointment('apt-001')">
                                            <i class="fas fa-calendar-alt"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="cancelAppointment('apt-001')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="appointment-item">
                                <div class="appointment-info">
                                    <h4>Sarah Khan</h4>
                                    <p>Dr. Fatima - Pediatrics</p>
                                    <div class="appointment-meta">
                                        <span><i class="fas fa-calendar"></i> Jan 15, 2025</span>
                                        <span><i class="fas fa-clock"></i> 2:00 PM</span>
                                        <span><i class="fas fa-phone"></i> +88 01987-654321</span>
                                    </div>
                                </div>
                                <div class="appointment-actions">
                                    <span class="status pending">Pending</span>
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline-primary" onclick="confirmAppointment('apt-002')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary" onclick="editAppointment('apt-002')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="cancelAppointment('apt-002')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="appointment-item">
                                <div class="appointment-info">
                                    <h4>Mohammad Ali</h4>
                                    <p>Dr. Islam - Orthopedics</p>
                                    <div class="appointment-meta">
                                        <span><i class="fas fa-calendar"></i> Jan 16, 2025</span>
                                        <span><i class="fas fa-clock"></i> 9:00 AM</span>
                                        <span><i class="fas fa-phone"></i> +88 01555-123456</span>
                                    </div>
                                </div>
                                <div class="appointment-actions">
                                    <span class="status upcoming">Upcoming</span>
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline-primary" onclick="editAppointment('apt-003')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary" onclick="sendReminder('apt-003')">
                                            <i class="fas fa-bell"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Appointment Calendar Widget -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-calendar"></i> Calendar View</h3>
                    </div>
                    <div class="card-body">
                        <div class="mini-calendar">
                            <div class="calendar-header">
                                <button onclick="previousMonth()"><i class="fas fa-chevron-left"></i></button>
                                <span id="currentMonth">January 2025</span>
                                <button onclick="nextMonth()"><i class="fas fa-chevron-right"></i></button>
                            </div>
                            <div class="calendar-grid">
                                <div class="calendar-day header">Sun</div>
                                <div class="calendar-day header">Mon</div>
                                <div class="calendar-day header">Tue</div>
                                <div class="calendar-day header">Wed</div>
                                <div class="calendar-day header">Thu</div>
                                <div class="calendar-day header">Fri</div>
                                <div class="calendar-day header">Sat</div>

                                <!-- Calendar days will be generated by JavaScript -->
                                <div id="calendarDays"></div>
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