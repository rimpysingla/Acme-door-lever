<!-- 
Page Name: updateProductSuccess.php 
Date: 03-11-2024
Author: Rimpy Singla 
Purpose: This code creates an HTML form for showing the success message of the product cost have been successfully updated to the database. This code also retrieves the cookie value named prodID in to the local $prodID variable and then showing the product details to the user.
-->				

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Cost Update Success</title>
    <link rel="stylesheet" type="text/css" href="css/myStyle.css">
</head>
<body class="product-container success-product-container">

	<?php
		
		// code to suppress error messages to the end user 
		mysqli_report(MYSQLI_REPORT_OFF);
		error_reporting(0);

		// Here, I am retrieving the cookie. The isset() function determines if the cookie has been set or not.

		if(isset($_COOKIE['updatedProdID']))
		{
			// if cookie exists then $prodID variable will set with the cookie (updatedProdID) value
			$prodID = (int) $_COOKIE['updatedProdID'] ;
		}
		else 
		{
			// otherwise $prodID set as blank value.
			$prodID = "";
		}

		if($prodID) {

			// connect to mysql and acme database as a root user
			$conn = @mysqli_connect("localhost:3306","root","","acme");

			// Check connection
			if (mysqli_connect_errno())
			{
				echo "<p>Failed to connect to MySQL and the acme database: " . mysqli_connect_error() . "</p>";	
				exit();
			}
			else
			{

				// Fetch the product details using the stored product ID
				$query = "SELECT * FROM products WHERE id=".$prodID;
				$results = mysqli_query($conn,$query);
				if ($results) 
				{
					$numRecords=mysqli_num_rows($results);
					if ($numRecords != 0)
					{
						//get the product details
						$product = mysqli_fetch_assoc($results);
						
					}
					else
					{
						echo "<p>Product not found in the table!</p>";
						$numRecords = 0; // Indicate no product was found
					}
				}
				else
				{
					echo "<p>Product not found in the table!</p>";
					$numRecords = 0; // Indicate no product was found
				}
			}
			// Clear session data after fetching the details
			mysqli_close($conn);
		}
	?>

	<div class="overlay-layer"></div>
    <div class="container">
        <div class="inner-div">
            <h1 class="page-title">Door Lever Inventory</h1>
            <div class="nav-container">
			    <ul class="nav-bar">
			        <li><a href="uploadProduct.php" class="nav-link">Add Product</a></li>
			        <li><a href="updateProduct.php" class="nav-link">Update Product</a></li>
			        <li><a href="deleteProduct.php" class="nav-link">Delete Product</a></li>
			    </ul>
			</div>
            <div class="product-content-section">
                <p>Product cost successfully updated.</p><br/>
                <?php if ($numRecords > 0): ?>
	                <!-- Display the full product details -->
	                <p><strong>Product ID:</strong> <?php echo htmlspecialchars($product['id']); ?></p><br>
	                <p><strong>Product Name:</strong> <?php echo htmlspecialchars($product['prodName']); ?></p><br>
	                <p><strong>Product Finish:</strong> <?php echo htmlspecialchars($product['prodFinish']); ?></p><br>
	                <p><strong>Product Usage:</strong> <?php echo htmlspecialchars($product['prodUsage']); ?></p><br>
	                <p><strong>Product Cost:</strong> $<?php echo htmlspecialchars(number_format($product['prodCost'], 2)); ?></p>
	            <?php endif; ?>
                
            </div>
        </div>
    </div>
</body>
</html>


