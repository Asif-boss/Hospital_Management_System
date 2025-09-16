<?php
// --- SETUP AND INITIALIZATION ---

// Enable detailed error reporting for development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start the session
session_start();

// --- DATABASE CONNECTION ---
// For a real application, this should be in a separate file (e.g., config.php)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital";

// Enable error reporting for MySQLi to throw exceptions on errors
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    // Log the error and show a user-friendly message
    error_log("Database connection failed: " . $e->getMessage());
    die("Sorry, we're having trouble connecting to the database. Please try again later.");
}

// --- AUTHENTICATION CHECK ---
$user_email = $_SESSION['email'] ?? $_COOKIE['email'] ?? null;
$user_type = $_SESSION['user_type'] ?? $_COOKIE['user_type'] ?? null;

if (!$user_email || !$user_type) {
    header('location: login.php');
    exit();
}


// --- DATA FETCHING FUNCTIONS ---

/**
 * Gets a user's profile details from the correct table based on their role.
 *
 * @param mysqli $conn The database connection object.
 * @param string $user_type The role of the user.
 * @param string $email The user's email.
 * @return array|null An associative array of user details or null if not found.
 */
function getUserDetails(mysqli $conn, string $user_type, string $email): ?array {
    $table_map = [
        'patient' => 'patients',
        'doctor' => 'doctors',
        'admin' => 'admins',
        'super_admin' => 'admins',
        'receptionist' => 'receptionists'
    ];
    $table = $table_map[$user_type] ?? null;
    if (!$table) {
        error_log("Invalid user_type provided: $user_type");
        return null;
    }

    $sql = "SELECT * FROM `$table` WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

/**
 * Fetches dashboard statistics tailored to the user's role.
 *
 * @param mysqli $conn The database connection object.
 * @param string $user_type The role of the user.
 * @param int|null $user_id The specific ID of the user (e.g., patient_id, doctor_id).
 * @return array An array of statistics.
 */
function getDashboardStats(mysqli $conn, string $user_type, ?int $user_id): array {
    $stats = [];
    $stmt = null;

    switch ($user_type) {
        case 'patient':
            if (!$user_id) return [];
            $queries = [
                'appointments' => "SELECT COUNT(*) FROM appointments WHERE patient_id = ?",
                'upcoming_appointments' => "SELECT COUNT(*) FROM appointments WHERE patient_id = ? AND appointment_date >= CURDATE() AND status = 'scheduled'",
                'medical_records' => "SELECT COUNT(*) FROM medical_records WHERE patient_id = ?",
                'unpaid_bills' => "SELECT COUNT(*) FROM billing WHERE patient_id = ? AND status = 'pending'"
            ];
            foreach ($queries as $key => $sql) {
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $stats[$key] = $stmt->get_result()->fetch_row()[0] ?? 0;
            }
            break;

        case 'doctor':
            if (!$user_id) return [];
            $queries = [
                'appointments' => "SELECT COUNT(*) FROM appointments WHERE doctor_id = ?",
                'todays_appointments' => "SELECT COUNT(*) FROM appointments WHERE doctor_id = ? AND appointment_date = CURDATE()",
                'patients_treated' => "SELECT COUNT(DISTINCT patient_id) FROM appointments WHERE doctor_id = ?"
            ];
            foreach ($queries as $key => $sql) {
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $stats[$key] = $stmt->get_result()->fetch_row()[0] ?? 0;
            }
            break;

        case 'admin':
        case 'super_admin':
            $queries = [
                'total_patients' => "SELECT COUNT(*) FROM patients",
                'total_doctors' => "SELECT COUNT(*) FROM doctors",
                'total_appointments' => "SELECT COUNT(*) FROM appointments",
                'total_revenue' => "SELECT SUM(amount) FROM billing WHERE status = 'paid'"
            ];
             foreach ($queries as $key => $sql) {
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $stats[$key] = $stmt->get_result()->fetch_row()[0] ?? 0;
            }
            break;

        case 'receptionist':
            $queries = [
                'todays_appointments' => "SELECT COUNT(*) FROM appointments WHERE appointment_date = CURDATE()",
                // This query now works because you've run the SQL fix to add the `created_at` column.
                'new_patients' => "SELECT COUNT(*) FROM patients WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())",
                'pending_appointments' => "SELECT COUNT(*) FROM appointments WHERE status = 'scheduled'",
                'unpaid_bills' => "SELECT COUNT(*) FROM billing WHERE status = 'pending'"
            ];
             foreach ($queries as $key => $sql) {
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $stats[$key] = $stmt->get_result()->fetch_row()[0] ?? 0;
            }
            break;
    }
    return $stats;
}

/**
 * Fetches recent activities relevant to the user's role.
 *
 * @param mysqli $conn The database connection object.
 * @param string $user_type The role of the user.
 * @param int|null $user_id The specific ID of the user.
 * @return array A list of recent activities.
 */
function getRecentActivities(mysqli $conn, string $user_type, ?int $user_id): array {
    $sql = "";
    switch ($user_type) {
        case 'patient':
            if (!$user_id) return [];
            $sql = "SELECT a.appointment_date, a.appointment_time, a.status, d.full_name AS doctor_name
                    FROM appointments a
                    JOIN doctors d ON a.doctor_id = d.id
                    WHERE a.patient_id = ?
                    ORDER BY a.appointment_date DESC, a.appointment_time DESC LIMIT 5";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            break;

        case 'doctor':
             if (!$user_id) return [];
            $sql = "SELECT a.appointment_date, a.appointment_time, a.status, p.full_name AS patient_name
                    FROM appointments a
                    JOIN patients p ON a.patient_id = p.id
                    WHERE a.doctor_id = ?
                    ORDER BY a.appointment_date DESC, a.appointment_time DESC LIMIT 5";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            break;

        case 'admin':
        case 'super_admin':
        case 'receptionist':
            $sql = "SELECT a.appointment_date, a.appointment_time, a.status, p.full_name AS patient_name, d.full_name AS doctor_name
                    FROM appointments a
                    JOIN patients p ON a.patient_id = p.id
                    JOIN doctors d ON a.doctor_id = d.id
                    ORDER BY a.created_at DESC LIMIT 5";
            $stmt = $conn->prepare($sql);
            break;
        
        default:
            return [];
    }

    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * Fetches unread notifications for the user.
 * NOTE: This requires the `notifications` table to exist.
 *
 * @param mysqli $conn The database connection object.
 * @param string $user_type The user's role.
 * @param int|null $user_id The general user ID from the `users` table.
 * @return array A list of notifications.
 */
function getNotifications(mysqli $conn, string $user_type, ?int $user_id): array {
     if (!$user_id) return [];
    $sql = "SELECT message, created_at FROM notifications
            WHERE user_id = ? AND user_type = ? AND status = 'unread'
            ORDER BY created_at DESC LIMIT 5";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $user_type);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}


// --- MAIN LOGIC ---
// Fetch user details once
$user_details = getUserDetails($conn, $user_type, $user_email) ?: ['full_name' => 'Unknown User', 'email' => $user_email, 'id' => null];

// Get the specific ID (patient_id, doctor_id, etc.) for use in other queries
$specific_user_id = $user_details['id'] ?? null;

// Also get the main user ID from the `users` table for notifications
$main_user_id = null;
$stmt_user = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt_user->bind_param("s", $user_email);
$stmt_user->execute();
$main_user_id = $stmt_user->get_result()->fetch_assoc()['id'] ?? null;


// Fetch all dashboard data
$stats = getDashboardStats($conn, $user_type, $specific_user_id);
$activities = getRecentActivities($conn, $user_type, $specific_user_id);
// This will now work because you've run the SQL fix to create the table.
$notifications = getNotifications($conn, $user_type, $main_user_id);


?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Your existing CSS is good, so I'm keeping it as is. */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f5f7fa; color: #333; line-height: 1.6; }
        .dashboard-container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .dashboard-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #e0e6ed; }
        .user-info { display: flex; align-items: center; gap: 15px; }
        .user-avatar { width: 60px; height: 60px; border-radius: 50%; background-color: #3498db; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; font-weight: bold; }
        .user-details h2 { color: #2c3e50; margin-bottom: 5px; }
        .user-details p { color: #7f8c8d; font-size: 14px; }
        .user-type { background-color: #3498db; color: white; padding: 5px 10px; border-radius: 15px; font-size: 12px; font-weight: bold; }
        .dashboard-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); display: flex; align-items: center; }
        .stat-icon { width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; font-size: 20px; }
        .stat-icon.patient { background-color: rgba(52, 152, 219, 0.2); color: #3498db; }
        .stat-icon.doctor { background-color: rgba(46, 204, 113, 0.2); color: #2ecc71; }
        .stat-icon.admin { background-color: rgba(155, 89, 182, 0.2); color: #9b59b6; }
        .stat-icon.receptionist { background-color: rgba(241, 196, 15, 0.2); color: #f1c40f; }
        .stat-info h3 { font-size: 24px; margin-bottom: 5px; font-weight: 600; }
        .stat-info p { color: #7f8c8d; font-size: 14px; }
        .dashboard-content { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }
        .dashboard-card { background: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); padding: 20px; margin-bottom: 20px; }
        .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid #e0e6ed; }
        .card-header h3 { color: #2c3e50; font-size: 18px; }
        .activity-list { list-style: none; }
        .activity-item { display: flex; align-items: center; padding: 10px 0; border-bottom: 1px solid #f1f1f1; }
        .activity-item:last-child { border-bottom: none; }
        .activity-icon { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; font-size: 16px; }
        .activity-info { flex-grow: 1; }
        .activity-info h4 { font-size: 14px; margin-bottom: 3px; }
        .activity-info p { font-size: 12px; color: #7f8c8d; }
        .activity-time { font-size: 12px; color: #7f8c8d; }
        .quick-actions { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; }
        .action-btn { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 15px; background: #f8f9fa; border-radius: 8px; text-decoration: none; color: #333; transition: all 0.3s ease; }
        .action-btn:hover { background: #3498db; color: white; transform: translateY(-3px); }
        .action-btn i { font-size: 24px; margin-bottom: 8px; }
        .action-btn span { font-size: 12px; font-weight: 500; }
        .empty-state { text-align: center; color: #7f8c8d; padding: 20px; }
        @media (max-width: 768px) { .dashboard-content, .dashboard-stats { grid-template-columns: 1fr; } .quick-actions { grid-template-columns: repeat(2, 1fr); } }
    </style>
    <?php include 'header.php'; ?>
    <main class="main-content">
    <!-- <div class="dashboard-container"> -->
        <div class="dashboard-header">
            <div class="user-info">
                <div class="user-avatar">
                    <?= htmlspecialchars(strtoupper(substr($user_details['full_name'], 0, 1))) ?>
                </div>
                <div class="user-details">
                    <h2>Welcome, <?= htmlspecialchars($user_details['full_name']); ?>!</h2>
                    <p><?= htmlspecialchars($user_details['email']); ?></p>
                </div>
            </div>
            <div class="user-type">
                <?= htmlspecialchars(ucfirst(str_replace('_', ' ', $user_type))) ?>
            </div>
        </div>

        <div class="dashboard-stats">
            <?php if ($user_type == 'patient'): ?>
                <div class="stat-card"><div class="stat-icon patient"><i class="fas fa-calendar-check"></i></div><div class="stat-info"><h3><?= $stats['appointments'] ?? 0 ?></h3><p>Total Appointments</p></div></div>
                <div class="stat-card"><div class="stat-icon patient"><i class="fas fa-clock"></i></div><div class="stat-info"><h3><?= $stats['upcoming_appointments'] ?? 0 ?></h3><p>Upcoming</p></div></div>
                <div class="stat-card"><div class="stat-icon patient"><i class="fas fa-file-medical"></i></div><div class="stat-info"><h3><?= $stats['medical_records'] ?? 0 ?></h3><p>Medical Records</p></div></div>
                <div class="stat-card"><div class="stat-icon patient"><i class="fas fa-receipt"></i></div><div class="stat-info"><h3><?= $stats['unpaid_bills'] ?? 0 ?></h3><p>Unpaid Bills</p></div></div>
            <?php elseif ($user_type == 'doctor'): ?>
                <div class="stat-card"><div class="stat-icon doctor"><i class="fas fa-calendar-check"></i></div><div class="stat-info"><h3><?= $stats['appointments'] ?? 0 ?></h3><p>Total Appointments</p></div></div>
                <div class="stat-card"><div class="stat-icon doctor"><i class="fas fa-clock"></i></div><div class="stat-info"><h3><?= $stats['todays_appointments'] ?? 0 ?></h3><p>Today's Appointments</p></div></div>
                <div class="stat-card"><div class="stat-icon doctor"><i class="fas fa-user-injured"></i></div><div class="stat-info"><h3><?= $stats['patients_treated'] ?? 0 ?></h3><p>Patients Treated</p></div></div>
            <?php elseif (in_array($user_type, ['admin', 'super_admin'])): ?>
                <div class="stat-card"><div class="stat-icon admin"><i class="fas fa-user-injured"></i></div><div class="stat-info"><h3><?= $stats['total_patients'] ?? 0 ?></h3><p>Total Patients</p></div></div>
                <div class="stat-card"><div class="stat-icon admin"><i class="fas fa-user-md"></i></div><div class="stat-info"><h3><?= $stats['total_doctors'] ?? 0 ?></h3><p>Total Doctors</p></div></div>
                <div class="stat-card"><div class="stat-icon admin"><i class="fas fa-calendar-check"></i></div><div class="stat-info"><h3><?= $stats['total_appointments'] ?? 0 ?></h3><p>Total Appointments</p></div></div>
                <div class="stat-card"><div class="stat-icon admin"><i class="fas fa-dollar-sign"></i></div><div class="stat-info"><h3>$<?= number_format($stats['total_revenue'] ?? 0, 2) ?></h3><p>Total Revenue</p></div></div>
            <?php elseif ($user_type == 'receptionist'): ?>
                <div class="stat-card"><div class="stat-icon receptionist"><i class="fas fa-calendar-day"></i></div><div class="stat-info"><h3><?= $stats['todays_appointments'] ?? 0 ?></h3><p>Today's Appointments</p></div></div>
                <div class="stat-card"><div class="stat-icon receptionist"><i class="fas fa-user-plus"></i></div><div class="stat-info"><h3><?= $stats['new_patients'] ?? 0 ?></h3><p>New Patients This Month</p></div></div>
                <div class="stat-card"><div class="stat-icon receptionist"><i class="fas fa-clock"></i></div><div class="stat-info"><h3><?= $stats['pending_appointments'] ?? 0 ?></h3><p>Pending Appointments</p></div></div>
                <div class="stat-card"><div class="stat-icon receptionist"><i class="fas fa-receipt"></i></div><div class="stat-info"><h3><?= $stats['unpaid_bills'] ?? 0 ?></h3><p>Unpaid Bills</p></div></div>
            <?php endif; ?>
        </div>

        <div class="dashboard-content">
            <div class="dashboard-main">
                <div class="dashboard-card">
                    <div class="card-header"><h3>Recent Activities</h3><a href="#">View All</a></div>
                    <ul class="activity-list">
                        <?php if (empty($activities)): ?>
                            <p class="empty-state">No recent activities found.</p>
                        <?php else: ?>
                            <?php foreach ($activities as $activity): ?>
                            <li class="activity-item">
                                <div class="activity-icon patient"><i class="fas fa-calendar-check"></i></div>
                                <div class="activity-info">
                                    <h4>
                                        <?php
                                        if ($user_type == 'patient') echo "Appointment with Dr. " . htmlspecialchars($activity['doctor_name']);
                                        elseif ($user_type == 'doctor') echo "Appointment with " . htmlspecialchars($activity['patient_name']);
                                        else echo "Appt: " . htmlspecialchars($activity['patient_name']) . " with Dr. " . htmlspecialchars($activity['doctor_name']);
                                        ?>
                                    </h4>
                                    <p>
                                        <?= date('M j, Y', strtotime($activity['appointment_date'])) . ' • ' . htmlspecialchars(ucfirst($activity['status'])) ?>
                                    </p>
                                </div>
                                <div class="activity-time"><?= date('g:i A', strtotime($activity['appointment_time'])) ?></div>
                            </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="dashboard-card">
                    <div class="card-header"><h3>Notifications</h3><a href="#">View All</a></div>
                     <ul class="activity-list">
                        <?php if (empty($notifications)): ?>
                            <p class="empty-state">You have no new notifications.</p>
                        <?php else: ?>
                            <?php foreach ($notifications as $notification): ?>
                            <li class="activity-item">
                                <div class="activity-icon patient"><i class="fas fa-bell"></i></div>
                                <div class="activity-info">
                                    <h4><?= htmlspecialchars($notification['message']) ?></h4>
                                    <p><?= date('M j, Y g:i A', strtotime($notification['created_at'])) ?></p>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="dashboard-sidebar">
                <div class="dashboard-card">
                    <div class="card-header"><h3>Quick Actions</h3></div>
                    <div class="quick-actions">
                        <?php if ($user_type == 'patient'): ?>
                            <a href="appointments.php" class="action-btn"><i class="fas fa-calendar-plus"></i><span>Book Appointment</span></a>
                            <a href="medical_records.php" class="action-btn"><i class="fas fa-file-medical"></i><span>Medical Records</span></a>
                            <a href="billing.php" class="action-btn"><i class="fas fa-receipt"></i><span>Billing</span></a>
                        <?php elseif ($user_type == 'doctor'): ?>
                            <a href="appointments.php" class="action-btn"><i class="fas fa-calendar"></i><span>My Schedule</span></a>
                            <a href="patients.php" class="action-btn"><i class="fas fa-user-injured"></i><span>My Patients</span></a>
                            <a href="medical_records.php" class="action-btn"><i class="fas fa-file-medical"></i><span>Medical Records</span></a>
                            <a href="reports.php" class="action-btn"><i class="fas fa-chart-line"></i><span>Reports</span></a>
                        <?php elseif (in_array($user_type, ['admin', 'super_admin'])): ?>
                            <a href="manage_doctors.php" class="action-btn"><i class="fas fa-user-md"></i><span>Manage Doctors</span></a>
                            <a href="manage_staff.php" class="action-btn"><i class="fas fa-users"></i><span>Manage Staff</span></a>
                            <a href="reports.php" class="action-btn"><i class="fas fa-chart-line"></i><span>Reports</span></a>
                            <a href="settings.php" class="action-btn"><i class="fas fa-cog"></i><span>Settings</span></a>
                        <?php elseif ($user_type == 'receptionist'): ?>
                            <a href="appointments.php" class="action-btn"><i class="fas fa-calendar-plus"></i><span>Schedule Appt.</span></a>
                            <a href="patients.php" class="action-btn"><i class="fas fa-user-plus"></i><span>Register Patient</span></a>
                            <a href="billing.php" class="action-btn"><i class="fas fa-receipt"></i><span>Billing</span></a>
                            <a href="reports.php" class="action-btn"><i class="fas fa-file-alt"></i><span>Daily Report</span></a>
                        <?php endif; ?>
                    </div>
                </div>
            <!-- </div> -->
        </div>
    </div>
    </main>
    <?php $conn->close(); ?>
</body>
</html>