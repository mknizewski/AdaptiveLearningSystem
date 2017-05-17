<?php
    include_once 'Enviroment/Session.php';
    include_once 'Enviroment/User.php';
    include_once 'Enviroment/DbContext.php';
    include_once 'Dictionaries/UserRolesDictionary.php';
    include_once 'Dictionaries/LearningStyleDictionary.php';

    $session = Session::getInstance();
    $dbContext = new DbContext();
    $user = unserialize($session -> __get("user"));
?>
<h2>Dodaj nowy kurs</h2>
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
             <div class="panel-heading">Formularz dodania nowego modułu</div>
             <div class="panel-body">
                <form method="POST" action="index.php?con=5&page=15">
                    <div class="form-group">
                        <label class="control-label" for="moduleName">Nazwa:</label>
                        <input class="form-control" name="moduleName" placeholder="Wprowadź nazwę modułu">
                    </div>

                    <div class="from-group">
                        <label class="control-label" for="course">Kurs:</label>
                        <select class="form-control" id="course" name="course" onchange="GetLessonByCourseId()">
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

                    <div class="from-group">
                        <label class="control-label" for="lesson">Lekcja:</label>
                        <select class="form-control" name="lesson" id="lesson">
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for"learningStyle">Styl:</label>
                        <select class="form-control" name="learningStyle">
                            <option value='-1'></option>
                            <?php
                                $styleStatement = "SELECT * FROM learningstyles";
                                $styleList = $dbContext -> Select($styleStatement);
                                
                                while ($row = $styleList -> fetch_assoc())
                                {
                                    $styleId = $row["id"];
                                    $styleTxt = "";
                                    switch ($styleId)
                                    {
                                        case LearningStyleDictionary::VISUAL:
                                            $styleTxt = LearningStyleDictionary::VISUAL_TEXT;
                                            break;
                                        case LearningStyleDictionary::AURAL:
                                            $styleTxt = LearningStyleDictionary::AURAL_TEXT;
                                            break;
                                        case LearningStyleDictionary::READING:
                                            $styleTxt = LearningStyleDictionary::READING_TEXT;
                                            break;
                                        case LearningStyleDictionary::KINESTHETIC:
                                            $styleTxt = LearningStyleDictionary::KINESTHETIC_TEXT;
                                            break;
                                        default:
                                            $styleTxt = LearningStyleDictionary::ALL_TEXT;
                                            break;
                                    }

                                    echo "<option value='$styleId'>$styleTxt</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="moduleDetails">Treść modułu:</label>
                        <textarea name="moduleDetails"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label" for="modulePiority">Kolejność:</label>
                        <input name="modulePiority" class="form-control" placeholder="Wprowadź kolejność">
                    </div>

                    <div class="form-group">
                        <button type="submit" style="float: right;" class="btn btn-primary">Dodaj moduł</button> 
                        <a href="index.php?con=5&page=1" type="button" style="float: right; margin-right: 5px;" class="btn btn-default">Cofnij</a> 
                    </div> 
                </form>  
             </div>  
        </div>
    </div>
</div>
<script>
    function GetLessonByCourseId()
    {
        var courseId = document.getElementById('course').value;
        var notSelected = -1;

        if (courseId != notSelected)
        {
            $.ajax({
                url: "Views/Admin/getlessons.php",
                type: "POST",
                data: { cId: courseId },
                success: function (data) {
                    var lessonSelect = document.getElementById('lesson');
                    lessonSelect.innerHTML = data;
                }
            });
        }
    }
</script>