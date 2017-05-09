<?php
    include_once 'DbContext.php';

    class User
    {
        public $Id;
        public $Name;
        public $Surname;
        public $Email;
        public $RoleId;

        public function GetRole()
        {
            $role = "";
            $dbContext = new DbContext();
            $statment = $this -> RoleStatement();

            $result = $dbContext -> Select($statment);

            if ($result -> num_rows > 0)
            {
                $row = $result -> fetch_assoc();
                $role = $row["name"];
            }

            if ($role === "admin")
                return "Administrator";
            else if ($role === "student")
                return "Student";
            else
                return "Gość";
        }

        public function GetLearningStyle()
        {
            $dbContext = new DbContext();
            $statment = "SELECT * FROM users WHERE id=" . $this -> Id;
            $userFromDb = $dbContext -> Select($statment) -> fetch_assoc();

            return $userFromDb["learning_style_id"];
        }

        private function RoleStatement()
        {
            $roleStatment = "SELECT * FROM roles WHERE id = " . $this -> RoleId;
            return $roleStatment;
        }
    }
?>