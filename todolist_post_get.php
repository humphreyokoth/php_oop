<?php
// importing db connection.
include("./db_connnection.php");

$dbobject = new DatabaseConnection;
$conn = $dbobject->OpenCon();



//New instance of objects.
$insert_todoObject = new ManageTodoList();
$get_todoObject = new ManageTodoList();
$update_todoObject = new ManageTodoList();
$delete_todoObject = new ManageTodoList();
//Posting to db query with insert method.
if (isset($_POST["item"])) {
  $dbobject = new DatabaseConnection;
  $conn = $dbobject->OpenCon();
  
  $insert_todoObject->insert_todo_item($_POST["item"]);
  //error_log("$insert_todoObject", 3, "./php_error.log");
} elseif (isset($_REQUEST["Retrieved"])) {
  $get_todoObject->get_todo_list();
} elseif (isset($_GET["edited"])) {
  $update_todoObject->update_todo_item($_POST["edited"]);
} elseif (isset($_POST["deleted"])) {
  $delete_todoObject->delete_todo_item($_POST["deleted"]);
};


// Class to doitem/
// class TodoItem
// {

//   public $id;
//   public $title;
//   public $date_added;

//   public function __construct($id, $title, $date_added)
//   {
//     $this->$id = $id;
//     $this->$title = $title;
//     
//   }
// }
// Post todo item method.
class ManageTodoList
{
  public $dbobject = null;
  public $conn     = null;

  public function __construct()
  {
    $this->dbobject = new DatabaseConnection;
    $this->conn = $this->dbobject->OpenCon();
  }

  public function insert_todo_item($to_do_item)
  {
    // Inserting into table todolist from input form.
    $sql = "INSERT INTO to_do_list_items(`title`) VALUES ('$to_do_item')";
    // Return results.
    $result =  $this->conn->query($sql);

    // error_log(print_r($conn) , 3, "./php_error.log");
    if ($result) {
      $row = $this->get_last_todo_item($this->conn);
      $item                = [];
      $item["id"]          = $row[0];
      $item["title"]       = $row[1];
      $item["date_added"]  = $row[2];
      $response            = [];
      $response["message"] =  'success';
      $response['data']    =  $item;

      error_log(print_r($response, true), 3, "./php_error.log");
      echo json_encode($response);
    } else {

      $response = [];
      $response["message"] =  ' Fail.';
      echo ("Not successful");
    }
  }

  // Get todo item by id from DB .
  public function get_last_todo_item()
  {
    $get_added_item = "SELECT * FROM to_do_list_items  ORDER by id DESC limit 1";
    $get_item = [];
    $result = $this->conn->query($get_added_item);

    while ($row = $result->fetch_row()) {

      $get_item = $row;
    }
    return $get_item;
  }


  // Retrieve from DB method
  public function get_todo_list()
  {
    $dbobject = new DatabaseConnection;
    $update_todoObject = new ManageTodoList();
    $delete_todoObject = new ManageTodoList();
    $conn = $dbobject->OpenCon();
    $sql = "SELECT * FROM to_do_list_items";

    $result = $this->$conn->query($sql);


    if ($result->num_rows > 0) {
      // output data of each row
      while ($row = $result->fetch_assoc()) {
      
?>

        <li>
          <input type="checkbox" name="checkbox" id="list-1" />
          <span><?php echo  $row["date_added"] ?></span>
          <i class="fa-solid fa-trash-can deleteIcon"><?php $update_todoObject   ?></i>

          <i class="fa-solid fa-pencil editIcon "><?php $delete_todoObject ?></i>

          <label class="label-2"> <?php echo  $row["title"] .  "<br>"; ?></label>



        </li>
<?php }
    } else {
      echo "0 results";
    }
  }

  public function update_todo_item($id)
  {
    $dbobject = new DatabaseConnection;
    $conn = $dbobject->OpenCon();

    // Inserting into table todolist from input form.
    $sql = "UPDATE `to_do_list_items` (`title`,`date_added`) VALUES ('$id')";

    // Return results.
    $result = $this->$conn->query($sql);

    // error_log(print_r($conn) , 3, "./php_error.log");
    if ($result) {

      echo ("successfully updated");
    } else {


      echo ("Not successful");
    }
  }
  public function delete_todo_item($id)
  {
    $dbobject = new DatabaseConnection;
    $conn = $dbobject->OpenCon();
    $sql = "DELETE FROM `to_do_list_items` WHERE id =$id ";
    $result = $this->$conn->query($sql);

    if ($result) {
      echo "successfully deleted";
    } else {
      echo "Unable to delete";
    }
  }
}


?>