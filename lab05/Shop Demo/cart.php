<?php
require_once 'includes/auth.php';
require_once 'includes/cart.php';
require_once 'includes/products.php';
require_login(); // Bảo vệ trang

// Xử lý form POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update số lượng
    if (!empty($_POST['qty'])) {
        foreach ($_POST['qty'] as $id => $qty) {
            cart_update((int)$id, (int)$qty);
        }
    }

    // Remove 1 sản phẩm
    if (!empty($_POST['remove'])) {
        cart_remove((int)$_POST['remove']);
    }

    // Clear Cart
    if (!empty($_POST['clear'])) {
        cart_clear();
    }
}

// Lấy giỏ mới nhất từ session
$cart = $_SESSION['cart'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Cart</title>
<style>
table { border-collapse: collapse; width: 70%; }
th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
button { padding: 5px 10px; margin: 2px; cursor: pointer; }
</style>
</head>
<body>

<h2>My Cart</h2>

<?php if (empty($cart)): ?>
    <p>Your cart is empty.</p>
<?php else: ?>
<form method="post">
<table>
<tr>
    <th>Product</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Total</th>
    <th>Action</th>
</tr>

<?php $grand = 0; ?>
<?php foreach ($cart as $id => $qty): 
    if (!isset($products[$id])) continue;
    $name  = $products[$id]['name'];
    $price = $products[$id]['price'];
    $total = $price * $qty;
    $grand += $total;
?>
<tr>
    <td><?=htmlspecialchars($name)?></td>
    <td>$<?=number_format($price)?></td>
    <td>
        <input type="number" name="qty[<?=$id?>]" value="<?=$qty?>" min="0">
    </td>
    <td>$<?=number_format($total)?></td>
    <td>
        <button type="submit" name="remove" value="<?=$id?>">Remove</button>
    </td>
</tr>
<?php endforeach; ?>

<tr>
    <td colspan="3"><b>Grand Total</b></td>
    <td colspan="2"><b>$<?=number_format($grand)?></b></td>
</tr>
</table>

<button type="submit">Update Cart</button>
<button type="submit" name="clear" value="1">Clear Cart</button>
</form>
<?php endif; ?>

</body>
</html>
