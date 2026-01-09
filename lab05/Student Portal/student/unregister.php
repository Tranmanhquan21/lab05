<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/flash.php';
require_once __DIR__ . '/../includes/csrf.php';

require_login();

// CSRF check
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_verify($_POST['csrf'] ?? null)) {
    http_response_code(400);
    exit('Bad Request');
}

$student_code = current_student()['student_code'] ?? '';
$course_code = trim($_POST['course_code'] ?? '');

// Đọc grades để kiểm tra
$grades = read_json('../data/grades.json', []);
foreach ($grades as $g) {
    if (($g['student_code'] ?? '') === $student_code && ($g['course_code'] ?? '') === $course_code) {
        set_flash('Không thể hủy: học phần đã có điểm.', 'error');
        header('Location: registrations.php');
        exit;
    }
}

// Xóa khỏi enrollments
$enrollments = read_json('../data/enrollments.json', []);
$enrollments = array_values(array_filter($enrollments, fn($e) => !($e['student_code'] === $student_code && $e['course_code'] === $course_code)));
write_json('../data/enrollments.json', $enrollments);

set_flash('Đã hủy đăng ký học phần.', 'info');
header('Location: registrations.php');
exit;
