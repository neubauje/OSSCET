<!DOCTYPE html>
<html lang="en">
<head>
<title>Classes</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="container text-center">
<h1>Student-facing class offerings</h1>
</div>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Courses</title>
    <style type="text/css">
        .bs-example{
            margin: 10px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="bs-example">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h3 class="pull-left">Class offerings list</h3>
    <?php if(isset($_POST['search_classes'])){ ?><form method="POST" action="classes.php"><input type="submit" name="see_all" value="See all"></form> <?php } ?>
                    </div>
                    <?php
                    include_once 'db.php';

         $student_id = $_SESSION['username']; 
                    $result = mysqli_query($conn,"SELECT * FROM offerings 
                    INNER JOIN rooms on offerings.room_id=rooms.room_id
                    INNER JOIN teachers ON offerings.teacher_id=teachers.teacher_id 
                    INNER JOIN courses ON offerings.course_id=courses.course_id 
                    INNER JOIN subject_tracks ON courses.track_id=subject_tracks.track_id 
                    INNER JOIN semesters ON offerings.semester_name=semesters.semester_name ORDER BY `start_date`");
                    $tracks = mysqli_query($conn,"SELECT * from subject_tracks");
                    $courses = mysqli_query($conn,"SELECT * from courses");
if(isset($_POST['enroll'])){
    $selected_class_id = $_POST['class_id'];
    if($search_enrollments = $conn->prepare('SELECT * from enrollment where class_id=? and student_id=?')){
        $search_enrollments->execute([$selected_class_id, $student_id]);
        $search_enrollments_result = $search_enrollments->get_result();
        if($search_enrollments_result->num_rows <1)
        {$seats_query = mysqli_query($conn, "SELECT vacancies FROM offerings WHERE `class_id`=$selected_class_id");
            $vacant_seats = mysqli_fetch_assoc($seats_query);
            echo "Printing array: ";
            echo '<pre>'; print_r($vacant_seats); echo '</pre>';
            $seats_number = $vacant_seats[0];
            if($seats_number > 0){$sql_query_enroll = "INSERT INTO `enrollment` (`class_id`, `student_id`, `status`)
            VALUES ($selected_class_id, '$student_id', 'a')";
            $updated_seats = $seats_number--;
            $sql_query_seat = "UPDATE `offerings` SET `vacancies` = $updated_seats WHERE `class_id` = $selected_class_id";
       
            if (mysqli_query($conn, $sql_query_enroll) && mysqli_query($conn, $sql_query_seat)) 
            {
               echo "Successfully registered for class!";
            } 
            else
            {
               echo "Error: " . $sql . "" . mysqli_error($conn);
            }}
        else{ echo "Class is full. Wait list functionality under development.";}}
    }
}
                   
if(isset($_POST['search_classes'])){
    if ($search = $conn->prepare('SELECT class_id, offerings.course_id, offerings.teacher_id, offerings.room_id, 
    occupancy, vacancies, offerings.semester_name, start_time, end_time, 
    monday, tuesday, wednesday, thursday, friday, saturday, sunday, 
    room_name, building_name, capacity, building_address, 
    prefix, first_name, last_name, bio_summary,
    course_name, summary, credits, courses.track_id, default_max_capacity,
    track_name FROM offerings 
    INNER JOIN rooms on offerings.room_id=rooms.room_id
    INNER JOIN teachers ON offerings.teacher_id=teachers.teacher_id 
    INNER JOIN courses ON offerings.course_id=courses.course_id 
    INNER JOIN subject_tracks ON courses.track_id=subject_tracks.track_id 
    INNER JOIN semesters ON offerings.semester_name=semesters.semester_name 
    WHERE offerings.course_id = ?
    ORDER BY `start_date`')){
        // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
$search->bind_param('s', $_POST['course_id']);
$search->execute();
// Store the result so we can check if the account exists in the database.
$search_result = $search->get_result();
    }
    $result = $search_result;}

                    if ($result->num_rows > 0) {

                    ?>
                      <table class='table table-bordered table-striped'>
                       <th>Semester</th>
                       <th>Name</th>
                       <th>Track</th>
                        <th>Summary</th>
                        <th>Cr hrs</th>
                        <th>Seats remaining</th>
                        <th>Location</th>
                        <th>Instructor</th>
                        <th>Time slot</th>
                    <?php
                    $i=0;
                    while($row = mysqli_fetch_array($result)) {
                        $teacher_name = $row['prefix'] . ' ' . $row['first_name'] . ' ' . $row['last_name'];
                        $location = $row['room_name'] . ' in ' . $row['building_name'];
                        $class_days = "";
                        if($row['monday'] == 1){$class_days = $class_days . 'M';}
                        if($row['tuesday'] == 1){$class_days = $class_days . 'Tu';}
                        if($row['wednesday'] == 1){$class_days = $class_days . 'W';}
                        if($row['thursday'] == 1){$class_days = $class_days . 'Th';}
                        if($row['friday'] == 1){$class_days = $class_days . 'F';}
                        if($row['saturday'] == 1){$class_days = $class_days . 'Sa';}
                        if($row['sunday'] == 1){$class_days = $class_days . 'Su';}
                        $time_slot = $row['start_time'] . ' to ' . $row['end_time'] . ' on ' . $class_days;
                    ?>
                    <tr>
                        <td><?php echo $row["semester_name"]; ?></td>
                        <td><?php echo $row["course_id"]; echo ': '; echo $row["course_name"]; ?></td>
                        <td><?php echo $row["track_name"]; ?></td>
                        <td><?php echo $row["summary"]; ?></td>
                        <td><?php echo $row["credits"]; ?></td>
                        <td><?php echo $row["vacancies"]; echo " out of "; echo $row["occupancy"]; ?></td>
                        <td><?php echo $location; ?></td>
                        <td><?php echo $teacher_name; ?></td>
                        <td><?php echo $time_slot; ?></td>
                        <td><form method="POST" action="classes.php"><input type="hidden" name="class_id" value="<?php echo $row['class_id'] ?>"><input type="submit" name="enroll" value="Enroll in this course"></form></td>
                    </tr>
                    <?php
                    $i++;
                    }
                    ?>
                    </table>
                     <?php
                    }
                    else{
                        echo "No result found";
                    }
                    ?>
                </div>
            </div>   
    </div>
<div>
    This is where students will view a list of all classes currently being offered. 
    Each class will have a title, a course number, number of credits, a list of any prerequesites, the department or subject track it falls under, 
    the name and description of the instructor offering the course, the days and time it is scheduled for, and its location (if applicable, some courses may be remote). 
    There should also be a display of how many students are already enrolled, and how many additional seats are still available.
    In order for a student to successfully enroll in a class, it must not interfere with any other classes the student is already enrolled in. 
    If the student is already enrolled full-time, the system will prompt a warning when the student attempts to enroll in an additional class.
    If a student attempts to enroll in a class with no available seats, they will be added to a waiting list for that class, 
    and also directed to view any other offerings for that same course.
</div>
</body>
</html>