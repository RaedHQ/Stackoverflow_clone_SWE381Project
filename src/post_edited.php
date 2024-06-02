<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("../src/db.php"); 
    $title = $_POST["title"];
    $description = $_POST["description"];
    $qid = $_POST["qid"];

    $query = "UPDATE question SET title = ? , description = ? WHERE id = ? ";

    $stmt = mysqli_prepare($con, $query);
    
    mysqli_stmt_bind_param($stmt, "ssi", $title, $description, $qid);
    
    mysqli_stmt_execute($stmt);

    header("Location: ../public/home.php"); 




}

mysqli_close($con);

?> 