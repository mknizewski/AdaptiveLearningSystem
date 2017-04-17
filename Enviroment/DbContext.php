<?php
    class DBContext
    {
        const INSERT_STATEMENT = 1;
        const UPDATE_STATEMENT = 2;
        const DELETE_STATEMENT = 3;

        const db_name = "als";
        const db_host = "localhost";
        const db_user = "root";
        const db_password = "";
    
        const host_name = "ALS";
        const website_name = "Adaptacyjny System Uczący";

        private $connection;

        public function __construct()
        {
            $this -> connection = new mysqli($this -> db_host, $this -> db_user, $this -> db_password, $this -> db_name);

            if ($connection -> connect_error)
            {
                die($this -> connection -> connect_error);
            }
        }

        public function Select($select_statement)
        {
            return $this -> connection -> query($select_statement);
        }

        public function MakeStatement($statement, $statement_type)
        {
            return $this -> connection -> query($statement) === TRUE;
        }

        public function InsertMultiply($insert_statement)
        {
            return $this -> connection -> multi_query($insert_statement) === TRUE;
        }

        public function __destruct()
        {
            $this -> connection -> close();
        }
    }
?>