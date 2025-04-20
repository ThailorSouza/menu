<?php
// Get the total number of items in the cart.
function getCartItemCount() {
    return isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
}

// Get the total price of the items in the cart.
function getCartTotalPrice() {
    $total = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $cartItem) {
            $total += $cartItem['price'] * $cartItem['quantity'];
        }
    }
    return $total;
}
?>