<?php
    include_once 'ControlerDictionary.php';

    class AboutController
    {
        public function GetViewById($view_id)
        {
            switch ($view_id)
            {
                case ControllerDictionary::ABOUT_US_ID:
                    $this -> MainPage();
                    break;
                default:
                    $this -> MainPage();
                    break;
            }
        }

        public function MainPage()
        {
            echo ControllerFactory::GetViewContent(ControllerDictionary::ABOUT_US_PAGE);
        }
    }
?>