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
                        <h3 class="pull-left">Courses List</h3>
                    </div>
                    <?php
                    include_once 'db.php';
                    if(isset($_POST['create_course']))
	{	
		 $course_id = $_POST['course_id'];
		 $course_name = $_POST['course_name'];
		 $summary = $_POST['summary'];
		 $credits = $_POST['credits'];
         $default_max_capacity = $_POST['default_max_capacity'];
         $track_id = $_POST['track_id'];
	
		 $sql_query = "INSERT INTO `courses` (`course_id`, `course_name`, `summary`, `credits`, `default_max_capacity`, `track_id`)
		 VALUES ('$course_id', '$course_name', '$summary', '$credits', '$default_max_capacity', '$track_id')";
	
		 if (mysqli_query($conn, $sql_query)) 
		 {
			echo "New course created successfully!";
		 } 
		 else
		 {
			echo "Error: " . $sql . "" . mysqli_error($conn);
		 }}
                    $result = mysqli_query($conn,"SELECT * FROM courses INNER JOIN subject_tracks ON courses.track_id=subject_tracks.track_id");
                    $tracks = mysqli_query($conn,"SELECT * from subject_tracks");
                    ?>
 
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                    ?>
                      <table class='table table-bordered table-striped'>
                       
                      <th>Name</th>
                        <th>Summary</th>
                        <th>Credit hours</th>
                        <th>Capacity</th>
                        <th>Track</th>

                      <tr><form method="POST" action="courses.php">
                        <td><input type="text" name="course_id" placeholder="Course ID"> <input type="text" name="course_name" placeholder="Course title"></td>
                        <td><textarea class="form-control" placeholder="Summarize the new course." name="summary"></textarea></td>
                        <td><input type="number" name="credits"></td>
                        <td><input type="number" name="default_max_capacity"></td>
                        <td><select name="track_id">
                            <?php
                    $i=0;
                    while($track_listing = mysqli_fetch_array($tracks)) {
                        $subject_id = $track_listing["track_id"];
                    ?>
                    <option value="<?php echo $subject_id ?>"> <?php echo $track_listing["track_name"] ?></option>
                    <?php
                    $i++;
                    }
                    ?></select></td>
                        <td><input type="submit" name="create_course" value="Create a new course"></td>
                      </form></tr>
                    <?php
                    $i=0;
                    while($row = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
                        <td><?php 
                        $row_course_id = $row["course_id"]; echo $row_course_id; echo ': '; echo $row["course_name"]; ?></td>
                        <td width:1000px><?php echo $row["summary"]; ?></td>
                        <td><?php echo $row["credits"]; ?></td>
                        <td><?php echo $row["default_max_capacity"]; ?></td>
                        <td><?php echo $row["track_name"]; ?></td>
                        <td><form method="POST" action="classes.php"><input type="hidden" name="course_id" value="<?php echo $row_course_id; ?>"><input type="submit" name="preload_class" value="Teach this course"></form></td>
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
    This is where teachers will view a list of all courses taught at the school. 
    Each course will have a description, a course number, number of credits, a list of any prerequesites, the department or subject track it falls under, 
    and a link to the class offerings currently available for that course. Teachers will be given the option to edit the information for each course, 
    to create a new course, or to list an offering for a course as its instructor. Offering a course will take the teacher to the Classes page, 
    with a new form already partially filled in.
</body>
</html>
