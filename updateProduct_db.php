<!-- 
Page Name: updateProduct_db.php 
Date: 03-11-2024 
Author: Rimpy Singla 
Purpose: This PHP script connects to a MySQL database as the root user, selects the database that already exists and adds the product updated cost to the products table. It handles errors or success messages accordingly.
-->

<?php
	// code to suppress error messages to the end user 
	mysqli_report(MYSQLI_REPORT_OFF);
	error_reporting(0);

	// connect to mysql and acme database as a root user
	$conn = @mysqli_connect("localhost:3306","root","","acme");

	// Check connection
	if (mysqli_connect_errno())
	{
		echo "<p>Failed to connect to MySQL and the acme database: " . mysqli_connect_error() . "</p>";
	}
	else
	{

		// Update the product cost in the products table in the 'acme' database
		$query = "UPDATE products SET prodCost ='".$prodUpdatedCost."' WHERE id= ".$prodID;
		$results = mysqli_query($conn,$query);

		// The mysqli_affected_rows($conn) command will return the number of rows updated. If this is zero, then the product id was not found.
		$numRowsAffected = mysqli_affected_rows($conn);
		if (!$results)
		{
			// echo "<p>Error updating product cost: " . mysqli_error($conn) . "</p>";
			$generalErrorMessage = "Error in updating product cost.";
		}
		else 
		{
			if ($numRowsAffected == 0) 
			{
				// This is because updated product cost could be same as the existing value for product ID
				$checkQuery = "SELECT * FROM products WHERE id= " .$prodID;
            	$checkResult = mysqli_query($conn, $checkQuery);

            	if (mysqli_num_rows($checkResult) > 0) {
                	$generalErrorMessage = "Product cost was not updated because it is the same as the existing value.";
            	} else {
                	$generalErrorMessage = "Product not found in the database.";
            	}
			}
			else 		
			{		
				//Here, the 'prodID' cookie is set with the value $prodID for 60 seconds.
				setcookie("updatedProdID",$prodID,time()+60);

				$generalErrorMessage = "";
				
			}
		}
	}
		
	//Close the connection
	mysqli_close($conn);
?>
