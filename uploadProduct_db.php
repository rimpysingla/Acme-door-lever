<!-- 
Page Name: uploadProduct_db.php 
Date: 29-10-2024 
Author: Rimpy Singla 
Purpose: This PHP script connects to a MySQL database as the root user, selects the database that already exists and adds the product details to the products table existed. It handles errors or success messages accordingly.
-->


<?php

	mysqli_report(MYSQLI_REPORT_OFF);

	error_reporting(0);

	// make the connection with database

	$conn = mysqli_connect("localhost", "root", "");

	if (!$conn) 

	{

		echo "The connection has failed: " . mysqli_connect_error();

	}

	else 

	{

		// no need to create the database and the table, as we already created that

		// Select the database acme to add the product details in the products table
		
		if (!mysqli_select_db($conn,"acme")) {

			echo "<p>Could not open the database: " . mysqli_error($conn)."</p>";	
		}

		else {

			// Insert product details in the products table
			// we can use variable name from uploadProduct.php file here because we include this file in it.

			$insert = "INSERT INTO products (prodName, prodFinish, prodUsage, prodImageUrl, prodCost) VALUES ('$_POST[prodName]','$_POST[prodFinish]', '$_POST[prodUsage]', '$imageLocation', '$_POST[prodCost]');";

			if (mysqli_query($conn,$insert)) {

				//update successful, retrieve the auto id - product id from the database with the mysqli_insert_id command

				$prodID = mysqli_insert_id($conn);

				//Here, the 'prodID' cookie is set with the value $prodID for 60 seconds.
				setcookie("prodID",$prodID,time()+60);

				//Here, the 'imageLocation' cookie is set with the value $imageLocation for 60 seconds.
				setcookie("imageLocation",$imageLocation,time()+60);


				//This will only show if we comment out the header('Location: uploadProductSuccess.php');
				// echo "<p>Product ID is: $prodID</p>";
				// echo "<p><img src='$imageLocation' height='300' width='400' alt='Image of the uploaded product'></p>";

				$generalErrorMessage = "";
				/* redirects to the uploadProductSuccess.php where the confirmation is displayed. */
				header('Location: uploadProductSuccess.php');
				exit();

			}

			else {
				$generalErrorMessage = "Failed to add the data in the database";
				echo "Insert query failed: " . mysqli_error($conn);

			}

		}

	}

	//Close the connection

	mysqli_close($conn);

?>
