<?php 
include 'db_connection.php';
$conn = opencon();
if(isset($_POST)){
    $id = $_POST['id'];
    $sql = "DELETE FROM contacts WHERE `contact_id`='$id'";

    if ($conn->query($sql) === TRUE) {
      echo "Record deleted successfully";
    } else {
      echo "Error deleting record: " . $conn->error;
    }
    
    }


?>