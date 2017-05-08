<?php
    include_once 'Controllers/ControlerFactory.php';
    include_once 'Controllers/ControlerDictionary.php';
    include_once 'Enviroment/Session.php';
    include_once 'Enviroment/DbContext.php';
    include_once 'Enviroment/Alert.php';
    include_once 'Dictionaries/ExceptionDictionary.php';
    include_once 'Dictionaries/LearningStyleDictionary.php';
    include_once 'Dictionaries/UserRolesDictionary.php';
    include_once 'Models/CourseModel.php';

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
                    case ControllerDictionary::ADMIN_COURSE_ADD_ID:
                        $this -> AddCourse();
                        break;
                    case ControllerDictionary::ADMIN_COURSE_ADD_POST_ID:
                        $this -> AddCoursePost();
                        break;
                    case ControllerDictionary::ADMIN_COURSE_EDIT_ID:
                        $this -> EditCourse();
                        break;
                    case ControllerDictionary::ADMIN_COURSE_EDIT_POST_ID:
                        $this -> EditCoursePost();
                        break;
                    case ControllerDictionary::ADMIN_COURSE_DELETE_ID:
                        $this -> DeleteCourse();
                        break;
                    case ControllerDictionary::ADMIN_COURSE_LIST_ID:
                        $this -> CoursesList();
                        break;
					case ControllerDictionary::ADMIN_VIEW_USERS_ID:
						$this -> ViewUsers();
						break;
                    case ControllerDictionary::ADMIN_VIEW_USERS_DELETE_USER_FROM_COURSE_POST_ID:
                        $this -> DeleteUserFromCourse();
                        break;
                    case ControllerDictionary::ADMIN_COURSE_LIST_ADD_USER_TO_COURSE_ID:
                        $this -> AddUserToCourse();
                        break;
                    case ControllerDictionary::ADMIN_ADD_LESSON_ID:
                        $this -> AddLesson();
                        break;
                    case ControllerDictionary::ADMIN_ADD_LESSON_POST_ID:
                        $this -> AddLessonPost();
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

        public function AddCourse()
        {
            echo ControllerFactory::GetViewContent(ControllerDictionary::ADMIN_COURSE_ADD_PAGE);
        }

        public function AddCoursePost()
        {
            $alert = new Alert();
            $session = Session::getInstance();
            $courseModel = new CourseModel();
            $title = $_POST["courseName"];
            $description = $_POST["courseDetails"];

            $courseModel -> SetCourseModel($title, $description);
            if ($courseModel -> ValidateData())
            {
                $dbContext = new DbContext();
                $currentDate = date('Y-m-d');
                $insertStatement = "INSERT INTO courses (title, description, insert_time) VALUES ('$title', '$description', '$currentDate')";

                $result = $dbContext -> MakeStatement($insertStatement, DbContext::INSERT_STATEMENT);
                if ($result)
                {
                    $alert -> Message = "Poprawnie dodano nowy kurs!";
                    $alert -> TYPE_OF_ALERT = Alert::SUCCES_ALERT;
                    $session -> __set("alert", serialize($alert));

                    ControllerFactory::Redirect(ControllerDictionary::ADMIN_CONTROLLER_ID, ControllerDictionary::ADMIN_MAIN_ID);
                }
                else
                {
                    $alert -> Message = ExceptionDictionary::DB_FAILED;
                    $alert -> TYPE_OF_ALERT = Alert::DANGER_ALERT;
                    $session -> __set("alert", serialize($alert));

                    ControllerFactory::Redirect(ControllerDictionary::ADMIN_CONTROLLER_ID, ControllerDictionary::ADMIN_COURSE_ADD_ID);
                }
            }
            else
            {
                $alert -> Message = ExceptionDictionary::ADD_COURSE_FAILED;
                $alert -> TYPE_OF_ALERT = Alert::DANGER_ALERT;
                $session -> __set("alert", serialize($alert));

                ControllerFactory::Redirect(ControllerDictionary::ADMIN_CONTROLLER_ID, ControllerDictionary::ADMIN_COURSE_ADD_ID);
            }
        }

        public function CoursesList()
        {
            echo ControllerFactory::GetViewContent(ControllerDictionary::ADMIN_COURSE_LIST_PAGE);
        }

        public function EditCourse()
        {
            echo ControllerFactory::GetViewContent(ControllerDictionary::ADMIN_COURSE_EDIT_PAGE);
        }

        public function EditCoursePost()
        {
            $alert = new Alert();
            $courseModel = new CourseModel();
            $dbContext = new DbContext();
            $session = Session::getInstance();

            $courseId = $_POST["courseId"];
            $courseTitle = $_POST["courseName"];
            $courseDesc = $_POST["courseDetails"];

            $courseModel -> SetCourseModel($courseTitle, $courseDesc);

            if ($courseModel -> ValidateData())
            {
                $updateStatement = "UPDATE courses SET title='$courseTitle', description='$courseDesc' WHERE id=$courseId";
                $result = $dbContext -> MakeStatement($updateStatement, DbContext::UPDATE_STATEMENT);

                if ($result)
                {
                    $alert -> Message = "Poprawnie zedytowano kurs!";
                    $alert -> TYPE_OF_ALERT = Alert::SUCCES_ALERT;
                    $session -> __set("alert", serialize($alert));

                    ControllerFactory::Redirect(ControllerDictionary::ADMIN_CONTROLLER_ID, ControllerDictionary::ADMIN_COURSE_LIST_ID);
                }
                else
                {
                    $alert -> Message = ExceptionDictionary::DB_FAILED;
                    $alert -> TYPE_OF_ALERT = Alert::DANGER_ALERT;
                    $session -> __set("alert", serialize($alert));

                    ControllerFactory::Redirect(ControllerDictionary::ADMIN_CONTROLLER_ID, ControllerDictionary::ADMIN_COURSE_ADD_ID);
                }
            }
            else
            {
                $alert -> Message = ExceptionDictionary::ADD_COURSE_FAILED;
                $alert -> TYPE_OF_ALERT = Alert::DANGER_ALERT;
                $session -> __set("alert", serialize($alert));

                ControllerFactory::Redirect(ControllerDictionary::ADMIN_CONTROLLER_ID, ControllerDictionary::ADMIN_COURSE_EDIT_ID);
            }
        }

        public function DeleteCourse()
        {
            $alert = new Alert();
            $dbContext = new DbContext();
            $session = Session::getInstance();
            $courseId = $_POST["id"];
			
            $deleteStatement = "DELETE FROM courses WHERE id=" . $courseId;
            $result = $dbContext -> MakeStatement($deleteStatement, DbContext::DELETE_STATEMENT);

            if ($result)
            {
                $alert -> Message = "Poprawnie usunięto kurs!";
                $alert -> TYPE_OF_ALERT = Alert::SUCCES_ALERT;
                $session -> __set("alert", serialize($alert));
            }
        }
        
        public function AddUserToCourse()
        {
            $alert = new Alert();
            $dbContext = new DbContext();
            $session = Session::getInstance();
            $currentDate = date('Y-m-d');

            $userId = $_POST["userId"];
            $courseId = $_POST["courseId"];
            $roleId = $_POST["roleId"];
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
        }

	    public function ViewUsers()
        {
		    echo ControllerFactory::GetViewContent(ControllerDictionary::ADMIN_VIEW_USERS_PAGE);
        }
        
        public function DeleteUserFromCourse()
        {   
            $alert = new Alert();
            $dbContext = new DbContext();
            $session = Session::getInstance();
            $userId = $_POST["userId"];
            $courseId = $_POST["courseId"];

            $deleteStatement = "DELETE FROM courses_users WHERE id_user=" . $userId . " AND id_course=" . $courseId;
            $result = $dbContext -> MakeStatement($deleteStatement, DbContext::DELETE_STATEMENT);

            if ($result)
            {
                $alert -> Message = "Poprawnie usunięto użytkownika z kursu!";
                $alert -> TYPE_OF_ALERT = Alert::SUCCES_ALERT;
                $session -> __set("alert", serialize($alert));
            }
        }

        public function AddLesson()
        {

        }

        public function AddLessonPost()
        {

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