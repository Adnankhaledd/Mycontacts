<?php 
    include 'db_connection.php';
    $conn = opencon();
    
    if(isset($_POST['Name'])){
        $sql = "SELECT `Name`,`Number`,`contact_id` FROM contacts WHERE `Name`='".$_POST['Name']."'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo json_encode($row);
            }
            } else {
            echo "0 results";
            }
    }




    CloseCon($conn);
?>