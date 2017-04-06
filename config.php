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
            $this -> connection = new mysqli($db_host, $db_user, $db_password, $db_name);

            if ($connection -> connect_error)
            {
                die($DB_CONNECTION_FAILED . $this -> connection -> connect_error);
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

    class Session
    {
    const SESSION_STARTED = TRUE;
    const SESSION_NOT_STARTED = FALSE;
   
    // The state of the session
    private $sessionState = self::SESSION_NOT_STARTED;
   
    // THE only instance of the class
    private static $instance;
   
    private function __construct() {}
   
    public static function getInstance()
    {
        if ( !isset(self::$instance))
        {
            self::$instance = new self;
        }
       
        self::$instance->startSession();
       
        return self::$instance;
    }
   
    public function startSession()
    {
        if ( $this->sessionState == self::SESSION_NOT_STARTED )
        {
            $this->sessionState = session_start();
        }
       
        return $this->sessionState;
    }
   
    public function __set( $name , $value )
    {
        $_SESSION[$name] = $value;
    }
   
    public function __get( $name )
    {
        if ( isset($_SESSION[$name]))
        {
            return $_SESSION[$name];
        }
    }
   
    public function __isset( $name )
    {
        return isset($_SESSION[$name]);
    }
     
    public function __unset( $name )
    {
        unset( $_SESSION[$name] );
    }
      
    public function destroy()
    {
        if ( $this->sessionState == self::SESSION_STARTED )
        {
            $this->sessionState = !session_destroy();
            unset( $_SESSION );
           
            return !$this->sessionState;
        }
       
        return FALSE;
    }
    }
?>