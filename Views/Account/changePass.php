<?php 
    include_once 'Enviroment/Session.php';
    include_once 'Enviroment/User.php';
    include_once 'Dictionaries/UserRolesDictionary.php';

    $session = Session::getInstance();
    $user = unserialize($session -> __get("user"));

    echo "<h2> Twoje Uprawnienia - " . $user -> Name . " " . $user -> Surname . "</h2>";
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
        <div class="panel-heading">Zmiana hasła</div>
        <div class="panel-body">
			<form action="index.php?con=4&page=6" method="post">
				<fieldset class="form-horizontal">
				<!-- Password input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="piCurrPass">Obecne hasło:</label>
				  <div class="col-md-6">
					<input id="piCurrPass" name="piCurrPass" type="password" placeholder="" class="form-control input-md" required>		
				  </div>
				</div>

				<!-- Password input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="piNewPass">Nowe hasło:</label>
				  <div class="col-md-6">
					<input id="piNewPass" name="piNewPass" type="password" placeholder="" class="form-control input-md" required>				
				  </div>
				</div>

				<!-- Password input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="piNewPassRepeat">Powtórz hasło:</label>
				  <div class="col-md-6">
					<input id="piNewPassRepeat" name="piNewPassRepeat" type="password" placeholder="" class="form-control input-md" required>
				  </div>
				</div>

				<!-- Button (Double) -->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="bCancel"></label>
				  <div class="col-md-8">
					<button id="bCancel" onclick="goBack()" name="bCancel" class="btn btn-danger">Anuluj</button>
					<button type="submit" id="bAccept" name="bAccept"  class="btn btn-success">Zmień hasło</button>
				  </div>
				</div>
				
				<?php 
					$userId = $user -> Id;
					echo '<div style="display:none;"><input id="userId" name="userId" value="'. $userId .'"></div>'; 
				?>
				</fieldset>
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

