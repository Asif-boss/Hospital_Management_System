<?php

if (!isset($_COOKIE['user_type']) || $_COOKIE['user_type'] !== 'doctor') {
    header('Location: ../../views/login.php?error=access_denied');
    exit;
}
include '../../views/templates/header.php';
include '../../views/templates/sidebar.php';

$doctor = [
    'id' => 'D001',
    'name' => 'Dr. Sarah Johnson',
    'specialty' => 'Cardiology',
    'image' => '../../assets/img/doctor.jpg',
    'contact' => '0123456780',
    'email' => 'sarah@med.com',
    'qualification' => 'MBBS, MD (Cardiology)',
    'experience' => '8 years',
    'location' => 'Room 305'
];

$appointments = [
    [
        'patient' => 'Ayesha Rahman',
        'date' => '2025-09-14',
        'time' => '10:00 AM',
        'status' => 'Confirmed',
        'reason' => 'Routine checkup'
    ],
    [
        'patient' => 'Imran Hasan',
        'date' => '2025-09-14',
        'time' => '12:00 PM',
        'status' => 'Pending',
        'reason' => 'Follow-up'
    ],
    [
        'patient' => 'Nadia Islam',
        'date' => '2025-09-15',
        'time' => '09:30 AM',
        'status' => 'Confirmed',
        'reason' => 'Heart palpitations'
    ]
];
?>
<div class="main-content">
    <header class="page-header">
        <h1>Doctor Dashboard</h1>
    </header>
    <section class="profile-card" style="max-width: 900px; margin: 0 auto 40px; display: flex; gap: 40px; box-sizing:border-box; align-items:center;">
        <img src="<?= htmlspecialchars($doctor['image']) ?>" class="profile-img" alt="<?= htmlspecialchars($doctor['name']) ?> Profile"
             style="width:150px; height:150px; object-fit:cover; border-radius:50%; border:6px solid #16a34a; margin-right:30px;">
        <div style="text-align:left;">
            <h2 style="font-size:28px; color:#1e293b;"><?= htmlspecialchars($doctor['name']) ?></h2>
            <div style="margin-bottom:7px;">
                <strong style="color:#16a34a;"><?= htmlspecialchars($doctor['specialty']) ?></strong>
                <span style="margin-left:18px;color:#64748b;">Qualification: <?= htmlspecialchars($doctor['qualification']) ?></span>
            </div>
            <div style="margin-bottom:7px;">Experience: <?= htmlspecialchars($doctor['experience']) ?> </div>
            <div style="margin-bottom:7px;"><i class="fa fa-envelope"></i> <?= htmlspecialchars($doctor['email']) ?></div>
            <div style="margin-bottom:7px;"><i class="fa fa-phone"></i> <?= htmlspecialchars($doctor['contact']) ?></div>
            <div style="margin-bottom:7px;"><i class="fa fa-map-marker"></i> <?= htmlspecialchars($doctor['location']) ?></div>
            <a href="edit_profile.php" class="btn primary" style="margin-top:12px;">Edit Profile</a>
        </div>
    </section>
    <section style="max-width: 900px; margin: 0 auto 30px; background: #eefcf6; border-radius: 16px; box-shadow: 0 4px 16px rgba(22,163,74,0.08); padding: 28px 34px;">
        <h2 style="color:#15803d; margin-bottom:18px;">My Appointments</h2>
        <?php if (count($appointments) == 0): ?>
            <p style="color:#888;">No upcoming appointments.</p>
        <?php else: ?>
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#d1fae5; color:#065f46;">
                    <th style="padding:11px 7px; border-bottom:1px solid #b6e7d8;">Patient</th>
                    <th style="padding:11px 7px; border-bottom:1px solid #b6e7d8;">Date</th>
                    <th style="padding:11px 7px; border-bottom:1px solid #b6e7d8;">Time</th>
                    <th style="padding:11px 7px; border-bottom:1px solid #b6e7d8;">Status</th>
                    <th style="padding:11px 7px; border-bottom:1px solid #b6e7d8;">Reason</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $appt): ?>
                <tr>
                    <td style="padding:9px 7px;"><?= htmlspecialchars($appt['patient']) ?></td>
                    <td style="padding:9px 7px;"><?= htmlspecialchars($appt['date']) ?></td>
                    <td style="padding:9px 7px;"><?= htmlspecialchars($appt['time']) ?></td>
                    <td style="padding:9px 7px; color:<?= $appt['status'] == 'Confirmed' ? '#16a34a' : '#dc2626' ?>; font-weight:600;">
                        <?= htmlspecialchars($appt['status']) ?>
                    </td>
                    <td style="padding:9px 7px;"><?= htmlspecialchars($appt['reason']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </section>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</body>
</html>
