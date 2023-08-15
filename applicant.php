<!DOCTYPE html>
<html lang="en">
<head>
<title>New user profile</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="container text-center">
<h1>Please select a role</h1>
</div>
<c:url var="applicantUrl" value="/applicant"/>
<form action="connect.php" method="post" modelAttribute="user">
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
</body>
</html>