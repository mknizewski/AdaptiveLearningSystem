<?php 
    include_once 'Enviroment/Session.php';
    include_once 'Enviroment/User.php';
    include_once 'Enviroment/DbContext.php';
    include_once 'Dictionaries/UserRolesDictionary.php';

    $session = Session::getInstance();
    $dbContext = new DbContext();
    $user = unserialize($session -> __get("user"));
    $courseId = $_GET["course"];

    $cStatement = "SELECT * FROM courses WHERE id=" . $courseId;
    $lStatement = "SELECT * FROM lessons WHERE course_id=" . $courseId;

    $course = $dbContext -> Select($cStatement) -> fetch_assoc();
    $lessonList = $dbContext -> Select($lStatement);

    echo "<h2> Kurs - " . $course["title"] . "</h2>";
?>
<hr />
<div class="row">
  <div class="col-sm-3">
    <div class="panel panel-primary">
        <div class="panel-heading">Nawigacja</div>
        <div class="panel-body"> 
              <ul>
                <li><a href="index.php?con=4&page=1">Główna</a></li>
                <li><a href="#">Dostępne kursy</a></li>
                <li><a href="#">Kontakt</a></li>
                <?php
                    if ($user -> RoleId == UserRolesDictionary::ADMIN)
                    {
                        echo '<li><a href="index.php?con=5&page=1">Panel administracyjny</a></li>';
                    }
                    else
                    {
                        echo '<li><a href="index.php?con=4&page=3">Ankieta adaptacyjna</a></li>';
                    }
                ?>
            </ul> 
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">Ustawienia konta</div>
        <div class="panel-body">
            <ul>
                <li><a href="index.php?con=4&page=5">Zmiana hasła</a></li>
                <li><a href="index.php?con=4&page=2">Sprawdź uprawnienia</a></li>
            </ul> 
        </div>
    </div>
  </div>

  <div class="col-sm-6">
    <div class="panel panel-info">
        <div class="panel-heading">Lekcje w kursie</div>
        <div class="panel-body">
            <div class="list-group">
            <?php
                while ($row = $lessonList -> fetch_assoc())
                {
                    $lessonId = $row["id"];
                    $lessonTitle = $row["title"];
                    $lessonInsertTime = $row["insert_time"];

                    echo '<a href="index.php?con=6&page=4&l=' . $lessonId . '&c=' . $courseId . '" class="list-group-item list-group-item-warning">';
                    echo '<div class="row">';
                    echo '<div class="col-md-6"><b>' . $lessonTitle . '</b></div>';
                    echo '<div class="col-md-6" style="text-align: right;">' . $lessonInsertTime . '</div>';
                    echo '</div>';
                    echo '</a>';
                }
            ?>
            </div>
            <a href="index.php?con=4&page=1" style="float: right;" class="btn btn-default">Cofnij</a>
        </div>
    </div>
  </div>

  <div class="col-sm-3">
    <div class="panel panel-primary">
        <div class="panel-heading">Wyszukiwarka</div>
        <div class="panel-body">
            <form class="form-inline" method="POST" action="">
                <div class="form-group">
                    <input type="text" placeholder="Wpisz szukaną frazę" name"search" class="form-control" />
                </div>
                <button type="submit" class="btn btn-default">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </form>
        </div>
    </div>
  </div>
</div>