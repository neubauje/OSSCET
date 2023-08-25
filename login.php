<?php
error_reporting(E_ALL ^ E_NOTICE);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Login Page</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
<?php require 'master.php';
include 'db.php';

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
                   if ($student = $conn->prepare('SELECT email, phone, dob, ssn, admission_date, graduation_date, mailing_address, cumulative_gpa FROM students WHERE user_id = ?')){
                       $student->bind_param('i', $user_id);
                       $student->execute();
                       $student->store_result();
                       if ($student->num_rows > 0){
                           $student->bind_result($email, $phone, $dob, $ssn, $admission_date, $graduation_date, $mailing_address, $cumulative_gpa);
                           $student->fetch();
                           $_SESSION['email'] = $email;
                           $_SESSION['phone'] = $phone;
                           $_SESSION['dob'] = $dob;
                           $_SESSION['ssn'] = $ssn;
                           $_SESSION['admission_date'] = $admission_date;
                           $_SESSION['graduation_date'] = $graduation_date;
                           $_SESSION['mailing_address'] = $mailing_address;
                           $_SESSION['cumulative_gpa'] = $cumulative_gpa;
                       }
                   };
               }

               if(($_SESSION['role_id'] == 4) or ($_SESSION['role_id'] == 5) or ($_SESSION['role_id'] == 6)){
                   if ($teacher = $conn->prepare('SELECT email, phone, prefix, ssn, hire_date, mailing_address, salary FROM teachers WHERE user_id = ?')){
                       $teacher->bind_param('i', $user_id);
                       $teacher->execute();
                       $teacher->store_result();
                       if ($teacher->num_rows > 0){
                           $teacher->bind_result($email, $phone, $prefix, $ssn, $hire_date, $mailing_address, $salary);
                           $teacher->fetch();
                           $_SESSION['email'] = $email;
                           $_SESSION['phone'] = $phone;
                           $_SESSION['prefix'] = $prefix;
                           $_SESSION['ssn'] = $ssn;
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
   }
?>
    <meta http-equiv="refresh" content="0;URL=index.php" /> <?php
} 

?>

<div class="container text-center">
<h1>Welcome to the OSSCET Login page</h1>
</div>
<form action="login.php" method="post" modelAttribute="user">
        <div class="form-group">
            <label for="username">Username</label>
            <input class="form-control" name='username' type="username" placeholder="Enter your username"/>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input class="form-control" name='password' type="password" placeholder="Enter your password"/>
        </div>
        <tr>
			<td colspan="2"><input type="submit" name='login' value="Log in" style="font-size:20px"></td>
		</tr>
    </form>
<?php require_once 'footer.php';?>
</body>
</html>