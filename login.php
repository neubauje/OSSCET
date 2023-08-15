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
?>

<div class="container text-center">
<h1>Welcome to the OSSCET Login page</h1>
</div>
<form action="connect.php" method="post" modelAttribute="user">
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