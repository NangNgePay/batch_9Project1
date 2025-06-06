<?php
session_start();
require_once '../config/database.php';
require_once '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Save order to database
    $user_id = $_SESSION['user_id'] ?? null; // if you have user system
    $delivery_date = $_POST['delivery_date'];
    $payment_method = $_POST['payment_method'];
    
    // Begin transaction
    $conn->begin_transaction();
    
    try {
        // Insert order
        $stmt = $conn->prepare("INSERT INTO orders (user_id, delivery_date, payment_method) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $delivery_date, $payment_method);
        $stmt->execute();
        $order_id = $conn->insert_id;
        
        // Insert order items
        foreach ($_SESSION['cart'] as $item) {
            $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, custom_message) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $order_id, $item['product_id'], $item['custom_message']);
            $stmt->execute();
        }
        
        $conn->commit();
        unset($_SESSION['cart']);
        echo "<div class='alert alert-success'>Order placed successfully!</div>";
    } catch (Exception $e) {
        $conn->rollback();
        echo "<div class='alert alert-danger'>Error: ".$e->getMessage()."</div>";
    }
} else {
    // Show checkout form
?>
<h2>Checkout</h2>
<form method="POST">
    <div class="mb-3">
        <label>Delivery Date:</label>
        <input type="date" name="delivery_date" class="form-control" required>
    </div>
    
    <div class="mb-3">
        <label>Payment Method:</label>
        <select name="payment_method" class="form-control" required>
            <option value="KBZ Pay">KBZ Pay</option>
            <option value="Wave Pay">Wave Pay</option>
            <option value="Cash on Delivery">Cash on Delivery</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-danger">Place Order</button>
</form>
<?php
}

require_once '../includes/footer.php';
?>