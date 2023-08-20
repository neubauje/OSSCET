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
                        <td><form method="POST" action="classes.php"><input type="hidden" name="course_id" value="<?php echo $row_course_id; ?>"><input type="submit" name="search_classes" value="See classes"></form></td>
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
    This is where students will view a list of all courses taught at the school. 
    Each course will have a description, a course number, number of credits, a list of any prerequesites, the department or subject track it falls under, 
    and a link to the class offerings currently available for that course.
</div>
</body>
</html>