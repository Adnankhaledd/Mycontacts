<?php
    $id = $_POST['id'];
    $filename = $_FILES['file']['name'];
    $location = 'upload/'.$filename;
    $uploadOk = 1;
    $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
    $image_base64 = base64_encode(file_get_contents($_FILES['file']['tmp_name']));
    $image = "data:image/".$imageFileType.";base64,".$image_base64;
    $valid_extensions = array('jpg','jpeg','png');
    if(!in_array(strtolower($imageFileType),$valid_extensions)){
        $uploadOk = 0;
    }
    if($uploadOk == 0){
        echo 0;
    }else{
        if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
            $query = "INSERT INTO images (contact_id,name,img_dir) values('$id','$filename','$image')";
            mysqli_query($conn,$query);
            echo  $id;
        }else{
            echo 0;
        }
    }


?>