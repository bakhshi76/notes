<?php
$con = mysqli_connect('localhost','root','','bakhshi');
if(!$con){
    echo "Error: Unable to connect to the database. Please check your configuration. (" . mysqli_connect_error() . ")";
    exit;
}
?>