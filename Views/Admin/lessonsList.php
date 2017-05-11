<?php
    include_once 'Enviroment/Session.php';
    include_once 'Enviroment/User.php';
    include_once 'Enviroment/DbContext.php';
    include_once 'Dictionaries/UserRolesDictionary.php';

    $session = Session::getInstance();
    $dbContext = new DbContext();
    $user = unserialize($session -> __get("user"));

    $selectStatement = "SELECT * FROM courses";
    $coursesList = $dbContext -> Select($selectStatement);
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
            <div class="panel-heading">
                Lista utworzonych lekcji
            </div>
            <div class="panel-body">
					<div class="from-group">
                        <label class="control-label" for="course">Wybierz kurs:</label>
                        <select class="form-control" id="course" name="course" onchange="showLessonsAndModuls()">
                            <option value='-1'></option>
                            <?php
                                $courseStatement = "SELECT * FROM courses";
                                $courseList = $dbContext -> Select($courseStatement);

                                while ($row = $courseList -> fetch_assoc())
                                {
                                    $courseId = $row["id"];
                                    $courseTitle = $row["title"];

                                    echo "<option value='$courseId'>$courseTitle</option>";
                                }
                            ?>
                        </select>
                    </div>
					<br/>
				<div  id="lessonAndModuls"></div> <!-- Tu z getLessonsAndModuls -->
                <a href="index.php?con=5&page=1" style="float: right;" class="btn btn-default">Cofnij</a>
            </div>
        </div>
        <div class="panel panel-info" id="courseDiv" style="display: none;">
            <div class="panel-heading" id="courseTitle"></div>
            <div class="panel-body" id="courseDesc"></div>
        </div>
    </div>
</div>

<script>
    function showLessonsAndModuls()
    {
        var courseId = document.getElementById('course').value;
        var notSelected = -1;

        if (courseId != notSelected)
        {
            $.ajax({
                url: "Views/Admin/getLessonsAndModuls.php",
                type: "POST",
                data: { cId: courseId },
                success: function (data) {
                    var lessonSelect = document.getElementById('lessonAndModuls');
                    lessonSelect.innerHTML = data;
                }
            });
        }
    }
	
	function lessonChangeCountOfModules(lessonId)
	{
		var lessId = lessonId;
		var lessIdAttr = "#" + lessonId;
		var newCountOfMudules = $(lessIdAttr).val();
		
		alert("zmiana ilosci modulow dla lekcji o id = " + lessId + " Nowa wartosc: " + newCountOfMudules);
	}
	
	function lessonChangeTitle(lessonId)
	{
		var lessId = lessonId;
		var lessIdAttr = "#title" + lessonId;
		var newTitle = $(lessIdAttr).val();
		
		alert("zmiana tytulu lekcji o id = " + lessId + " Nowa wartosc: " + newTitle);
	}
	
	function moduleChangeTitle(moduleId)
	{
		var modId = moduleId;
		var modIdAttr = "#modtitle" + modId;
		var newTitle = $(modIdAttr).val();
		
		alert("zmiana modulu (tytul) o id = " + modId + " Nowa wartosc: " + newTitle);
	}
	
	function moduleChangeCountOfModules(moduleId)
	{
		var modId = moduleId;
		var modIdAttr = "#modQueue" + modId;
		var newCountOfMudules = $(modIdAttr).val();
		
		alert("zmiana kolejnosci MODUŁ -> id = " + modId + " Nowa wartosc: " + newCountOfMudules);
	}
	
	function UpdateLearningStyleForModule(moduleId, learningStyleId)
	{
		var modId = moduleId;
		var lsId = learningStyleId;
		
		alert("Update learning Style. Id modulu: " + modId + "; style nauczania Id: " + lsId);
	}
	
	function DeleteModule(moduleId)
	{
		var modId = moduleId;
		
		alert("USUWANIE. Id modulu: " + modId );
	}
	
	
    /*function ShowCourseDesc(title, description)
    {
        var courseDiv = document.getElementById("courseDiv");
        var courseTitle = document.getElementById("courseTitle");
        var courseDesc = document.getElementById("courseDesc");

        courseDiv.style.display = "block";
        courseTitle.innerHTML = title;
        courseDesc.innerHTML = description;
    }

    function AddUserToCourse(uId, cId, rId)
    {
        if (confirm('Czy na pewno chcesz dodać użytkownika do kursu?'))
        {
            $.ajax({
                url: "index.php?con=5&page=11",
                data: { userId: uId, courseId: cId, roleId: rId },
                type: "POST",
                success: function() {
                    location.reload(true);
                }
            });
        }
    }

    function DeleteCourse(courseId)
    {
        if (confirm('Czy na pewno chcesz usunąć kurs?'))
        {
            $.ajax(
                { 
                    url: "index.php?con=5&page=5",
                    data: { id: courseId },
                    type: "POST",
                    success: function(){
                        location.reload(true);
                    }}
                );
        }
    }*/
</script>