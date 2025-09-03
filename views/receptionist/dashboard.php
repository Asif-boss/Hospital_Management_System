<?php
// dashboard.php

if (!isset($_COOKIE['user_type']) || $_COOKIE['user_type'] !== 'receptionist') {
    header("Location: ../login.php");
    exit();
}


$totalPatients = 120;
$totalDoctors = 15;
$totalAppointments = 45;
$totalLabOrders = 18;


$appointments = [
    ["patient" => "Ahmed Hassan", "doctor" => "Dr. Rahman", "date" => "2025-09-05", "time" => "10:30 AM", "status" => "confirmed"],
    ["patient" => "Sarah Khan", "doctor" => "Dr. Fatima", "date" => "2025-09-05", "time" => "2:00 PM", "status" => "pending"],
    ["patient" => "Mohammad Ali", "doctor" => "Dr. Islam", "date" => "2025-09-06", "time" => "9:00 AM", "status" => "upcoming"]
];


$labOrders = [
    ["id" => "LAB-010", "patient" => "John Doe", "test" => "Blood Test", "status" => "processing"],
    ["id" => "LAB-011", "patient" => "Jane Smith", "test" => "X-Ray", "status" => "approved"],
    ["id" => "LAB-012", "patient" => "Michael Brown", "test" => "Urine Analysis", "status" => "pending"]
];

include '../templates/header.php';
?>

<div class="dashboard-layout">
    <?php include '../templates/sidebar.php'; ?>

    <main class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <h2><i class="fas fa-home"></i> Dashboard</h2>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="dashboard-card">
                <div class="card-body">
                    <h3><?php echo $totalPatients; ?></h3>
                    <p>Total Patients</p>
                </div>
            </div>
            <div class="dashboard-card">
                <div class="card-body">
                    <h3><?php echo $totalDoctors; ?></h3>
                    <p>Total Doctors</p>
                </div>
            </div>
            <div class="dashboard-card">
                <div class="card-body">
                    <h3><?php echo $totalAppointments; ?></h3>
                    <p>Appointments</p>
                </div>
            </div>
            <div class="dashboard-card">
                <div class="card-body">
                    <h3><?php echo $totalLabOrders; ?></h3>
                    <p>Lab Orders</p>
                </div>
            </div>
        </div>

        <div class="dashboard-widgets">
            <!-- Recent Appointments -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h3><i class="fas fa-calendar-alt"></i> Recent Appointments</h3>
                    <a href="appointments.php" class="view-all">View All</a>
                </div>
                <div class="card-body">
                    <div class="appointments-list">
                        <?php foreach ($appointments as $a) { ?>
                            <div class="appointment-item">
                                <div class="appointment-info">
                                    <h4><?php echo $a["patient"]; ?></h4>
                                    <p><?php echo $a["doctor"]; ?></p>
                                    <div class="appointment-meta">
                                        <span><i class="fas fa-calendar"></i> <?php echo $a["date"]; ?></span>
                                        <span><i class="fas fa-clock"></i> <?php echo $a["time"]; ?></span>
                                    </div>
                                </div>
                                <div class="appointment-actions">
                                    <span class="status <?php echo $a["status"]; ?>"><?php echo ucfirst($a["status"]); ?></span>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <!-- Recent Lab Orders -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h3><i class="fas fa-vials"></i> Recent Lab Orders</h3>
                    <a href="labtests.php" class="view-all">View All</a>
                </div>
                <div class="card-body">
                    <div class="lab-orders-list">
                        <?php foreach ($labOrders as $order) { ?>
                            <div class="lab-order-item">
                                <div class="order-info">
                                    <h4><?php echo $order["patient"]; ?></h4>
                                    <p><?php echo $order["test"]; ?></p>
                                    <span class="order-id">#<?php echo $order["id"]; ?></span>
                                </div>
                                <div class="appointment-status">
                                    <span class="status <?php echo $order["status"]; ?>"><?php echo ucfirst($order["status"]); ?></span>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- FontAwesome -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>

