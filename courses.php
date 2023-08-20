
<!DOCTYPE html>
<html lang="en">
<head>
<title>Courses</title>
</head>
<body>
<?php include 'master.php';?>

<div class="container text-center">
<h1>Welcome to the Course catalogue!</h1>
</div>
<?php

if($_SESSION['role_id'] == 3){
    echo "You are a new applicant. Please go to <li><a href='profile.php'><span class='glyphicon glyphicon-briefcase'></span>Profile</a></li> in order to select a role before viewing courses.";
}
if($_SESSION['role_id'] == 1){
    require_once 'courses_student.php';
}
if($_SESSION['role_id'] == 2){
    require_once 'courses_student.php';
}
if($_SESSION['role_id'] == 4){
    require_once 'courses_teacher.php';
}
if($_SESSION['role_id'] == 5){
    require_once 'courses_teacher.php';
}
if($_SESSION['role_id'] == 6){
    echo "You are a teacher's aide, and as such do not have permission to edit or create courses. Please see <li><a href='classes.php'><span class='glyphicon glyphicon-briefcase'></span>Class offerings</a></li> to add a class to your schedule.";
}

?>
<?php include 'footer.php';?>
</body>
</html>
