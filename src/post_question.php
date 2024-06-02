<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    include("../src/db.php"); 
    $title = $_POST["title"];
    $description = $_POST["description"];
    $userid = $_SESSION['id'];

    $query = "INSERT INTO question (title, description,user_id) VALUES (?, ?,?)";

    $stmt = mysqli_prepare($con, $query);
    
    mysqli_stmt_bind_param($stmt, "ssi", $title, $description, $userid);
    
    mysqli_stmt_execute($stmt);

    
    header("Location: ../public/home.php"); 



}

mysqli_close($con);

?> 