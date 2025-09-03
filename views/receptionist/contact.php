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
            <?php include '../templates/sidebar.php'; ?>
            <h2><i class="fas fa-phone-alt"></i> Contact & Support</h2>
            <div class="header-actions">
                <button class="btn btn-outline-primary" onclick="showEmergencyContacts()">
                    <i class="fas fa-ambulance"></i> Emergency Contacts
                </button>
            </div>
        </div>

        <div class="contact-container">
            <div class="content-left">
                <!-- Contact Form -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-envelope"></i> Send Message</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($successMessage): ?>
                            <div class="success-message">
                                <i class="fas fa-check-circle"></i> <?php echo $successMessage; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($errors) && !empty($errors)): ?>
                            <div class="alert alert-error">
                                <i class="fas fa-exclamation-triangle"></i>
                                <?php echo implode('<br>', $errors); ?>
                            </div>
                        <?php endif; ?>

                        <form class="contact-form" method="POST" action="" onsubmit="validateContactForm(event)">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input type="text" id="name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" id="email" name="email" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" id="phone" name="phone">
                                </div>
                                <div class="form-group">
                                    <label for="department">Department</label>
                                    <select id="department" name="department" required>
                                        <option value="">Select Department</option>
                                        <option value="administration">Administration</option>
                                        <option value="billing">Billing & Insurance</option>
                                        <option value="appointments">Appointments</option>
                                        <option value="emergency">Emergency Services</option>
                                        <option value="laboratory">Laboratory</option>
                                        <option value="pharmacy">Pharmacy</option>
                                        <option value="technical">Technical Support</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="priority">Priority Level</label>
                                <select id="priority" name="priority" required>
                                    <option value="low">Low - General Inquiry</option>
                                    <option value="medium">Medium - Service Request</option>
                                    <option value="high">High - Urgent Issue</option>
                                    <option value="critical">Critical - Emergency</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea id="message" name="message" rows="6" placeholder="Please describe your inquiry or issue in detail..." required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-paper-plane"></i> Send Message
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Message History -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-history"></i> Message History</h3>
                    </div>
                    <div class="card-body">
                        <div class="message-history">
                            <div class="message-item">
                                <div class="message-header">
                                    <h4>Equipment Maintenance Request</h4>
                                    <span class="message-date">Jan 10, 2025</span>
                                </div>
                                <p>Reported issue with X-ray machine in Room 3. Technician scheduled for inspection.</p>
                                <span class="message-status resolved">Resolved</span>
                            </div>

                            <div class="message-item">
                                <div class="message-header">
                                    <h4>Billing System Query</h4>
                                    <span class="message-date">Jan 8, 2025</span>
                                </div>
                                <p>Question about insurance claim processing delays. Awaiting response from IT department.</p>
                                <span class="message-status pending">Pending</span>
                            </div>

                            <div class="message-item">
                                <div class="message-header">
                                    <h4>Staff Schedule Update</h4>
                                    <span class="message-date">Jan 5, 2025</span>
                                </div>
                                <p>Request for schedule modification due to emergency coverage needs.</p>
                                <span class="message-status resolved">Resolved</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-right">
                <!-- Contact Information -->
                <div class="contact-info">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3><i class="fas fa-info-circle"></i> Contact Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="contact-item">
                                <div class="contact-icon emergency">
                                    <i class="fas fa-ambulance"></i>
                                </div>
                                <div class="contact-details">
                                    <h4>Emergency</h4>
                                    <p>999 / +88 02-9999-0000</p>
                                    <span>24/7 Emergency Services</span>
                                </div>
                            </div>

                            <div class="contact-item">
                                <div class="contact-icon phone">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="contact-details">
                                    <h4>Reception</h4>
                                    <p>+88 02-8888-1111</p>
                                    <span>General inquiries & appointments</span>
                                </div>
                            </div>

                            <div class="contact-item">
                                <div class="contact-icon email">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="contact-details">
                                    <h4>Email Support</h4>
                                    <p>info@bdhospital.com</p>
                                    <span>Response within 24 hours</span>
                                </div>
                            </div>

                            <div class="contact-item">
                                <div class="contact-icon location">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="contact-details">
                                    <h4>Address</h4>
                                    <p>123 Medical Street</p>
                                    <span>Dhaka-1000, Bangladesh</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Department Hours -->
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
                                    <span class="dept-name">Pediatrics</span>
                                    <span class="dept-hours">8:00 AM - 4:00 PM</span>
                                </div>
                                <div class="hours-item">
                                    <span class="dept-name">Laboratory</span>
                                    <span class="dept-hours">7:00 AM - 6:00 PM</span>
                                </div>
                                <div class="hours-item">
                                    <span class="dept-name">Pharmacy</span>
                                    <span class="dept-hours">24/7</span>
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