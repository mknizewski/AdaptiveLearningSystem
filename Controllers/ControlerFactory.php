<?php
    include_once 'ControlerDictionary.php';
    include_once 'MainController.php';
    include_once 'AboutController.php';
    include_once 'SignController.php';
    include_once 'AccountController.php';
    include_once 'AdminController.php';
    include_once 'CourseController.php';

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
                case ControllerDictionary::ACCOUNT_CONTROLLER_ID:
                    return new AccountController();
                case ControllerDictionary::ADMIN_CONTROLLER_ID:
                    return new AdminController();
                case ControllerDictionary::COURSE_CONTROLLER_ID:
                    return new CourseController();
                default:
                    return false;
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

        public static function Redirect($controller_id, $page_id)
        {
            $location = "Location: index.php?con=$controller_id&page=$page_id";
            header($location);
        }
    }
?>