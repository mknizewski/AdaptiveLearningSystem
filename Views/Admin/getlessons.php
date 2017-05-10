<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/AdaptiveLearningSystem/Enviroment/DbContext.php');

    $response = "";
    $dbContext = new DbContext();
    $courseId = $_POST["cId"];
    $selectStatement = "SELECT * FROM lessons WHERE course_id=" . $courseId;
    $lessonsList = $dbContext -> Select($selectStatement);
    
    while ($row = $lessonsList -> fetch_assoc())
    {
        $lessonId = $row["id"];
        $lessonTitle = $row["title"];

        $response = $response . " <option value='$lessonId'>$lessonTitle</option>";
    }

    echo $response;
?>