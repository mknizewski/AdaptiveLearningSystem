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
                case ControllerDictionary::COURSE_SIGN_ID:
                    $this -> SignIn();
                    break;
                case ControllerDictionary::COURSE_LESSONS_ID:
                    $this -> Lessons();
                    break;
                case ControllerDictionary::COURSE_LESSON_MODULES_ID:
                    $this -> Modules();
                    break;
                default:
                    return false;
            }
        }

        public function Main()
        {
            echo ControllerFactory::GetViewContent(ControllerDictionary::COURSE_MAIN_PAGE);
        }

        public function Lessons()
        {
            echo ControllerFactory::GetViewContent(ControllerDictionary::COURSE_LESSONS_PAGE);
        }

        public function Modules()
        {
            $alert = new Alert();
            $session = Session::getInstance();
            $user = $session -> __get("user");
            $learningStyleId = $user -> GetLearningStyle();

            if ($learningStyleId == 0)
            {
                $alert -> Message = "Wpierw określ swój styl nauczania poprzez wypełnienie ankiety!";
                $alert -> TYPE_OF_ALERT = Alert::WARNING_ALERT;
                $session -> __set("alert", serialize($alert));

                ControllerFactory::Redirect(ControllerDictionary::ACCOUNT_CONTROLLER_ID, ControllerDictionary::ACCOUNT_MAIN_ID);
                return;
            }

            echo ControllerFactory::GetViewContent(ControllerDictionary::COURSE_LESSON_MODULES_PAGE);
        }

        public function SignIn()
        {
            $alert = new Alert();
            $dbContext = new DbContext();
            $session = Session::getInstance();
            $currentDate = date('Y-m-d');

            if ($session -> __isset("user") == false)
            {
                ControllerFactory::Redirect(ControllerDictionary::SIGN_CONTROLLER_ID, ControllerDictionary::LOGIN_ID);
                return;
            }

            $user = unserialize($session -> __get("user"));

            $userId = $user -> Id;
            $roleId = $user -> RoleId;
            $courseId = $_GET["course"];

            $insertStatement = "INSERT INTO courses_users (id_user, id_course, id_role, insert_time) VALUES('$userId', '$courseId', '$roleId', '$currentDate')";
            $selectStatement = "SELECT * FROM courses_users WHERE id_course=" . $courseId . " AND id_user=" . $userId;
            $selectResult = $dbContext -> Select($selectStatement) -> num_rows == 0;

            if ($selectResult)
            {
                $result = $dbContext -> MakeStatement($insertStatement, DbContext::INSERT_STATEMENT);
                if ($result)
                {
                    $alert -> Message = "Poprawnie dodano użytkownika!";
                    $alert -> TYPE_OF_ALERT = Alert::SUCCES_ALERT;
                    $session -> __set("alert", serialize($alert));
                }
            }
            else
            {
                $alert -> Message = "Użytkownik jest już zapisany do tego kursu.";
                $alert -> TYPE_OF_ALERT = Alert::WARNING_ALERT;
                $session -> __set("alert", serialize($alert));
            }

            ControllerFactory::Redirect(ControllerDictionary::COURSE_CONTROLLER_ID, ControllerDictionary::COURSE_MAIN_ID);
        }
    }
?>