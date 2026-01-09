<?php
require_once 'includes/auth.php';
require_once 'includes/flash.php';
require_once 'includes/users.php';

$username_cookie = $_COOKIE['remember_username'] ?? '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['username'] ?? '');
    $p = $_POST['password'] ?? '';

    if (!empty($users[$u]) && password_verify($p, $users[$u]['hash'])) {
        $_SESSION['auth'] = true;
        $_SESSION['user'] = ['username' => $u, 'role' => $users[$u]['role']];

        if (!empty($_POST['remember'])) {
            setcookie('remember_username', $u, time() + 7 * 86400, '/');
        }

        file_put_contents('data/log.txt', date('Y-m-d H:i:s') . " LOGIN $u\n", FILE_APPEND);
        set_flash('success', 'Đăng nhập thành công');
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Sai tài khoản hoặc mật khẩu';
    }
}
?>
<form method="post">
    <h2>Login</h2>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
    <input name="username" value="<?= htmlspecialchars($username_cookie) ?>" placeholder="Username"><br>
    <input type="password" name="password" placeholder="Password"><br>
    <label><input type="checkbox" name="remember"> Remember me</label><br>
    <button>Login</button>
</form>