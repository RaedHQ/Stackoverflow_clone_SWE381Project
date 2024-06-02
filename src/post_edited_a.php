<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("../src/db.php"); 
    $body = $_POST["body"];
    $aid = $_POST["aid"];

    $query = "UPDATE answer SET body = ? WHERE id = ? ";

    $stmt = mysqli_prepare($con, $query);
    
    mysqli_stmt_bind_param($stmt, "si", $body, $aid);
    
    mysqli_stmt_execute($stmt);

    header("Location: ../public/home.php"); 




}

mysqli_close($con);

?> 