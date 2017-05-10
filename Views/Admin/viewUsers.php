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
                <li><a href="index.php?con=4&page=5">Zmiana hasła</a></li>
                <li><a href="index.php?con=4&page=2">Sprawdź uprawnienia</a></li>
            </ul> 
        </div>
    </div>
  </div>
    <div class="col-md-9">
		<div class="panel panel-info">
            <div class="panel-heading">Użytkownicy w serwisie</div>
            <div class="panel-body ">
                <table class="table table-hover">
                    <thead>
                        <tr>
							<th>Imię</th>
                            <th>Nazwisko</th>
                            <th>Email</th>
                            <th>Rola</th>
                            <th>Styl uczenia</th>
                            <th>Kursy</th>
							<th>Zmień rolę</th>
							<th>VARK</th>
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
									echo '<td><button type="submit" class="btn btn-primary" onclick = "ResetVARK('. $row["id"] .')">Resetuj</button></td>';
                                    echo "</tr>";
                                }
                            }
                        ?>							
					</tbody>
				</table>

                <a href="index.php?con=5&page=1" style="float: right; margin-top: 5px" class="btn btn-default">Cofnij</a>

			</div>
		</div>
    </div>
</div>

<div class="row">
	<div class="col-md-12">
		<h2>Przewodnik po środowisku .NET</h1>
		<h4>Co to jest?</h4>
		<ul class="list-group">
			<a class="list-group-item">Poradnik, w którym znajdziesz wszystko na temat .NET i C#</a>
			<a class="list-group-item">Krótkie i rzetelne treści, które łatwo dotrą do kursanta</a>
			<a class="list-group-item">Świetne quizy sprawdzające wiedzę</a>
			<a class="list-group-item">Testy z kodu, które wpływają na przyswajaną wiedzę praktyczna</a>
			<a class="list-group-item">I... oczywiście tutoriale z Akademii C#</a>
		</ul>
		<h4>Czego potrzebujesz?</h4>
		<ul class="list-group">
			<a class="list-group-item">Komputer z dostępem do sieci. Tak! Tylko to!</a>
		</ul>
		<h4>Z czego składa się kurs?</h4>
		<ul class="list-group">
			<a class="list-group-item">Akademia C# - czya tutoriale z kanału YT wykonane przez naszych specjaastów</a>
			<a class="list-group-item">Uczę się! - są to po prostu rzetelne lekcje, dzięki którym przyswoisz wiedzę</a>
			<a class="list-group-item">Ja koduję! - tutaj przetestujesz swoje możawości w zadaniach praktycznych z kodu</a>
			<a class="list-group-item">Sprawdź się! - quizy z pytaniami, które sprawdzą wiedzę z lekcji</a>
			<a class="list-group-item">Czy wiesz, że...? - sekcja z ciekawostkami o .NET</a>
			<a class="list-group-item">Oceń nas! - sondy, dzięki którym dowiemy się jakie jest Wasze zdanie na temat różnych kwestii</a>
		</ul>
		<img src="http://pioter-test.cba.pl/als/okladka-wymiar2.png" width="600px" class="img img-responsive">
		<br>
		<img src="http://pioter-test.cba.pl/als/plytkaPNG2.png" width="500px" class="img img-responsive">
		<br>
		<p><h4>Nie zwlekaj!</h4></p>
		<p><h4>I zacznij już dziś!</h4></p>
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
		        url: "index.php?con=5&page=16",
		        data: { userId: uId, role_id: rId },
		        type: "POST",
		        success: function() {
			        location.reload(true);
		        }
	        });
	    }
	}
</script>
<script>
	function ResetVARK(uId)
	{
		if (confirm('Czy na pewno chcesz zresetować VARK?'))
	    {
		    $.ajax({
		        url: "index.php?con=5&page=17",
		        data: { userId: uId },
		        type: "POST",
		        success: function() {
			        location.reload(true);
		        }
	        });
	    }
	}
</script>