<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>sign up</title>
</head>

          
      <div class="container">
        <form method="POST" action="signup.php"  class="form">
          <div class="form-group">
            <label for="fullname">Full name</label>
            <input type="text" name="name" id="fullname" class="form-control"   placeholder="full name" required>
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required>
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
          </div>
          
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
          </div>
          <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
      
        </div>

       
        <?php

        include 'db_connection.php';
        $conn = OpenCon();

        if(isset($_POST['submit'])){

          $name = $conn -> real_escape_string($_POST['name']);
          $email = $conn -> real_escape_string($_POST['email']);
          $password = $conn -> real_escape_string($_POST['password']);
          $sql = "SELECT Email FROM emails WHERE Email LIKE '$email'";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              echo '<div class="container" id="textArea"><h4 id="text">you are already signed up with the email '.$row['Email'].',please log in:  </h4>
              <form action="login.php" id="signup">
              <input type="submit" value="log in" class="btn btn-primary">
              </form>';
            }
          } else {
            $query = "INSERT INTO emails (name,Email,password)
            VALUES ('$name', '$email', '$password')";

            if ($conn->query($query) === TRUE) {
              echo '<div class="container" id="textArea"><h3 id="text">you have been successfully signed up</h3>
              <form action="login.php" id="signup">
              <input type="submit" value="log IN" class="btn btn-primary">
              </form>'
              ;
            } else {
              echo "Error: " . $sql . "<br>" . $conn->error;  
            }
        
        }  
        }
          

     CloseCon($conn);
 
    ?>
        
        
       


</body>
</html>