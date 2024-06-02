<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../src/signin.php");
    exit;
}

include("../src/db.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $aid = $_POST["aid"];
    $comment = $_POST["comment"];
    $user_id = $_SESSION["id"];
    var_dump($aid);  

  
    if (empty($comment)) {
        echo "Please fill in the answer field";
    } else {

        $query = "INSERT INTO answer_comment (a_id, user_id, body) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "iis", $aid, $user_id, $comment);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Comment posted successfully";
            header("Location: ../public/comment_answer.php/$aid"); 
        } else {
            echo "Error posting comment: " . mysqli_error($con);
        }
    
}
}

mysqli_close($con);
?>
