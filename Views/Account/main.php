<?php 
    include_once 'Enviroment/Session.php';

    $session = Session::getInstance();
    $user = unserialize($session -> __get("user"));

    echo "<h2> Konto - " . $user -> Name . " " . $user -> Surname . "</h2>";
?>
<hr />
<div class="row">
  <div class="col-sm-3">
    <div class="panel panel-primary">
        <div class="panel-heading">Nawigacja</div>
        <div class="panel-body"> 
              <ul>
                <li><a href="#">Opcja 1</a></li>
                <li><a href="#">Opcja 1</a></li>
                <li><a href="#">Opcja 1</a></li>
            </ul> 
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">Ustawienia konta</div>
        <div class="panel-body">
            <ul>
                <li><a href="#">Zmiana hasła</a></li>
                <li><a href="#">Sprawdź uprawnienia</a></li>
            </ul> 
        </div>
    </div>
  </div>

  <div class="col-sm-6">
    <div class="panel panel-primary">
        <div class="panel-heading">Przegląd moich kursów</div>
        <div class="panel-body">
            Panel Content
        </div>
    </div>
  </div>

  <div class="col-sm-3">
    <div class="panel panel-primary">
        <div class="panel-heading">Wyszukiwarka</div>
        <div class="panel-body">
            <form class="form-inline">
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