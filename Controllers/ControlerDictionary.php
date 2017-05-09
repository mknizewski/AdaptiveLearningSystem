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

        const ACCOUNT_FORM_ID = 3;
        const ACCOUNT_FORM_POST_ID = 4;
        const ACCOUNT_FORM_PAGE = "Views/Account/form.php";
        //-------------------------//

        //-------------------------//
        const ADMIN_CONTROLLER_ID = 5;

        const ADMIN_MAIN_ID = 1;
        const ADMIN_MAIN_PAGE = "Views/Admin/main.php";

        const ADMIN_COURSE_ADD_ID = 2;
        const ADMIN_COURSE_ADD_POST_ID = 6;
        const ADMIN_COURSE_ADD_PAGE = "Views/Admin/addcourse.php";

        const ADMIN_COURSE_LIST_ID = 3;
        const ADMIN_COURSE_LIST_ADD_USER_TO_COURSE_ID = 11;
        const ADMIN_COURSE_LIST_PAGE = "Views/Admin/courseslist.php";

        const ADMIN_COURSE_EDIT_ID = 4;
        const ADMIN_COURSE_EDIT_POST_ID = 7;
        const ADMIN_COURSE_EDIT_PAGE = "Views/Admin/editcourse.php";

        const ADMIN_COURSE_DELETE_ID = 5;
        const ADMIN_COURSE_DELETE_POST_ID = 8;
        const ADMIN_COURSE_DELETE_PAGE = "Views/Admin/deletecourse.php";
		
		const ADMIN_VIEW_USERS_ID = 9;
        const ADMIN_VIEW_USERS_DELETE_USER_FROM_COURSE_POST_ID = 10;
		const ADMIN_VIEW_USERS_PAGE = "Views/Admin/viewusers.php";

        const ADMIN_ADD_LESSON_ID = 12;
        const ADMIN_ADD_LESSON_POST_ID = 13;
        const ADMIN_ADD_LESSON_PAGE = "Views/Admin/addlesson.php";

        const ADMIN_ADD_MODULE_ID = 14;
        const ADMIN_ADD_MODULE_POST_ID = 15;
        const ADMIN_ADD_MODULE_PAGE = "Views/Admin/addmodule.php";
        //-------------------------//
        const COURSE_CONTROLLER_ID = 6;

        const COURSE_LIST_ID = 1;
        const COURSE_MAIN_PAGE = "Views/Courses/main.php";
        //-------------------------//
    }
?>