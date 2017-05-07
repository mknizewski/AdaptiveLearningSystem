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
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
							<th>Imię</th>
                            <th>Nazwisko</th>
                            <th>Email</th>
                            <th>Rola</th>
                            <th>Styl uczenia</th>
                            <th>Kursy</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
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
                                    echo "<td>" . $row["email"] . "</td>";
                                    echo "<td>" . $role  . "</td>";
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
														
														echo '<li><a style="" href="#">'. $courseName .'</a><a id="goout" deleteID="'.$id_courses_users.'" style="">Wypisz</a></li>';
													}	
												}
											}
												echo'	</ul>
												  </div>';
										}
										else
											echo 'Jeszcze nie zapisany...';
									echo "</td>";	
                                    echo "</tr>";
                                }
                            }
							
							
							/*
							                                    echo "<td>";
														$selectStatement = "SELECT * FROM courses_users WHERE id_user = ".$id;
														$signToCourseList = $dbContext -> Select($selectStatement);
														if ($signToCourseList -> num_rows > 0)
														{
															while ($rowIdCourses = $signToCourseList -> fetch_assoc())
															{
																$id_course = $rowIdCourses["id_course"];
																$number = $rowIdCourses["insert_time"];
																
																$selectStatement = "SELECT * FROM courses WHERE id = ".$id_course;
																$coursesList = $dbContext -> Select($selectStatement);
																if ($coursesList -> num_rows > 0)
																{
																	echo '<div class="dropdown disabled">
																			<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Zapisany do ...
																			<span class="caret disabled"></span></button>
																			<ul id="dropDownMenu_Courses" class="dropdown-menu" >';
																	while ($rowCourses = $coursesList -> fetch_assoc())
																	{
																		$courseName = $rowCourses["title"];
																		
																		echo '<li><a style="display:inline;" href="#">'. $number .'</a><a id="goout" deleteID="'.$number.'" style="display:inline;">Wypisz</a></li>';
																	}
																}
															}
														}
														else
															echo 'Jeszcze nie zapisany...';
														
									echo'			</ul>
												  </div>'. 
												  
										"</td>";
							*/
                        ?>
						
						
					</tbody>
				</table>
			</div>
		</div>
    </div>
</div>

