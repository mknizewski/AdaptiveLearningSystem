<?php
    class RegisterModel
    {
        public $Name = ""; 
        public $Surname = "";
        public $Email = "";
        public $Password = "";

        public function ValidateData()
        {
            if (strlen($this -> Name) === 0)
                return false;
            
            if (strlen($this -> Surname) === 0)
                return false;

            $domain = strstr($this -> Email, "@");

            if ($domain === false)
                return false;

            if (strlen($this -> Password) === 0)
                return false;

            return true;
        }
    }
?>