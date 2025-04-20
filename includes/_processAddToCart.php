<?php
session_start();

// Initialize the cart if not already set.
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Get the product details from the POST request.
$itemId = filter_input(INPUT_POST, 'itemId', FILTER_SANITIZE_NUMBER_INT);
$itemName = filter_input(INPUT_POST, 'itemName', FILTER_SANITIZE_STRING);
$itemPrice = filter_input(INPUT_POST, 'itemPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

// Check if the item is already in the cart.
$found = false;
foreach ($_SESSION['cart'] as &$cartItem) {
    if ($cartItem['id'] == $itemId) {
        $cartItem['quantity'] += 1;
        $found = true;
        break;
    }
}

// If the item is not in the cart, add it as a new entry.
if (!$found) {
    $_SESSION['cart'][] = [
        'id' => $itemId,
        'name' => $itemName,
        'price' => $itemPrice,
        'quantity' => 1,
    ];
}

// Redirect back to the home page or show success.
header('Location: home.php');
exit;
?>
