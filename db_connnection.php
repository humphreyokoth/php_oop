<?php 

// Class Database connection.
class DatabaseConnection{
    // public $dbhost ="localhost";
    // public $dbuser = "root" ;
    // public $dbpass = "";
    // public $db = "wp_course";
  
    public function __construct()
    {
        $this->OpenCon();
    }
    public function OpenCon(){
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $db = "wp_course";
        $conn = new mysqli($this->$dbhost,$this->$dbuser,$this->$dbpass,$this->$db) or die ("connectfailed:%s\n".$conn->error);
        return $conn;
    }
        // function CloseCon($conn){
        // //$conn->close();
        // }
}
?>