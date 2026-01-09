<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/flash.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$students = read_json('students.json', []);

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['student_code'] ?? '');
    $pass = (string)($_POST['password'] ?? '');

    if ($code === '' || $pass === '') {
        $error = 'Vui lòng nhập đầy đủ mã SV và mật khẩu.';
    } else {
        $found = null;
        foreach ($students as $s) {
            if (($s['student_code'] ?? '') === $code) { 
                $found = $s; 
                break; 
            }
        }

        if ($found && password_verify($pass, $found['password_hash'] ?? '')) {
            $_SESSION['auth'] = true;
            $_SESSION['student'] = [
                'student_code' => $found['student_code'] ?? '',
                'full_name' => $found['full_name'] ?? '',
                'class_name' => $found['class_name'] ?? '',
                'email' => $found['email'] ?? ''
            ];
            set_flash('Đăng nhập thành công.', 'success');
            header('Location: student/profile.php');
            exit;
        } else {
            $error = 'Sai mã SV hoặc mật khẩu.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Login</title>
<style>
body { font-family: Arial; display:flex; justify-content:center; align-items:center; height:100vh; background:#f2f2f2; }
form { background:#fff; padding:20px; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.1); }
input { margin:5px 0; padding:8px; width:100%; }
button { padding:8px 12px; margin-top:10px; width:100%; cursor:pointer; }
p.error { color:red; }
</style>
</head>
<body>
<form method="post">
    <h2>Student Login</h2>
    <?php if ($error): ?>
        <p class="error"><?=htmlspecialchars($error)?></p>
    <?php endif; ?>
    Student Code: <input type="text" name="student_code" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Login</button>
</form>
</body>
</html>
