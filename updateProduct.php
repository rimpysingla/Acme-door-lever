<!-- 
Page Name: updateProduct.php 
Date: 03-11-2024 
Author: Rimpy Singla 
Purpose: This code creates an HTML form for updating product cost of a specific product in the 'acme' database 'products' table. It uses PHP to validate user input, ensuring that fields are not left blank and should be a numeric value. This script ensures that the product new cost must be in a range between 20-200. The code handles both submission and reset functionality.
-->

<!DOCTYPE html>
		<html lang="en">
		
		<head>
			<meta charset="UTF-8">
			<title>Update Product Form</title>
			<link rel="stylesheet" type="text/css" href="css/myStyle.css">
		</head>

		<body class="product-container update-product-container">
		<?php
			// code to suppress error messages to the end user 

			mysqli_report(MYSQLI_REPORT_OFF);

			error_reporting(0);

			$prodID = ""; $prodUpdatedCost = "";
			$prodIDErr ="";$prodUpdatedCostErr = "";
			$generalErrorMessage = "";
			$invalidData = false;

			// This code will run if Submit button is pressed
		
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				
				// if reset button is pressed, it will reset the form

				if(isset($_POST["reset"])){
					header("Refresh:0");
					echo "RESET";
					exit();
				}

				// The sanitized input returned by the checkInput()
				
				$prodID = checkInput($_POST["prodID"]);
				$prodUpdatedCost = checkInput($_POST["prodUpdatedCost"]);

				// Check if the product ID is blank, set the product ID error field accordingly
				if($prodID == "")  {
					$prodIDErr ="Product ID must not be blank";
					$invalidData = true;
				}
				elseif (!is_numeric($prodID)){
					$prodIDErr="Product ID must be numeric only";
					$invalidData = true;
				}
				
				// Check if the product updated cost is blank or not
				if ($prodUpdatedCost == ""){
					$prodUpdatedCostErr ="Product cost must not be blank";
					$invalidData = true;
				}
				// Check if the product cost is numeric or not
				elseif (!is_numeric($prodUpdatedCost)){
					$prodUpdatedCostErr = "Product cost must be numeric only";
					$invalidData = true;
				}
				// Check if the product new cost must be between 20 and 200
				elseif ($prodUpdatedCost < 20 || $prodUpdatedCost > 200 ) {
					$prodUpdatedCostErr = "Product cost must need to be between 20 and 200";
					$invalidData = true;
				}
				
				// If the data is valid, update product cost for a specific product in the database products table
				if ($invalidData == false){

					//script to update product cost in the database
					include('updateProduct_db.php');
					if($numRowsAffected > 0) {
						/* redirects to the updateProductSuccess.php where the confirmation is displayed. */
						header('Location: updateProductSuccess.php');
						exit();
					}
				}

			}

			// This function will remove any blank characters on either side of the data, it will remove any slashes and convert any special characters to HTML entities.

			function checkInput($inputData) {
				$inputData = trim($inputData);
				$inputData = stripslashes($inputData);
				$inputData = htmlspecialchars($inputData);
				return $inputData;
			}
			

		?>
		<div class="overlay-layer"></div>
		<div class="container">
			<div class="inner-div">
				<h1 class="page-title">Door Lever Inventory</h1>
				<div class="nav-container">
				    <ul class="nav-bar">
				        <li><a href="uploadProduct.php" class="nav-link">Add Product</a></li>
				        <li><a href="updateProduct.php" class="nav-link active">Update Product</a></li>
				        <li><a href="deleteProduct.php" class="nav-link">Delete Product</a></li>
				    </ul>
				</div>
				<div class="product-content-section">
					<div class="page-intro">
						<h2 class="page-subtitle">Update Product Cost Form</h2>
						<p class="desc">Enter the Door Lever product ID and updated cost in to the form and when you are ready, click the update product button.</p>
						<p class="meta-desc">NOTE: <span>*</span> denotes required entry</p>
					</div>
			        <form id="updateProdForm" class="update-product-form" name="updateProdForm" method="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
			        	<div class="form-field-container">
			        		<label for="prodID">Product ID</label>
		            		<div><input type="text" id="prodID" name="prodID" placeholder="Enter the product ID" value="<?php echo $prodID;?>"><span class="field-error">* <?php echo $prodIDErr;?></span></div>
		            	</div>
	                	<div class="form-field-container">
	                		<label for="prodUpdatedCost">Product Cost</label>
			                <div class="product-cost-input-field"><div class="price-wrapper">
			                	<span>$</span>
			                    <input type="text" id="prodUpdatedCost" name="prodUpdatedCost" placeholder="100.00" value="<?php echo $prodUpdatedCost;?>"/>
			                </div>
			                <span class="field-error">* <?php echo $prodUpdatedCostErr;?></span></div>
			            </div>
			            <div class="action-container">
				            <input class="button-primary" type="submit" name="submit" value="Update Product" title="Update Product">
							<input class="button-secondary" type="submit" name="reset" value ="Reset" title="Reset Form">
				        </div>
				        <!-- General Error Message Displayed Below the Form -->
			            <?php if (!empty($generalErrorMessage)) : ?>
			                <div class="general-error-message">
			                    <?php echo $generalErrorMessage; ?>
			                </div>
			            <?php endif; ?>
			        </form>
			    </div>
			</div>
		</div>
	</body>
</html>