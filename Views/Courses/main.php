<?php
    include_once 'Enviroment/DbContext.php';

    $dbContext = new DbContext();
    $selectStatement = "SELECT * FROM courses";
    $courseList = $dbContext -> Select($selectStatement);
?>
<div class="alert alert-info">
  <strong>Info</strong> Kliknij na kurs by zobaczyć jego opis.
</div>
<h2>Kursy dostępne w serwisie</h2>
<hr />
 <div class="panel-group" id="accordion">
 <?php
    if ($courseList -> num_rows > 0)
    {
        while ($row = $courseList -> fetch_assoc())
        {
            $courseId = $row["id"];
            $courseTitle = $row["title"];
            $courseDesc = $row["description"];

            echo '<div class="panel panel-default">';
            echo '<div class="panel-heading">';
            echo '<h4 class="panel-title">';
            echo '<a data-toggle="collapse" data-parent="#accordion" href="#collapse' . $courseId . '">';
            echo $courseTitle . '</a>';
            echo '<a href="index.php?con=6&page=2&course=' . $courseId . '" class="btn btn-success btn-sm" style="float: right; margin-top: -6px;">Zapisz</a>';
            echo '</h4>';
            echo '</div>';

            echo '<div id="collapse' . $courseId . '" class="panel-collapse collapse">';
            echo '<div class="panel-body">';
            echo $courseDesc;
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }
 ?>
</div> 