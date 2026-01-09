<?php
function set_flash(string $key, string $msg): void {
    $_SESSION['flash'][$key] = $msg;
}
function get_flash(string $key): ?string {
    if (empty($_SESSION['flash'][$key])) return null;
    $msg = $_SESSION['flash'][$key];
    unset($_SESSION['flash'][$key]);
    return $msg;
}
