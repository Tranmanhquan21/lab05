<?php
if (session_status() === PHP_SESSION_NONE) session_start();

function require_login(): void {
    if (empty($_SESSION['auth']) || empty($_SESSION['student'])) {
        header('Location: ../login.php');
        exit;
    }
}

function current_student(): array {
    return $_SESSION['student'] ?? [];
}
