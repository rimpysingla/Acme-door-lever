<!-- 
Page Name: deleteProduct_db.php 
Date: 04-11-2024 
Author: Rimpy Singla 
Purpose: This PHP script connects to a MySQL database as the root user, selects the database that already exists and delete the product from the products table in the acme database. It handles errors or success messages accordingly.
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
		// Delete the product from the products table in the 'acme' database
		$query = "DELETE FROM products WHERE id= ".$prodID;
		$results = mysqli_query($conn,$query);

		// The mysqli_affected_rows($conn) command will return the number of rows affected. If this is zero, then the product id was not found.
		$numRowsAffected = mysqli_affected_rows($conn);
		if (!$results)
		{
			// echo "<p>Error deleting product from the products table: " . mysqli_error($conn) . "</p>";
			$generalErrorMessage = "Product not deleted from the table!";
		}
		else 
		{
			if ($numRowsAffected == 0) 
			{
				$generalErrorMessage = "Product ID could not be found in the table!";
			}
			else 		
			{		

				//Here, the 'prodID' cookie is set with the value $prodID for 60 seconds.
				setcookie("prodID",$prodID,time()+60);

				$generalErrorMessage = "";
			}
		}
	}
		
	//Close the connection
	mysqli_close($conn);
?>
