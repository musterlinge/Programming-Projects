<?php
session_start();

// Check for a flash message and store it in a variable
$flashMessage = '';
if(isset($_SESSION['flash_message'])) {
    $flashMessage = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']); // Clear the message so it's only shown once
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

    <section id="prod" class="my-5 pb5">
    <div class="prod-container text-center mt-5 py-5">
      <h1 class="text-light">Products</h1>
      <hr>
    </div>
    <div class="row text-light mx-auto container-fluid">
      <?php
        include 'secrets.php';
        $sql = "SELECT products.PartNumber, products.PictureLink AS PL, products.Name, products.Description, products.Price, products.Weight, quantityonhand.Quantity as Quantity FROM products
        INNER JOIN quantityonhand ON products.PartNumber = quantityonhand.PartNumber";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        foreach($result as $row) {
        echo "<div class='product text-center col-lg-3 col-md-4 col-sm-12'>";
        echo "<img class='same-size-images' src='images/" . $row['PL'] . "' alt='Product Image'>";
        echo "<h5 class='p-name'>" . $row['Name'] . "</h5>";
        echo "<h6 class='p-quantity'>" . $row['Description'] . "</h6>";
        echo "<h4 class='p-price'>$" . $row['Price'] . "</h4>";
        echo "<h6 class='p-quantity'>Available Quantity: " . $row['Quantity'] . "</h6>";
?>
        <!-- Add to Cart Form -->
        <form method='post' action='cart.php' class='form-group'>
            <input type='hidden' name='PartNumber' value='<?php echo $row['PartNumber']; ?>'>
            <input type='hidden' name='Name' value='<?php echo $row['Name']; ?>'>
            <input type='hidden' name='Price' value='<?php echo $row['Price']; ?>'>
            <input type='hidden' name='PictureLink' value='<?php echo $row['PL']; ?>'>
            <input type='hidden' name='Weight' value='<?php echo $row['Weight']; ?>'>
            <input type='number' name='product_quantity' class='small-input' value='1' min='1'>
            <button class='add-to-cart-btn' type='submit' name='add_to_cart'>Add to Cart</button>
        </form>
<?php
        echo "</div>";
    }
?>
        </div>
    </section>

     <!-- View Cart Button Section -->
  <section class="view-cart-section text-center my-5">
    <a href="cart.php"><button class="btn btn-primary">View Cart</button></a>
  </section>

    <footer>
      <div class="footer">
        <p class="footer-text">Copyright © Dream Team Auto Parts 2023</p>
      </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>

<?php if ($flashMessage): ?>
    <div class="alert alert-success" role="alert">
        <?php echo $flashMessage; ?>
    </div>
<?php endif; ?>