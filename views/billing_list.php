<?php
include __DIR__ . '/header.php';
require_once __DIR__ . '/../models/billing_model.php';
$bills=get_all_bills();
?>
<section class="container">
<h2>Billing</h2>
<?php if(empty($bills)): ?><p>No billing records.</p><?php else: ?>
<table class="simple-table"><tr><th>ID</th><th>Patient</th><th>Amount</th><th>Status</th><th>Action</th></tr>
<?php foreach($bills as $b): ?>
<tr><td><?php echo $b['id']; ?></td><td><?php echo $b['patient_id']; ?></td>
<td><?php echo $b['amount']; ?></td><td><?php echo $b['status']; ?></td>
<td><button class="bill-view" data-id="<?php echo $b['id']; ?>">View</button></td></tr>
<?php endforeach; ?></table>
<div id="bill-detail"></div>
<?php endif; ?>
</section>
<?php include __DIR__ . '/footer.php'; ?>
