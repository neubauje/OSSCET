<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Classes</title>
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
                    </div>
                    <?php
                    include_once 'db.php';
                    if(isset($_POST['preload_class']))
	{	
		 $course_id = $_POST['course_id'];}
         
         else{
            $course_id = "Please enter a course ID";
         }

         $teacher_id = $_SESSION['username']; ?>

<form method="POST" action="classes.php">
<div class="form-group">
            <label for="course_id">Course ID</label>
            <input class="form-control" name='course_id' type="text" value="<?php echo $course_id;?>" />
        </div>
        <div class="form-group">
            <label for="teacher_id">Teacher ID</label>
            <input class="form-control" name='username' type="username" value="<?php echo $teacher_id;?>" />
        </div>
        <div class="form-group"><label for="semester_name">Semester </label><select name="room_id">
<?php $semesters = mysqli_query($conn,"SELECT * from semesters ORDER BY `start_date`"); $l=0;
                    while($semesters_list = mysqli_fetch_array($semesters)) {
                        $semester_name = $semesters_list["semester_name"];
                    ?>
                    <option value="<?php echo $semester_name ?>"> <?php echo $semester_name; ?></option>
                    <?php
                    $l++;
                    } ?>
        </select></div>
        <div class="form-group"><label for="room_id">Room </label><select name="room_id">
<?php $rooms = mysqli_query($conn,"SELECT * from rooms"); $j=0;
                    while($rooms_list = mysqli_fetch_array($rooms)) {
                        $room_id = $rooms_list["room_id"];
                    ?>
                    <option value="<?php echo $room_id ?>"> <?php echo $rooms_list["room_name"]; echo " in "; echo $rooms_list["building_name"]; ?></option>
                    <?php
                    $j++;
                    } ?>
        </select></div>
        <div class="form-group">
            <label for="start_time">Start time</label>
            <input class="form-control" name="start_time" type="time" />
            <label for="end_time">End time</label>
            <input class="form-control" name="end_time" type="time" /></div>
        <div class="form-group">Days of the week: 
        <input type="checkbox" name="monday" value="monday">Mon
        <input type="checkbox" name="tuesday" value="tuesday">Tue
        <input type="checkbox" name="wednesday" value="wednesday">Wed
        <input type="checkbox" name="thursday" value="thursday">Thur
        <input type="checkbox" name="friday" value="friday">Fri
        <input type="checkbox" name="saturday" value="saturday">Sat
        <input type="checkbox" name="sunday" value="sunday">Sun
        </div>
        <tr>
			<td colspan="2"><input type="submit" name='create_class' value="Save class offering" style="font-size:20px"></td>
		</tr>
</form>

    <?php if(isset($_POST['create_class'])){
    if ($room = $conn->prepare('SELECT room_id, room_name, building_name, capacity, ada_accessible, building_address FROM rooms WHERE room_id = ?')) {
        // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
        $room->bind_param('s', $_POST['room_id']);
        $room->execute();
        // Store the result so we can check if the room exists in the database.
        $room->store_result();
    
        if ($room->num_rows > 0) {
            $room->bind_result($room_id, $room_name, $building_name, $room_capacity, $ada_accessible, $building_address);
            $room->fetch();}}

    if ($course = $conn->prepare('SELECT course_id, default_max_capacity FROM courses WHERE course_id = ?')) {
                // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
                $course->bind_param('s', $_POST['course_id']);
                $course->execute();
                // Store the result so we can check if the room exists in the database.
                $course->store_result();
            
        if ($course->num_rows > 0) {
                    $course->bind_result($course_id, $course_capacity);
                    $course->fetch();}}
            
            if($room_capacity < $course_capacity){$occupancy = $room_capacity;}
            else{$occupancy = $course_capacity;}

            $semester_name = $_POST['semester_name'];
            $start_time = $_POST['start_time'];
            $end_time = $_POST['end_time'];
            $monday = isset($_POST['monday']);
            $tuesday = isset($_POST['tuesday']);
            $wednesday = isset($_POST['wednesday']);
            $thursday = isset($_POST['thursday']);
            $friday = isset($_POST['friday']);
            $saturday = isset($_POST['saturday']);
            $sunday = isset($_POST['sunday']);
    
		 $sql_query = "INSERT INTO `offerings` (`course_id`, `teacher_id`, `room_id`, `occupancy`, `vacancies`, `semester_name`, `start_time`, `end_time`,
          `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`)
		 VALUES ('$course_id', '$teacher_id', '$room_id', '$occupancy', '$occupancy', '$semester_name', '$start_time', '$end_time', 
         '$monday', '$tuesday', '$wednesday', '$thursday', '$friday', '$saturday', '$sunday')";
	
		 if (mysqli_query($conn, $sql_query)) 
		 {
			echo "New class offered successfully!";
		 } 
		 else
		 {
			echo "Error: " . $sql . "" . mysqli_error($conn);
		 }}
                    $result = mysqli_query($conn,"SELECT * FROM offerings 
                    INNER JOIN teachers ON offerings.teacher_id=teachers.teacher_id 
                    INNER JOIN courses ON offerings.course_id=courses.course_id 
                    INNER JOIN subject_tracks ON courses.track_id=subject_tracks.track_id 
                    INNER JOIN semesters ON offerings.semester_name=semesters.semester_name ORDER BY `start_date`");
                    $tracks = mysqli_query($conn,"SELECT * from subject_tracks");
                    $courses = mysqli_query($conn,"SELECT * from courses");
                    ?>
 
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                    ?>
                      <table class='table table-bordered table-striped'>
                       <th>Semester</th>
                      <th>Name</th>
                      <th>Track</th>
                        <th>Summary</th>
                        <th>Credit hours</th>
                        <th>Seats remaining</th>
                        <th>Location</th>
                        <th>Instructor</th>
                        
                    <?php
                    $i=0;
                    while($row = mysqli_fetch_array($result)) {
                        $teacher_name = $row['prefix'] . ' ' . $row['first_name'] . ' ' . $row['last_name'];
                    ?>
                    <tr>
                        <td><?php echo $row["semester_name"]; ?></td>
                        <td><?php echo $row["course_id"]; echo ': '; echo $row["course_name"]; ?></td>
                        <td><?php echo $row["track_name"]; ?></td>
                        <td width:1000px><?php echo $row["summary"]; ?></td>
                        <td><?php echo $row["credits"]; ?></td>
                        <td><?php echo $row["vacancies"]; echo " out of "; echo $row["occupancy"]; ?></td>
                        <td><?php echo $row["room_id"]; ?></td>
                        <td><?php echo $teacher_name; ?></td>
                        <!-- <td><form method="POST" action="classes.php"><input type="hidden" name="whatever" value="$row['course_id']"><input type="submit" name="create_class" value="Teach this course"></form></td> -->
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
    This is where teachers can view a list of all classes currently being offered. 
    Each class will have a title, a course number, number of credits, a list of any prerequesites, the department or subject track it falls under, 
    the name and description of the instructor offering the course, the days and time it is scheduled for, and its location (if applicable, some courses may be remote). 
    There should also be a display of how many students are already enrolled, and how many additional seats are still available.
    Teachers may also create a class offering from here, with a form that will feature a drop-down/search bar to select the course number/name.
    In order for a class to be successfully created, it must not interfere with any other class offered by the same teacher, nor with any other class offered in the same room.
</div>
</body>
</html>