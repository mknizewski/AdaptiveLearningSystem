<?php
    include_once 'Enviroment/Session.php';
    include_once 'Enviroment/User.php';
    include_once 'Enviroment/DbContext.php';
    include_once 'Dictionaries/UserRolesDictionary.php';

    $session = Session::getInstance();
    $dbContext = new DbContext();
    $user = unserialize($session -> __get("user"));

    $courseId = $_GET["edit"];
    $selectStatement = "SELECT * FROM courses WHERE id = " . $courseId;
    $result = $dbContext -> Select($selectStatement) -> fetch_assoc();
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
                <li><a href="#">Zmiana hasła</a></li>
                <li><a href="index.php?con=4&page=2">Sprawdź uprawnienia</a></li>
            </ul> 
        </div>
    </div>
  </div>
    <div class="col-md-9">
        <div class="panel panel-info">
            <div class="panel-heading">
                <?php echo 'Edycja kursu: <b>' . $result["title"] . '</b>'; ?>
            </div>
            <div class="panel-body">
                <from method="POST" action="index.php&con5&page=7">
                    <?php
                        echo '<input type="hidden" name="courseId" value="' . $courseId . '">';
                    ?>
                    <div class="form-group">
                        <label class="control-label" for="courseName">Nazwa:</label>
                        <?php 
                            $titleValue = $result["title"];
                            echo '<input type="courseName" class="form-control" name="courseName" id="courseName" placeholder="Wprowadź nazwę kursu" value="' . $titleValue . '">'; 
                        ?>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="courseDetails">Opis kursu:</label>
                        <?php
                            $descValue = $result["description"];
                            echo '<textarea id="courseDetails" name="courseDetails">' . $descValue . '</textarea>';
                        ?>
                    </div>

                    <button type="submit" class="btn btn-success" style="float: right; margin-left: 10px;">Edytuj</button>
                    <a href="index.php?con=5&page=3" style="float: right;" class="btn btn-default">Cofnij</a>
                </from>
            </div>
        </div>
    </div>
</div>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>
	tinymce.init({ selector:'textarea',  
	plugins: "textcolor colorpicker link insertdatetime table image media  autoresize autolink wordcount",
	toolbar: "forecolor backcolor link insertdatetime table image media " });
</script>