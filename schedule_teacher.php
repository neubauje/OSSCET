<!DOCTYPE html>
<html lang="en">
<head>
<title>Schedule</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="container text-center">
<h1>My schedule</h1>
</div>
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
                        <h3 class="pull-left">Offered classes</h3>
                    </div>
                    <?php
                    include_once 'db.php';

                    if(isset($_POST['cancel_class'])){
                        $selected_class_id = $_POST['class_id'];
                        if($search_classes = $conn->prepare('SELECT * from offerings where class_id=?')){
                            $search_classes->execute([$selected_class_id]);
                            $search_classes_result = $search_classes->get_result();
                            if($search_classes_result->num_rows > 0){
                                $sql_cancel_class = "DELETE from offerings WHERE `class_id` = $selected_class_id";
                           
                                if (mysqli_query($conn, $sql_cancel_class)) 
                                {
                                   echo "Successfully canceled class.";?>
                                   <meta http-equiv="refresh" content="0;URL=schedule.php" /><?php
                                } 
                                else
                                {
                                   echo "Error: " . $sql . "" . mysqli_error($conn);
                                }
                            }
                        }
                    }

         $teacher_id = $_SESSION['username'];
         $teacher_user_id = $_SESSION['user_id'];
         $result = mysqli_query($conn,"SELECT * FROM offerings
                    INNER JOIN teachers ON offerings.teacher_user_id=teachers.user_id 
                    INNER JOIN courses ON offerings.course_id=courses.course_id 
                    INNER JOIN rooms ON offerings.room_id=rooms.room_id
                    INNER JOIN semesters ON offerings.semester_name=semesters.semester_name 
                    WHERE offerings.teacher_user_id = '$teacher_user_id'
                    ORDER BY `start_date`");
                    if ($result->num_rows > 0) {

                        ?>
                          <table class='table table-bordered table-striped'>
                           <th>Semester</th>
                           <th>Name</th>
                            <th>Summary</th>
                            <th>Credit hours</th>
                            <th>Location</th>
                            <th>Time slot</th>
                            <th>Current enrollment</th>
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
                            $enrolled_students = $row["occupancy"] - $row["vacancies"];
                        ?>
                        <tr>
                            <td><?php echo $row["semester_name"]; ?></td>
                            <td><?php echo $row["course_id"]; echo ': '; echo $row["course_name"]; ?></td>
                            <td><?php echo $row["summary"]; ?></td>
                            <td><?php echo $row["credits"]; ?></td>
                            <td><?php echo $location; ?></td>
                            <td><?php echo $time_slot; ?></td>
                            <td><?php echo $enrolled_students; ?></td>
                            <?php $displayed_class_id = $row["class_id"];
                            if($search_enrollments = $conn->prepare('SELECT * from enrollment where class_id=? and enrollment_status="a"')){
                                $search_enrollments->execute([$displayed_class_id]);
                                $search_enrollments_result = $search_enrollments->get_result();
                            if($search_enrollments_result->num_rows > 0){ ?>
                                <td><form method="POST" action="schedule.php"><input type="hidden" name="class_id" value="<?php echo $row['class_id'] ?>"><input type="submit" name="yoink" value="Cannot (yet) cancel a class with students in it."></form></td> 
                                <?php }
                            else { ?>
                            <td><form method="POST" action="schedule.php"><input type="hidden" name="class_id" value="<?php echo $row['class_id'] ?>"><input type="submit" name="cancel_class" value="Cancel this class"></form></td>
                           <?php }} ?>
                        </tr>
                        <?php
                        $i++;
                        }
                        ?>
                        </table>
                         <?php
                        }
                        else{
                            echo "You are not currently offering any classes.";
                        }?>
                </div>
            </div>
<div>
    This is where teachers can view the shape of their schedule for the current and upcoming semesters, based on the classes they've offered. 
    Teachers may rescind an offered class from here, but will be prompted with a warning if there are already students enrolled in that class.
</div>
</body>
</html>