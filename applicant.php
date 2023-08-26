<!DOCTYPE html>
<html lang="en">
<head>
<title>New user profile</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
  <?php 
include 'db.php';
session_start();

  if(isset($_POST['update_user'])){
    $role_id = $_POST['role_id'];
    $user_id = $_SESSION['user_id'];
   if ($stmt = $conn->prepare('SELECT username, `password`, first_name, last_name FROM users WHERE users.user_id = ?')) {
      // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
      $stmt->bind_param('i', $user_id);
      $stmt->execute();
      // Store the result so we can check if the account exists in the database.
      $stmt->store_result();
    
      if ($stmt->num_rows > 0) { 
        $stmt->bind_result($username, $password, $first_name, $last_name);
			   $stmt->fetch();
        $sql_query = "UPDATE `users` SET `role_id` = '$role_id' WHERE `user_id` = $user_id";}
      if(($role_id == 1) or ($role_id == 2)){
        $user_query = "INSERT INTO students (`user_id`, 
        `student_id`, 
        `password`,
        `role_id`, 
        `first_name`, 
        `last_name`)
        VALUES ($user_id, 
        '$username', 
        '$password',
        $role_id, 
        '$first_name', 
        '$last_name')";
      }
      if(($role_id == 4) or ($role_id == 5) or ($role_id == 6)){
        $user_query = "INSERT INTO teachers (`user_id`, 
        `teacher_id`, 
        `password`,
        `role_id`, 
        `first_name`, 
        `last_name`)
        VALUES ($user_id, 
        '$username', 
        '$password',
        $role_id, 
        '$first_name', 
        '$last_name')";
      }

if ((mysqli_query($conn, $sql_query)) && (mysqli_query($conn, $user_query)))
{
  echo "User profile updated!";
  $_SESSION['role_id'] = $role_id; 
  $_SESSION['username'] = $username;
  $_SESSION['user_id'] = $user_id;
  $_SESSION['first_name'] = $first_name;
  $_SESSION['last_name'] = $last_name;
  ?>
  <meta http-equiv="refresh" content="0;URL=profile.php" /> 
  <?php
} 
else
{
  echo "Error: " . $sql . "" . mysqli_error($conn);
}
    }}
  
  if($_SESSION['role_id'] == 3){?>
<div class="container text-center">
<h1>Please select a role</h1>
</div>
<c:url var="applicantUrl" value="/applicant"/>
<form action="applicant.php" method="post" modelAttribute="user">
        <div class="form-group">
            <label for="role_id">Role</label>
            <select name="role_id">
  <option value="3">Applicant</option>
  <option value="1">Student (Undergrad)</option>
  <option value="2">Graduate student</option>
  <option value="4">Professor</option>
  <option value="5">Instructor</option>
  <option value="6">Teacher's Aide</option>
</select>
        </div>
        <tr>
			<td colspan="2"><input type="submit" name='update_user' value="Save User" style="font-size:20px"></td>
		</tr>
    </form>
    <?php }
    else { 
      if($role_search = $conn->prepare('SELECT * from roles where role_id = ?')){
      $role_search->execute([$_SESSION['role_id']]);
      $role_search_result = $role_search->get_result();
      $role_result = mysqli_fetch_assoc($role_search_result);
            $role_name = $role_result['role_name'];}
      ?>
    <div>Your role is set: <?php echo $role_name; ?></div>
    <div>Please see an administrator if this needs to be changed.</div>
  <?php } ?>
</body>
</html>