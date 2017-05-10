<?php
    include_once 'Enviroment/DbContext.php';
    include_once 'Enviroment/Session.php';
    include_once 'Enviroment/User.php';
    include_once 'Dictionaries/UserRolesDictionary.php';

    $session = Session::getInstance();
    $user = unserialize($session -> __get("user"));

    $context = new DbContext();
    $courseStatement = "SELECT * FROM courses";

    $courseList = $context -> Select($courseStatement);
?>
<h2>Panel Administracyjny</h2>
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
    <div class="col-md-9">
        <div class="panel panel-info">
            <div class="panel-heading">
                Dodanie nowej lekcji
            </div>
            <div class="panel-body">
                <form method="POST" action="index.php?con=5&page=13">
                        <div class="form-group">
                            <label class="control-label" for="lessonName">Nazwa:</label>
                            <input class="form-control" name="lessonName" placeholder="Wprowadź nazwę lekcji">
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="forCourse">Kurs:</label>
                            <select class="form-control" name="forCourse">
                                <option value="-1"></option>
                                <?php
                                    while ($row = $courseList -> fetch_assoc())
                                    {
                                        $courseId = $row["id"];
                                        $courseTitle = $row["title"];
                                        echo "<option value='$courseId'>$courseTitle</option>";
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="countOfModules">Liczba modułów:</label>
                            <input class="form-control" name="countOfModules" placeholder="Wprowadź liczbę modułów">
                        </div>

                        <div class="form-group">
                            <button type="submit" style="float: right;" class="btn btn-primary">Dodaj lekcję</button> 
                            <a href="index.php?con=5&page=1" type="button" style="float: right; margin-right: 5px;" class="btn btn-default">Cofnij</a> 
                        </div> 
                    </form>  
            </div>
    </div>
</div>