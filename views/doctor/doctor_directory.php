<?php

if (!isset($_COOKIE['user_type']) || $_COOKIE['user_type'] !== 'doctor') {
    header('Location: ../../views/login.php?error=access_denied');
    exit;
}
include '../../views/templates/header.php';
include '../../views/templates/sidebar.php';

// Sample data for doctor directory with image URLs - replace with real DB query
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

// Filter logic
$searchName = trim($_GET['search_name'] ?? '');
$searchSpecialty = trim($_GET['search_specialty'] ?? '');

$filteredDoctors = array_filter($doctors, function ($doc) use ($searchName, $searchSpecialty) {
    $matchName = !$searchName || stripos($doc['name'], $searchName) !== false;
    $matchSpecialty = !$searchSpecialty || stripos($doc['specialty'], $searchSpecialty) !== false;
    return $matchName && $matchSpecialty;
});
?>
<div class="main-content">
  <header class="page-header">
    <h1>Doctor Directory</h1>
  </header>

  <section style="max-width: 900px; margin: 0 auto 30px;">
    <form method="GET" action="doctor_directory.php" style="display:flex; gap: 15px; flex-wrap: wrap; justify-content: center;">
      <input type="text" name="search_name" placeholder="Search by name" value="<?= htmlspecialchars($searchName) ?>" style="padding:10px 14px; font-size:16px; border-radius:8px; border:1px solid #cbd5e1; width: 250px; max-width: 100%;">
      <input type="text" name="search_specialty" placeholder="Search by specialty" value="<?= htmlspecialchars($searchSpecialty) ?>" style="padding:10px 14px; font-size:16px; border-radius:8px; border:1px solid #cbd5e1; width: 250px; max-width: 100%;">
      <button type="submit" class="btn primary" style="padding: 12px 30px; font-size: 16px;">Search</button>
      <a href="doctor_directory.php" class="btn back-btn" style="padding: 12px 30px; font-size: 16px; text-align:center; line-height:32px; text-decoration:none; display:inline-block;">Reset</a>
    </form>
  </section>

  <section class="profile-card" style="max-width: 900px; margin: auto;">
    <?php if (empty($filteredDoctors)): ?>
      <p style="text-align:center; color:#888; font-style: italic;">No doctors found matching search criteria.</p>
    <?php else: ?>
      <ul id="doctorDirectory" style="list-style:none; padding-left:0; display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
        <?php foreach ($filteredDoctors as $doc): ?>
          <li style="background:#f9fafb; border-radius:12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); width: 250px; padding:20px; text-align: center; display: flex; flex-direction: column; align-items: center;">
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
    <?php endif; ?>
  </section>
</div>
<script src="../../assets/js/validation.js"></script>
</body>
</html>
