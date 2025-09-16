<?php
include __DIR__ . '/header.php';
require_once __DIR__ . '/../models/claims_model.php';
$claims=get_all_claims();
?>
<section class="container">
<h2>Claims</h2>
<?php if(empty($claims)): ?><p>No claims found.</p><?php else: ?>
<table class="simple-table"><tr><th>ID</th><th>Patient</th><th>Amount</th><th>Status</th><th>Action</th></tr>
<?php foreach($claims as $c): ?>
<tr><td><?php echo $c['id']; ?></td><td><?php echo $c['patient_id']; ?></td>
<td><?php echo $c['claim_amount']; ?></td><td><?php echo $c['status']; ?></td>
<td><button class="claim-view" data-id="<?php echo $c['id']; ?>">View</button></td></tr>
<?php endforeach; ?></table>
<div id="claim-detail"></div>
<?php endif; ?>
</section>
<?php include __DIR__ . '/footer.php'; ?>
