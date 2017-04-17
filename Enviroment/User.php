<?php
    include_once 'Enviroment/DbContext.php';

    class User
    {
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

            if ($dbResult -> num_rows > 0)
            {
                $row = $dbResult -> fetch_assoc();
                $role = $row["name"];
            }

            return $role;
        }

        private function RoleStatement()
        {
            $roleStatment = "SELECT * FROM roles WHERE role_id = '$RoleId'";
            return $roleStatment;
        }
    }
?>