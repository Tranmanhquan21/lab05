<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/flash.php';
require_once __DIR__ . '/../includes/csrf.php';

require_login();
$student = current_student();
$flash = get_flash();
?>
<h2>Profile</h2>
<?php if ($flash): ?>
<p style="color: <?= $flash['type'] === 'error' ? 'red' : ($flash['type'] === 'info' ? 'blue' : 'green') ?>">
    <?= htmlspecialchars($flash['message']) ?>
</p>
<?php endif; ?>

<p>Student Code: <?= htmlspecialchars($student['student_code'] ?? '') ?></p>
<p>Full Name: <?= htmlspecialchars($student['full_name'] ?? '') ?></p>
<p>Class: <?= htmlspecialchars($student['class_name'] ?? '') ?></p>
<p>Email: <?= htmlspecialchars($student['email'] ?? '') ?></p>

<form method="post" action="../logout.php">
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <button>Logout</button>
</form>
