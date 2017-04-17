<?php
    include_once 'ControlerDictionary.php';
    include_once 'ControlerFactory.php';
    include_once 'Models/RegisterModel.php';
    include_once 'Models/LoginModel.php';
    include_once 'Enviroment/DbContext.php';
    include_once 'Enviroment/Alert.php';
    include_once 'Enviroment/Session.php';
    include_once 'Enviroment/User.php';
    include_once 'Dictionaries/UserRolesDictionary.php';
    include_once 'Dictionaries/ExceptionDictionary.php';

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
                case ControllerDictionary::LOGOUT_ID:
                    $this -> LogOut();
                    break;
            }
        }
        
        public function LogOut()
        {
            $session = Session::getInstance();
            
            if ($session -> __isset("user"))
            {
                $session -> __unset("user");
            }

            ControllerFactory::Redirect(ControllerDictionary::MAIN_CONTROLLER_ID, ControllerDictionary::MAIN_PAGE_ID);
        }

        public function Login()
        {
            echo ControllerFactory::GetViewContent(ControllerDictionary::LOGIN_PAGE);
        }

        public function LoginPost()
        {
            $user = new User();
            $pwdFromDb = "";

            $email = $_POST["email"];
            $pwd = $_POST["password"];
            $rememberMe = $_POST["remember"];

            $loginModel = new LoginModel();
            $loginModel -> Email = $email;
            $loginModel -> Password = $pwd;
            $loginModel -> RememberMe = $rememberMe;

            $dbResult = $this -> GetUserFromDb($loginModel);
            if ($dbResult -> num_rows > 0)
            {
                while ($row = $dbResult -> fetch_assoc())
                {
                    $user -> Name = $row["name"];
                    $user -> Surname = $row["surname"];
                    $user -> Email = $row["email"];
                    $user -> RoleId = $row["role_id"];

                    $pwdFromDb = $row["password"];
                }

                if (strcmp($pwd, $pwdFromDb) === 0)
                {
                    $session = Session::getInstance();
                    $session -> __set("user", serialize($user));
                }
                else
                {
                    $alert = new Alert();
                    $alert -> Message = ExceptionDictionary::LOGIN_DB_FAILED;
                    $alert -> TYPE_OF_ALERT = Alert::DANGER_ALERT;

                    $session = Session::getInstance();
                    $session -> __set("alert", serialize($alert));
                }
            }
            else
            {
                $alert = new Alert();
                $alert -> Message = ExceptionDictionary::LOGIN_DB_NOT_FOUND;
                $alert -> TYPE_OF_ALERT = Alert::DANGER_ALERT;

                $session = Session::getInstance();
                $session -> __set("alert", serialize($alert));
            }

            ControllerFactory::Redirect(ControllerDictionary::MAIN_CONTROLLER_ID, ControllerDictionary::MAIN_PAGE_ID);
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
                $insertStatement = $this -> RegisterUserDbStatement($registerModel);
                $dbContext = new DbContext();

                $inserted = $dbContext -> MakeStatement($insertStatement, DbContext::INSERT_STATEMENT);

                if ($inserted)
                {
                    $alert -> Message = "Poprawnie zarejestrowano konto " . $email . "!";
                    $alert -> TYPE_OF_ALERT = Alert::SUCCES_ALERT;
                }
                else
                {
                    $alert -> Message = ExceptionDictionary::REGISTER_DB_FAILED;
                    $alert -> TYPE_OF_ALERT = Alert::DANGER_ALERT;
                }

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

        private function GetUserFromDb($loginModel)
        {
            $email = $loginModel -> Email;
            $selectStatement = "SELECT * FROM users WHERE email LIKE '$email'";

            $dbContext = new DbContext();
            return $dbContext -> Select($selectStatement);
        }

        private function RegisterUserDbStatement($registerModel)
        {
            $name = $registerModel -> Name;
            $surname = $registerModel -> Surname;
            $email = $registerModel -> Email;
            $password = $registerModel -> Password;

            $insertStatement = "INSERT INTO users (role_id, name, surname, email, password) VALUES (" . UserRolesDictionary::GUEST . ",";
            $insertStatement = $insertStatement . "'$name', " . "'$surname', ";
            $insertStatement = $insertStatement . "'$email', " . "'$password')";

            return $insertStatement;
        }
    }
?>