<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/data.php';

require_login();
$student = current_student();
$code = trim((string)($student['student_code'] ?? ''));

// Đọc dữ liệu
$grades = read_json('../data/grades.json', []);
$courses = read_json('../data/courses.json', []);

// Lọc bảng điểm của sinh viên hiện tại
$myGrades = array_values(array_filter($grades, fn($g) =>
    trim((string)($g['student_code'] ?? '')) === $code
));

// Map course_code → course
$courseMap = [];
foreach ($courses as $c) {
    $courseMap[$c['course_code']] = $c;
}
?>

<h2>My Grades</h2>

<?php if (empty($myGrades)): ?>
<p>You do not have any grades yet.</p>
<?php else: ?>
<table border="1" cellpadding="5">
<tr>
    <th>Course Code</th>
    <th>Course Name</th>
    <th>Midterm</th>
    <th>Final</th>
    <th>Total</th>
</tr>

<?php foreach ($myGrades as $g):
    $c = $courseMap[$g['course_code']] ?? [];
    // đảm bảo course_name luôn là string
    $courseName = '';
    if (isset($c['course_name'])) {
        $courseName = is_array($c['course_name']) ? implode(' - ', $c['course_name']) : $c['course_name'];
    }
?>
<tr>
    <td><?= htmlspecialchars($g['course_code'] ?? '') ?></td>
    <td><?= htmlspecialchars($courseName) ?></td>
    <td><?= htmlspecialchars($g['midterm'] ?? '') ?></td>
    <td><?= htmlspecialchars($g['final'] ?? '') ?></td>
    <td><?= htmlspecialchars($g['total'] ?? '') ?></td>
</tr>
<?php endforeach; ?>

</table>
<?php endif; ?>
