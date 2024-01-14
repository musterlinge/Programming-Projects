<?php
session_start();

// Check if the cart exists and clear it
if (isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Optionally, you can reset other related session variables
$_SESSION['subtotal'] = 0;
$_SESSION['total_weight'] = 0;
$_SESSION['shipping_charge'] = 0;
$_SESSION['total'] = 0;

// Redirect to the products page
header("Location: product.php");
exit();
?>
