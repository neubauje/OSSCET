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
// include 'messages_compose.php';

    //list all messages to or from you
        $messages = mysqli_query($conn,"SELECT * FROM messages 
        INNER JOIN users b on messages.sender_id=b.user_id
        INNER JOIN users bb on messages.recipient_id=bb.user_id
        WHERE sender_id = '$user_id' or recipient_id = '$user_id'
        ORDER BY `message_timestamp` desc");
        if ($messages->num_rows < 1){
            ?> <div>No messages found.</div> <?php ;}
        else{
            ?>
                          <table class='table table-bordered table-striped'>
                           <th>Sent</th>
                           <th>From</th>
                            <th>To</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Mark as Read</th>
                            <th>Reply</th>
                        <?php
                        $i=0;
                        while($row = mysqli_fetch_array($messages)) {
                            print_r(array_keys($row));
                            $sender_name = $row['b.first_name'] . ' ' . $row['b.last_name'];
                            $recipient_name = $row['bb.first_name'] . ' ' . $row['bb.last_name'];
                            $message_subject = $row['message_subject'];
                            $message_content = $row['message_content'];
                            $timestamp = $row['message_timestamp'];
                            $message_status = $row['message_status'];
                            $displayed_message_id = $row['message_id'];
                        ?>
                        <tr>
                            <td><?php echo $timestamp; ?></td>
                            <td><?php echo $sender_name ?></td>
                            <td><?php echo $recipient_name; ?></td>
                            <td><?php echo $message_subject; ?></td>
                            <td><?php echo $message_content; ?></td>
                            <?php 
                            if(($message_status == 'u') && ($row['recipient_id'] == $_SESSION['user_id'])){ ?>
                                <td><form method="POST" action="messages.php"><input type="hidden" name="message_id" value="<?php echo $displayed_message_id ?>"><input type="submit" name="read" value="Mark message as read"></form></td> <?php } ?>
                            <td><form method="POST" action="messages_compose.php"><input type="hidden" name="message_id" value="<?php echo $displayed_message_id ?>"><input type="submit" name="reply" value="Reply"></form></td>
                           <?php } ?>
                        </tr></table>
                        <?php
                        }


    echo "This is where you can view your messages and respond to them. You can also initiate a new message to anyone teaching or enrolled in one of your classes. 
    This is also where you will find automated system notifications, such as an alert that a seat has become available for a class that you were on the waiting list for.";


?>
<?php include 'footer.php';?>
</body>
</html>
