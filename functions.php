<?php 
    session_start();
    include 'db_connection.php';
    
    function updateList(){
        
        
        global $conn;
        $sql = "SELECT `Name` FROM contacts WHERE User_id ='".$_SESSION['id']."'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $name = $row['Name'];
            echo "<option value ='$name'>$name</option>";
        }
        echo '</select> yes';
        } else {
        echo "</select> nope";
    }
    }
    updateList();
    
    


?>