<?php
    include_once 'Controllers/ControlerFactory.php';
    include_once 'Controllers/ControlerDictionary.php';
    include_once 'Enviroment/Session.php';
    include_once 'Enviroment/DbContext.php';
    include_once 'Enviroment/Alert.php';
    include_once 'Dictionaries/ExceptionDictionary.php';
    include_once 'Dictionaries/LearningStyleDictionary.php';

    class AccountController
    {
        public function GetViewById($view_id)
        {
            if ($this -> CheckAuth())
            {
                switch ($view_id)
                {
                    case ControllerDictionary::ACCOUNT_MAIN_ID:
                        $this -> Main();
                        break;
                    case ControllerDictionary::ACCOUNT_PERMISSIONS_ID:
                        $this -> Permission();
                        break;
                    case ControllerDictionary::ACCOUNT_FORM_ID:
                        $this -> Form();
                        break;
                    case ControllerDictionary::ACCOUNT_FORM_POST_ID:
                        $this -> FormPost();
                        break;
					case ControllerDictionary::ACCOUNT_CHANGE_PASSWORD_ID:
                        $this -> ChangePasswordPage();
                        break;
					case ControllerDictionary::ACCOUNT_CHANGE_PASSWORD_POST_ID:
                        $this -> ChangePasswordRun();
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

        public function Form()
        {
            echo ControllerFactory::GetViewContent(ControllerDictionary::ACCOUNT_FORM_PAGE);
        }

        public function FormPost()
        {
            $alert = new Alert();
            $session = Session::getInstance();

            $numOfQuestions = 9;
            $visualPoints = 0;
            $auralPoints = 0;
			$readingPoints = 0;
            $kinestheticPoints = 0;

            for ($i = 0; $i < $numOfQuestions; $i++)
            {
                $vCheckBox = "p" . $i . "v";
                $aCheckBox = "p" . $i . "a";
				$rCheckBox = "p" . $i . "r";
                $kCheckBox = "p" . $i . "k";

                if (isset($_POST[$vCheckBox]))
                    $visualPoints++;

                if (isset($_POST[$aCheckBox]))
                    $auralPoints++;
				
				if (isset($_POST[$rCheckBox]))
                    $readingPoints++;

                if (isset($_POST[$kCheckBox]))
                    $kinestheticPoints++;
            }

            $max = max(array($visualPoints, $auralPoints, $readingPoints, $kinestheticPoints));
            $learningId = "";
            $learingText = "";
			$currentStylePoints = 0;
			$currentStylePercent = 0;
			
			$visualPercent = round($visualPoints / $numOfQuestions * 100, 2);
			$auralPercent = round($auralPoints / $numOfQuestions * 100, 2);
			$readingPercent = round($readingPoints / $numOfQuestions * 100, 2);
			$kinestheticPercent = round($kinestheticPoints / $numOfQuestions * 100, 2);
            
            switch ($max)
            {
                case $visualPoints:
                    $learningId = LearningStyleDictionary::VISUAL;
                    $learingText = LearningStyleDictionary::VISUAL_TEXT;
					$currentStylePoints = $visualPoints;
                    break;
                case $auralPoints:
                    $learningId = LearningStyleDictionary::AURAL;
                    $learingText = LearningStyleDictionary::AURAL_TEXT;
					$currentStylePoints = $auralPoints;
                    break;
				case $readingPoints:
                    $learningId = LearningStyleDictionary::READING;
                    $learingText = LearningStyleDictionary::READING_TEXT;
					$currentStylePoints = $readingPoints;
                    break;
                case $kinestheticPoints:
                    $learingId = LearningStyleDictionary::KINESTHETIC;
                    $learingText = LearningStyleDictionary::KINESTHETIC_TEXT;
					$currentStylePoints = $kinestheticPoints;
                    break;
            }
			$currentStylePercent = round($currentStylePoints / $numOfQuestions * 100, 2);

            $user = unserialize($session -> __get("user"));
            $userId = $user -> Id;

            $dbContext = new DbContext();
            $updateStatement = "UPDATE users SET learning_style_id = $learingId WHERE id = $userId";
            $dbContext -> MakeStatement($updateStatement, DbContext::UPDATE_STATEMENT);
            
            $alert -> Message = "Dziękujemy za wypełnienie ankiety. Według ankiety jesteś: <b>" . $learingText ." (". $currentStylePercent ."%)</b>
									<p>". LearningStyleDictionary::VISUAL_TEXT .": ". $visualPercent ."%</p>
									<p>". LearningStyleDictionary::AURAL_TEXT .": ". $auralPercent ."%</p>
									<p>". LearningStyleDictionary::READING_TEXT .": ". $readingPercent ."%</p>
									<p>". LearningStyleDictionary::KINESTHETIC_TEXT .": ". $kinestheticPercent ."%</p>";
            $alert -> TYPE_OF_ALERT = Alert::INFO_ALERT;
            $session -> __set("alert", serialize($alert));

            ControllerFactory::Redirect(ControllerDictionary::ACCOUNT_CONTROLLER_ID, ControllerDictionary::ACCOUNT_MAIN_ID);
        }

        public function Main()
        {
            echo ControllerFactory::GetViewContent(ControllerDictionary::ACCOUNT_MAIN_PAGE);
        }

        public function Permission()
        {
            echo ControllerFactory::GetViewContent(ControllerDictionary::ACCOUNT_PERMISSIONS_PAGE);
        }
		
		public function ChangePasswordPage()
		{
			echo ControllerFactory::GetViewContent(ControllerDictionary::ACCOUNT_CHANGE_PASSWORD_PAGE);
		}
		
		public function ChangePasswordRun()
		{
			$alert = new Alert();
            $dbContext = new DbContext();
            $session = Session::getInstance();
            $CurrPass = $_POST["piCurrPass"];
            $NewPass = $_POST["piNewPass"];
            $NewPassRepeat = $_POST["piNewPassRepeat"];
			$id = $_POST["userId"];

            
			$selectStatement = "SELECT id FROM users WHERE id = '". $id ."' AND password = '" . $CurrPass . "'";
			$usersList = $dbContext -> Select($selectStatement);
			if ($usersList -> num_rows == 0)
			{
				$alert -> Message = "Obecne hasło nie jest poprawne! Popraw to!";
                $alert -> TYPE_OF_ALERT = Alert::WARNING_ALERT;
                $session -> __set("alert", serialize($alert));
				header("Location: index.php?con=4&page=5");
			}
			else if($NewPass != $NewPassRepeat)
			{
				$alert -> Message = "Hasła nie pokrywają się! Popraw błędy!";
                $alert -> TYPE_OF_ALERT = Alert::WARNING_ALERT;
                $session -> __set("alert", serialize($alert));
				header("Location: index.php?con=4&page=5");
			}
			else
			{
				$updateStatement = "UPDATE users SET password = '" . $NewPass . "' WHERE id = '" . $id . "'";
				$result = $dbContext -> MakeStatement($updateStatement, DbContext::UPDATE_STATEMENT);
				
				if ($result)
				{
					$alert -> Message = "Zmieniono hasło!";
					$alert -> TYPE_OF_ALERT = Alert::SUCCES_ALERT;
					$session -> __set("alert", serialize($alert));
					header("Location: index.php?con=4&page=5");
				}
			}

		}
		
        private function CheckAuth()
        {
            $session = Session::getInstance();
            return $session -> __isset("user");
        }
    }
?>