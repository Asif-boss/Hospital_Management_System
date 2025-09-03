<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BD Hospital - Healthcare Excellence</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="navbar">
            <div class="nav-container">
                <div class="nav-brand">
                    <i class="fas fa-hospital-alt"></i>
                    <span>BD Hospital</span>
                </div>
                <ul class="nav-menu">
                    <li><a href="#home" class="nav-link">Home</a></li>
                    <li><a href="#services" class="nav-link">Services</a></li>
                    <!-- <li><a href="#doctors" class="nav-link">Doctors</a></li> -->
                    <li><a href="#about" class="nav-link">About</a></li>
                    <!-- <li><a href="#footer" class="nav-link" >Contact</a></li> -->
                    <li><a href="login.php"><button class="btn-login">Login</button></a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-content">
            <h1>Welcome to BD Hospital</h1>
            <p>Your Health, Our Priority - Delivering Excellence in Healthcare</p>
            <div class="hero-buttons">
                <button class="btn-primary">Book Appointment</button>
                <button class="btn-secondary">New Patient</button>
            </div>
        </div>
        <div class="hero-stats">
            <div class="stat-item">
                <h3>50+</h3>
                <p>Expert Doctors</p>
            </div>
            <div class="stat-item">
                <h3>10,000+</h3>
                <p>Happy Patients</p>
            </div>
            <div class="stat-item">
                <h3>25</h3>
                <p>Years of Service</p>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services">
        <div class="container">
            <h2 class="section-title">Our Services</h2>
            <div class="services-grid">
                <div class="service-card">
                    <i class="fas fa-heartbeat"></i>
                    <h3>Cardiology</h3>
                    <p>Comprehensive heart care with advanced diagnostics and treatment</p>
                </div>
                <div class="service-card">
                    <i class="fas fa-brain"></i>
                    <h3>Neurology</h3>
                    <p>Expert neurological care for brain and nervous system disorders</p>
                </div>
                <div class="service-card">
                    <i class="fas fa-bone"></i>
                    <h3>Orthopedics</h3>
                    <p>Advanced bone and joint treatments with minimally invasive procedures</p>
                </div>
                <div class="service-card">
                    <i class="fas fa-baby"></i>
                    <h3>Pediatrics</h3>
                    <p>Specialized healthcare for infants, children, and adolescents</p>
                </div>
                <div class="service-card">
                    <i class="fas fa-eye"></i>
                    <h3>Ophthalmology</h3>
                    <p>Complete eye care services with state-of-the-art equipment</p>
                </div>
                <div class="service-card">
                    <i class="fas fa-ambulance"></i>
                    <h3>Emergency</h3>
                    <p>24/7 emergency services with rapid response team</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Actions -->
    <section class="quick-actions">
        <div class="container">
            <h2 class="section-title">Quick Actions</h2>
            <div class="actions-grid">
                <button class="action-card">
                    <i class="fas fa-calendar-plus"></i>
                    <h3>Book Appointment</h3>
                    <p>Schedule your visit with our specialists</p>
                </button>
                <button class="action-card">
                    <i class="fas fa-user-plus"></i>
                    <h3>New Patient Registration</h3>
                    <p>Register as a new patient</p>
                </button>
                <button class="action-card">
                    <i class="fas fa-history"></i>
                    <h3>Patient History</h3>
                    <p>View medical records and history</p>
                </button>
                <button class="action-card">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <h3>Billing</h3>
                    <p>View bills and make payments</p>
                </button>
                <button class="action-card">
                    <i class="fas fa-shield-alt"></i>
                    <h3>Insurance Claims</h3>
                    <p>Submit insurance claims</p>
                </button>
                <button class="action-card">
                    <i class="fas fa-download"></i>
                    <h3>Export Data</h3>
                    <p>Download prescriptions and reports</p>
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="about">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>BD Hospital</h3>
                    <p>Providing quality healthcare with compassion and excellence since 1998.</p>
                    <div class="social-links">
                        <a href="#about"><i class="fab fa-facebook"></i></a>
                        <a href="#about"><i class="fab fa-twitter"></i></a>
                        <a href="#about"><i class="fab fa-instagram"></i></a>
                        <a href="#about"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Contact Info</h3>
                    <p><i class="fas fa-map-marker-alt"></i> 408/1 (Old KA 66/1), Kuratoli, Khilkhet, Dhaka-1229, Bangladesh</p>
                    <p><i class="fas fa-phone"></i> +880 1234-567890</p>
                    <p><i class="fas fa-envelope"></i> info@bdhospital.com</p>
                </div>
                <div class="footer-section">
                    <h3>Emergency</h3>
                    <p class="emergency-number">
                        <i class="fas fa-phone-alt"></i>
                        <span>999</span>
                    </p>
                    <p>24/7 Emergency Services Available</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 BD Hospital. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>