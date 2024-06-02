<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("../src/db.php"); 
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $query = "INSERT INTO user (username, password) VALUES (?, ?)";

    $stmt = mysqli_prepare($con, $query);
    
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    
    mysqli_stmt_execute($stmt);

    header("Location: ../public/home.php");
    
}


mysqli_close($con);

?>


