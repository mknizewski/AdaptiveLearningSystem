<?php
    include_once 'ControlerDictionary.php';
    include_once 'MainController.php';
    include_once 'AboutController.php';
    include_once 'SignController.php';

    class ControllerFactory
    {
        public static function GetControllerById($con_id)
        {
            switch ($con_id)
            {
                case ControllerDictionary::MAIN_CONTROLLER_ID:
                    return new MainController();
                case ControllerDictionary::ABOUT_US_CONTROLLER_ID:
                    return new AboutController();
                case ControllerDictionary::SIGN_CONTROLLER_ID:
                    return new SignController();
            }
        }

        public static function GetViewContent($filename)
        {
             if (is_file($filename)) 
             {
                ob_start();
                include $filename;
                return ob_get_clean();
             }

            return false;
        }
    }
?>