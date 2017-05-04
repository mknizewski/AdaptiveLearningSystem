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
<h2>Lista użytkowników</h2>
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
            <div class="panel-heading">Użytkownicy w serwisie</div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
							<th>Imię</th>
                            <th>Nazwisko</th>
                            <th>Email</th>
                            <th>Rola</th>
                            <th>Styl uczenia</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
							error_reporting(E_ALL & ~E_NOTICE);
                            if ($usersList -> num_rows > 0)
                            {
                                while ($row = $usersList -> fetch_assoc())
                                {
									$user_id = "'" . $row["id"] . "'";
                                    $role_id = "'" . $row["role_id"] . "'";
                                    $learning_style_id = "'" . $row["learning_style_id"] . "'";			
									$selectStatement = "SELECT * FROM roles WHERE id = ".$role_id;
									$rolesList = $dbContext -> Select($selectStatement);
									if ($rolesList -> num_rows > 0)
										while ($rowRoles = $rolesList -> fetch_assoc())
											$role = $rowRoles["name"];
									
									$selectStatement = "SELECT * FROM learningstyles WHERE id = ".$learning_style_id;
									$learningStylesList = $dbContext -> Select($selectStatement);
									if ($learningStylesList -> num_rows > 0)
										while ($rowLearningStyle = $learningStylesList -> fetch_assoc())
											$learning_style = $rowLearningStyle["name"];	
									else
										$learning_style = "Jeszcze nie określono";
										
                                    echo "<tr>";
                                    echo "<td>" . $row["name"] . "</td>";
                                    echo "<td>" . $row["surname"] . "</td>";
                                    echo "<td> <a href = 'mailto:". $row["email"] ."'>". $row["email"] ."</a> </td>";
                                    echo "<td> $role"; 
									echo "</br><b>Zmień:</b>  
										<input type = 'text'  name = 'role_change' size = '5'> 
										<input type = 'submit' size = '1' value = 'ok' > 
										</td>";
                                    echo "<td>". $learning_style . "</td>";
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