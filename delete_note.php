<?php
session_start();
require_once 'inc/db.php';
if(!isset($_SESSION['user_id'])){
    header("Location:login.php");
    exit;
}
if(isset($_GET['id'])){
    $note_id=$_GET['id'];
    $user_id=$_SESSION['user_id'];
    //فقط نوتایی که مال همون کابره رو میخوایم پاک کنیم
    $sql="DELETE FROM `notes` WHERE `note_id`='$note_id' AND `user_id`='$user_id'";
    mysqli_query($con,$sql);
}
header("Location:panel.php");
exit;
?>