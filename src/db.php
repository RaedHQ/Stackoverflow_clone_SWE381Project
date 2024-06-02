<?php

$host = '127.0.0.1';
$db = 'stackoverflow_database';
$user = 'root';
$pass = '0000';

try{
$con = mysqli_connect("$host","$user",$pass,"$db");
}catch(Exception $e){
    echo "oo    ".$e->getMessage();
}

if (mysqli_connect_errno()) {
    die("Failed:". mysqli_connect_error());
}


?>