<!-- 
Page Name: createDB.php 
Date: 28-10-2024 
Author: Rimpy Singla 
Purpose: This PHP script connects to a MySQL database as the root user, creates a database named 'acme' if it doesn't already exist, and creates a 'products' table within that database to store product information and the 'custlogin' table to store customer login information. It executes multiple SQL queries using mysqli_multi_query() and handles errors or success messages accordingly.
-->

<!DOCTYPE html>

<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<title>Create Door Lever Database</title>
	</head>
	<body>

		<?php

			// code to suppress error messages to the end user 

			mysqli_report(MYSQLI_REPORT_OFF);

			error_reporting(0);


			// Establish a connection to MySQL server as root user (Administrator)

			$conn = mysqli_connect("localhost","root","");


			// Check connection, this function returns 0 if the connection was successful.

			if (mysqli_connect_errno())

			{
				// If connection fails, display the error message
				echo "<p>Failed to connect to MySQL, Error: " . mysqli_connect_error() . "</p>";
			
			}

			else

			{

				echo "<p>Connected to MySQL</p>";

		
				// Create database and table

				$query ="DROP DATABASE IF EXISTS acme;";

				$query.="CREATE DATABASE acme;";

				$query.="USE acme;";

				$query.= "CREATE TABLE IF NOT EXISTS products (id int not null auto_increment primary key, prodName varchar(30) not null, prodFinish varchar(30) not null, prodUsage varchar(30) not null, prodImageUrl varchar(100) not null, prodCost float(8,2) not null);";

				$query.= "CREATE TABLE IF NOT EXISTS custlogin (userName varchar(50) not null primary key, userPassword varchar(255) not null);";

			
				// Execute multiple queries at once using mysqli_multi_query()

				if (mysqli_multi_query($conn,$query)) 

				{
					// Database 'acme', 'products' and 'custlogin' tables created successfully
					// The DO...WHILE loop is used to process multiple results from the multi-query execution
					do

					{
						// Move to the next result (if any) until all results are processed
						mysqli_next_result($conn);	

					} while (mysqli_more_results($conn)); // WHILE statement checks if there are more query results to process


					// Once all queries are processed, display success message

					echo "<p>Database 'acme' and tables 'products' and 'custlogin' created successfully.</p>";

					// Inserting a user into the custlogin table

					$userName = "rimpy_singla";
					$userPassword = "myPassword123";

					// Hash the password to securely store it in database by using password_hash()

					$hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);

					// New username and password details are added to the table. We secured the password by using the password_hash() function before inserting the record.

					$insert = "INSERT INTO custlogin(userName, userPassword) VALUES ('$userName','$hashedPassword')";

					if (mysqli_query($conn,$insert)) 
					{
						// New user added successfully
						echo "<p>New user added successfully</p>"; 
					}
					else 
					{
						echo "<p>Insertion of new user query failed: " . mysqli_error($conn)."</p>";
					}

				}

				else 

				{
					// If there is an error in any of the queries, display the error message

					echo "<p>Error: " . mysqli_error($conn) ."</p>";

				}

				// Close the connection

				mysqli_close($conn);

			}

		?>

	</body>
</html>