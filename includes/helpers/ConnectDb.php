<?php
class ConnectDb{
    private static $instance = null;
    private $conn;

    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "MusicPlayerDb";

    private function __construct(){
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if($this->conn->connect_error){
            echo "Connection failed: " . $this->conn->connect_error;
        }
    }

    private function __clone(){}

    public function __wakeup(){
        throw new \Exception("Cannot unserialize singleton");
    }

    public static function getInstance(){
        if(!self::$instance){
            self::$instance = new ConnectDb();
        }

        return self::$instance;
    }

    public function getConnection() : object{ 
        return $this->conn;
    }
}

?>