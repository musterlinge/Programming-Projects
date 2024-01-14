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

<!----------------- IMPLEMENTING THE WAREHOUSE CODE HERE --------------------------->

<h1 style="color:white;">Current Orders Awaiting Shipment:</h1>
<body>

<!----Print table of current orders that need to be shipped---->
 <?php
          include 'secrets.php';
	  $sql = "SELECT Orders.OrderID FROM Orders Where Orders.Status ='pending'";
	  $result = $pdo->prepare($sql);
	  $result->execute();
	  $orderTableInfo = $result->fetchAll(PDO::FETCH_ASSOC);
	  drawTable($orderTableInfo);

	 function drawTable($rows)
	{
		echo '<table border=3px solid black, style="background-color:white; border-color:black;">';
		echo "<tr>";
		echo '<th style="background-color:black; color:white;">Order ID</th>';
		echo "</tr>";
 		foreach($rows as $row)
 		{
		    echo "<tr>";
	            echo "<td><a href='printPacking.php?OrderNumber=".$row['OrderID']."'".">" . $row['OrderID'] . "</a></td>";
		    echo "</tr>";	
	 
 		}
	    	echo "</table>";
	}
 ?>

</body>
</html>