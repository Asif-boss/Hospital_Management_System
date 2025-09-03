

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
<?php elseif (isset($_COOKIE['user_type']) && $_COOKIE['user_type'] === 'doctor'): ?>
  <div class="sidebar">
    <div class="sidebar-header">
      <h2 class="sidebar-title">Doctor Panel</h2>
    </div>
    <nav class="sidebar-nav">
      <a href="dashboard.php" class="nav-link <?php if ($currentPage == 'dashboard.php'): ?>active<?php endif; ?>">
        <span class="icon">🏠</span>
        <span class="link-text">Dashboard</span>
      </a>
      <a href="edit_profile.php" class="nav-link <?php if ($currentPage == 'edit_profile.php'): ?>active<?php endif; ?>">
        <span class="icon">👤</span>
        <span class="link-text">Edit Profile</span>
      </a>
      <a href="prescription.php" class="nav-link <?php if ($currentPage == 'prescription.php'): ?>active<?php endif; ?>">
        <span class="icon">📝</span>
        <span class="link-text">Prescription</span>
      </a>
      <a href="lab_test.php" class="nav-link <?php if ($currentPage == 'lab_test.php'): ?>active<?php endif; ?>">
        <span class="icon">🔬</span>
        <span class="link-text">Lab Test Order</span>
      </a>
      <a href="doctor_directory.php" class="nav-link <?php if ($currentPage == 'doctor_directory.php'): ?>active<?php endif; ?>">
        <span class="icon">📋</span>
        <span class="link-text">Doctor Directory</span>
      </a>
      <a href="../../Controllers/logout.php" class="nav-link logout-link">
        <span class="icon">🚪</span>
        <span class="link-text">Logout</span>
      </a>
    </nav>
  </div>
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