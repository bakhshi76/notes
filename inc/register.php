<?php

require_once 'db.php';
$name = htmlspecialchars(trim($_POST['name']),ENT_QUOTES);
$email = $_POST['email'];
$pass1 = $_POST['pass1'];
$pass2 = $_POST['pass2'];
if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    $error='Invalid email address.';
    require_once 'index.php';
    exit;
}
if(empty($email)){
    $error = 'Please enter your email address.';
    require 'index.php';
    exit;
}
if(empty($pass1) || empty($pass2)){
    $error='Please enter and confirm your password.';
    require_once 'index.php';
    exit;
}
if ($pass1 != $pass2) {
    $error = 'Passwords do not match.';
    require_once 'index.php';
    exit;
}
if(strlen($pass1)<=4){
    $error='Password must be at least 4 characters.';
    require_once 'index.php';
    exit;
}
$check = mysqli_query($con, "SELECT * FROM `users` WHERE `email` = '$email'");
if ($check) {
    if (mysqli_num_rows($check) > 0) {
        $error = 'Email is already registered.';
        require_once 'index.php';
        exit;
    }
}
$password=md5($pass2);

$insert= mysqli_query($con,"INSERT INTO `users`(`name`,`email`,`password`) VALUES ('$name' , '$email' ,'$password')");
if($insert){
    $success = 'Registration successful. You can now log in.';
    require_once 'login.php';
    exit;
}
else{
    $error = 'Registration failed. Please try again later.';
    require_once 'index.php';
    exit;
}
