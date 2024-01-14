<?php
session_start();
include 'secrets.php'; // Include the database connection settings

// Initialize flash message
$flashMessage = isset($_SESSION['flash_message']) ? $_SESSION['flash_message'] : '';
unset($_SESSION['flash_message']); // Clear the flash message after use


// Function to get shipping charge based on weight
function getShippingCharge($weight, $pdo) {
    $bracket = ceil($weight / 25); // Determine the weight bracket
    $bracket = min($bracket, 5); // Limit the bracket to 5

    $stmt = $pdo->prepare("SELECT Charge FROM ShippingHandlingCharges WHERE WeightBracket = ?");
    $stmt->execute([$bracket]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result ? $result['Charge'] : 0;
}

// Function to calculate subtotal and total weight
function calculateTotalsAndWeights($pdo) {
    $subtotal = 0;
    $totalWeight = 0.0;
    foreach ($_SESSION['cart'] as $item) {
        $subtotal += $item['Price'] * $item['product_quantity'];
        $totalWeight += $item['Weight'] * $item['product_quantity'];
    }
    $_SESSION['subtotal'] = $subtotal;
    $_SESSION['total_weight'] = $totalWeight;
    $_SESSION['shipping_charge'] = getShippingCharge($totalWeight, $pdo);
    $_SESSION['total'] = $subtotal + $_SESSION['shipping_charge'];
}

// Initialize session cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Add product to cart
if (isset($_POST['add_to_cart'])) 
{
    $item_array = array(
        'PartNumber' => $_POST['PartNumber'],
        'Name' => $_POST['Name'],
        'Price' => $_POST['Price'],
        'PictureLink' => $_POST['PictureLink'],
        'product_quantity' => $_POST['product_quantity'],
        'Weight' => $_POST['Weight']
    );

    $found = false;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => &$value) {
            if ($value['PartNumber'] == $_POST['PartNumber']) {
                $value['product_quantity'] += $_POST['product_quantity'];
                $found = true;
                break;
            }
        }
        if (!$found) {
            $_SESSION['cart'][] = $item_array;
        }
    } else {
        $_SESSION['cart'] = array($item_array);
    }

    calculateTotalsAndWeights($pdo); // Recalculate subtotal and weight
    $_SESSION['flash_message'] = "Item(s) added to cart";
    header("Location: product.php");
    exit();
}

// Remove product from cart
if (isset($_POST['removeProduct'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value['PartNumber'] == $_POST['PartNumber']) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
            $_SESSION['flash_message'] = "Item removed from cart";
            break;
        }
    }
    calculateTotalsAndWeights($pdo); // Recalculate subtotal and weight
    $_SESSION['flash_message'] = "Item removed from cart";
    header("Location: cart.php"); // Redirect to refresh the page and update the cart
    exit();
}

// Update product quantity
if (isset($_POST['update_quantity'])) {
    foreach ($_SESSION['cart'] as $key => &$value) {
        if ($value['PartNumber'] == $_POST['PartNumber']) {
            $value['product_quantity'] = $_POST['product_quantity'];
            $_SESSION['flash_message'] = "Cart updated";
            break;
        }
    }
    calculateTotalsAndWeights($pdo); // Recalculate subtotal and weight
    $_SESSION['flash_message'] = "Cart updated";
    header("Location: cart.php"); // Redirect to refresh the page and update the cart
    exit();
}

// Always calculate total and weight when the cart is updated
calculateTotalsAndWeights($pdo);
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


    <section class="cart container my-5 py-5">
    <div class="container mt-5">
        <h2>Your Cart</h2>
        <hr>
        <!-- Display flash message if set -->
        <?php if (!empty($flashMessage)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $flashMessage; ?>
            </div>
        <?php endif; ?>
    </div>

    <table class="mt-5 pt-5">
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Subtotal</th>
            <th>Total Weight</th>
        </tr>
        

        <?php foreach($_SESSION['cart'] as $key => $value): 
            $itemTotalPrice = $value['Price'] * $value['product_quantity'];
            $itemTotalWeight = $value['Weight'] * $value['product_quantity'];
        ?>
        <tr>
            <td>
                <div class="product-info">
                    <img class="same-size-images" src="images/<?php echo $value['PictureLink'];?>" alt="<?php echo $value['Name'];?>">
                    <p><?php echo $value['Name'];?><br> Price: $<?php echo $value['Price'];?><br>
                    <form method="POST" action="cart.php">
                        <input type="hidden" name="PartNumber" value="<?php echo $value['PartNumber'];?>">
                        <input class="remove-btn" type="submit" name="removeProduct" value="Remove">
                    </form>
                    </p>
                </div>
            </td>
            <td>
                <!-- Update Quantity Form -->
                <form method="POST" action="cart.php">
                    <input type="hidden" name="PartNumber" value="<?php echo $value['PartNumber'];?>">
                    <input type="number" name="product_quantity" value="<?php echo $value['product_quantity'];?>" min="0">
                    <input type="submit" name="update_quantity" value="Edit">
                </form>
            </td>
            <!-- Display the total weight for each item -->
            <td class="wheat-color">$<?php echo number_format($itemTotalPrice, 2); ?></td>
            <td><?php echo $itemTotalWeight; ?> lbs</td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="cart-total">
        <table>
            <tr>
                <td class="wheat-color">Subtotal</td>
                <td class="wheat-color">$<?php echo $_SESSION['subtotal']; ?></td>
            </tr>
            <tr>
                <td class="wheat-color">Total Weight</td>
                <td class="wheat-color"><?php echo $_SESSION['total_weight']; ?> lbs</td>
            </tr>
            <tr>
                <td class="wheat-color">Shipping & Handling Charge</td>
                <td class="wheat-color">$<?php echo $_SESSION['shipping_charge']; ?></td>
            </tr>
            <tr>
                <td class="wheat-color">Total</td>
                <td class="wheat-color">$<?php echo $_SESSION['total']; ?></td>
            </tr>
        </table>
    </div>

        <div class="checkout-container">
        <form method="POST" action="checkout.php" style="display: inline;">
            <input class="btn add-to-cart-btn" type="submit" value="Checkout" name="checkout">
        </form>
        <!-- Back to Products button -->
        <a href="product.php" class="btn add-to-cart-btn" style="background-color: #ccc;">Back to Products</a>
    </div>

    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
