<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="./style.css">
  <style>
  /* Add CSS styles for table */
  table {
    width: 100%;
    border-collapse: collapse;
  }

  th, td {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
    background-color: #f2f2f2;
  }

  /* Add the new CSS rule for the Status column */
  #order-table th:nth-child(6),
  #order-table td:nth-child(6) {
    color: black;
  }
</style>
  <title>Dream Team Auto View Inventory</title>
</head>
<body>
  <!-- Main Navigation Header -->
  <header class="main-header">
    <div class="logo-container">
      <img class="logoImage" src="images/logo.PNG" alt="Logo"> <!-- IF IMAGE DOES NOT LOAD, EITHER ADD OR REMOVE SLASH FROM images -->
    </div>
    <nav class="nav-menu">
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="product.php">Products</a></li>
        <li><a href="login.php">Sign in</a></li>
      </ul>
    </nav>
  </header>

  <!-- Workstation Navigation Header -->
  <div class="workstationNav">
    <ul>
      <li class="workstationDrop">
        <a href="warehouse.php" class="workstationButton">Warehouse</a>
        <div class="workDropContent">
          <a href="printPacking.php">Print Packing List</a>
          <a href="printInvoice.php">Print Invoice</a>
          <a href="printShipping.php">Print Shipping Labels</a>
          <a href="updateOrderStatus.php">Update Order Status</a>
        </div>
      </li>
      <li class="workstationDrop">
        <a href="admin-login.html" class="workstationButton">Administrative</a>
        <div class="workDropContent">
          <a href="admin-login.html">Sign In</a>
        </div>
      </li>
      <li class="workstationDrop">
        <a href="receiving.php" class="workstationButton">Receiving</a>
        <div class="workDropContent">
          <a href="viewInventory.php">View Inventory</a>
          <a href="addInventory.php">Add Inventory</a>
        </div>
      </li>
    </ul>
  </div>

  <!-- Administrative Interface -->
  <h2 style="color: white;">Administrative Interface</h2>

  <!-- Set Shipping and Handling Charges Form -->
  <form id="shipping-form" method="post" action="admin.php">
  <h3 style="color: white;">Set Shipping and Handling Charges</h3>
  <label for="weight-bracket" style="color: white;">Weight Bracket:</label>
  <input type="text" id="weight-bracket" name="weight-bracket" required>
  <label for="charge" style="color: white;">Charge:</label>
  <input type="text" id="charge" name="charge" required>
  <button type="submit" name="setCharge">Set Charge</button>
  <!-- Add a div to display the success message -->
  <div id="success-message" style="color: white;"></div>
