<?php 

// Class Database connection.
class DatabaseConnection{
function OpenCon(){
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $db = "wp_course";
    $conn = new mysqli($dbhost,$dbuser,$dbpass,$db) or die ("connectfailed:%s\n".$conn->error);
    return $conn;
}
function CloseCon($conn){
 //$conn->close();
}
}
?>