<?php
require_once '../config/database.php';
require_once '../includes/header.php';
require_once '../cart/add_to_cart.php';

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<div class="row">
    <?php while($product = $result->fetch_assoc()): ?>
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <img src="../assets/images/<?= $product['image'] ?>" class="card-img-top">
            <div class="card-body">
                <h5 class="card-title"><?= $product['name'] ?></h5>
                <p class="card-text"><?= $product['description'] ?></p>
                <p class="text-danger fw-bold"><?= number_format($product['price']) ?> MMK</p>
                
                <form class="add-to-cart-form">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <div class="mb-3">
                        <label>Custom Message:</label>
                        <textarea name="custom_message" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<?php require_once '../includes/footer.php'; ?>