<?php include 'master.php';?>
<?php
$server_name = "localhost";
$username = "root";
$password = "";
$database_name = "osscet";
$port = "3306";

// Create connection
$conn = new mysqli($server_name, $username, $password, $database_name, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
	
	if(isset($_POST['register']))
	{	
		 $username = $_POST['username'];
		 $password = $_POST['password'];
		 $first_name = $_POST['first_name'];
		 $last_name = $_POST['last_name'];
	
		 $sql_query = "INSERT INTO `users` (`user_id`, `username`, `password`, `role_id`, `first_name`, `last_name`)
		 VALUES (NULL, '$username', '$password', '3', '$first_name', '$last_name')";
	
		 if (mysqli_query($conn, $sql_query)) 
		 {
			echo "New user registered successfully!";
		 } 
		 else
		 {
			echo "Error: " . $sql . "" . mysqli_error($conn);
		 }
		 mysqli_close($conn);
	}
	if(isset($_POST['login'])){
		 
		 if ($stmt = $conn->prepare('SELECT user_id, password, first_name, last_name, role_id FROM users WHERE username = ?')) {
			// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
			$stmt->bind_param('s', $_POST['username']);
			$stmt->execute();
			// Store the result so we can check if the account exists in the database.
			$stmt->store_result();
		
			if ($stmt->num_rows > 0) {
				$stmt->bind_result($user_id, $password, $first_name, $last_name, $role_id);
				$stmt->fetch();
				// Account exists, now we verify the password.
				// Note: remember to use password_hash in your registration file to store the hashed passwords.
				if ($_POST['password'] === $password) {
					// Verification success! User has logged-in!
					// Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
					session_regenerate_id();
					$_SESSION['loggedin'] = TRUE;
					$_SESSION['username'] = $_POST['username'];
					$_SESSION['password'] = $password;
					$_SESSION['user_id'] = $user_id;
					$_SESSION['name'] = "$first_name $last_name";
					$_SESSION['first_name'] = $first_name;
					$_SESSION['last_name'] = $last_name;
					$_SESSION['role_id'] = $role_id;
					echo 'Welcome, ' . $_SESSION['name'] . '!';

					if(($_SESSION['role_id'] == 1) or ($_SESSION['role_id'] == 2)){
						if ($student = $conn->prepare('SELECT email, phone, dob, ssn, bank_account_number, bank_routing_number, admission_date, graduation_date, mailing_address, cumulative_gpa FROM students WHERE user_id = ?')){
							$student->bind_param('i', $user_id);
							$student->execute();
							$student->store_result();
							if ($student->num_rows > 0){
								$student->bind_result($email, $phone, $dob, $ssn, $bank_account_number, $bank_routing_number, $admission_date, $graduation_date, $mailing_address, $cumulative_gpa);
								$student->fetch();
								$_SESSION['email'] = $email;
								$_SESSION['phone'] = $phone;
								$_SESSION['dob'] = $dob;
								$_SESSION['ssn'] = $ssn;
								$_SESSION['bank_account_number'] = $bank_account_number;
								$_SESSION['bank_routing_number'] = $bank_routing_number;
								$_SESSION['admission_date'] = $admission_date;
								$_SESSION['graduation_date'] = $graduation_date;
								$_SESSION['mailing_address'] = $mailing_address;
								$_SESSION['cumulative_gpa'] = $cumulative_gpa;
							}
						};
					}

					if(($_SESSION['role_id'] == 4) or ($_SESSION['role_id'] == 5) or ($_SESSION['role_id'] == 6)){
						if ($teacher = $conn->prepare('SELECT email, phone, prefix, ssn, bank_account_number, bank_routing_number, hire_date, mailing_address, salary FROM teachers WHERE user_id = ?')){
							$teacher->bind_param('i', $user_id);
							$teacher->execute();
							$teacher->store_result();
							if ($teacher->num_rows > 0){
								$teacher->bind_result($email, $phone, $prefix, $ssn, $bank_account_number, $bank_routing_number, $hire_date, $mailing_address, $salary);
								$teacher->fetch();
								$_SESSION['email'] = $email;
								$_SESSION['phone'] = $phone;
								$_SESSION['prefix'] = $prefix;
								$_SESSION['ssn'] = $ssn;
								$_SESSION['bank_account_number'] = $bank_account_number;
								$_SESSION['bank_routing_number'] = $bank_routing_number;
								$_SESSION['hire_date'] = $hire_date;
								$_SESSION['mailing_address'] = $mailing_address;
								$_SESSION['salary'] = $salary;
							}
						};
					}

				} else {
					// Incorrect password
					echo "Incorrect credentials! (Password does not match.)";
				}
			} else {
				// Incorrect username
				echo 'Incorrect credentials! (Username does not exist.)';
			}
		
			$stmt->close();
		}
	
		 mysqli_close($conn);
	}

	if(isset($_POST['update_user'])){
		 $role_id = $_POST['role_id'];
		if ($stmt = $conn->prepare('SELECT user_id, first_name, last_name FROM users WHERE username = ?')) {
		   // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
		   $stmt->bind_param('s', $_SESSION['username']);
		   $stmt->execute();
		   // Store the result so we can check if the account exists in the database.
		   $stmt->store_result();
	   
		   if ($stmt->num_rows > 0) {
			   $stmt->bind_result($user_id, $first_name, $last_name);
			   $stmt->fetch();
			   // Account exists, now we verify the password.
			   // Note: remember to use password_hash in your registration file to store the hashed passwords.
			   
			   $sql_query = "UPDATE `users` SET `role_id` = '$role_id' WHERE `user_id` = $user_id";

if (mysqli_query($conn, $sql_query)) 
{
   echo "User profile updated!";
   $_SESSION['role_id'] = $role_id;
} 
else
{
   echo "Error: " . $sql . "" . mysqli_error($conn);
}
mysqli_close($conn);
		   }
		   $stmt->close();
	   }
   }

	if(isset($_POST['update_student'])){
		$user_id = $_SESSION['user_id'];
		$role_id = $_SESSION['role_id'];
		$username = $_POST['username'];
		$password = $_SESSION['password'];
		 $role_id = $_SESSION['role_id'];
		 $email = $_POST['email'];
		 $phone = $_POST['phone'];
		 $first_name = $_POST['first_name'];
		 $last_name = $_POST['last_name'];
		 $dob = $_POST['dob'];
		 $ssn = $_POST['ssn'];
		 $bank_account_number = $_POST['bank_account_number'];
		 $bank_routing_number = $_POST['bank_routing_number'];
		 $mailing_address = $_POST['mailing_address'];

		if ($stmt = $conn->prepare('SELECT * FROM students WHERE user_id = ?')) {
			// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
			$stmt->bind_param('i', $_SESSION['user_id']);
			$stmt->execute();
			// Store the result so we can check if the account exists in the database.
			$stmt->store_result();
		
			if ($stmt->num_rows > 0) {
				$sql_query = "UPDATE students SET `student_id` = '$username',
				`role_id` = $role_id, 
				`email` = '$email', 
				`phone` = '$phone', 
				`first_name` = '$first_name', 
				`last_name` = '$last_name', 
				`dob` = '$dob', 
				`ssn` = '$ssn', 
				`bank_account_number` = '$bank_account_number', 
				`bank_routing_number` = '$bank_routing_number', 
				`mailing_address` = '$mailing_address'
		 WHERE `user_id` = $user_id";
			}

		 else{
		
		 $sql_query = "INSERT INTO students (`user_id`, 
		 `student_id`, 
		 `password`,
		 `role_id`, 
		 `email`, 
		 `phone`, 
		 `first_name`, 
		 `last_name`, 
		 `dob`, 
		 `ssn`, 
		 `bank_account_number`, 
		 `bank_routing_number`, 
		 `mailing_address`)
		 VALUES ($user_id, 
		 '$username', 
		 '$password',
		 $role_id, 
		 '$email',
		 '$phone',
		 '$first_name', 
		 '$last_name', 
		 '$dob', 
		 '$ssn', 
		 '$bank_account_number', 
		 '$bank_routing_number', 
		 '$mailing_address')";
		 }
		 }
	
		 if (mysqli_query($conn, $sql_query)) 
		 {
			echo "Student profile updated!";
			$_SESSION['role_id'] = $role_id;
			$_SESSION['username'] = $username;
			$_SESSION['email'] = $email;
			$_SESSION['phone'] = $phone;
			$_SESSION['first_name'] = $first_name;
			$_SESSION['last_name'] = $last_name;
			$_SESSION['dob'] = $dob;
			$_SESSION['ssn'] = $ssn;
			$_SESSION['bank_account_number'] = $bank_account_number;
			$_SESSION['bank_routing_number'] = $bank_routing_number;
			$_SESSION['mailing_address'] = $mailing_address;
		 } 
		 else
		 {
			echo "Error: " . $sql . "" . mysqli_error($conn);
		 }
		 mysqli_close($conn);
		 $stmt->close();
   }

