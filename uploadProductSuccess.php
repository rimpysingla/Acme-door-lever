<!-- 
Page Name: uploadProductSuccess.php 
Date: 29-10-2024 
Author: Rimpy Singla 
Purpose: This code creates an HTML form for showing the success message of the product have been successfully added to the database. This code also retrieves the cookie value named prodID in to the local $prodID variable and then showing the product ID to the user.
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
	}

	if(isset($_COOKIE['imageLocation']))
	{
		// if cookie exists then $imageLocation variable will set with the cookie (imageLocation) value
		$imageLocation = $_COOKIE['imageLocation'] ;
	}
	else 
	{
		// otherwise $imageLocation set as blank value.
		$imageLocation = "";
	}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="UTF-8">
	    <title>Product Details Uploaded Confirmation</title>
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
	                    <p>Product details successfully added to the database.</p>

	                    <?php if ($prodID): ?>
	                        <p>The product ID for this product is: <?php echo htmlspecialchars($prodID); ?></p>
	                    <?php endif; ?>

	                    <?php if ($imageLocation): ?>
	                        <p><img src="<?php echo htmlspecialchars($imageLocation); ?>" height="300" width="400" alt="Image of the uploaded product"></p>
	                    <?php endif; ?>
	                </div>
	            </div>
	        </div>
	    </div>
	</body>
</html>
