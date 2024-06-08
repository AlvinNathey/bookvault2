<?php 
require_once("connection.php");
if(isset ($_GET["user_id"])){
    $user_id = $_GET["user_id"];

    require_once("connection.php");

    $sql = "DELETE  FROM users WHERE user_id ='$user_id' ";

    $result= mysqli_query($conn, $sql);

}

header('location: viewusers.php');
exit;
?>