<?php

if (!isset($_COOKIE['user_type']) || $_COOKIE['user_type'] !== 'doctor') {
    header('Location: ../../views/login.php?error=access_denied');
    exit;
}
include '../../views/templates/header.php';
include '../../views/templates/sidebar.php';

$doctors = [
    [
        'name' => 'Dr. Sarah Johnson',
        'specialty' => 'Cardiology',
        'contact' => '0123456780',
        'availability' => 'Mon-Fri, 9 AM - 5 PM',
        'id' => 'D001',
        'image' => '../../assets/img/doctor.jpg',
    ],
    [
        'name' => 'Dr. Michael Brown',
        'specialty' => 'Neurology',
        'contact' => '0123456781',
        'availability' => 'Tue-Thu, 10 AM - 4 PM',
        'id' => 'D002',
        'image' => '../../assets/img/doctor.jpg',
    ],
    [
        'name' => 'Dr. Fatima Ali',
        'specialty' => 'Pediatrics',
        'contact' => '0123456782',
        'availability' => 'Mon-Wed, 8 AM - 3 PM',
        'id' => 'D003',
        'image' => '../../assets/img/doctor.jpg',
    ],
];
?>
<div class="main-content">
  <header class="page-header">
    <h1>Doctor Directory</h1>
  </header>
  <section style="max-width: 900px; margin: 0 auto 30px;">
    <form class="search-form" onsubmit="filterDoctors(); return false;">
      <input type="text" id="doctorSearchInput" placeholder="Search by name or ID" />
      <select id="specialtyFilter">
        <option value="all">All Specialties</option>
        <option value="cardiology">Cardiology</option>
        <option value="neurology">Neurology</option>
        <option value="pediatrics">Pediatrics</option>
      </select>
      <button type="button" onclick="filterDoctors()" class="btn primary">Search</button>
      <a href="doctor_directory.php" class="btn back-btn">Reset</a>
    </form>
  </section>
  <section class="profile-card" style="max-width: 900px; margin: auto;">
    <div id="doctorDirectory">
      <ul style="list-style:none; padding-left:0; display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
        <?php foreach ($doctors as $doc): ?>
          <li data-id="<?= htmlspecialchars($doc['id']) ?>" data-name="<?= htmlspecialchars($doc['name']) ?>" data-specialty="<?= strtolower($doc['specialty']) ?>" style="background:#f9fafb; border-radius:12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); width: 250px; padding:20px; text-align: center; display: flex; flex-direction: column; align-items: center;">
            <img src="<?= htmlspecialchars($doc['image']) ?>" alt="<?= htmlspecialchars($doc['name']) ?> Profile" style="width:120px; height:120px; object-fit: cover; border-radius: 50%; border: 3px solid #4338ca; margin-bottom: 15px;">
            <strong style="font-size: 18px; color: #1e293b; margin-bottom: 8px;"><?= htmlspecialchars($doc['name']) ?></strong>
            <span><strong>Specialty:</strong> <?= htmlspecialchars($doc['specialty']) ?></span><br>
            <span><strong>Contact:</strong> <?= htmlspecialchars($doc['contact']) ?></span><br>
            <span><strong>Availability:</strong> <?= htmlspecialchars($doc['availability']) ?></span><br>
            <span><strong>ID:</strong> <?= htmlspecialchars($doc['id']) ?></span><br>
            <button class="bookBtn" style="margin-top: 12px; padding: 8px 20px; background-color: #4338ca; color: white; border: none; border-radius: 8px; cursor: pointer;" onclick="alert('Book appointment with <?= addslashes($doc['name']) ?>')">Book Appointment</button>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>
</div>
<script src="../../assets/js/validation.js"></script>
<script src="../../assets/js/doctor.js"></script>
</body>
</html>
