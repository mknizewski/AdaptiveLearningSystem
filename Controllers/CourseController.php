<?php
    include_once 'Controllers/ControlerFactory.php';
    include_once 'Controllers/ControlerDictionary.php';
    include_once 'Enviroment/Session.php';
    include_once 'Enviroment/DbContext.php';
    include_once 'Enviroment/Alert.php';

    class CourseController
    {
        public function GetViewById($view_id)
        {
            switch ($view_id)
            {
                case ControllerDictionary::COURSE_MAIN_ID:
                    $this -> Main();
                    break;
                default:
                    return false;
            }
        }

        public function Main()
        {

        }
    }
?>