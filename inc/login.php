<?php
session_start();
require_once 'db.php';
$email=$_POST['email'];
$password=$_POST['pass1'];
$sql="SELECT * FROM `users` WHERE `email` = '$email'";
$check=mysqli_query($con,$sql);
if(mysqli_num_rows($check)>0){
    $output=mysqli_fetch_assoc($check);
    $hashed_password=md5($password);
    if($hashed_password==$output['password']){
        $_SESSION['user_id']=$output['user_id'];
        header('Location: panel.php');
        exit;
    }else{
        echo "Invalid password";
    }
}else{
    echo "Invalid email";
}
?>
