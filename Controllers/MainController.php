<?php
    include_once 'ControlerDictionary.php';
    include_once 'ControlerFactory.php';

    class MainController
    {
        public function GetViewById($view_id)
        {
            switch ($view_id)
            {
                case ControllerDictionary::MAIN_PAGE_ID:
                    $this -> MainPage();
                    break;
                default:
                    return false;
            }
        }

        public function MainPage()
        {
            echo ControllerFactory::GetViewContent(ControllerDictionary::MAIN_PAGE);
        }
    }
?>