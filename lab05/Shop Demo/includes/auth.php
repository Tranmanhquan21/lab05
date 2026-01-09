<?php
declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) session_start();

function is_logged_in(): bool {
    return !empty($_SESSION['auth']);
}

function require_login(): void {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}
