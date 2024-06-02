<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../src/signin.php");
    exit;
}

include("../src/db.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question_id = $_POST["question_id"];
    $answer = $_POST["answer"];
    $user_id = $_SESSION["id"];

  
    if (empty($answer)) {
        echo "Please fill in the answer field";
    } else {
        $query = "INSERT INTO answer (question_id, user_id, body) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "iis", $question_id, $user_id, $answer);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Answer posted successfully";
            header("Location: ../public/answer_form.php/$question_id"); 
        } else {
            echo "Error posting answer: " . mysqli_error($con);
        }
    
}
}

mysqli_close($con);
?>
