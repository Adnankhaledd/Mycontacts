<?php 
session_start();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">\
    <link rel="stylesheet" href="style.css">
    <title>phpProject</title>
  </head>
  <body>
  
  <div class="container login">
    <form method="POST" action="login.php">
    
      <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required>
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
      </div>
      <button type="submit" name="submit" class="btn btn-primary">Log in</button>
    
   </form>
  </div>



    
    <?php

    include 'db_connection.php';
    $conn = OpenCon();
    if(isset($_POST['submit'])){
        $email = $conn -> real_escape_string($_POST['email']);
        $password = $conn -> real_escape_string($_POST['password']);
        $sql = "SELECT name,password,User_id FROM emails WHERE Email='$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          
          while($row = $result->fetch_assoc()) {
              if($row['password'] == $password){
                  $_SESSION['id'] = $row['User_id'];
                  $_SESSION['name'] = $row['name'];
                  header('location: index.php'); 
              }else{
                echo '<div class="container"><h4>wrong password please check again</h4></div>';
              }
                 
          }
         } else {
              echo '<div class="container" id="textArea"><h3>we didnt find such an email</h3>
              <form action="signup.php" id="signup">
              <input type="submit" value="sign up!" class="btn btn-primary">
              </form>
              </div>'; 
              }
    }
    
     CloseCon($conn);
 

    ?>
    

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>

