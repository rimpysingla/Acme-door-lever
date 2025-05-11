<!-- 
Page Name: deleteProductSuccess.php 
Date: 04-11-2024 
Author: Rimpy Singla 
Purpose: This code creates an HTML form for showing the success message of the product have been successfully deleted from the database. This code also retrieves the cookie value named prodID in to the local $prodID variable and then showing the deleted product ID to the user.
-->

<?php
	
	// code to suppress error messages to the end user 
	mysqli_report(MYSQLI_REPORT_OFF);
	error_reporting(0);

	// Here, I am retrieving the cookie. The isset() function determines if the cookie has been set or not.

	if(isset($_COOKIE['prodID']))
	{
		// if cookie exists then $prodID variable will set with the cookie (prodID) value
		$prodID = $_COOKIE['prodID'] ;
	}
	else 
	{
		// otherwise $prodID set as blank value.
		$prodID = "";
		exit();
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Deleted Confirmation</title>
    <link rel="stylesheet" type="text/css" href="css/myStyle.css">
</head>
<body class="product-added-confirmation-page product-container">
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
                <div class="content-section">
                	<p>Product ID <?php echo htmlspecialchars($prodID) ?> successfully deleted from the database.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
