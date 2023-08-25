<!DOCTYPE html>
<html lang="en">
<head>
<title>Student profile</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="container text-center">
<h1>Student profile information</h1>
</div>
<c:url var="profile_student_url" value="/profile_student"/>
<?php
include 'db.php';
$user_id = $_SESSION['user_id'];
$role_id = $_SESSION['role_id'];
$password = $_SESSION['password'];
$username = $_SESSION['username'];
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];

if(isset($_POST['update_student'])){
   
    $new_username = $_POST['username'];
     $email = $_POST['email'];
     $phone = $_POST['phone'];
     $first_name = $_POST['first_name'];
     $last_name = $_POST['last_name'];
     $dob = $_POST['dob'];
     $ssn = $_POST['ssn'];
     $mailing_address = $_POST['mailing_address'];

     //Check for username change
     if($_POST['username'] != $_SESSION['username']){    
        // echo "Username change attempt detected. Checking for availability.";
        $username_update = TRUE;}
    else{
        // echo "No username change detected.";
        $username_update = FALSE;
    }

    //Username change attempt
     if ($username_update == TRUE) {

         //Check to make sure the new username isn't already taken  
     if ($unique_check = $conn->prepare('SELECT * FROM users WHERE username = ?')) {
        $unique_check->bind_param('s', $new_username);
        $unique_check->execute();
         $unique_check->store_result();
    
        if ($unique_check->num_rows > 0) { 
            //Error form for when the new username IS taken
            ?>
            <form action="profile.php" method="post" modelAttribute="student">

            <div class="form-group">
                <label for="username">Username - ERROR: That username is already in use.</label>
                <input class="form-control" name='username' type="username" value="<?php echo $username;?>" />
            </div>
            <div class="form-group">
                <label for="first_name">First name</label>
                <input class="form-control" name='first_name' type="text" value="<?php echo $first_name;?>" />
            </div>
            <div class="form-group">
                <label for="last_name">Last name</label>
                <input class="form-control" name='last_name' type="text" value="<?php echo $last_name;?>" />
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input class="form-control" name='email' type="email" value="<?php echo $email;?>" />
            </div>
            <div class="form-group">
                <label for="phone">Phone number</label>
                <input class="form-control" name='phone' type="phone" value="<?php echo $phone;?>" />
            </div>
            <div class="form-group">
                <label for="dob">Date of birth</label>
                <input class="form-control" name='dob' type="date" value="<?php echo $dob;?>" />
            </div>
            <div class="form-group">
                <label for="ssn">Social security number</label>
                <input class="form-control" name='ssn' type="text" value="<?php echo $ssn;?>" />
            </div>
            <div class="form-group">
                <label for="mailing_address">Mailing address</label>
                <input class="form-control" name='mailing_address' type="textarea" value="<?php echo $mailing_address;?>" />
            </div>
            <tr>
                <td colspan="2"><input type="submit" name='update_student' value="Save profile" style="font-size:20px"></td>
            </tr>
        </form> <?php
        }
        else{
        $username = $new_username;
        }
    }
}

    //If username is being changed, and new username is available, OR when username is not being changed
    if ($stmt = $conn->prepare('SELECT * FROM students WHERE user_id = ?')) {
        // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        // Store the result so we can check if the account exists in the database.
        $stmt->store_result();
    
      
            $sql_query = "UPDATE students SET `student_id` = '$username',
            `role_id` = $role_id, 
            `email` = '$email', 
            `phone` = '$phone', 
            `first_name` = '$first_name', 
            `last_name` = '$last_name', 
            `dob` = '$dob', 
            `ssn` = '$ssn', 
            `mailing_address` = '$mailing_address'
     WHERE `user_id` = $user_id";}

     $update_user = "UPDATE users SET 
     `username` = '$username',
     `first_name` = '$first_name',
     `last_name` = '$last_name'
     WHERE `user_id` = $user_id";
     

     if ((mysqli_query($conn, $sql_query)) && (mysqli_query($conn, $update_user)))
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
        $_SESSION['mailing_address'] = $mailing_address;
     } 
     else
     {
        echo "Error: " . $sql . "" . mysqli_error($conn);
     }}


if ($stmt = $conn->prepare('SELECT * FROM students WHERE user_id = ?')) {
        $stmt->execute([$_SESSION['user_id']]);
        // Store the result so we can check if the account exists in the database.
        $profile_result = $stmt->get_result();
        if ($profile_result->num_rows > 0) {
            $profile = mysqli_fetch_assoc($profile_result);
            $my_username = $profile['student_id'];
            $my_email = $profile['email'];
            $my_phone = $profile['phone'];
            $my_dob  = $profile['dob'];
            $my_first_name = $profile['first_name'];
            $my_last_name = $profile['last_name'];
            $my_ssn = $profile['ssn'];
            $my_mailing_address = $profile['mailing_address'];
        }
else{echo 'No students found';}}


?>
<form action="profile.php" method="post" modelAttribute="student">

        <div class="form-group">
            <label for="username">Username</label>
            <input class="form-control" name='username' type="username" value="<?php echo $my_username;?>" />
        </div>
        <div class="form-group">
            <label for="first_name">First name</label>
            <input class="form-control" name='first_name' type="text" value="<?php echo $my_first_name;?>" />
        </div>
        <div class="form-group">
            <label for="last_name">Last name</label>
            <input class="form-control" name='last_name' type="text" value="<?php echo $my_last_name;?>" />
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input class="form-control" name='email' type="email" value="<?php echo $my_email;?>" />
        </div>
        <div class="form-group">
            <label for="phone">Phone number</label>
            <input class="form-control" name='phone' type="phone" value="<?php echo $my_phone;?>" />
        </div>
        <div class="form-group">
            <label for="dob">Date of birth</label>
            <input class="form-control" name='dob' type="date" value="<?php echo $my_dob;?>" />
        </div>
        <div class="form-group">
            <label for="ssn">Social security number</label>
            <input class="form-control" name='ssn' type="text" value="<?php echo $my_ssn;?>" />
        </div>
        <div class="form-group">
            <label for="mailing_address">Mailing address</label>
            <input class="form-control" name='mailing_address' type="textarea" value="<?php echo $my_mailing_address;?>" />
        </div>
        <tr>
			<td colspan="2"><input type="submit" name='update_student' value="Save profile" style="font-size:20px"></td>
		</tr>
    </form>
</body>
</html>