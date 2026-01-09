<?php
require_once 'includes/auth.php';
require_once 'includes/cart.php';
require_once 'includes/products.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cart_add((int)$_POST['id']);
    header('Location: cart.php');
    exit;
}
?>
<h2>Products</h2>
<?php foreach ($products as $id => $p): ?>
<form method="post">
    <?=htmlspecialchars($p['name'])?> - $<?=number_format($p['price'])?>
    <input type="hidden" name="id" value="<?=$id?>">
    <button>Add to cart</button>
</form>
<?php endforeach; ?>
