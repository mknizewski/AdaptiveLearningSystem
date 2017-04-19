<?php
    include_once 'Controllers/ControlerFactory.php';
    include_once 'Controllers/ControlerDictionary.php';
    include_once 'Enviroment/Session.php';
    include_once 'Enviroment/DbContext.php';
    include_once 'Enviroment/Alert.php';
    include_once 'Dictionaries/ExceptionDictionary.php';

    class AccountController
    {
        public function GetViewById($view_id)
        {
            if ($this -> CheckAuth())
            {
                switch ($view_id)
                {
                    case ControllerDictionary::ACCOUNT_MAIN_ID:
                        $this -> Main();
                        break;
                    case ControllerDictionary::ACCOUNT_PERMISSIONS_ID:
                        $this -> Permission();
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
            echo ControllerFactory::GetViewContent(ControllerDictionary::ACCOUNT_MAIN_PAGE);
        }

        public function Permission()
        {
            echo ControllerFactory::GetViewContent(ControllerDictionary::ACCOUNT_PERMISSIONS_PAGE);
        }

        private function CheckAuth()
        {
            $session = Session::getInstance();
            return $session -> __isset("user");
        }
    }
?>