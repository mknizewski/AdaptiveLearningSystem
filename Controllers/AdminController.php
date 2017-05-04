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
                    case ControllerDictionary::ADMIN_COURSE_DELETE_ID:
                        $this -> DeleteCourse();
                        break;
                    case ControllerDictionary::ADMIN_COURSE_LIST_ID:
                        $this -> CoursesList();
                        break;
					case ControllerDictionary::ADMIN_VIEW_USERS_ID:
						$this -> ViewUsers();
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

        }

        public function DeleteCourse()
        {

        }
		
		public function ViewUsers()
        {
			echo ControllerFactory::GetViewContent(ControllerDictionary::ADMIN_VIEW_USERS_PAGE);
        }

        public function CheckAuth()
        {
            $session = Session::getInstance();
            $user = unserialize($session -> __get("user"));

            if ($user -> RoleId == UserRolesDictionary::ADMIN)
                return true;
            
            return false;
        }
		
		public function CheckRole($role_id)
		{
			$roleText = "";
			
			if($role_id == 1)
				$roleText = UserRolesDictionary::ADMIN_TEXT;
			
			if($role_id == 2)
				$roleText = UserRolesDictionary::STUDENT_TEXT;
		
			if($role_id == 3)
				$roleText = UserRolesDictionary::GUEST_TEXT;
			
			return $roleText;
		}
		
		public function CheckLearningStyle($learning_style_id)
		{
			$learingText = "";
			
			if($learning_style_id == 0)
				$learingText = "Brak";
			
			if($learning_style_id == 1)
				$learingText = LearningStyleDictionary::VISUAL_TEXT;
			
			if($learning_style_id == 2)
				$learingText = LearningStyleDictionary::AURAL_TEXT;
			
			if($learning_style_id == 3)
				$learingText = LearningStyleDictionary::READING_TEXT;
			
			if($learning_style_id == 4)
				$learingText = LearningStyleDictionary::KINESTHETIC_TEXT;
			
			return $learingText;
		}
    }
?>