<?php include __DIR__ . '/header.php'; ?>
<section class="container">
<?php if($type==='404'): ?>
<h2>404 - Page Not Found</h2>
<?php elseif($type==='500'): ?>
<h2>500 - Server Error</h2>
<?php else: ?>
<h2>Error</h2>
<?php endif; ?>
<p><a href="/controller/doctor_controller.php">Home</a></p>
</section>
<?php include __DIR__ . '/footer.php'; ?>
