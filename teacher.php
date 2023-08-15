<!DOCTYPE html>
<html lang="en">
<head>
<title>Teacher profile</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="container text-center">
<h1>Teacher profile information</h1>
</div>
<c:url var="teacherUrl" value="/teacher"/>
<?php
if (!(isset($_SESSION['title']))){$_SESSION['title'] = "Mx.";}
if (!(isset($_SESSION['email']))){$_SESSION['email'] = "student@uagc.edu";}
if (!(isset($_SESSION['phone']))){$_SESSION['phone'] = "(111)222-3333";}
if (!(isset($_SESSION['ssn']))){$_SESSION['ssn'] = "111-22-3333";}
if (!(isset($_SESSION['bank_account_number']))){$_SESSION['bank_account_number'] = "123456789";}
if (!(isset($_SESSION['bank_routing_number']))){$_SESSION['bank_routing_number'] = "0102030405";}
if (!(isset($_SESSION['mailing_address']))){$_SESSION['mailing_address'] = "1401 University of AZ \n Tucson, AZ \n 85719";}
if (!(isset($_SESSION['bio_summary']))){$_SESSION['bio_summary'] = "This is a placeholder for where your biography/summary should go. It will be shown to students, describing you. Please put it in 3rd person and make sure to include your pronouns.";}
?>
<form action="connect.php" method="post" modelAttribute="teacher">

        <div class="form-group">
            <label for="username">Username</label>
            <input class="form-control" name='username' type="username" value="<?php echo $_SESSION['username'];?>" />
        </div>
        <div class="form-group">
            <label for="title">Title</label>
            <input class="form-control" name='title' type="text" value="<?php echo $_SESSION['title'];?>" />
        </div>
        <div class="form-group">
            <label for="first_name">First name</label>
            <input class="form-control" name='first_name' type="text" value="<?php echo $_SESSION['first_name'];?>" />
        </div>
        <div class="form-group">
            <label for="last_name">Last name</label>
            <input class="form-control" name='last_name' type="text" value="<?php echo $_SESSION['last_name'];?>" />
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input class="form-control" name='email' type="email" value="<?php echo $_SESSION['email'];?>" />
        </div>
        <div class="form-group">
            <label for="phone">Phone number</label>
            <input class="form-control" name='phone' type="phone" value="<?php echo $_SESSION['phone'];?>" />
        </div>
        <div class="form-group">
            <label for="ssn">Social security number</label>
            <input class="form-control" name='ssn' type="text" value="<?php echo $_SESSION['ssn'];?>" />
        </div>
        <div class="form-group">
            <label for="bank_account_number">Bank account number</label>
            <input class="form-control" name='bank_account_number' type="text" value="<?php echo $_SESSION['bank_account_number'];?>" />
        </div>
        <div class="form-group">
            <label for="bank_routing_number">Bank routing number</label>
            <input class="form-control" name='bank_routing_number' type="text" value="<?php echo $_SESSION['bank_routing_number'];?>" />
        </div>
        <div class="form-group">
            <label for="mailing_address">Mailing address</label>
            <input class="form-control" name="mailing_address" type="textarea" value="<?php echo $_SESSION['mailing_address'];?>" />
        </div>
        <div class="form-group">
            <label for="bio_summary">Public summary</label>
            <input class="form-control" name="bio_summary" type="textarea" value="<?php echo $_SESSION['bio_summary'];?>" />
        </div>
        <tr>
			<td colspan="2"><input type="submit" name='update_teacher' value="Save profile" style="font-size:20px"></td>
		</tr>
    </form>
</body>
</html>