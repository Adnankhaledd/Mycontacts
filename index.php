<?php 
session_start();
include 'db_connection.php';
$conn = OpenCon();  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    
    <title>php</title>
</head>
<body>

<div class="updates"></div>
    <div class="container">
        <div class="form-group"
            <br><br>
            <?php 
                echo '<h4> Welcome '.$_SESSION['name'].' all your contacts are displayed here:</h4><br><br>';
            ?>
         </div>
            <br>
            <div class="container">
            <div class="row" id="results"></div>
            <form method="post">
                <div class="row">
                    <div class="col">
                    <input id='contact' type="text" class="form-control" placeholder="contact name" required pattern="[a-zA-Z0-9 ]+">
                    </div>
                    <div class="col">
                    <input id='number' type="text" class="form-control" placeholder="number" required>
                    </div>
                    <i  class="fa fa-user-plus prefix blue-text fa-2x" id="addClick"></i>
                </div>
            </form>
                <br><br>
            </div>
            <div class="container" id="test">
            <?php 
            $sql = "SELECT `Name`,`Number`,`contact_id` FROM contacts WHERE `User_id` =".$_SESSION['id'].""; 
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
              echo '<table class="table table-bordered" id="contacts_table"><thead class="thead-dark"><tr><th style="width:7%" scope="col">id</th><th scope="col">Name</th><th scope="col">Number</th><th style="width:20%" scope="col">Actions</th></tr></thead>';
              // output data of each row
              while($row = $result->fetch_assoc()) {
                $id = str_replace(' ','_',$row["Name"]);
                echo "<tr id='".$row["contact_id"]."'><td>".$row["contact_id"]."</td><td class='name'>".$row["Name"]."</td><td> ".$row["Number"]."</td><td><form method='post'><i class='fas fa-user-times prefix red-text fa-2x' id='delete'></i> <a href='' data-toggle='modal' data-target='#modalSubscriptionForm'><i class='fas fa-user-edit prefix green-text fa-2x' id='update'></a></form></td></tr>";
              }
              echo "</table>";
            } else {
              echo "0 results";}
              CloseCon($conn);
            ?> 
            </div>
        </div>
            <script>        
                $('#contacts_table').click(function(e){
                    e.preventDefault();
                    var id = e.target.closest('tr').id;
                    var clicked = e.target.id;
                    console.log(clicked)
                    if(clicked == 'delete'){
                    $.ajax({
                        url:"delete.php",
                        method:"POST",
                        data:{
                            id:id,
                        },
                        }).done(function(data){
                            $('#results').html(`<div id ="alert"  class="alert alert-primary" role="alert">    ${data}!!</div>`);
                            if(data == "Record deleted successfully"){
                                $(`#${id}`).remove();
                                $(`#${id}`).remove(); 
                            }
                            else{
                                $('#results').html(`<div id ="alert"  class="alert alert-primary" role="alert"> ${data}!!</div>`)
                            }
                            
                        }) } 
                        else if(clicked == 'update'){
                            
                            var id = e.target.parentNode.parentNode.parentNode.parentNode;
                            var contact_id = $(id).find('td:first').text();
                            var contact = $(id).find('td:first').next().text();
                            var number = $(id).find('td:first').next().next().text();
                            console.log(id);

                            var output = `<div class="modal fade" id="modalSubscriptionForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                            aria-hidden="true"><form method = 'post'><div class="modal-dialog" role="document"><div class="modal-content" id='test'><div class="modal-header text-center"><h4 class="modal-title w-100 font-weight-bold">Update contact ${contact}</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body mx-3"><div class="md-form mb-5"><i class="fas fa-user prefix grey-text"></i><input type="text" id="contact" class="form-control " value="${contact}"></div><div class="md-form mb-4"><i class="fas fa-mobile-alt prefix grey-text"></i><input  type="text" id="number" class="form-control" value="${number}"></div><div><div class="md-form mb-4"><input  type="text" id="id" class="form-control" value="${contact_id}" readonly></div></div></div><div class="modal-footer d-flex justify-content-center"><button data-dismiss="modal" type='submit' class="btn btn-indigo" id='edit'>Edit<i class="fas fa-paper-plane-o ml-1"></i></button></div></div></div></div></form>
                            </div>`
                            
                            $('.updates').html(output);
                        } else if(clicked == 'upload'){
                            var id = e.target.parentNode.parentNode.parentNode.parentNode.id;
                            var fd = new FormData();
                            var files = $('#file')[0].files[0];
                            fd.append('file',files);
                            fd.append('id',id);

                            $.ajax({
                                url:'upload.php',
                                type:'post',
                                data:fd,id,
                                contentType: false,
                                processData: false,
                            }).done(function(data){
                                if(data != 0){
                                    console.log(data)
                                    // $('#img').attr('src',data);
                                    // $('.preview').show();

                                }else{
                                    alert('file not uploaded')
                                }
                            })
                        }
                        }) 
                // Add contact
                $('#addClick').click(function(event){
                    event.preventDefault();
                    number = $('#number').val();   
                    contact = $('#contact').val();
                    $.ajax({
                        url:"addContact.php",
                        method:'POST',
                        data:{
                            number:number,
                            contact:contact
                        }
                    }).done(function(data){
                        if(data == 'error'){
                            $('#results').html(`<div class="alert alert-danger" role="alert">
                                contact not created please make sure to check the name and number and try again;
                            </div>`);
                        }else{
                            var obj = JSON.parse(data);
                            $('#results').html(`<div id ="alert"  class="alert alert-primary" role="alert">contact ${obj.Name} was created!!</div>`);
                            $('#contacts_table').append(`
                            <tr id=${obj.contact_id}><td>${obj.contact_id}</td><td>${obj.Name}</td><td>${obj.Number}</td><td><form method='post'><i class='fas fa-user-times prefix red-text fa-2x' id='delete'></i> <a href='' data-toggle='modal' data-target='#modalSubscriptionForm'><i class='fas fa-user-edit prefix green-text fa-2x' id='update'></a></form></td></tr>
                            `)
                        };
                        
                    });
                    
                });
                //edit contact
                $(document).on('click','#edit',function(event){
                    event.preventDefault();
                    var number = $('#number').val();   
                    var contact = $('#contact').val();
                    var id = $('#id').val();
                    $.ajax({
                        url:"update.php",
                        method:"POST",
                        data:{
                            id:id,
                            number:number,
                            contact:contact
                        },
                        }).done(function(data){
                            if(data == 'error'){
                                $('#results').html(`<div class="alert alert-danger" role="alert">
                                    contact not created please make sure to check the name and number and try again;
                                </div>`)
                            }else{
                                $(`#${id}`).remove();
                                var obj = JSON.parse(data);
                                $('#results').html(`<div id ="alert"  class="alert alert-primary" role="alert">contact ${obj.Name} was created!!</div>`);
                                $('#results').html(`<div id ="alert"  class="alert alert-primary" role="alert">contact was updated!!</div>`);
                                $('#contacts_table').append(`
                                <tr id=${obj.contact_id}><td>${obj.contact_id}</td><td>${obj.Name}</td><td>${obj.Number}</td></td><td><form method='post'><i class='fas fa-user-times prefix red-text fa-2x' id='delete'></i> <a href='' data-toggle='modal' data-target='#modalSubscriptionForm'><i class='fas fa-user-edit prefix green-text fa-2x'></i></a></form></td></tr> 
                                `)
                                
                            }
                        });
                });                     
            </script>
            <form action="logout.php">
                <input type="submit">
            </form>
            
<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>
    
</body>
</html>