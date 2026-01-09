<?php
require_once 'includes/auth.php';
require_once 'includes/flash.php';
require_once 'includes/csrf.php';
require_login();
?>
<h2>Dashboard</h2>
<p><?= htmlspecialchars(get_flash('success') ?? '') ?></p>
<p>Xin chào <?= htmlspecialchars($_SESSION['user']['username']) ?></p>

<a href="products.php">Products</a> |
<a href="cart.php">Cart</a>

<?php if ($_SESSION['user']['role'] === 'admin'): ?>
    | <b>Admin Panel</b>
<?php endif; ?>

<form method="post" action="logout.php">
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <button>Logout</button>
</form>