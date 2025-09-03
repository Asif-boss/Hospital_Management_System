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
            <h2><i class="fas fa-envelope"></i> Contact Hospital</h2>
        </div>

        <div class="contact-container">
            <div class="contact-left">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-paper-plane"></i> Send Message</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($success)): ?>
                            <div class="success-message">
                                <i class="fas fa-check-circle"></i>
                                <?php echo $success; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" class="contact-form" id="contactForm">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" name="name" id="contactName" required>
                                    <span class="error-text" id="nameError"></span>
                                </div>
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input type="email" name="email" id="contactEmail" required>
                                    <span class="error-text" id="emailError"></span>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Subject</label>
                                    <select name="subject" id="contactSubject" required>
                                        <option value="">Select Subject</option>
                                        <option value="appointment">Appointment Inquiry</option>
                                        <option value="billing">Billing Question</option>
                                        <option value="medical">Medical Records</option>
                                        <option value="complaint">Complaint</option>
                                        <option value="feedback">Feedback</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <span class="error-text" id="subjectError"></span>
                                </div>
                                <div class="form-group">
                                    <label>Priority Level</label>
                                    <select name="priority" id="contactPriority" required>
                                        <option value="low">Low</option>
                                        <option value="medium" selected>Medium</option>
                                        <option value="high">High</option>
                                        <option value="urgent">Urgent</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Message</label>
                                <textarea name="message" id="contactMessage" rows="6" placeholder="Please describe your inquiry in detail..." required></textarea>
                                <span class="error-text" id="messageError"></span>
                            </div>

                            <div class="form-group">
                                <label class="checkbox-container">
                                    <input type="checkbox" name="copy_email" checked>
                                    <span class="checkmark"></span>
                                    Send me a copy of this message
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-paper-plane"></i> Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="contact-right">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-info-circle"></i> Contact Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="contact-info">
                            <div class="contact-item">
                                <div class="contact-icon emergency">
                                    <i class="fas fa-ambulance"></i>
                                </div>
                                <div class="contact-details">
                                    <h4>Emergency</h4>
                                    <p>999</p>
                                    <span>24/7 Emergency Services</span>
                                </div>
                            </div>

                            <div class="contact-item">
                                <div class="contact-icon phone">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="contact-details">
                                    <h4>Main Reception</h4>
                                    <p>+880-2-9876543</p>
                                    <span>8:00 AM - 10:00 PM</span>
                                </div>
                            </div>

                            <div class="contact-item">
                                <div class="contact-icon email">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="contact-details">
                                    <h4>Email Support</h4>
                                    <p>support@bdhospital.com</p>
                                    <span>Response within 24 hours</span>
                                </div>
                            </div>

                            <div class="contact-item">
                                <div class="contact-icon location">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="contact-details">
                                    <h4>Address</h4>
                                    <p>123 Medical Street<br>Dhaka 1000, Bangladesh</p>
                                    <span>Main Campus</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-clock"></i> Department Hours</h3>
                    </div>
                    <div class="card-body">
                        <div class="hours-list">
                            <div class="hours-item">
                                <span class="dept-name">Emergency</span>
                                <span class="dept-hours">24/7</span>
                            </div>
                            <div class="hours-item">
                                <span class="dept-name">General Medicine</span>
                                <span class="dept-hours">8:00 AM - 8:00 PM</span>
                            </div>
                            <div class="hours-item">
                                <span class="dept-name">Cardiology</span>
                                <span class="dept-hours">9:00 AM - 5:00 PM</span>
                            </div>
                            <div class="hours-item">
                                <span class="dept-name">Laboratory</span>
                                <span class="dept-hours">7:00 AM - 9:00 PM</span>
                            </div>
                            <div class="hours-item">
                                <span class="dept-name">Pharmacy</span>
                                <span class="dept-hours">8:00 AM - 10:00 PM</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-history"></i> Recent Messages</h3>
                    </div>
                    <div class="card-body">
                        <div class="message-history">
                            <div class="message-item">
                                <div class="message-header">
                                    <h4>Appointment Confirmation</h4>
                                    <span class="message-date">Dec 12, 2024</span>
                                </div>
                                <p>Your appointment with Dr. Sarah Johnson has been confirmed for December 15th at 10:30 AM.</p>
                                <span class="message-status resolved">Resolved</span>
                            </div>
                            <div class="message-item">
                                <div class="message-header">
                                    <h4>Billing Inquiry</h4>
                                    <span class="message-date">Dec 8, 2024</span>
                                </div>
                                <p>Question about insurance coverage for recent lab tests.</p>
                                <span class="message-status pending">Pending</span>
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
