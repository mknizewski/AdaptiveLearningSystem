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
	
	//$idkursu = $GET['idcourse'];
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
		var course_id = $("#courseId");
		
		// alert("zmiana ilosci modulow dla lekcji o id = " + lessId + " Nowa wartosc: " + newCountOfMudules);        if (confirm('Czy na pewno chcesz dodać użytkownika do kursu?'))
        {
            $.ajax({
                url: "index.php?con=5&page=96",
                data: { lesson_id: lessId, countOfModules: newCountOfMudules},
                type: "POST",
                success: function() {
					location.reload(true);
                }
            });
        }
		
	}
	
	function lessonChangeTitle(lessonId)
	{
		var lessId = lessonId;
		var lessIdAttr = "#title" + lessonId;
		var newTitle = $(lessIdAttr).val();
		
		//alert("zmiana tytulu lekcji o id = " + lessId + " Nowa wartosc: " + newTitle);
		        {
            $.ajax({
                url: "index.php?con=5&page=95",
                data: { lesson_id: lessId, title: newTitle },
                type: "POST",
                success: function() {
					location.reload(true);
                    //location.replace('https://developer.mozilla.org/en-US/docs/Web/API/Window/location');
                }
            });
        }
	}
	
	function moduleChangeTitle(moduleId)
	{
		var modId = moduleId;
		var modIdAttr = "#modtitle" + modId;
		var newTitle = $(modIdAttr).val();
		
		//alert("zmiana modulu (tytul) o id = " + modId + " Nowa wartosc: " + newTitle);
				        {
            $.ajax({
                url: "index.php?con=5&page=94",
                data: { moduleId: modId, title: newTitle },
                type: "POST",
                success: function() {
					location.reload(true);
                    //location.replace('https://developer.mozilla.org/en-US/docs/Web/API/Window/location');
                }
            });
        }
	}
	
	function moduleChangeCountOfModules(moduleId)
	{
		var modId = moduleId;
		var modIdAttr = "#modQueue" + modId;
		var newCountOfMudules = $(modIdAttr).val();
		
		//alert("zmiana kolejnosci MODUŁ -> id = " + modId + " Nowa wartosc: " + newCountOfMudules);
		        {
            $.ajax({
                url: "index.php?con=5&page=93",
                data: { moduleId: modId, countOfModules: newCountOfMudules},
                type: "POST",
                success: function() {
					location.reload(true);
                }
            });
        }
	}
	
	function UpdateLearningStyleForModule(moduleId, learningStyleId)
	{
		var modId = moduleId;
		var lsId = learningStyleId;
		
		//alert("Update learning Style. Id modulu: " + modId + "; style nauczania Id: " + lsId);
				        {
            $.ajax({
                url: "index.php?con=5&page=92",
                data: { moduleId: modId, learnid: lsId},
                type: "POST",
                success: function() {
					location.reload(true);
                }
            });
        }
	}
	
	function DeleteModule(moduleId)
	{		
		// var modId = moduleId;
		// alert("USUWANIE. Id modulu: " + modId );
		
		if (confirm('Czy na pewno chcesz usunąć moduł?'))
        {
            $.ajax({
                url: "",
                data: {  },
                type: "POST",
                success: function() {
                    location.reload(true);
                }
            });
        }
	}	
	
	function DeleteLesson(lessId)
	{		
		// var lessId = moduleId;
		// alert("USUWANIE. Id lekcji: " + lessId );
		
		if (confirm('Czy na pewno chcesz usunąć lekcję?'))
        {
            $.ajax({
                url: "",
                data: {  },
                type: "POST",
                success: function() {
                    location.reload(true);
                }
            });
        }
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