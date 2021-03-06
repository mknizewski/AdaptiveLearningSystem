<?php 
    include_once 'Enviroment/Session.php';
    include_once 'Enviroment/User.php';
    include_once 'Enviroment/DbContext.php';
    include_once 'Dictionaries/UserRolesDictionary.php';
    include_once 'Dictionaries/LearningStyleDictionary.php';

    $session = Session::getInstance();
    $dbContext = new DbContext();
    $user = unserialize($session -> __get("user"));

    $courseId = $_GET["c"];
    $lessonId = $_GET["l"];
    $learningStyleId = $user -> GetLearningStyle();

    $mStatement = "SELECT * FROM modules WHERE lesson_id=" . $lessonId . " ORDER BY order_num";
    $lStatement = "SELECT * FROM lessons WHERE id=" .  $lessonId;

    $modulesList = $dbContext -> Select($mStatement);
    $lesson = $dbContext -> Select($lStatement) -> fetch_assoc();

    echo "<h2>Lekcja: <b>" . $lesson["title"] . "</b></h2>";
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
    <?php
        while ($row = $modulesList -> fetch_assoc())
        {
            $learningStyle = $row["learningstyle_id"];

            if ($learningStyle == LearningStyleDictionary::ALL || $learningStyle == $learningStyleId)
            {
                echo '<div class="panel panel-default">';
                echo '<div class="panel-heading">' . $row["title"] . '</div>';
                echo '<div class="panel-body">';
                echo $row["content"];
                echo '</div>';
                echo '</div>';
            }
        }
    ?>
    <?php
        echo "<a href='index.php?con=6&page=3&course=$courseId' style='float: right;' class='btn btn-default'>Cofnij</a>";
    ?>
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