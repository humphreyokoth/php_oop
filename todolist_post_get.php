<?php
// importing db connection.
include("./db_connnection.php");

$dbobject = new DatabaseConnection;
$conn = $dbobject->OpenCon();

//Posting to db query with insert method..
if (
  isset($_POST["item"]) &&
  isset($_POST["insert_item"])

) {
  insert_todo_item($_POST["item"]);
} elseif (isset($_POST["edited"])) {
  update_todo_item($_POST["edited"]);
} elseif (isset($_POST["deleted"])) {
  delete_todo_item($_POST["deleted"]);
};


// Class to doitem/
class TodoItem
{

  public $id;
  public $title;
  public $date_added;

  public function __construct($id, $title, $date_added)
  {
    $this->$id = $id;
    $this->$title = $title;
    $this->$date_added = $date_added;
  }
}
// Post todo item method.

function insert_todo_item($to_do_item)
{
  $dbobject = new DatabaseConnection;
  $conn = $dbobject->OpenCon();
  //$conn = OpenCon();
  // Date declaring.
  $date = date('Y-m-d');
  // Inserting into table todolist from input form.
  $sql = "INSERT INTO to_do_list_items(`title`,`date_added`) VALUES ('$to_do_item','$date')";
  // Return results.
  $result = $conn->query($sql);

  // error_log(print_r($conn) , 3, "./php_error.log");
  if ($result) {
    $row = get_last_todo_item($conn);
    $response["message"] =  'success';
    $response['data'] =  $row;
    echo json_encode($response);
  } else {

    //$response = [];
    $response["message"] =  ' Fail.';
    echo ("Not successful");
  }
}

// Get todo item by id from DB.
function get_last_todo_item($conn)
{
  $get_added_item = "SELECT * FROM to_do_list_items ORDER BY  id  DESC limit 1";
  $result = $conn->query($get_added_item);
  $row = $result->fetch_assoc();
  return $row;
}
// Get todo item by title from DB.
// function get_todo_item_by_title($conn,$to_do_item){

//   $get_added_item = "SELECT * FROM to_do_list_items WHERE  title = $to_do_item ";
//   $result = $conn->query($get_added_item);
//   return $result;
// }

// Retrieve from DB method
function get_todo_list()
{
  $dbobject = new DatabaseConnection;
  $conn = $dbobject->OpenCon();
  $sql = "SELECT * FROM to_do_list_items";

  $result = $conn->query($sql);


  if ($result->num_rows > 0) {
    // $array1 = array();
    // output data of each row
    while ($row = $result->fetch_assoc()) {
      // array_push($array1,$row["title"], $row["date_added"] );
?>

      <li>
        <input type="checkbox" name="checkbox" id="list-1" />
        <span><?php echo  $row["date_added"] ?></span>
        <i class="fa-solid fa-trash-can deleteIcon"></i>

        <i class="fa-solid fa-pencil editIcon "></i>

        <label class="label-2"> <?php echo  $row["title"] .  "<br>"; ?></label>



      </li>
<?php }
  } else {
    echo "0 results";
  }
}

function update_todo_item($id){
  $dbobject = new DatabaseConnection;
  $conn = $dbobject->OpenCon();

  // Inserting into table todolist from input form.
  $sql = "UPDATE `to_do_list_items` (`title`,`date_added`) VALUES ('$id')";

  // Return results.
  $result = $conn->query($sql);

  // error_log(print_r($conn) , 3, "./php_error.log");
  if ($result) {
  
    echo ("successfully updated");
  } else {

  
    echo ("Not successful");
  }
  
}
function delete_todo_item($id){
  $dbobject = new DatabaseConnection;
  $conn = $dbobject->OpenCon();
  $sql = "DELETE FROM `to_do_list_items` WHERE id=$id ";
  $result = $conn->query($sql);

	if($result){
    echo "successfully deleted";
	}else{
    echo "Unable to delete";
	}
}


?>