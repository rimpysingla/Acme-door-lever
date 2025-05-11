<!-- 
Page Name: LoginDetails_Verify.php 
Date: 30-10-2024 
Author: Rimpy Singla 
Purpose: This PHP script connects to a MySQL database 'acme' as the root user and checks if the entered username exists in the custlogin table. If the username exists, it verifies the password entered by the user against the hashed password stored in the database using password_verify(). If the password matches, it redirects the user to uploadProduct.php. If not, it sets an appropriate error message for the user.
-->


<?php 

	//Connect to the database server using the syntax mysqli_connect(server, username, password)
	
	// code to suppress error messages to the end user 
	mysqli_report(MYSQLI_REPORT_OFF);

	error_reporting(0);

	// make the connection with database

 	$conn = mysqli_connect("localhost:3306", "root", "");

 	if (!$conn) {

		echo "The connection has failed: " . mysqli_connect_error();

	 }

	else 

	{

		// no need to create the database and the table, as we already created that

		// Select the database acme to fetch the password from the custlogin table

		if (!mysqli_select_db($conn,"acme")) {

			echo "<p>Could not open the database: " . mysqli_error($conn)."</p>";	
		}

		else {

			// put the values of userName and userPassword entered by user in the variables $userName and $userPassword

			$userName = $_POST['userName'];

			$userPassword = $_POST['userPassword']; // Password filled by the user

			// Select the record from custlogin table where username is the entered username by user

			$query = "SELECT * FROM custlogin WHERE userName='".$userName."'";

			$results = mysqli_query($conn,$query);

			if ($results) {

				$numRecords=mysqli_num_rows($results);

				if ($numRecords != 0) //found a match with the username

				{

					//need to verify user - check the password. Fetch the row of user data that have the same username 

					$row = mysqli_fetch_array($results);

					// Hashed password stored in the database

					$hashedPassword = $row['userPassword'];

					// compare the hashed password from the table with the password entered from the form.

					$passwordsAreTheSame = password_verify($userPassword,$hashedPassword);

					if ($passwordsAreTheSame == true)

					{
						$generalErrorMessage = "";

						// Move on the upload product page if password matched
						header('Location: uploadProduct.php');
						exit();

					}

					else

					{
						// error message variable to show invalid password error
						$generalErrorMessage = "Username exists but the Password does not match the stored password.";
					}

				}

				else

				{

					$generalErrorMessage = "This user does not exist.";

				}	

			}

			else

			{

				echo "<p>Error locating customer details</p>";

			}

		}

	}

	//Close the connection

	mysqli_close($conn);

?>