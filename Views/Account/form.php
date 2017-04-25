<?php 
    include_once 'Enviroment/Session.php';
    include_once 'Enviroment/User.php';
    include_once 'Dictionaries/UserRolesDictionary.php';

    $session = Session::getInstance();
    $user = unserialize($session -> __get("user"));

    echo "<h2> Ankieta adaptacyjna - " . $user -> Name . " " . $user -> Surname . "</h2>";
?>
<hr />
<div class="alert alert-info">
    Przed zaczęciem kursu prosimy o wypełnienie krótkiej ankiety. Pozwoli to sytemowi spersonalizować kurs specjalnie pod Ciebie.
</div>
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

  <div class="col-sm-6">
    <div class="panel panel-info">
        <div class="panel-heading">Ankieta adaptacyjna</div>
        <div class="panel-body">
             <form method="POST" action="index.php?con=4&page=4">
                <div>
                    <div class="form-group">
                        <b>Kiedy pierwszy raz posługuję się nowym dla mnie sprzętem...</b>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p0v"> Czytam instrukcję.</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p0a"> Słucham, ewentualnie dopytuję.</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p0k"> Uczę się obsługi na zasadzie prób i błędów.</label>
                    </div>
                </div>
                <br />
                <div>
                    <div class="form-group">
                        <b>Kiedy zgubiłem/am drogę…</b>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p1v"> Patrzę na mapę.</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p1a"> Pytam ludzi o wskazówki.</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p1k"> Idę 'na czuja' ewentualnie używam kompasu.</label>
                    </div>
                </div>
                <br />
                <div>
                    <div class="form-group">
                        <b>Najłatwiej zapamiętuję…</b>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p2v"> Twarze.</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p2a"> Imiona.</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p2k"> Rzeczy które robiłem/robiłam.</label>
                    </div>
                </div>
                <br />
                <div>
                    <div class="form-group">
                        <b>Większość wolnego czasu spędzam…</b>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p3v"> Oglądając telewizję.</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p3a"> Rozmawiając ze znajomymi.</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p3k"> Na aktywności fizycznej.</label>
                    </div>
                </div>
                <br />
                <div>
                    <div class="form-group">
                        <b>Podejrzewam, że ktoś kłamie…</b>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p4v"> Widzę, że unika wzroku.</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p4a"> Słyszę zmianę w tonie głosu.</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p4k"> Czuję to.</label>
                    </div>
                </div>
                <br />
                <div>
                    <div class="form-group">
                        <b>Kiedy powtarzam materiał na egzamin…</b>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p5v"> Robię mnóstwo notatek.</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p5a"> Czytam notatki sobie lub znajomym.</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p5k"> Wyobrażam sobie, jak piszę różne sformułowania.</label>
                    </div>
                </div>
                <br />
                <div>
                    <div class="form-group">
                        <b>Przy pierwszym kontakcie…</b>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p6v"> Jak osoba wygląda i jak jest.</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p6a"> Jaki ktoś ma głos i jak mówi.</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p6k"> Jaką osoba ma postawę i jak się.</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-default" style="float: right;">Zatwierdź</button>
            </form>
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