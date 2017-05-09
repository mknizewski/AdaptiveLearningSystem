<?php
    include_once 'Enviroment/Session.php';
    include_once 'Enviroment/User.php';
    include_once 'Dictionaries/UserRolesDictionary.php';


    //include_once 'Controllers/AdminController.php';


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
            <div class="panel-body table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
							<th>Imię</th>
                            <th>Nazwisko</th>
                            <th>Email</th>
                            <th>Rola</th>
                            <th>Styl uczenia</th>
                            <th>Kursy</th>
							<th>Zmień role</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
							error_reporting(E_ALL & ~E_NOTICE);
                            if ($usersList -> num_rows > 0)
                            {
                                while ($row = $usersList -> fetch_assoc())
                                {
									$id = "'" . $row["id"] . "'";

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
                                    echo "<td>" . $role  ."</td>"; 
                                    echo "<td>". $learning_style . "</td>";
									echo "<td>";
										$selectStatement = "SELECT * FROM courses_users WHERE id_user = ".$id;
										$signToCourseList = $dbContext -> Select($selectStatement);
										if ($signToCourseList -> num_rows > 0)
										{
											echo '<div class="dropdown disabled">
																			<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Zapisany do ...
																			<span class="caret disabled"></span></button>
																			<ul id="dropDownMenu_Courses" class="dropdown-menu" >';
											while ($rowIdCourses = $signToCourseList -> fetch_assoc())
											{
												$id_course = $rowIdCourses["id_course"];
												$id_courses_users = $rowIdCourses["id"];
												
												
												$selectStatement = "SELECT * FROM courses WHERE id = ".$id_course;
												$coursesList = $dbContext -> Select($selectStatement);
												if ($coursesList -> num_rows > 0)
												{
													while ($rowCourses = $coursesList -> fetch_assoc())
													{														
														$courseName = $rowCourses["title"];														
														echo '<li><a style="" href="#">'. $courseName .'</a><a href="#" id="goout" onclick="DeleteUser(' . $id . ', ' . $id_course . ')" style="">Wypisz</a></li>';
													}	
												}
											}
												echo'	</ul>
												  </div>';
										}
										else
											echo 'Jeszcze nie zapisany...';
									echo "</td>";
									/*echo '<td>
										<input type= "text"  size = "1" name ='. $id .'/> 
										<input type= 'submit' name= 'change_role' size= '2' value= 'Zmień' onclick=".   .' />
										</td>';*/
									echo '<td>
											<div class="dropdown disabled">
												<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">'. $role .'
												<span class="caret disabled"></span></button>
												<ul id="dropDownMenu_Courses" class="dropdown-menu" >
													<li><a onclick="UpdateRole(' . $row["id"] . ', ' . 1 . ')" href="#">'. admin .'</a></li>
													<li><a onclick="UpdateRole(' . $row["id"] . ', ' . 2 . ')" href="#">'. student .'</a></li>
													<li><a onclick="UpdateRole(' . $row["id"] . ', ' . 3 . ')" href="#">'. guest .'</a></li>
												</ul>
											</div>
										  </td>';
                                    echo "</tr>";
                                }
                            }
<<<<<<< HEAD
=======
							
										
>>>>>>> b8ce2f6d8633e48252945baa1b8ba4ee0b4f0c2a
                        ?>							
					</tbody>
				</table>

                <a href="index.php?con=5&page=1" style="float: right; margin-top: 5px" class="btn btn-default">Cofnij</a>

			</div>
		</div>
    </div>
</div>
<script>
    function DeleteUser(uId, cId)
    {
	    if (confirm('Czy na pewno chcesz usunąć danego użytkownika z kursu?'))
	    {
		    $.ajax({
		        url: "index.php?con=5&page=10",
		        data: { userId: uId, courseId: cId },
		        type: "POST",
		        success: function() {
			        location.reload(true);
		        }
	        });
	    }
    }
</script>
<script>
	function UpdateRole(uId, rId)
	{
		if (confirm('Czy na pewno chcesz zmienić role użytkownika?'))
	    {
		    $.ajax({
		        url: "index.php?con=5&page=11",
		        data: { userId: uId, role_id: rId },
		        type: "POST",
		        success: function() {
			        location.reload(true);
		        }
	        });
	    }
	}
</script>