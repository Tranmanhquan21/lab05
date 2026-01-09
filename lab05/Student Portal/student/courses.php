<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/flash.php';
require_once __DIR__ . '/../includes/csrf.php';

require_login();
$student = current_student();
$courses = read_json('../data/courses.json', []);
$enrollments = read_json('../data/enrollments.json', []);
$myCourses = array_map(fn($e) => $e['course_code'], array_filter($enrollments, fn($e) => $e['student_code'] === $student['student_code']));
$flash = get_flash();
?>

<h2>Available Courses</h2>
<?php if($flash): ?>
<p style="color: <?= $flash['type'] === 'error' ? 'red' : ($flash['type'] === 'info' ? 'blue' : 'green') ?>">
    <?= htmlspecialchars($flash['message']) ?>
</p>
<?php endif; ?>

<table border="1" cellpadding="5">
<tr><th>Course Code</th><th>Name</th><th>Action</th></tr>
<?php foreach ($courses as $c): ?>
<tr>
    <td><?= htmlspecialchars($c['course_code']) ?></td>
    <td><?= htmlspecialchars($c['course_name']) ?></td>
    <td>
    <?php if(in_array($c['course_code'], $myCourses)): ?>
        Already Registered
    <?php else: ?>
        <form method="post" action="register.php" style="display:inline">
            <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
            <input type="hidden" name="course_code" value="<?= htmlspecialchars($c['course_code']) ?>">
            <button>Register</button>
        </form>
    <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>
</table>
