<?php
error_reporting(E_ALL ^ E_NOTICE)
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Registration Page</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.1/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<?php include 'master.php';?>

<div class="container text-center">
<h1>Welcome to the Registration page</h1>
</div>
<c:url var="registerUrl" value="/register"/>
<?php 
include 'db.php';

if(isset($_POST['register']))
	{	
		 $username = $_POST['username'];
		 $password = $_POST['password'];
		 $first_name = $_POST['first_name'];
		 $last_name = $_POST['last_name'];

         if ($stmt = $conn->prepare('SELECT * FROM users WHERE username = ?')) {
			// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
			$stmt->bind_param('s', $_POST['username']);
			$stmt->execute();
			// Store the result so we can check if the username exists in the database.
			$stmt->store_result();
		
			if ($stmt->num_rows > 0) { ?>

                <form action="registration.php" method="post" modelAttribute="user">
        <div class="form-group">
            <label for="username">Username - ERROR: That username was already taken!</label>
            <input class="form-control" name='username' type="username" placeholder="Pick something else!"/>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input class="form-control" name='password' type="password" placeholder=" <?php $password ?> "/>
        </div>
        <div class="form-group">
            <label for="first_name">First name</label>
            <input class="form-control" name='first_name' type="text" placeholder=" <?php $first_name ?> "/>
        </div>
        <div class="form-group">
            <label for="last_name">Last name</label>
            <input class="form-control" name='last_name' type="text" placeholder=" <?php $last_name ?> "/>
        </div>
        <tr>
			<td colspan="2"><input type="submit" name='register' value="Save User" style="font-size:20px"></td>
		</tr>
    </form> 
    <?php
            }
		 else {$sql_query = "INSERT INTO `users` (`user_id`, `username`, `password`, `role_id`, `first_name`, `last_name`)
		 VALUES (NULL, '$username', '$password', '3', '$first_name', '$last_name')";
	
		 if (mysqli_query($conn, $sql_query)) 
		 {
			echo "New user registered successfully!";?>
            <meta http-equiv="refresh" content="0;URL=login.php" /> <?php
		 } 
		 else
		 {
			echo "Error: " . $sql . "" . mysqli_error($conn);
		 }}}
		
	} 
    else { ?>

<form action="registration.php" method="post" modelAttribute="user">
        <div class="form-group">
            <label for="username">Username</label>
            <input class="form-control" name='username' type="username" placeholder="Create a username"/>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input class="form-control" name='password' type="password" placeholder="Create a password"/>
        </div>
        <div class="form-group">
            <label for="first_name">First name</label>
            <input class="form-control" name='first_name' type="text" placeholder="John"/>
        </div>
        <div class="form-group">
            <label for="last_name">Last name</label>
            <input class="form-control" name='last_name' type="text" placeholder="Doe"/>
        </div>
        <tr>
			<td colspan="2"><input type="submit" name='register' value="Save User" style="font-size:20px"></td>
		</tr>
    </form>

<?php } 
include 'footer.php';?>
</body>
</html>
