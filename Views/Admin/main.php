<?php
    include_once 'Enviroment/Session.php';
    include_once 'Enviroment/User.php';
    include_once 'Dictionaries/UserRolesDictionary.php';

    $session = Session::getInstance();
    $user = unserialize($session -> __get("user"));
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
    <div class="col-md-9">
        <div class="panel panel-info">
            <div class="panel-heading">
                Zarządzanie systemem e-learningowym
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4><span class="glyphicon glyphicon-book"></span> Kursy</h4>
                        <hr />
                        <ul>
                            <li><a href='index.php?con=5&page=2'>Dodaj kurs</a></li>
                            <li><a href='index.php?con=5&page=3'>Zarządzanie kursami</a></li>
                        </ul>
                        <br />
                        <h4><span class="glyphicon glyphicon-tasks"></span> Lekcje</h4>
                        <hr />
                        <ul>
                            <li><a href='index.php?con=5&page=12'>Dodaj lekcje</a></li>
                            <li><a href='index.php?con=5&page=14'>Dodaj moduł</a></li>
                            <li><a href='index.php?con=5&page=99'>Zarządzanie lekcjami</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h4><span class="glyphicon glyphicon-user"></span> Użytkownicy</h4>
                        <hr />
                        <ul>
                            <li><a href='index.php?con=5&page=9'>Przeglądaj użytkowników</a></li>
                        </ul>
                        <br />
                        <br />
                    </div>
                </div>
            </div>
    </div>
</div>