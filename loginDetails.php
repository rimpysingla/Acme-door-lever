<!-- 
Page Name: loginDetails.php
Date: 30-10-2024 
Author: Rimpy Singla 
Purpose: This code creates an HTML form for user login, where users can enter their username and password. It validates the input fields to ensure they are not left blank and sanitizes the user input. It processes the form submission and includes a separate file (LoginDetails_Verify.php) for further verification.
-->

<!DOCTYPE html>

<?php

	// code to suppress error messages to the end user 

	mysqli_report(MYSQLI_REPORT_OFF);

	error_reporting(0);

	//these variables need to be outside of the if statement otherwise not recognised in the form tags
	$errMessageUserName=""; 
	$errMessageUserPassword=""; 
	$userName ="";
	$userPassword ="";
	$generalErrorMessage = ""; // For general login failure message
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {  //User has pressed the submit button
		// if reset button is pressed, it will reset the form
		if(isset($_POST["reset"])){
			header("Refresh:0");
			exit();
		}
		
		// The sanitized input returned by the checkInput()
		$userName = checkInput($_POST["userName"]);
		$userPassword = checkInput($_POST["userPassword"]);
		
		$validData = true;

		// check if the username and password is blank or not
		if($userName == "") {
			$errMessageUserName="User name must not be blank";
			$validData = false;
		}
		
		if($userPassword == "") {
			$errMessageUserPassword="User password must not be blank";
			$validData = false;
		}
		
		// if username and password is not blank and valid data is true
		if ($validData) {
			include("LoginDetails_Verify.php");
			// If username or password does not match, set general error message
			// exit();
		}
	}
	

	function checkInput($inputData) {
		$inputData = trim($inputData);
		$inputData = stripslashes($inputData);
		$inputData = htmlspecialchars($inputData);
		$inputData = strip_tags($inputData);
		return $inputData;
	}
?>


<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Login Details</title>
		<link rel="stylesheet" href="css/myStyle.css">
	</head>
	<body class="login-page-container">
		<div class="overlay-layer"></div>
		<div class="container">
			<div class="inner-div">
				<div class="page-intro">
					<h1 class="page-title">Login Details</h1>
					<p class="desc">Enter your login details and when your are ready, click the login button.</p>
					<p class="meta-desc">NOTE: <span>*</span> denotes required entry</p>
				</div>
		        <form class="login-form" method="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
		            <div class="form-field-container">
		            	<label for="userName" class="sr-only">Username <span class="field-error">*</span></label>
	            		<div>
	            			<input type="text" id="userName" name="userName" placeholder="johndoe123" value="<?php echo $userName;?>">
	            			<span class="field-error"><?php echo $errMessageUserName;?></span>
	            		</div>
		            </div>
		            <div class="form-field-container">
		            	<label for="userPassword" class="sr-only">Password <span class="field-error">*</span></label>
		            	<div>
			            	<input type="password" id="userPassword" name="userPassword" placeholder="**********" value=""><span class="field-error"><?php echo $errMessageUserPassword;?></span>
			            </div>
		            </div>
		            <div class="action-container">
			            <input class="button-primary" type="submit" name="submit" value="Submit" title="Submit Form">
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
	</body>
</html>