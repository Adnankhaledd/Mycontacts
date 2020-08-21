<?php 

    
    include 'db_connection.php';
    $conn = OpenCon();
    if(isset($_POST)){
        if ($_POST['number'] != '' && $_POST['contact'] != ''){
        $number = $_POST['number'];
        $contact = $_POST['contact']; 
        $sql = "INSERT INTO `contacts` (`User_id`, `contact_id`, `Name`, `Number`) VALUES ('1', NULL,'$contact', '$number')";
        if ($conn->query($sql) === TRUE) {
          $query = "SELECT `Name`,`Number`,`contact_id` FROM contacts WHERE `Name`='$contact'";
          $result = $conn->query($query);
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {  
              echo json_encode($row);
              }
              } else { echo 'error';}
              } else {
                echo 'error';
              }} else echo 'error';
            };
              CloseCon($conn);

?>