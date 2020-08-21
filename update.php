<?php 
include 'db_connection.php';
$conn = opencon();
if(isset($_POST)){
    $id = $_POST['id'];
    $number = $_POST['number'];
    $contact = $_POST['contact'];
    $sql = "UPDATE contacts SET `Name`='$contact',`Number`=$number WHERE `contact_id`='$id'";
    if ($conn->query($sql) === TRUE) {
        $query = "SELECT `Name`,`Number`,`contact_id` FROM contacts WHERE `contact_id`='$id'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {  
            echo json_encode($row);
            }
            } else { echo 'error';}
            } else {
              echo 'error';
            }
          };
           


?>