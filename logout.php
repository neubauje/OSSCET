<?php
error_reporting(E_ALL ^ E_NOTICE);
$_SESSION['loggedin'] = FALSE;
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>
label{display:inline-block;width:100px;margin-bottom:10px;}
</style>
<title>Online Self-Service Course Enrollment Tool</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.1/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.1/js/bootstrap.min.js"></script>
</head>
<body>

<?php require 'master.php';?>

<div class="container text-center">
<h1>Welcome to the Online Self-Service Course Enrollment Tool (OSSCET)</h1>
</div>
<meta http-equiv="refresh" content="0;URL=index.php" />
<?php require_once 'footer.php';?>
</body>
</html>