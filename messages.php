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
    include_once 'db.php';
    $user_id = $_SESSION['user_id'];

    //save a new message to the database
if(isset($_POST['send_message'])){
    $recipient_id = $_POST['recipient_id'];
    $sender_id = $_SESSION['user_id'];
    $message_subject = $_POST['message_subject'];
    $message_content = $_POST['message_content'];

    $create_message = "INSERT INTO `messages` (recipient_id, sender_id, message_subject, message_content)
    VALUES ('$recipient_id', '$sender_id', '$message_subject', '$message_content')";

if (mysqli_query($conn, $create_message)) 
{
   echo "Message sent successfully!";?>
   <meta http-equiv="refresh" content="0;URL=messages.php" /> <?php
} 
else
{
   echo "Error: " . $sql . "" . mysqli_error($conn);
}
}

//if neither a student nor a teacher, what are you doing here?
if($_SESSION['role_id'] == 3){
    echo "You are a new applicant. Please go to <li><a href='profile.php'><span class='glyphicon glyphicon-briefcase'></span>Profile</a></li> in order to select a role before attempting to send messages.";
}


else{ 

//if a student, find classes you're enrolled in
    if(($_SESSION['role_id'] == 1) or ($_SESSION['role_id'] == 1))
    {$my_classes_search = mysqli_query($conn, "SELECT * from enrollment
    WHERE enrollment.user_id = '$user_id' and enrollment_status = 'a'");}

//if a teacher, find classes you're teaching
    if(($_SESSION['role_id'] == 4) or ($_SESSION['role_id'] == 5))
    {$my_classes_search = mysqli_query($conn, "SELECT * from offerings
    WHERE offerings.teacher_user_id = '$user_id'");}

$contacts_list = [];

//gather all students in the classes we found
while($my_classes_list = mysqli_fetch_array($my_classes_search)){
    $my_class_id = $my_classes_list["class_id"];
    $classmates_search = mysqli_query($conn, "SELECT * from enrollment WHERE enrollment.class_id = '$my_class_id' and enrollment_status = 'a'");
    $classmates_search_result = mysqli_fetch_array($classmates_search);
    $classmates_list = $classmates_search_result["user_id"];
    while($my_classmate = mysqli_fetch_array($classmates_list)){
    array_push($contacts_list, $my_classmate);}
}

//if a student, also gather the teachers of the classes we found
if(($_SESSION['role_id'] == 1) or ($_SESSION['role_id'] == 1)){
    while($my_classes_list = mysqli_fetch_array($my_classes_search)){
        $my_class_id = $my_classes_list["class_id"];
        $enrollment_search = mysqli_query($conn, "SELECT * from offerings WHERE class_id = '$my_class_id'");
        $enrollment_search_result = mysqli_fetch_array($enrollment_search);
        $teachers_list = $enrollment_search_result["teacher_user_id"];
        while($my_teacher = mysqli_fetch_array($teachers_list)){
        array_push($contacts_list, $my_teacher);}
    }
}

//form to compose a new message
    ?>

    <form method="POST" action="messages.php">
        
<div class="form-group">
    <label for="recipient_id">To:</label>
    <select name="recipient_id">
<?php while($my_contact = mysqli_fetch_array($contacts_list)){
$contacts_query = mysqli_query($conn, "SELECT username, first_name, last_name, role_id, role_name FROM users 
INNER JOIN roles on users.role_id=roles.role_id
WHERE user_id = $my_contact ");
$contact_username = $contacts_query['username'];
$contact_first_name = $contacts_query['first_name'];
$contact_last_name = $contacts_query['last_name'];
$contact_role_id = $contacts_query['role_id'];
$contact_role_name = $contacts_query['role_name'];
?>
<option value="<?php echo $my_contact; ?>"> <?php echo $contact_first_name . " " . $contact_last_name . ", " . $contact_role_name; ?></option>
<?php } ?>
</select></div>

<div class="form-group">
    <label for="message_subject">Subject</label>
    <input class="form-control" name="message_subject" type="text" />
</div>
<div class="form-group">
    <label for="message_content">Body</label>
    <input class="form-control" name="message_content" type="textarea" />
</div>
<tr>
    <input type="submit" name='send_message' value="Send" style="font-size:20px"></td>
</tr>
</form>


    <?php 
    //list all messages to or from you
        $messages = mysqli_query($conn,"SELECT * FROM messages 
        WHERE sender_id = '$user_id' or recipient_id = '$user_id'
        ORDER BY `message_timestamp` desc");

    echo "This is where you can view your messages and respond to them. You can also initiate a new message to anyone teaching or enrolled in one of your classes. 
    This is also where you will find automated system notifications, such as an alert that a seat has become available for a class that you were on the waiting list for.";
}

?>
<?php include 'footer.php';?>
</body>
</html>
