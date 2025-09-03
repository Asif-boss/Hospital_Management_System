<?php
if (!isset($_COOKIE['user_type'])) {
    header('location: ../login.php');
} elseif ($_COOKIE['user_type'] !== 'receptionist') {
    header('location: ../login.php');
}

include '../templates/header.php';
?>
<div class="dashboard-layout">
    <?php include '../templates/sidebar.php'; ?>
    <main class="main-content">
    </main>

</div>
<script src="../../assets/js/validation.js"></script>
</body>
</html>