if(isset($_POST['update_teacher'])){
		$user_id = $_SESSION['user_id'];
		$role_id = $_SESSION['role_id'];
		$username = $_POST['username'];
		$password = $_SESSION['password'];
		 $role_id = $_SESSION['role_id'];
		 $email = $_POST['email'];
		 $phone = $_POST['phone'];
		 $prefix = $_POST['prefix'];
		 $first_name = $_POST['first_name'];
		 $last_name = $_POST['last_name'];
		 $ssn = $_POST['ssn'];
		 $bank_account_number = $_POST['bank_account_number'];
		 $bank_routing_number = $_POST['bank_routing_number'];
		 $mailing_address = $_POST['mailing_address'];
		 $bio_summary = $_POST['bio_summary'];

		if ($stmt = $conn->prepare('SELECT * FROM teachers WHERE user_id = ?')) {
			// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
			$stmt->bind_param('i', $user_id);
			$stmt->execute();
			// Store the result so we can check if the account exists in the database.
			$stmt->store_result();
		
			if ($stmt->num_rows > 0) {
				
				$sql_query = "UPDATE teachers SET `teacher_id` = '$username', 
				`role_id` = $role_id, 
				`email` = '$email', 
				`phone` = '$phone', 
				`prefix` = '$prefix',
				`first_name` = '$first_name', 
				`last_name` = '$last_name', 
				`ssn` = '$ssn', 
				`bank_account_number` = '$bank_account_number', 
				`bank_routing_number` = '$bank_routing_number', 
				`mailing_address` = '$mailing_address',
				`bio_summary` = '$bio_summary'
		 WHERE `user_id` = $user_id";
			}

		 else{
		
		 $sql_query = "INSERT INTO teachers (`user_id`, 
		 `teacher_id`, 
		 `password`,
		 `role_id`, 
		 `email`, 
		 `phone`, 
		 `prefix`,
		 `first_name`, 
		 `last_name`, 
		 `ssn`, 
		 `bank_account_number`, 
		 `bank_routing_number`, 
		 `mailing_address`,
		 `bio_summary`)
		 VALUES ($user_id, 
		 '$username', 
		 '$password',
		 $role_id, 
		 '$email',
		 '$phone',
		 '$prefix',
		 '$first_name', 
		 '$last_name',
		 '$ssn', 
		 '$bank_account_number', 
		 '$bank_routing_number', 
		 '$mailing_address',
		 '$bio_summary')";
		 }
		 }
	
		 if (mysqli_query($conn, $sql_query)) 
		 {
			echo "Teacher profile updated!";
			$_SESSION['role_id'] = $role_id;
			$_SESSION['username'] = $username;
			$_SESSION['email'] = $email;
			$_SESSION['phone'] = $phone;
			$_SESSION['prefix'] = $prefix;
			$_SESSION['first_name'] = $first_name;
			$_SESSION['last_name'] = $last_name;
			$_SESSION['ssn'] = $ssn;
			$_SESSION['bank_account_number'] = $bank_account_number;
			$_SESSION['bank_routing_number'] = $bank_routing_number;
			$_SESSION['mailing_address'] = $mailing_address;
			$_SESSION['bio_summary'] = $bio_summary;
		 } 
		 else
		 {
			echo "Error: " . $sql . "" . mysqli_error($conn);
		 }
		 mysqli_close($conn);
		 $stmt->close();
   }

}


?>