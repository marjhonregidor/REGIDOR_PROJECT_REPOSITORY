<?php 
include('connection.php');
$item = $_POST['item'];
$description = $_POST['description'];
$price = $_POST['price'];
$address = $_POST['address'];
$id = $_POST['id'];

$sql = "UPDATE `items` SET  `item`='$item' , `description`= '$description', `price`='$price',  `address`='$address' WHERE id='$id' ";
$query= mysqli_query($con,$sql);
$lastId = mysqli_insert_id($con);
if($query ==true)
{
   
    $data = array(
        'status'=>'true',
       
    );

    echo json_encode($data);
}
else
{
     $data = array(
        'status'=>'false',
      
    );

    echo json_encode($data);
} 

?>