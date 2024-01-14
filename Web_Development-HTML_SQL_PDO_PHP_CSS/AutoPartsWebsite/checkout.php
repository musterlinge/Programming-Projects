<?php
session_start();
include 'secrets.php'; // Include the database connection settings

if (!empty($_SESSION['cart']) && isset($_POST['placeOrder'])) {
    $name = $_POST['name'] ?? "";
    $email = $_POST['email'] ?? "";
    $address = $_POST['address'] ?? "";
    $creditCardNumber = $_POST['card'] ?? "";
    $creditCardExpirationDate = $_POST['exp'] ?? "";
    $totalCost = $_SESSION['total'] ?? 0;
    $totalWeight = $_SESSION['total_weight'] ?? 0;

    if (!empty($email)) {
        try {
            $pdo->beginTransaction();

            // Check if email already exists
            $checkEmailSQL = "SELECT UserID FROM Users WHERE Email = ?";
            $stmt = $pdo->prepare($checkEmailSQL);
            $stmt->execute([$email]);
            if ($stmt->rowCount() === 0) {
                // Insert new user
                $insertUserSQL = "INSERT INTO Users (Name, Email, Address, CreditCardNumber, CreditCardExpirationDate) VALUES (?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($insertUserSQL);
                $stmt->execute([$name, $email, $address, $creditCardNumber, $creditCardExpirationDate]);
                $userID = $pdo->lastInsertId();
            } else {
                // Get existing user ID
                $userID = $stmt->fetchColumn();
            }

            // Insert order into database
            $insertOrderSQL = "INSERT INTO Orders (CustomerID, TotalWeight, TotalPrice, ShippingCharge, Date, Status) VALUES (?, ?, ?, ?, NOW(), 'pending')";
            $stmt = $pdo->prepare($insertOrderSQL);
            $stmt->execute([$userID, $totalWeight, $totalCost, $_SESSION['shipping_charge']]);

            // Retrieve the orderID just after inserting the order
            $orderID = $pdo->lastInsertId();

            // Insert items from cart into OrderDetails table
            foreach ($_SESSION['cart'] as $item) {
                $partNumber = $item['PartNumber'];
                $quantity = $item['product_quantity'];
                $price = $item['Price'] * $quantity; // Calculate the price for each item

                $insertItemSQL = "INSERT INTO OrderDetails (OrderID, PartNumber, Quantity, Price) VALUES (?, ?, ?, ?)";
                $itemStmt = $pdo->prepare($insertItemSQL);
                $itemStmt->execute([$orderID, $partNumber, $quantity, $price]);
            }

            $pdo->commit();

            // Set the session variables
            $_SESSION['orderID'] = $orderID; // Ensure this is the order ID
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['address'] = $address;
            $_SESSION['totalWeight'] = $totalWeight;
            $_SESSION['totalPrice'] = $totalCost;
            $_SESSION['orderDate'] = date('Y-m-d');
            $_SESSION['status'] = 'pending';

            // Clear the cart and set success messages
            $_SESSION['cart'] = array();
            $_SESSION['flash_message'] = "Order placed successfully";

            header("Location: thank_you.php");
            exit();

        } catch (PDOException $e) {
            $pdo->rollBack();
            // Handle the error, perhaps set a flash message to display the error
            $_SESSION['flash_message'] = "Error placing order: " . $e->getMessage();
            header("Location: checkout.php");
            exit();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="./style.css">
        <title>Dream Team Auto Parts Products</title>
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

        <div class="container text-center mt-3 pt-5">
        <h2>Checkout</h2>
        <hr class="mx-auto">
        </div>

        <div class="mx-auto container">
            <form id="checkout-form" method="POST" action="thank_you.php">
                <div class="form-group checkout-small-element">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Name" class="form-control">
                </div>
                <div class="form-group checkout-small-element">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="Email" class="form-control">
                </div>
                <div class="form-group checkout-small-element">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" placeholder="Address" class="form-control">
                </div>
                <div class="form-group checkout-small-element">
                    <label for="card">Credit Card Number</label>
                    <input type="text" id="card" name="card" placeholder="Credit Card Number" class="form-control">
                </div>
                <div class="form-group checkout-small-element">
                    <label for="exp">Expiration Date</label>
                    <input type="text" id="exp" name="exp" placeholder="Expiration Date" class="form-control">
                </div>
                <div>

                <p>Subtotal: $<?php echo isset($_SESSION['subtotal']) ? $_SESSION['subtotal'] : 0; ?></p>
                <p>Shipping & Handling Charge: $<?php echo isset($_SESSION['shipping_charge']) ? $_SESSION['shipping_charge'] : 0; ?></p>
                <p>Total Cost: $<?php echo isset($_SESSION['total']) ? $_SESSION['total'] : 0; ?></p>
                <p>Total Weight: <?php echo isset($_SESSION['total_weight']) ? $_SESSION['total_weight'] : 0; ?> lbs</p>
                <input type="submit" class="buy-btn" id="checkout" name="placeOrder" value="Place Order"/>
            </div>
            </form>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</html>