<!-- 
Page Name: uploadProduct.php 
Date: 28-10-2024 
Author: Rimpy Singla 
Purpose: This code creates an HTML form for uploading product information (product name, finish, usage, cost, and image) to the server. It uses PHP to validate user input, ensuring that fields are not left blank and that the product cost is a positive numeric value. The code handles both submission and reset functionality.
-->

<!DOCTYPE html>
		<html lang="en">
		
		<head>
			<meta charset="UTF-8">
			<title>Upload Product Form</title>
			<link rel="stylesheet" type="text/css" href="css/myStyle.css">
		</head>

		<body class="product-container upload-product-container">
		<?php
			// code to suppress error messages to the end user 

			mysqli_report(MYSQLI_REPORT_OFF);

			error_reporting(0);

			$prodName = ""; $prodFinish = ""; $prodUsage = ""; $prodCost = ""; $imageUpload = "";
			$prodNameErr ="";$prodFinishErr = "";$prodUsageErr = ""; $prodCostErr=""; $prodImageErr = "";
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
				
				$prodName = checkInput($_POST["prodName"]);
				$prodFinish = checkInput($_POST["prodFinish"]);
				$prodUsage = checkInput($_POST["prodUsage"]);
				$prodCost = checkInput($_POST["prodCost"]);

				// Handle the image upload
    			if (isset($_FILES['prodImage'])) {
					$imageUpload = $_FILES['prodImage']['name'];
					$imageType = $_FILES['prodImage']['type'];
					$imageSize = $_FILES['prodImage']['size'];
					$imageTempName = $_FILES['prodImage']['tmp_name'];
					// Image location variable stores the location of the image that is in the images folder
					$imageLocation = "images/$imageUpload";

					// Validate the image, as it must not be empty and must be in specific (jpg,jpeg,png) formats
					if ($imageUpload == "") {
						$prodImageErr = "Image must be selected";
						$invalidData = true;
					}

					// Check the image must be a jpg or png file
					elseif ($imageType != 'image/jpg' && $imageType != 'image/png' && $imageType != 'image/jpeg'){
						$prodImageErr = "You must select a valid jpg, jpeg and png image";
						$invalidData = true;
					}

					elseif($imageTempName == "") {
						echo "<p>You must enter a valid filename and size (less than 40M) </p>" ;
						$invalidData = true;
					}
					

					// This is to make sure that the file ($imageTempName) is a valid upload file 
					elseif (!move_uploaded_file($imageTempName, $imageLocation)) {
						$prodImageErr = "Failed to upload the image";
						$invalidData = true;

						$theError = $_FILES['prodImage']['error'];
						echo "<p>Error: $theError</p>";
						echo "<p>Image : $imageUpload</p>";
						echo "<p>Size : $imageSize</p>";
						echo "<p>Location: $imageLocation</p>";
						echo "<p>temp name: $imageTempName</p>";

						// The switch statement is used to determine the file upload error.
						switch ($_FILES['prodImage']['error'])
						{	
							// The file size exceeds the size set by the server 
							case UPLOAD_ERR_INI_SIZE:
								$prodImageErr = "Image size is big. Select another image";
								echo "<p>Error: Image file exceeds the maximum size limit set by the server</p>" ;
								break;
							// The file size exceeds the size set by the browser 
							case UPLOAD_ERR_FORM_SIZE:
								$prodImageErr = "Image size is big. Select another image";
								echo "<p>Error: Image file exceeds the maximum size limit set by the browser</p>" ;
								break;
							// No file selected by the user 
							case UPLOAD_ERR_NO_FILE:
								echo "<p>Error: No image uploaded</p>" ;
								break;
							
							default:
								echo "<p>Image could not be uploaded </p>" ;
						}

			        }
				}

				// Check if the product name is blank, set the product name error field accordingly
				if($prodName == "")  {
					$prodNameErr ="Product name must not be blank";
					$invalidData = true;
				}
				
				// Check if the product finish is blank, set the product finish error field accordingly
				if ($prodFinish == ""){
					$prodFinishErr ="Product finish must not be blank";
					$invalidData = true;
				}
				

				// Check if the product usage is blank, set the product usage error field accordingly
				if($prodUsage == "")  {
					$prodUsageErr ="Product usage must not be blank";
					$invalidData = true;
				}
				
				
				// Check if the product cost is blank or not
				if ($prodCost == ""){
					$prodCostErr ="Product cost must not be blank";
					$invalidData = true;
				}
				// Check if the product cost is numeric or not
				elseif (!is_numeric($prodCost)){
					$prodCostErr = "Product cost must be numeric only";
					$invalidData = true;
				}
				// Check if the product cost is greater than 0 or not
				elseif ($prodCost < 0) {
					$prodCostErr = "Product cost must be greater than 0";
					$invalidData = true;
				}
				
				// If the data is valid, add products to database products table and show a message of confirmation to the user
				if ($invalidData == false){
					//script to add product details to the database
					include('uploadProduct_db.php');

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
				        <li><a href="uploadProduct.php" class="nav-link active">Add Product</a></li>
				        <li><a href="updateProduct.php" class="nav-link">Update Product</a></li>
				        <li><a href="deleteProduct.php" class="nav-link">Delete Product</a></li>
				    </ul>
				</div>
				<div class="product-content-section">
					<div class="page-intro">
						<h2 class="page-subtitle">Product Entry Form</h2>
						<p class="desc">Enter the Door Lever product details in to the form and when you are ready, click the upload product button.</p>
						<p class="meta-desc">NOTE: <span>*</span> denotes required entry</p>
					</div>
			        <form id="uploadProdForm" class="upload-product-form" name="uploadProdForm" method="post" enctype="multipart/form-data" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
			        	<div class="form-field-container">
			        		<label for="prodName">Product Name</label>
		            		<div><input type="text" id="prodName" name="prodName" placeholder="Enter the product name" value="<?php echo $prodName;?>"><span class="field-error">* <?php echo $prodNameErr;?></span></div>
		            	</div>
			            <div class="form-field-container">
			            	<label for="prodFinish">Product Finish</label>
	                		<div><input type="text" id="prodFinish" name="prodFinish" placeholder="Enter the product finish" value="<?php echo $prodFinish;?>"/><span class="field-error">* <?php echo $prodFinishErr;?></span></div>
	                	</div>
		                <div class="form-field-container">
		                	<label for="prodUsage">Product Usage</label>
			                <div><input type="text" id="prodUsage" name="prodUsage" placeholder="Enter the usage of the product" value="<?php echo $prodUsage;?>"/><span class="field-error">* <?php echo $prodUsageErr;?></span></div>
			            </div>
			            <div class="form-field-container">
			            	<label for="prodImage">Product Image</label>
	                		<div>
	                			<input type="hidden" name='MAX_FILE_SIZE' value='41943040'>
	                			<input type="file" id="prodImage" name="prodImage" value="<?php echo $prodImage;?>"/>
	                			<span class="field-error">* <?php echo $prodImageErr;?></span>
	                		</div>
	                	</div>
	                	<div class="form-field-container">
	                		<label for="prodCost">Product Cost</label>
			                <div class="product-cost-input-field"><div class="price-wrapper">
			                	<span>$</span>
			                    <input type="text" id="prodCost" name="prodCost" placeholder="100.00" value="<?php echo $prodCost;?>"/>
			                </div>
			                <span class="field-error">* <?php echo $prodCostErr;?></span></div>
			            </div>
			            <div class="action-container">
				            <input class="button-primary" type="submit" name="submit" value="Upload Product" title="Upload Product">
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