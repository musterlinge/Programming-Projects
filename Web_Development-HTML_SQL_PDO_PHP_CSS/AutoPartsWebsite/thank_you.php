<?php
session_start();

// Retrieve session variables
$orderID = isset($_SESSION['orderID']) ? $_SESSION['orderID'] : 'N/A';
$name = isset($_SESSION['name']) ? $_SESSION['name'] : 'N/A';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'N/A';
$address = isset($_SESSION['address']) ? $_SESSION['address'] : 'N/A';
$totalWeight = isset($_SESSION['totalWeight']) ? $_SESSION['totalWeight'] : '0';
$totalPrice = isset($_SESSION['totalPrice']) ? $_SESSION['totalPrice'] : '0.00';
$orderDate = isset($_SESSION['orderDate']) ? $_SESSION['orderDate'] : 'N/A';
$status = isset($_SESSION['status']) ? $_SESSION['status'] : 'N/A';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <title>Thank You for Your Order</title>
</head>
<body>
    <header class="main-header">
        <div class="logo-container">
            <img class="logoImage" src="images/logo.PNG" alt="Logo"> <!-- IF IMAGE DOES NOT LOAD, EITHER ADD OR REMOVE SLASH FROM images-->
        </div>
        <nav class="nav-menu">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="product.php">Products</a></li>
                <li><a href="login.php">Sign in</a></li>
            </ul>
        </nav>
    </header>

    <section class="container my-5 py-5">
        <h2>Thank You for Your Order</h2>
        <hr>
        <div class="container text-center mt-3 pt-5">
        <h2>Thank You for Your Order!</h2>
        <hr class="mx-auto">
        <p>Order Details:</p>
        <p>Order ID: <?php echo $orderID; ?></p>
        <p>Name: <?php echo $_SESSION['name']; ?></p>
        <p>Email: <?php echo $_SESSION['email']; ?></p>
        <p>Address: <?php echo $_SESSION['address']; ?></p>
        <p>Total Cost: $<?php echo $_SESSION['total']; ?></p>
        <p>Shipping & Handling Charge: $<?php echo $_SESSION['shipping_charge']; ?></p>
        <p>Total Weight: <?php echo $_SESSION['total_weight']; ?> lbs</p>
        <p>Order Date: <?php echo $_SESSION['orderDate']; ?></p>
        <p>Status: <?php echo $_SESSION['status']; ?></p>
    </div>
        <div class="thank-you-message">
            <p>Thank you for your order! Your order has been successfully placed.</p>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>