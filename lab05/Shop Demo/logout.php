<?php
require_once 'includes/auth.php';
require_once 'includes/csrf.php';
require_once 'includes/flash.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_verify($_POST['csrf'] ?? '')) {
    http_response_code(400);
    exit;
}

$user = $_SESSION['user']['username'] ?? '';
session_destroy();
setcookie('remember_username', '', time() - 3600, '/');
session_start();
file_put_contents('data/log.txt', date('Y-m-d H:i:s') . " LOGOUT $user\n", FILE_APPEND);
set_flash('info', 'Bạn đã đăng xuất');
header('Location: login.php');
