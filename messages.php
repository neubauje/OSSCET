<?php
error_reporting(E_ALL ^ E_NOTICE)
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Messages</title>
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
<h1>Welcome to the messages page!</h1>
</div>
<?php

if($_SESSION['role_id'] == 3){
    echo "You are a new applicant. Please go to <li><a href='profile.php'><span class='glyphicon glyphicon-briefcase'></span>Profile</a></li> in order to select a role before attempting to send messages.";
}
else{
    echo "This is where you can view your messages and respond to them. You can also initiate a new message to anyone teaching or enrolled in one of your classes. 
    This is also where you will find automated system notifications, such as an alert that a seat has become available for a class that you were on the waiting list for.";
}

?>
<?php include 'footer.php';?>
</body>
</html>
