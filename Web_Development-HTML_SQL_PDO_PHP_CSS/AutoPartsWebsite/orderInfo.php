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


<!----------------- IMPLEMENTING THE ORDER INFO CODE HERE --------------------------->

<!---------CREATE ORDER OVERVIEW--------------->
<body>
<?php
    $OrderNum = "";
    include 'secrets.php';

    if (isset($_GET['newOrderNumber']) || isset($_GET['OrderNumber'])) 
    {
	$OrderNum = $_GET["OrderNumber"];
        $sql = "SELECT products.Name, orderdetails.PartNumber, orderdetails.Quantity FROM orderdetails LEFT JOIN products ON orderdetails.PartNumber=products.PartNumber WHERE OrderID=?";
        $result = $pdo->prepare($sql);
        $result->bindParam(1, $_GET['OrderNumber']);
        $result->execute();
        $orderInfo = $result->fetchAll(PDO::FETCH_ASSOC);

    	echo "Order Number: " . $OrderNum;

	
	echo '<table border=3px solid black, style="background-color:white; border-color:black;">';
	echo "<tr>";
	echo '<th style="background-color:black; color:white;">Product Name</th>';
	echo '<th style="background-color:black; color:white;">Product Number</th>';
	echo '<th style="background-color:black; color:white;">Quantity</th>';
	echo "</tr>";

	foreach($orderInfo as $rows)
	{

	 echo "<tr>";

		echo "<td>". $rows['Name'] . "</td>";
		echo "<td>". $rows['PartNumber'] . "</td>";
		echo "<td>". $rows['Quantity'] . "</td>";	 
	  echo "</tr>";
    	  }
       echo "</table>";  
   }
?>


<br>

<!---------Form that will send the order number to the corresponding selection---->

<form action="" method="GET">
 <label for="orderID" style="color: white;">Order Number:</label>
 <input type="text" id="OrderNumber" value="<?php echo $OrderNum;?>" name="OrderNumber" required>
<input type="submit" name="newOrderNumber" formaction="orderInfo.php" value="View New Order Number">
<br> <br>
<input type="submit" name="printPacking" formaction="printPacking.php" value="Print Packing List">
<input type="submit" name="printInvoice" formaction="printInvoice.php" value="Print Invoice">
<input type="submit" name="printShippingLabel" formaction="printShipping.php" value="Print Shipping Label">
<input type="submit" name="updateOrderStatus" formaction="updateOrderStatus.php" value="Update Order Status">
</form>

</body>
</html>