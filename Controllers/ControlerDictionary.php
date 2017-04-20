<?php
    class ControllerDictionary
    {
        //-------------------------//
        const MAIN_CONTROLLER_ID = 1;

        const MAIN_PAGE_ID = 1;
        const MAIN_PAGE = "Views/Main/main.php";
        //-------------------------//

        //-------------------------//
        const ABOUT_US_CONTROLLER_ID = 2;

        const ABOUT_US_ID = 1;
        const ABOUT_US_PAGE = "Views/About/about.php";
        //-------------------------//

        //-------------------------//
        const SIGN_CONTROLLER_ID = 3;

        const LOGIN_ID = 1;
        const LOGIN_POST_ID = 3;
        const LOGIN_PAGE = "Views/Sign/login.php";

        const REGISTER_ID = 2;
        const REGISTER_POST_ID = 4;
        const REGISTER_PAGE = "Views/Sign/register.php";

        const LOGOUT_ID = 5;
        //-------------------------//

        //-------------------------//
        const ACCOUNT_CONTROLLER_ID = 4;

        const ACCOUNT_MAIN_ID = 1;
        const ACCOUNT_MAIN_PAGE = "Views/Account/main.php";

        const ACCOUNT_PERMISSIONS_ID = 2;
        const ACCOUNT_PERMISSIONS_PAGE = "Views/Account/permission.php";
        //-------------------------//
    }
?>