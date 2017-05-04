<?php
    include_once 'Enviroment/Session.php';
    include_once 'Enviroment/User.php';
    include_once 'Enviroment/DbContext.php';
    include_once 'Dictionaries/UserRolesDictionary.php';

    $session = Session::getInstance();
    $dbContext = new DbContext();
    $user = unserialize($session -> __get("user"));

    $selectStatement = "SELECT * FROM users";
    $coursesList = $dbContext -> Select($selectStatement);
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
                <li><a href="#">Zmiana hasła</a></li>
                <li><a href="index.php?con=4&page=2">Sprawdź uprawnienia</a></li>
            </ul> 
        </div>
    </div>
  </div>
    <div class="col-md-9">
        <div class="panel panel-info">
            <div class="panel-heading">
                Lista utworzonych kursów
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tytuł</th>
                            <th>Data utworzenia</th>
                            <th>Dodaj użytkownika</th>
                            <th>Opis</th>
                            <th>Edycja</th>
                            <th>Usun</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            echo "lista";
                            
                        ?>
                    </tbody>
                </table>

                <a href="index.php?con=5&page=1" style="float: right;" class="btn btn-default">Cofnij</a>
            </div>
        </div>
        <div class="panel panel-info" id="courseDiv" style="display: none;">
            <div class="panel-heading" id="courseTitle">
            </div>
            <div class="panel-body" id="courseDesc"></div>
        </div>
    </div>
</div>

<script>
    function ShowCourseDesc(title, description)
    {
        var usersList = document.getElementById("usersList");
        var userRoleId = document.getElementById("role_id");
        var userLearningStyleId = document.getElementById("learning_style_id");
		var userName = document.getElementById("name");
		var userSurname = document.getElementById("surName");

        courseDiv.style.display = "inline";
        courseTitle.innerHTML = title;
        courseDesc.innerHTML = description;
    }
</script>