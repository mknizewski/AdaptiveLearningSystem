<?php
    include_once 'ControlerDictionary.php';
    include_once 'ControlerFactory.php';
    include_once 'Models/RegisterModel.php';
    include_once 'Enviroment/DbContext.php';
    include_once 'Enviroment/Alert.php';
    include_once 'Enviroment/Session.php';

    class SignController
    {
        public function GetViewById($view_id)
        {
            switch ($view_id)
            {
                case ControllerDictionary::LOGIN_ID:
                    $this -> Login();
                    break;
                case ControllerDictionary::REGISTER_ID:
                    $this -> Register();
                    break;
                case ControllerDictionary::LOGIN_POST_ID:
                    $this -> LoginPost();
                    break;
                case ControllerDictionary::REGISTER_POST_ID:
                    $this -> RegisterPost();
                    break;
            }
        }
        
        public function Login()
        {
            echo ControllerFactory::GetViewContent(ControllerDictionary::LOGIN_PAGE);
        }

        public function LoginPost()
        {

        }

        public function Register()
        {
            echo ControllerFactory::GetViewContent(ControllerDictionary::REGISTER_PAGE);
        }

        public function RegisterPost()
        {
            $alert = new Alert();

            $name = $_POST["name"];
            $surname = $_POST["surname"];
            $email = $_POST["email"];
            $pwd = $_POST["password"];

            $registerModel = new RegisterModel();
            $registerModel -> Name = $name;
            $registerModel -> Surname = $surname;
            $registerModel -> Email = $email;
            $registerModel -> Password = $pwd;

            if ($registerModel -> ValidateData())
            {
                //TODO: Zapis w bazie
                $alert -> Message = "Poprawnie zarejestrowano konto " . $email . "!";
                $alert -> TYPE_OF_ALERT = Alert::SUCCES_ALERT;

                $session = Session::getInstance();
                $session -> __set("alert", serialize($alert));

                ControllerFactory::Redirect(ControllerDictionary::MAIN_CONTROLLER_ID, ControllerDictionary::MAIN_PAGE_ID);
            }
            else
            {
                $alert -> Message = "Popraw błędy";
                $alert -> TYPE_OF_ALERT = Alert::DANGER_ALERT;

                $session = Session::getInstance();
                $session -> __set("alert", serialize($alert));

                ControllerFactory::Redirect(ControllerDictionary::SIGN_CONTROLLER_ID, ControllerDictionary::REGISTER_ID);
            }
        }
    }
?>