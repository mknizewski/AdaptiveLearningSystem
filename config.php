<?php
    // Includes
    include_once 'dictionaries.php';

    // Server Global Variables
    $db_name = "";
    $db_host = "";
    $db_user = "";
    $db_password = "";
    
    $host_name = "";
    $website_name = "";

    // Class of Database Context
    class DBContext
    {
        const INSERT_STATEMENT = 1;
        const UPDATE_STATEMENT = 2;
        const DELETE_STATEMENT = 3;

        private $connection;

        public function __construct()
        {
            $connection = new mysqli($db_host, $db_user, $db_password, $db_name);

            if ($connection -> connect_error)
            {
                die($DB_CONNECTION_FAILED . $connection -> connect_error);
            }
        }

        public function Select($select_statement)
        {
            return $connection -> query($select_statement);
        }

        public function MakeStatement($statement, $statement_type)
        {
            return $connection -> query($statement) === TRUE;
        }

        public function InsertMultiply($insert_statement)
        {
            return $connection -> multi_query($insert_statement) === TRUE;
        }

        public function __destruct()
        {
            $connection -> close();
        }
    }

    class Server
    {

    }
?>