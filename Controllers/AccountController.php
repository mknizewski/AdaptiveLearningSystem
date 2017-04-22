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

            $numOfQuestions = 7;
            $visualPoints = 0;
            $auralPoints = 0;
            $kinestheticPoints = 0;

            for ($i = 0; $i < $numOfQuestions; $i++)
            {
                $vCheckBox = "p" . $i . "v";
                $aCheckBox = "p" . $i . "a";
                $kCheckBox = "p" . $i . "k";

                if (isset($_POST[$vCheckBox]))
                    $visualPoints++;

                if (isset($_POST[$aCheckBox]))
                    $auralPoints++;

                if (isset($_POST[$kCheckBox]))
                    $kinestheticPoints++;
            }

            $max = max(array($visualPoints, $auralPoints, $kinestheticPoints));
            $learningId = "";
            $learingText = "";
            
            switch ($max)
            {
                case $visualPoints:
                    $learningId = LearningStyleDictionary::VISUAL;
                    $learingText = LearningStyleDictionary::VISUAL_TEXT;
                    break;
                case $auralPoints:
                    $learningId = LearningStyleDictionary::AURAL;
                    $learingText = LearningStyleDictionary::AURAL_TEXT;
                    break;
                case $kinestheticPoints:
                    $learingId = LearningStyleDictionary::KINESTHETIC;
                    $learingText = LearningStyleDictionary::KINESTHETIC_TEXT;
                    break;
            }

            $user = unserialize($session -> __get("user"));
            $userId = $user -> Id;

            $dbContext = new DbContext();
            $updateStatement = "UPDATE users SET learning_style_id = $learingId WHERE id = $userId";
            $dbContext -> MakeStatement($updateStatement, DbContext::UPDATE_STATEMENT);
            
            $alert -> Message = "Dziękujemy za wypełnienie ankiety. Według ankiety jesteś: <b>" . $learingText . "</b>";
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

        private function CheckAuth()
        {
            $session = Session::getInstance();
            return $session -> __isset("user");
        }
    }
?>