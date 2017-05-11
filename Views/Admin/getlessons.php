<?php
    $db_name = "als";
    $db_host = "localhost";
    $db_user = "root";
    $db_password = "";

    $connection = new mysqli($db_host, $db_user, $db_password, $db_name);
    $response = "";
    $courseId = $_POST["cId"];
    $selectStatement = "SELECT * FROM lessons WHERE course_id=" . $courseId;
    $lessonsList = $connection -> query($selectStatement);
    
    while ($row = $lessonsList -> fetch_assoc())
    {
        $lessonId = $row["id"];
        $lessonTitle = $row["title"];

        $response = $response . " <option value='$lessonId'>$lessonTitle</option>";
    }

    echo $response;
?>