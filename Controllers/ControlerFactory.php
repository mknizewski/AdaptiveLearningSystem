<?php
    include 'ControlerDictionary.php';

    class ControllerFactory
    {
        public static function GetControllerById($id)
        {
            switch ($id)
            {
                case ControllerDictionary::MAIN_PAGE_ID:
                    return ControllerDictionary::MAIN_PAGE;
                case ControllerDictionary::ABOUT_US_ID:
                    return ControllerDictionary::ABOUT_US;
                default:
                    return ControllerDictionary::MAIN_PAGE;
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