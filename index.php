<?php
    include_once 'Controllers/ControlerFactory.php';
    include_once 'Controllers/ControlerDictionary.php';
    include_once 'Enviroment/Session.php';
    include_once 'Enviroment/Alert.php';

    $session = Session::getInstance();
    $session -> startSession();
?>

<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adaptacyjny system uczący</title>
    <link href="Content/css/bootstrap.css" rel="stylesheet">
  </head>
  <body>
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">

            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php?con=1&page=1">Główna</a>
                    </li>
                    <li>
                        <a href="#">Kursy</a>
                    </li>
                    <li>
                        <a href="index.php?con=2&page=1">O nas</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php?con=3&page=2"><span class="glyphicon glyphicon-user"></span> Rejestracja</a></li>
                    <li><a href="index.php?con=3&page=1"><span class="glyphicon glyphicon-log-in"></span> Logowanie</a></li>
                </ul>
            </div>
        </div>
    </div>

    <br />
    <br />
    <br />

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php
                    if ($session -> __isset("alert"))
                    {
                        $alert = unserialize($session -> __get("alert"));
                        Alert::MakeAlert($alert);

                        $session -> __unset("alert");
                    }

                    if (isset($_GET["con"]))
                    {
                        $con_id = $_GET["con"];
                        $page_id;
                        
                        if (isset($_GET["page"]))
                        {
                            $page_id = $_GET["page"];
                            $controller = ControllerFactory::GetControllerById($con_id);
                            $controller -> GetViewById($page_id);
                        }
                    }
                    else
                    {
                        $mainController = ControllerFactory::GetControllerById(ControllerDictionary::MAIN_CONTROLLER_ID);
                        $mainController -> GetViewById(ControllerDictionary::MAIN_PAGE_ID);
                    }
                ?>
            </div>
        </div>

            <footer>
                <hr />
                <h6>Wszystkie prawa zastrzeżone - 2017</h6>
            </footer>
    </div>

    <script src="Content/js/jquery.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="Content/js/bootstrap.js"></script>
  </body>
</html>