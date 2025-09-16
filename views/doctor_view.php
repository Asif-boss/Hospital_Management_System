<?php
include __DIR__ . '/header.php';
require_once __DIR__ . '/../models/doctor_model.php';
$id = isset($_GET['id'])?(int)$_GET['id']:0;
$doc = $id?get_doctor_by_id($id):null;
?>
<section class="container">
<?php if(!$doc): ?><p>Doctor not found.</p><?php else: ?>
<h2><?php echo $doc['full_name']; ?></h2>
<p>Specialty: <?php echo $doc['specialty']; ?></p>
<p>Fee: <?php echo $doc['consultation_fee']; ?></p>
<p>Email: <?php echo $doc['email']; ?></p>
<p>Phone: <?php echo $doc['phone']; ?></p>
<?php endif; ?>
</section>
<?php include __DIR__ . '/footer.php'; ?>
