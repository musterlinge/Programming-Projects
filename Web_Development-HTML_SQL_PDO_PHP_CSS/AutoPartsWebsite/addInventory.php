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


<!----------------- IMPLEMENTING THE ADD INVENTORY CODE HERE --------------------------->
<body>
<?php
    $PartNum = "";
    include 'secrets.php';
    if (isset($_GET['newPartNumber']) || isset($_GET['PartNumber']) ) 	
    {
	
	$PartNum = $_GET["PartNumber"];
        $sql = "SELECT Inventory.PartNumber, Inventory.Name, Inventory.QuantityOnHand FROM Inventory WHERE PartNumber=?";
        $result = $pdo->prepare($sql);
        $result->bindParam(1, $PartNum);
        $result->execute();
        $inventoryInfo = $result->fetchAll(PDO::FETCH_ASSOC);
	
        function updateQuantity($Part, $quantity) {
          include 'secrets.php';
      
          // Start transaction
          $pdo->beginTransaction();
      
          try {
              // Update Inventory table
              $sql = "UPDATE Inventory SET QuantityOnHand = (QuantityOnHand + ?) WHERE PartNumber=?";	
              $result = $pdo->prepare($sql);
              $result->bindParam(1, $quantity);
              $result->bindParam(2, $Part);				
              $result->execute();
      
              // Update QuantityOnHand table
              $sql = "UPDATE QuantityOnHand SET Quantity = (Quantity + ?) WHERE PartNumber=?";	
              $result = $pdo->prepare($sql);
              $result->bindParam(1, $quantity);
              $result->bindParam(2, $Part);				
              $result->execute();
      
              // Commit transaction
              $pdo->commit();
      
              // Fetch new quantity from Inventory to display
              $sql = "SELECT QuantityOnHand FROM Inventory WHERE PartNumber=?";
              $result = $pdo->prepare($sql);
              $result->bindParam(1, $Part);
              $result->execute();
              $inventoryInfo = $result->fetch(PDO::FETCH_ASSOC);
      
              echo "New Quantity in Inventory: " . $inventoryInfo['QuantityOnHand'];
          } catch (Exception $e) {
              // Rollback transaction on error
              $pdo->rollBack();
              echo "Error updating inventory: " . $e->getMessage();
          }
      }



	if ($result->rowCount() > 0)
	{
		$Quantity = "";
		foreach($inventoryInfo as $rows)
		{
			echo "Part Number: ". $rows['PartNumber'];
			echo "<br>Part Name: ". $rows['Name'] . "<br>";
			echo "Quantity in Inventory: ". $rows['QuantityOnHand'];
    	 	}
		echo "<form action=\"addInventory.php\" method=\"GET\">";
 		echo "<label for=\"Quantity\" style=\"color: white;\">Input Quantity Being Added:</label>";
 		echo "<input type=\"text\" id=\"Quantity\" value='" . $Quantity . "' name=\"Quantity\" required>";
		echo "<input type=\"hidden\" name=\"PartNumber\" value='" . $PartNum . "'>";
		echo "<input type=\"submit\" name=\"newQuantity\" value=\"Update Quantity\">";
		echo "</form>";

		if (isset($_GET['Quantity']))
		{
			updateQuantity($PartNum, $_GET['Quantity']);
		}
		 

	}
	else
	{
		echo"Unable to locate the part number provided. Please try again.<br>";
	}


    }
?>



<form action="" method="GET">
 <label for="PartNumber" style="color: white;">Part Number:</label>
 <input type="text" id="PartNumber" value="<?php echo $PartNum;?>" name="PartNumber" required>
<input type="submit" name="newPartNumber" formaction="addInventory.php" value="View Part Number">
</form>


</body>
</html>