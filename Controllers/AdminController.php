<?php
    include_once 'Controllers/ControlerFactory.php';
    include_once 'Controllers/ControlerDictionary.php';
    include_once 'Enviroment/Session.php';
    include_once 'Enviroment/DbContext.php';
    include_once 'Enviroment/Alert.php';
    include_once 'Dictionaries/ExceptionDictionary.php';
    include_once 'Dictionaries/LearningStyleDictionary.php';
    include_once 'Dictionaries/UserRolesDictionary.php';

    class AdminController
    {
        public function GetViewById($view_id)
        {
            if ($this -> CheckAuth())
            {
                switch ($view_id)
                {
                    case ControllerDictionary::ADMIN_MAIN_ID:
                        $this -> Main();
                        break;
                    default:
                        return false;
                }
            }
            else
            {
                echo ControllerFactory::GetViewContent(ExceptionDictionary::PAGE_403);
            }
        }

        public function Main()
        {
            echo ControllerFactory::GetViewContent(ControllerDictionary::ADMIN_MAIN_PAGE);
        }

        public function CheckAuth()
        {
            $session = Session::getInstance();
            $user = unserialize($session -> __get("user"));

            if ($user -> RoleId == UserRolesDictionary::ADMIN)
                return true;
            
            return false;
        }
    }
?>