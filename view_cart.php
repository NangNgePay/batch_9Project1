<?php
session_start();
require_once '../config/database.php';
require_once '../includes/header.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<div class='alert alert-info'>Your cart is empty!</div>";
    require_once '../includes/footer.php';
    exit;
}
?>

<h2>Your Valentine Gifts</h2>
<table class="table">
    <thead>
        <tr>
            <th>Product</th>
            <th>Custom Message</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $total = 0;
        foreach ($_SESSION['cart'] as $item): 
            $product = $conn->query("SELECT * FROM products WHERE id=".$item['product_id'])->fetch_assoc();
            $total += $product['price'];
        ?>
        <tr>
            <td><?= $product['name'] ?></td>
            <td><?= $item['custom_message'] ?></td>
            <td><?= number_format($product['price']) ?> MMK</td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2">Total</th>
            <th><?= number_format($total) ?> MMK</th>
        </tr>
    </tfoot>
</table>

<a href="../checkout/process_order.php" class="btn btn-danger">Proceed to Checkout</a>

<?php require_once '../includes/footer.php'; ?>