

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="hospital-info">
            <i class="fas fa-hospital-alt"></i>
            <div>
                <h3>BD Hospital</h3>
                <p><?php echo ucfirst($_COOKIE['user_type']) ?> Panel</p>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <?php if ($_COOKIE['user_type'] === 'patient'): ?>
            <a href="dashboard.php" class="nav-link">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="appointments.php" class="nav-link">
                <i class="fas fa-calendar-alt"></i>
                <span>Appointments</span>
            </a>
            <a href="history.php" class="nav-link">
                <i class="fas fa-history"></i>
                <span>Medical History</span>
            </a>
            <a href="billing.php" class="nav-link">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Billing</span>
            </a>
            <a href="contact.php" class="nav-link">
                <i class="fas fa-envelope"></i>
                <span>Contact Us</span>
            </a>
            <a href="profile.php" class="nav-link">
                <i class="fas fa-user-circle"></i>
                <span>Profile</span>
            </a>
        <?php elseif ($_COOKIE['user_type'] === 'admin'): ?>
            <a href="dashboard.php" class="nav-link">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a href="inventory.php" class="nav-link">
                <i class="fas fa-boxes"></i>
                <span>Inventory</span>
            </a>
            <a href="staff.php" class="nav-link">
                <i class="fas fa-users"></i>
                <span>Staff Management</span>
            </a>
            <a href="doctor_registry.php" class="nav-link">
                <i class="fas fa-user-md"></i>
                <span>Doctor Registry</span>
            </a>
            <a href="profile.php" class="nav-link">
                <i class="fas fa-user-circle"></i>
                <span>Profile</span>
            </a>
            <a href="superadmin.php" class="nav-link">
                <i class="fas fa-crown"></i>
                <span>Super Admin</span>
            </a>
        <?php elseif ($_COOKIE['user_type'] === 'receptionist'): ?>
            <a href="dashboard.php" class="nav-link">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a href="appointments.php" class="nav-link">
                <i class="fas fa-calendar-alt"></i>
                <span>Appointments</span>
            </a>
            <a href="billing.php" class="nav-link">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Billing & Insurance</span>
            </a>
            <a href="labtest.php" class="nav-link">
                <i class="fas fa-vial"></i>
                <span>Lab Test Orders</span>
            </a>
            <a href="contact.php" class="nav-link">
                <i class="fas fa-envelope"></i>
                <span>Contact Us</span>
            </a>
            <a href="profile.php" class="nav-link">
                <i class="fas fa-user-circle"></i>
                <span>Profile</span>
            </a>
        <?php endif; ?>
    </nav>

    <div class="sidebar-footer">
        <div class="hospital-contact">
            <h4>Emergency Contact</h4>
            <p><i class="fas fa-phone"></i> 999</p>
            <p><i class="fas fa-envelope"></i> emergency@bdhospital.com</p>
        </div>
    </div>
</aside>