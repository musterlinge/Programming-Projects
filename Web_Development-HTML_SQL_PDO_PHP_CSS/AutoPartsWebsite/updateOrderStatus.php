<!DOCTYPE html>
<html lang="en">

<!-----------------------------Main Navigation Header------------------------------>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="./style.css">
  <title>Dream Team Auto View Inventory </title>
</head>
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
<!-----------------------------Workstation Navigation Header------------------------------>
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

<!----------------- IMPLEMENTING THE UPDATE STATUS CODE HERE --------------------------->
<body>

<?php
    $OrderNum = "";
    include 'secrets.php';

    if (isset($_GET['newOrderNumber']) || isset($_GET['OrderNumber'])) 	
    {

  function updateStatus($order) {
    include 'secrets.php';

    try {
        $pdo->beginTransaction();

        // Retrieve order items and quantities
        $sql = "SELECT PartNumber, Quantity FROM OrderDetails WHERE OrderID=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$order]);
        $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Update Inventory for each item in the order
        foreach ($orderDetails as $item) {
            $updateInventorySQL = "UPDATE Inventory SET QuantityOnHand = QuantityOnHand - ? WHERE PartNumber=?";
            $updateStmt = $pdo->prepare($updateInventorySQL);
            $updateStmt->execute([$item['Quantity'], $item['PartNumber']]);

            // Update QuantityOnHand
            $updateQuantityOnHandSQL = "UPDATE QuantityOnHand SET Quantity = Quantity - ? WHERE PartNumber=?";
            $updateQuantityStmt = $pdo->prepare($updateQuantityOnHandSQL);
            $updateQuantityStmt->execute([$item['Quantity'], $item['PartNumber']]);
        }

        // Update the order status
        $updateOrderSQL = "UPDATE Orders SET Status='shipped' WHERE OrderID=?";
        $updateOrderStmt = $pdo->prepare($updateOrderSQL);
        $updateOrderStmt->execute([$order]);

        $pdo->commit();
        echo "<br>Updated Successfully.<br>";
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "<br>Error updating this order number. Please check the order number and try again.<br>";
    }
}
	
	$OrderNum = $_GET["OrderNumber"];
        $sql = "SELECT Orders.OrderID, Orders.Status FROM Orders WHERE OrderID=?";
        $result = $pdo->prepare($sql);
        $result->bindParam(1, $_GET['OrderNumber']);
        $result->execute();
        $orderInfo = $result->fetchAll(PDO::FETCH_ASSOC);
	
	if ($result->rowCount() > 0)
	{
		foreach($orderInfo as $rows)
		{
			echo "Order Number: ". $rows['OrderID'];
			echo "<br>Current Status: ". $rows['Status'] . "<br>";
    	 	}
	
		if (isset($_GET['update']))
		{
			updateStatus($OrderNum);
		}
		echo "<form action=\"updateOrderStatus.php?update=true\" method=\"GET\">";
		echo"<br><input type=\"submit\" name=\"update\" value=\"Update Status to Shipped\"><br>";
		echo "<input type=\"hidden\" id=\"OrderNumber\" name=\"OrderNumber\" value='" . $OrderNum . "'>";
		echo "</form>";
		
	}
	else
	{
		echo"Unable to locate the order number provided. Please try again or return to the main Warehouse page to 		view the current orders pending shipment.<br>";
	}
}
	
?>
<br>



<!---------Form that will send the order number to the corresponding selection---->


<form action="" method="GET">
 <label for="orderID" style="color: white;">Order Number:</label>
 <input type="text" id="OrderNumber" value="<?php echo $OrderNum;?>" name="OrderNumber" required>
<input type="submit" name="newOrderNumber" formaction="updateOrderStatus.php" value="View New Order Number">
<br> <br>
<input type="submit" name="printPacking" formaction="printPacking.php" value="Print Packing List">
<input type="submit" name="printInvoice" formaction="printInvoice.php" value="Print Invoice">
<input type="submit" name="printShippingLabel" formaction="printShipping.php" value="Print Shipping Label">
<input type="submit" name="updateOrderStatus" formaction="updateOrderStatus.php" value="Update Order Status">
</form>

</body>
</html>