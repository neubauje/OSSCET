<?php
error_reporting(E_ALL ^ E_NOTICE)
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Classes</title>
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
<h1>Welcome to the Class offerings and enrollment page!</h1>
</div>
<?php

if($_SESSION['role_id'] == 3){
    echo "You are a new applicant. Please go to <li><a href='profile.php'><span class='glyphicon glyphicon-briefcase'></span>Profile</a></li> in order to select a role before viewing class offerings.";
}
if($_SESSION['role_id'] == 1){
    require_once 'classes_student.php';
}
if($_SESSION['role_id'] == 2){
    require_once 'classes_student.php';
}
if($_SESSION['role_id'] == 4){
    require_once 'classes_teacher.php';
}
if($_SESSION['role_id'] == 5){
    require_once 'classes_teacher.php';
}
if($_SESSION['role_id'] == 6){
    require_once 'classes_student.php';
    // teacher's aides will "enroll" in a class in the same way that a student would, since their information will not be listed on the class offering. But their role_id will allow them to not count against the occupancy/vacancy totals for the class.
}

?>
<?php include 'footer.php';?>
</body>
</html>
