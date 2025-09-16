<?php
include __DIR__ . '/header.php';
require_once __DIR__ . '/../models/doctor_model.php';
$doctors = get_all_doctors();
?>
<section class="container">
<h2>Doctors</h2>
<?php if(empty($doctors)): ?><p>No doctors found.</p><?php else: ?>
<table class="simple-table"><tr><th>Name</th><th>Specialty</th><th>Fee</th><th>Action</th></tr>
<?php foreach($doctors as $d): ?>
<tr><td><?php echo $d['full_name']; ?></td><td><?php echo $d['specialty']; ?></td>
<td><?php echo $d['consultation_fee']; ?></td>
<td><button class="view-btn" data-id="<?php echo $d['id']; ?>">View</button></td></tr>
<?php endforeach; ?></table>
<div id="doctor-detail"></div>
<?php endif; ?>
</section>
<?php include __DIR__ . '/footer.php'; ?>
