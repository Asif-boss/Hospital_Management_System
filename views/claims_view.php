<?php
include __DIR__ . '/header.php';
require_once __DIR__ . '/../models/claims_model.php';
$id=isset($_GET['id'])?(int)$_GET['id']:0;
$c=$id?get_claim_by_id($id):null;
?>
<section class="container">
<?php if(!$c): ?><p>Claim not found.</p><?php else: ?>
<h2>Claim #<?php echo $c['id']; ?></h2>
<p>Patient: <?php echo $c['patient_id']; ?></p>
<p>Amount: <?php echo $c['claim_amount']; ?></p>
<p>Status: <?php echo $c['status']; ?></p>
<?php endif; ?>
</section>
<?php include __DIR__ . '/footer.php'; ?>
