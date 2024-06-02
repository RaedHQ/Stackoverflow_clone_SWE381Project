<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../src/signin.php");
    exit;
}

include("../src/db.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cid = $_POST["cid"];
    $comment = $_POST["comment"];
    $user_id = $_SESSION["id"];
    var_dump($cid);  

  
    if (empty($comment)) {
        echo "Please fill in the answer field";
    } else {
        $query = "INSERT INTO Question_Comment (q_id, user_id, body) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "iis", $cid, $user_id, $comment);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Comment posted successfully";
            header("Location: ../public/comment_question.php/$cid"); 
        } else {
            echo "Error posting comment: " . mysqli_error($con);
        }
    
}
}

mysqli_close($con);
?>
