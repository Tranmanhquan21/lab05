<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/flash.php';
require_once __DIR__ . '/../includes/csrf.php';

require_login();
$student = current_student();
$student_code = $student['student_code'] ?? '';

// Đọc dữ liệu
$enrollments = read_json('../data/enrollments.json', []);
$courses = read_json('../data/courses.json', []);
$grades = read_json('../data/grades.json', []);

// Lọc học phần của sinh viên
$myEnrollments = array_filter($enrollments, fn($e) => ($e['student_code'] ?? '') === $student_code);

// Map course_code → course
$courseMap = [];
foreach ($courses as $c) $courseMap[$c['course_code']] = $c;

// Map student_course → grade
$gradesMap = [];
foreach ($grades as $g) $gradesMap[$g['student_code'].'_'.$g['course_code']] = $g;

// Lấy flash
$flash = get_flash();
?>

<h2>My Registrations</h2>

<?php if ($flash): ?>
<p style="color: <?= $flash['type']==='error' ? 'red' : ($flash['type']==='info' ? 'blue' : 'green') ?>">
    <?= htmlspecialchars($flash['message']) ?>
</p>
<?php endif; ?>

<table border="1" cellpadding="5">
<tr>
    <th>Course Code</th>
    <th>Course Name</th>
    <th>Action</th>
</tr>

<?php foreach ($myEnrollments as $e):
    $c = $courseMap[$e['course_code']] ?? [];
    $courseName = '';
    if (isset($c['course_name'])) {
        $courseName = is_array($c['course_name']) ? implode(' - ', $c['course_name']) : $c['course_name'];
    }
    $hasGrade = isset($gradesMap[$student_code.'_'.$e['course_code']]);
?>
<tr>
    <td><?= htmlspecialchars($e['course_code']) ?></td>
    <td><?= htmlspecialchars($courseName) ?></td>
    <td>
        <?php if($hasGrade): ?>
            Cannot Unregister (Already Graded)
        <?php else: ?>
            <form method="post" action="unregister.php" style="display:inline">
                <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
                <input type="hidden" name="course_code" value="<?= htmlspecialchars($e['course_code']) ?>">
                <button>Unregister</button>
            </form>
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>
</table>
