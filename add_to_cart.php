<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $custom_message = $_POST['custom_message'];
    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    $_SESSION['cart'][] = [
        'product_id' => $product_id,
        'custom_message' => $custom_message
    ];
    
    echo json_encode(['status' => 'success', 'count' => count($_SESSION['cart'])]);
}
?>