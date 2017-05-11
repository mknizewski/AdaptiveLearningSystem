<?php 
    include_once 'Enviroment/Session.php';
    include_once 'Enviroment/User.php';
    include_once 'Enviroment/DbContext.php';
    include_once 'Dictionaries/UserRolesDictionary.php';

    $session = Session::getInstance();
    $dbContext = new DbContext();
    $user = unserialize($session -> __get("user"));

    $coursesStatement = "SELECT * FROM courses_users WHERE id_user=" . $user -> Id; 
    $usersCourseList = $dbContext -> Select($coursesStatement);

    echo "<h2> Twoje Konto - " . $user -> Name . " " . $user -> Surname . "</h2>";
?>
<hr />
<div class="row animated fadeIn">
  <div class="col-sm-3">
    <div class="panel panel-primary">
        <div class="panel-heading">Nawigacja</div>
        <div class="panel-body"> 
              <ul>
                <li><a href="index.php?con=4&page=1">Główna</a></li>
                <li><a href="#">Dostępne kursy</a></li>
                <li><a href="index.php?con=2&page=1">Kontakt</a></li>
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
        <div class="panel-heading">Przegląd moich kursów</div>
        <div class="panel-body">
            <?php
                while ($row = $usersCourseList -> fetch_assoc())
                {
                    $courseId = $row["id_course"];
                    $cSelect = "SELECT * FROM courses WHERE id=" . $courseId;
                    $course = $dbContext -> Select($cSelect) -> fetch_assoc();

                    echo '<div class="row">';
                    echo '<div class="col-md-6"> <p style="margin-top: 5px;"><b>' . $course["title"] . '</b></p></div>';
                    echo '<div class="col-md-6">';
                    echo '<a href="index.php?con=6&page=3&course=' . $courseId . '" class="btn btn-primary" style="float: right;">Przejdź</a>';
                    echo '</div>';
                    echo '</div>';

                    echo '<br />';
                }
            ?>
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