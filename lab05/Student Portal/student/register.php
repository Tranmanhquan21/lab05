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

// Đọc enrollments
$enrollments = read_json('../data/enrollments.json', []);

// Kiểm tra đã đăng ký chưa
foreach ($enrollments as $e) {
    if (($e['student_code'] ?? '') === $student_code && ($e['course_code'] ?? '') === $course_code) {
        set_flash('Bạn đã đăng ký học phần này.', 'error');
        header('Location: courses.php'); // cùng thư mục student/, không lặp student/student
        exit;
    }
}

// Thêm mới
$enrollments[] = [
    'student_code' => $student_code,
    'course_code' => $course_code,
    'created_at' => date('Y-m-d H:i:s')
];

write_json('../data/enrollments.json', $enrollments);
set_flash('Đăng ký học phần thành công.', 'success');
header('Location: registrations.php'); // cùng thư mục
exit;
