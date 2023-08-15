<?php
error_reporting(E_ALL ^ E_NOTICE)
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Registration Page</title>
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
<h1>Welcome to the Registration page</h1>
</div>
<c:url var="registerUrl" value="/register"/>
<form action="connect.php" method="post" modelAttribute="user">
        <div class="form-group">
            <label for="username">Username</label>
            <input class="form-control" name='username' type="username" placeholder="Create a username"/>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input class="form-control" name='password' type="password" placeholder="Create a password"/>
        </div>
        <div class="form-group">
            <label for="first_name">First name</label>
            <input class="form-control" name='first_name' type="text" placeholder="John"/>
        </div>
        <div class="form-group">
            <label for="last_name">Last name</label>
            <input class="form-control" name='last_name' type="text" placeholder="Doe"/>
        </div>
        <!-- <div class="form-group">
            <label for="confirmPassword">Confirm Password</label>
            <input class="form-control" name="password" placeholder="Confirm password"/>
        </div>
        <fieldset>
            <legend>Role</legend>
            <form:errors path="role" cssClass="bg-danger"/>
            <div class="radio">
               <label>
                    <input type="radio" path="role" value="teacher"/>
                    Teacher
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" path="role" value="student" checked="checked"/>
                    Student
                </label>
            </div>
        </fieldset> -->
        <tr>
			<td colspan="2"><input type="submit" name='register' value="Save User" style="font-size:20px"></td>
		</tr>
    </form>

<?php include 'footer.php';?>
</body>
</html>
