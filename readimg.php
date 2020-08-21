<?php 
    include 'db_connection.php';
    $conn = OpenCon();
    $sql = "SELECT * FROM `images` ORDER BY id desc limit 1";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $filename = $row['name'];
    $image = $row['img_dir'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <img src="upload/<?= $filename?>"">
    <br>
    <img src="<?=$image?>">
</body>
</html>