</form>
<hr>

  <!-- View Orders Form -->
  <h3 style="color: white;">View Orders</h3>
  <form method="post" action="admin.php">
    <label for="date-range" style="color: white;">Date Range:</label>
    <input type="date" id="start-date" name="start-date">
    <input type="date" id="end-date" name="end-date">
    <label for="order-status" style="color: white;">Order Status:</label>
    <select id="order-status" name="order-status">
      <option value="pending">Pending</option>
      <option value="shipped">Shipped</option>
    </select>
    <label for="price-range" style="color: white;">Price Range:</label>
    <input type="text" id="min-price" name="min-price" placeholder="Min Price">
    <input type="text" id="max-price" name="max-price" placeholder="Max Price">
    <button type="submit" name="searchOrders">Search Orders</button>
  </form>

  <!-- Order Details Table -->
  <table id="order-table">
    <thead>
      <tr>
        <th>Order ID</th>
        <th>Customer ID</th>
        <th>Total Weight</th>
        <th>Total Price</th>
        <th>Date</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php
        include 'secrets.php';
        $orders = []; // Initialize $orders as an empty array
        try {
          if (isset($_POST['setCharge'])) {
            // Handle editing shipping and handling charges
            $weightBracket = $_POST['weight-bracket'];
            $charge = $_POST['charge'];
          
            // Check if the weight bracket exists in the database
            $checkSql = "SELECT * FROM ShippingHandlingCharges WHERE WeightBracket = :weightBracket";
            $checkStmt = $pdo->prepare($checkSql);
            $checkStmt->execute([':weightBracket' => $weightBracket]);
            $existingCharge = $checkStmt->fetch(PDO::FETCH_ASSOC);
          
            if ($existingCharge) {
              // Update the charge if the weight bracket exists
              $updateSql = "UPDATE ShippingHandlingCharges SET Charge = :charge WHERE WeightBracket = :weightBracket";
              $updateStmt = $pdo->prepare($updateSql);
              $updateStmt->execute([':charge' => $charge, ':weightBracket' => $weightBracket]);
              echo "<script>document.getElementById('success-message').textContent = 'Charge for weight bracket $weightBracket updated successfully.';</script>";
            } else {
              // Insert a new charge if the weight bracket does not exist
              $insertSql = "INSERT INTO ShippingHandlingCharges (WeightBracket, Charge) VALUES (:weightBracket, :charge)";
              $insertStmt = $pdo->prepare($insertSql);
              $insertStmt->execute([':weightBracket' => $weightBracket, ':charge' => $charge]);
              echo "<script>document.getElementById('success-message').textContent = 'Charge for weight bracket $weightBracket added successfully.';</script>";
            }
          }

          if (isset($_POST['searchOrders'])) {
            // Handle searching for orders based on criteria
            $queryParams = [];
            $sql = "SELECT OrderID, CustomerID, TotalWeight, TotalPrice, Date, Status FROM Orders WHERE 1=1";
            if (!empty($_POST['start-date']) && !empty($_POST['end-date'])) {
              $sql .= " AND Date BETWEEN :startDate AND :endDate";
              $queryParams[':startDate'] = $_POST['start-date'];
              $queryParams[':endDate'] = $_POST['end-date'];
            }
            if (!empty($_POST['order-status'])) {
              $sql .= " AND Status = :orderStatus";
              $queryParams[':orderStatus'] = $_POST['order-status'];
            }
            if (!empty($_POST['min-price']) && !empty($_POST['max-price'])) {
              $sql .= " AND TotalPrice BETWEEN :minPrice AND :maxPrice";
              $queryParams[':minPrice'] = $_POST['min-price'];
              $queryParams[':maxPrice'] = $_POST['max-price'];
            }
            $stmt = $pdo->prepare($sql);
            $stmt->execute($queryParams);
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
          }
        } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
        }
        // PHP code to fetch and display order details from the database
        // You should replace this with your actual database query and loop
        // Here is a simplified example of how you can display orders:
        foreach ($orders as $order) {
          echo "<tr>";
          echo "<td>{$order['OrderID']}</td>";
          echo "<td>{$order['CustomerID']}</td>";
          echo "<td>{$order['TotalWeight']}</td>";
          echo "<td>{$order['TotalPrice']}</td>";
          echo "<td>{$order['Date']}</td>";
          echo "<td>{$order['Status']}</td>";
          echo "</tr>";
        }
      ?>
    </tbody>
  </table>

  <script>
    // JavaScript functions to handle administrative tasks
    function setShippingCharge() {
      // Implement logic to set shipping and handling charges here
      const weightBracket = document.getElementById("weight-bracket").value;
      const charge = document.getElementById("charge").value;
      // Add logic to send this data to the server or update it as needed
      console.log(`Set charge for weight bracket ${weightBracket} to ${charge}`);
    }

    function searchOrders() {
      // Implement logic to search orders based on date range, status, or price range
      const startDate = document.getElementById("start-date").value;
      const endDate = document.getElementById("end-date").value;
      const orderStatus = document.getElementById("order-status").value;
      const minPrice = document.getElementById("min-price").value;
      const maxPrice = document.getElementById("max-price").value;
      // Add logic to fetch orders from the server based on the selected criteria
      // Update the order-table with the retrieved data
      console.log("Search orders based on the selected criteria");
    }
  </script>

<script>
  function showNotification(message) {
    if ('Notification' in window) {
      Notification.requestPermission().then(function (permission) {
        if (permission === 'granted') {
          new Notification(message);
        }
      });
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    <?php
    if (isset($_POST['setCharge'])) {
      echo "var response = " . json_encode($response) . ";";
      echo "if (response.success) {";
      echo "  showNotification('Charge for weight bracket $weightBracket updated successfully.');";
      echo "}";
    }
    ?>
  });
</script>


</body>
</html>
