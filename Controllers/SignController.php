<?php
    include_once 'ControlerDictionary.php';
    include_once 'ControlerFactory.php';
    include_once 'Models/RegisterModel.php';

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
                echo "OK";
            }
            else
            {
                //TODO: Error
            }
        }
    }
?>