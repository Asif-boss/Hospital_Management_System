<?php
include __DIR__ . '/header.php';
require_once __DIR__ . '/../models/billing_model.php';
$id=isset($_GET['id'])?(int)$_GET['id']:0;
$bill=$id?get_bill_by_id($id):null;
?>
<section class="container">
<?php if(!$bill): ?><p>Bill not found.</p><?php else: ?>
<h2>Bill #<?php echo $bill['id']; ?></h2>
<p>Patient: <?php echo $bill['patient_id']; ?></p>
<p>Amount: <?php echo $bill['amount']; ?></p>
<p>Status: <?php echo $bill['status']; ?></p>
<p>Insurance: <?php echo $bill['insurance_info']; ?></p>
<?php endif; ?>
</section>
<?php include __DIR__ . '/footer.php'; ?>
