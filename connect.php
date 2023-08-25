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