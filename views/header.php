<?php
    if (!isset($_COOKIE['user_type']) && !isset($_SESSION['user_type'])) {
        header('location: login.php');
    } elseif (isset($_COOKIE['user_type'])) {
        $user_type = $_COOKIE['user_type'];
    } else {
        $user_type = $_SESSION['user_type'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>BD Hospital : Dashboard</title>
    <link rel="stylesheet" href="../assets/css/sidebar_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="../assets/js/sidebar.js"></script>
</head>
<body>
    <header class="main-header">
        <div class="header-left">
            <div class="hospital-logo">
                <span>BD Hospital</span>
            </div>
        </div>
        
        <div class="header-center">
            <h1>Welcome Back!</h1>
        </div>

        <div class="header-right">
            <!-- <div class="notifications">
                <span class="notification-icon">🔔</span>
                <?php if ($unread_count > 0): ?>
                    <span class="notification-badge"><?php echo $unread_count; ?></span>
                <?php endif; ?>
                <div class="notifications-dropdown">
                    <div class="notification-header">
                        <h4>Notifications</h4>
                        <span class="mark-all-read">Mark all as read</span>
                    </div>
                    <div class="notification-list">
                        <?php if (empty($notifications)): ?>
                            <div class="notification-item">
                                <p>No notifications</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($notifications as $notification): ?>
                                <div class="notification-item <?php echo $notification['is_read'] ? '' : 'unread'; ?>">
                                    <span class="icon <?php echo htmlspecialchars($notification['type']); ?>">
                                        <?php echo $notification['type'] === 'success' ? '✔' : ($notification['type'] === 'warning' ? '⚠' : 'ℹ'); ?>
                                    </span>
                                    <div>
                                        <p><?php echo htmlspecialchars($notification['message']); ?></p>
                                        <span class="time">
                                            <?php
                                            $time_diff = time() - strtotime($notification['created_at']);
                                            if ($time_diff < 60) {
                                                echo 'Just now';
                                            } elseif ($time_diff < 3600) {
                                                echo floor($time_diff / 60) . ' min ago';
                                            } elseif ($time_diff < 86400) {
                                                echo floor($time_diff / 3600) . ' hour' . (floor($time_diff / 3600) > 1 ? 's' : '') . ' ago';
                                            } else {
                                                echo floor($time_diff / 86400) . ' day' . (floor($time_diff / 86400) > 1 ? 's' : '') . ' ago';
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div class="notification-footer">
                        <a href="#">View all notifications</a>
                    </div>
                </div>
            </div> -->

            <div class="user-profile">
                <img src="https://images.pexels.com/photos/5215024/pexels-photo-5215024.jpeg?auto=compress&cs=tinysrgb&w=50&h=50&fit=crop&crop=face" alt="Profile">
                <div class="user-dropdown">
                    <a href="profile.php">My Profile</a>
                    <a href="../controllers/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <aside class="sidebar">
        <nav class="sidebar-nav">
            <?php if ($user_type === 'patient'): ?>
                <a href="dashboard.php" class="nav-link">Dashboard</a>
                <a href="patient_appointments.php" class="nav-link">Appointments</a>
                <a href="patient_history.php" class="nav-link">Medical History</a>
                <a href="patient_billing.php" class="nav-link">Billing</a>
                <a href="patient_contact.php" class="nav-link">Contact Us</a>
                <a href="profile.php" class="nav-link">Profile</a>
            <?php elseif ($user_type === 'admin'): ?>
                <a href="dashboard.php" class="nav-link">Dashboard</a>
                <a href="inventory.php" class="nav-link">Inventory</a>
                <a href="staff.php" class="nav-link">Staff Management</a>
                <a href="doctor_registry.php" class="nav-link">Doctor Registry</a>
                <a href="profile.php" class="nav-link">Profile</a>
            <?php elseif ($user_type === 'super_admin'): ?>
                <a href="dashboard.php" class="nav-link">Dashboard</a>
                <a href="inventory.php" class="nav-link">Inventory</a>
                <a href="staff.php" class="nav-link">Staff Management</a>
                <a href="doctor_registry.php" class="nav-link">Doctor Registry</a>
                <a href="admin_management.php" class="nav-link">Admin Management</a>
                <a href="profile.php" class="nav-link">Profile</a>
            <?php elseif ($user_type === 'receptionist'): ?>
                <a href="dashboard.php" class="nav-link">Dashboard</a>
                <a href="receptionist_appointment.php" class="nav-link">Appointments</a>
                <a href="receptionist_billing.php" class="nav-link">Billing & Insurance</a>
                <a href="receptionist_labtest.php" class="nav-link">Lab Test Orders</a>
                <a href="profile.php" class="nav-link">Profile</a>
            <?php elseif ($user_type === 'doctor'): ?>
                <a href="dashboard.php" class="nav-link">Dashboard</a>
                <a href="doctor_directory.php" class="nav-link">Appointments</a>
                <a href="doctor_prescription.php" class="nav-link">Patients</a>
                <a href="doctor_lab_test.php" class="nav-link">Lab Results</a>
                <a href="profile.php" class="nav-link">Profile</a>
            <?php endif; ?>
        </nav>

        <div class="sidebar-footer">
            <div class="hospital-contact">
                <h4>Emergency Contact</h4>
                <p>📞 999</p>
                <p>🖂 info@bdhospital.com</p>
            </div>
        </div>
    </aside>