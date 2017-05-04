<?php
    include_once 'Enviroment/Session.php';
    include_once 'Enviroment/User.php';
    include_once 'Dictionaries/UserRolesDictionary.php';

    $session = Session::getInstance();
	$dbContext = new DbContext();
    $user = unserialize($session -> __get("user"));
	
	$selectStatement = "SELECT * FROM users";
    $usersList = $dbContext -> Select($selectStatement);
?>
<h2>Lista u¿ytkowników</h2>
<hr />
<div class="row">
    <div class="col-sm-3">
    <div class="panel panel-primary">
        <div class="panel-heading">Nawigacja</div>
        <div class="panel-body"> 
              <ul>
                <li><a href="index.php?con=4&page=1">G³ówna</a></li>
                <li><a href="#">Dostêpne kursy</a></li>
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
                <li><a href="#">Zmiana has³a</a></li>
                <li><a href="index.php?con=4&page=2">SprawdŸ uprawnienia</a></li>
            </ul> 
        </div>
    </div>
  </div>
    <div class="col-md-9">
		<div class="panel panel-info">
            <div class="panel-heading">U¿ytkownicy w serwisie</div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
							<th>Imiê</th>
                            <th>Nazwisko</th>
                            <th>Email</th>
                            <th>Rola</th>
                            <th>Styl uczenia</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
                            if ($usersList -> num_rows > 0)
                            {
                                while ($row = $usersList -> fetch_assoc())
                                {
                                    $name = "'" . $row["name"] . "'";
                                    $surname = "'" . $row["surname"] . "'";
                                    $email = "'" . $row["email"] . "'";
                                    $role_id = "'" . $row["role_id"] . "'";
                                    $learning_style = "'" . $row["learning_style_id"] . "'";
									
	

										/*$selectStatement = "SELECT * FROM users";
										$roleExist = $dbContext -> Select($selectStatement);
										
											$role = "'" . $row["name"] . "'";*/
										
						
									
                                    echo "<tr>";
                                    echo "<td>" . $row["name"] . "</td>";
                                    echo "<td>" . $row["surname"] . "</td>";
                                    echo "<td>" . $row["email"] . "</td>";
                                    echo "<td>" . $row["role_id"] . "</td>";
                                    echo "<td>" . $row["learning_style_id"] . "</td>";
                                    echo "</tr>";
                                }
                            }
                        ?>
					</tbody>
				</table>
			</div>
		</div>
    </div>
</div>