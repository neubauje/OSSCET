<?php
error_reporting(E_ALL ^ E_NOTICE)
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Profile Page</title>
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
<h1>Welcome to the Profile page</h1>
</div>
<?php

if($_SESSION['role_id'] == 3){
    echo "You are a new applicant.";
require_once 'applicant.php';
}
if($_SESSION['role_id'] == 1){
    echo "You are a student.";
    require_once 'student.php';
}
if($_SESSION['role_id'] == 2){
    echo "You are a student.";
    require_once 'student.php';
}
if($_SESSION['role_id'] == 4){
    echo "You are a teacher.";
    require_once 'teacher.php';
}
if($_SESSION['role_id'] == 5){
    echo "You are a teacher.";
    require_once 'teacher.php';
}
if($_SESSION['role_id'] == 6){
    echo "You are a teacher.";
    require_once 'teacher.php';
}

?>
<?php include 'footer.php';?>
</body>
</html>
