<?php
    include_once 'Controllers/ControlerFactory.php';
    include_once 'Controllers/ControlerDictionary.php';
    include_once 'Enviroment/Session.php';
    include_once 'Enviroment/Alert.php';
    include_once 'Enviroment/User.php';
    include_once 'Dictionaries/ExceptionDictionary.php';

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
                        <?php
                            if ($session -> __isset("user"))
                            {
                                echo '<a href="index.php?con=4&page=1">Główna</a>';
                            }
                            else
                            {
                                echo '<a href="index.php?con=1&page=1">Główna</a>';
                            }
                        ?>
                    </li>
                    <li>
                        <a href="#">Kursy</a>
                    </li>
                    <li>
                        <a href="index.php?con=2&page=1">O nas</a>
                    </li>
                </ul>
                <?php
                    if ($session -> __isset("user"))
                    {
                        $user =  unserialize($session -> __get("user"));
                        echo '<ul class="nav navbar-nav navbar-right">';
                        echo '<li class="dropdown">';
                        echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">' . $user -> Email . ' <span class="caret"></span></a>';
                        
                        echo '<ul class="dropdown-menu">';
                        echo '<li><a href="index.php?con=4&page=1">Moje konto</a></li>';
                        echo '<li><a href="#">Ustawienia</a></li>';
                        echo '<li role="separator" class="divider"></li>';
                        echo '<li><a href="index.php?con=3&page=5">Wyloguj się</a></li>';
                        echo '</ul>';

                        echo '</li>';
                        echo '</ul>';
                    }
                    else
                    {
                        echo '<ul class="nav navbar-nav navbar-right">';
                        echo '<li><a href="index.php?con=3&page=2"><span class="glyphicon glyphicon-user"></span> Rejestracja</a></li>';
                        echo '<li><a href="index.php?con=3&page=1"><span class="glyphicon glyphicon-log-in"></span> Logowanie</a></li>';
                        echo '</ul>';
                    }
                ?>
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

                            if ($controller !== false)
                            {
                                $status = $controller -> GetViewById($page_id);

                                if ($status === false)
                                {
                                    echo ControllerFactory::GetViewContent(ExceptionDictionary::PAGE_404);
                                }
                            }
                            else
                            {
                                echo ControllerFactory::GetViewContent(ExceptionDictionary::PAGE_404);
                            }
                        }
                        else
                        {
                            echo ControllerFactory::GetViewContent(ExceptionDictionary::PAGE_404);
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