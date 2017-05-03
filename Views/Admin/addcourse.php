<?php
    include_once 'Enviroment/Session.php';
    include_once 'Enviroment/User.php';
    include_once 'Dictionaries/UserRolesDictionary.php';

    $session = Session::getInstance();
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
                <li><a href="#">Zmiana hasła</a></li>
                <li><a href="index.php?con=4&page=2">Sprawdź uprawnienia</a></li>
            </ul> 
        </div>
    </div>
  </div>
    <div class="col-md-9">
        <div class="panel panel-info">
             <div class="panel-heading">Formularz dodania nowego kursu</div>
             <div class="panel-body">
                <form method="POST" action="index.php?con=5&page=6">
                    <div class="form-group">
                        <label class="control-label" for="courseName">Nazwa:</label>
                        <input type="courseName" class="form-control" name="courseName" id="courseName" placeholder="Wprowadź nazwę kursu">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="courseDetails">Opis kursu:</label>
                        <textarea id="courseDetails" name="courseName"></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" style="float: right;" class="btn btn-primary">Dodaj kurs</button> 
                        <a href="index.php?con=5&page=1" type="button" style="float: right; margin-right: 5px;" class="btn btn-default">Cofnij</a> 
                    </div> 
                </form>  
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