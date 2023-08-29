<?php
error_reporting(E_ALL ^ E_NOTICE);
// ini_set('session.use_only_cookies','1');
session_start();
if( isset($_SESSION['username']))
echo "Welcome: " . $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container text-center">
<h1>OSSCET</h1>
</div>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
<ul class="nav">
<li class="nav-item"><a class="nav-link active" href=index.php>Home</a></li>
<?php
include_once 'db.php';
// ini_set('session.use_only_cookies','1');
session_start();

if( isset($_SESSION['username']))
{$user_id = $_SESSION['user_id'];
echo '<li class="nav-item"><a class="nav-link active" href="profile.php"><span class="glyphicon glyphicon-briefcase"></span> Profile</a></li>';
echo '<li class="nav-item"><a class="nav-link active" href="courses.php"><span class="glyphicon glyphicon-briefcase"></span> Courses</a></li>';
echo '<li class="nav-item"><a class="nav-link active" href="classes.php"><span class="glyphicon glyphicon-off"></span> Class offerings</a></li>';
echo '<li class="nav-item"><a class="nav-link active" href="schedule.php"><span class="glyphicon glyphicon-off"></span> My Schedule</a></li>';
echo '<li class="nav-item"><a class="nav-link active" href="grades.php"><span class="glyphicon glyphicon-off"></span> My Grades</a></li>';
$new_mail = mysqli_query($conn,"SELECT * from `messages`
        WHERE recipient_id = $user_id and message_status='u'");
        if ($new_mail->num_rows > 0){$unread = TRUE; $message_count = $new_mail->num_rows;}
        else {$unread = FALSE;}
echo '<li class="nav-item"><a class="nav-link active" href="messages.php"><span class="glyphicon glyphicon-off"></span> My Messages';
if($unread == TRUE){echo ' (' . $message_count . ' new)';}
echo '</a></li>';
echo '<li class="nav-item"><a class="nav-link active" href="logout.php"><span class="glyphicon glyphicon-off"></span> Logout</a></li>';
}
else
{
echo '<li class="nav-item"><a class="nav-link active" href="login.php"><span class="glyphicon glyphicon-user"></span> Login</a></li>';
echo '<li class="nav-item"><a class="nav-link active" href="registration.php"><span class="glyphicon glyphicon-pencil"></span> Registration</a></li>';
}
?>
</ul>
</nav>
</body>
</html>