<?php
    include_once 'Enviroment/Session.php';
    include_once 'Enviroment/User.php';
    include_once 'Dictionaries/UserRolesDictionary.php';
	include_once 'Dictionaries/LearningStyleDictionary.php';

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
                            if ($usersList -> num_rows > 0)
                            {
                                while ($row = $usersList -> fetch_assoc())
                                {
                                    $name = "'" . $row["name"] . "'";
                                    $surname = "'" . $row["surname"] . "'";
                                    $email = "'" . $row["email"] . "'";
                                    $role_id = "'" . $row["role_id"] . "'";
									$role_text = CheckRole($role_id);
                                    $learning_style_id = "'" . $row["learning_style_id"] . "'";			
									$learning_style_text = CheckLearningStyle($learning_style_id);
									
                                    echo "<tr>";
                                    echo "<td>" . $row["name"] . "</td>";
                                    echo "<td>" . $row["surname"] . "</td>";
                                    echo "<td>" . $row["email"] . "</td>";
                                    echo "<td>" . $role_text  . "</td>";
                                    echo "<td>". $learning_style_text . "</td>";
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
<script>
		public function CheckRole(role_id)
		{
			var roleText = "";
			
			if(role_id == 1)
				roleText = UserRolesDictionary::ADMIN_TEXT;
			
			if(role_id == 2)
				roleText = UserRolesDictionary::STUDENT_TEXT;
		
			if(role_id == 3)
				roleText = UserRolesDictionary::GUEST_TEXT;
			
			return roleText;
		}
		
		public function CheckLearningStyle(learning_style_id)
		{
			var learingText = "";
			
			if(learning_style_id == 0)
				learingText = "Brak";
			
			if(learning_style_id == 1)
				learingText = LearningStyleDictionary::VISUAL_TEXT;
			
			if(learning_style_id == 2)
				learingText = LearningStyleDictionary::AURAL_TEXT;
			
			if(learning_style_id == 3)
				learingText = LearningStyleDictionary::READING_TEXT;
			
			if(learning_style_id == 4)
				learingText = LearningStyleDictionary::KINESTHETIC_TEXT;
			
			return learingText;		
		}
</script>