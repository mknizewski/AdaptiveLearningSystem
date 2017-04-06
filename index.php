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
                        <a href="index.php?con=2&page=1">O nas</a>
                    </li>
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
                    include_once 'Controllers/ControlerFactory.php';
                    include_once 'Controllers/ControlerDictionary.php';
                    
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
    </div>

    <script src="Content/js/jquery.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="Content/js/bootstrap.js"></script>
  </body>
</html>