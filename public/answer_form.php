<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Answer</title>
</head>
<body>
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        .form-container {
         max-width: 500px;
        padding: 20px;
        background-color: #f5f5f5;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

    .form-container label {
         display: block;
         margin-bottom: 10px;
         font-weight: bold;
        }

    .form-container input[type="text"],
    .form-container textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 3px;
        font-size: 16px;
        margin-bottom: 20px;
        }

    .form-container textarea {
        height: 120px;
    }

    .form-container button[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        font-size: 16px;
    }

    .form-container button[type="submit"]:hover {
        background-color: #45a049;
    }
    a{
        text-decoration: none;
        font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
        font-size: 18px;
        }

    </style>
    <?php 
        session_start();
 
        $url_parts = explode('/', $_SERVER['REQUEST_URI']);
        $tmp = end($url_parts);
        $question_id = intval($tmp);
        ?>
    <h2>Answers</h2>
    <?php
include("../src/db.php"); 
 
    $query = "SELECT * FROM answer WHERE question_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $question_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "Answer ID: " . $row["id"] . "<br>";
            echo "Answer: " . $row["body"] . "<br>";
            echo"<div> <a href=../comment_answer.php/$row[id]> Comment </a>";
            echo"<br>";
            $rate_query = "select * from rating where answer_id = ?";
            $rate_stmt = mysqli_prepare($con, $rate_query);
            $answer_id = $row['id'];
            mysqli_stmt_bind_param($rate_stmt, "i", $answer_id);
            mysqli_stmt_execute($rate_stmt);
            $rate_result = mysqli_stmt_get_result($rate_stmt);
            $user_rated = false;
            while ($rate_row = mysqli_fetch_assoc($rate_result)){
                if(isset($_SESSION['loggedin']) && $rate_row["user_id"] == $_SESSION["id"] )
                    $user_rated = true;            
        } 
        if(!$user_rated && isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === True){
            echo"<form action='../../src/rates.php/$row[id]' method='post'> class='form-container' ";
            echo "Rate the answer:";
            echo"<label><input type='radio' name='rating' value='1'>1 Star</label>
            <label><input type='radio' name='rating' value='2'>2 Star</label> 
            <label><input type='radio' name='rating' value='3'>3 Star</label> 
            <label><input type='radio' name='rating' value='4'>4 Star</label> 
            <label><input type='radio' name='rating' value='5'>5 Star</label> 
            <button type='submit'>Rate</button>
            <hr> ";
            echo"</form>";
        }
        else if($user_rated){
            echo "<br>You already rated this answer: <br>";
        }
        $states_query = "SELECT COUNT(*) AS num_ratings, AVG(rating) AS avg_rating FROM Rating WHERE answer_id = ?";
        $states_stmt = mysqli_prepare($con, $states_query);
        mysqli_stmt_bind_param($states_stmt, "i", $answer_id);
        mysqli_stmt_execute($states_stmt);
        mysqli_stmt_bind_result($states_stmt, $num_ratings, $avg_rating);
        mysqli_stmt_fetch($states_stmt);
        echo "Number of ratings: " . $num_ratings . "<br>";
        echo "Average rating: " . $avg_rating . "<br>";
        mysqli_stmt_close($states_stmt);
        echo"<br><hr><br>";
        }

    } else {
        echo "No answers found for question ID: " . $question_id;
    }
    
    

   
   
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === True)       
        echo ' <h2>Post Answer</h2>
        <form action="../../src/post_answer.php" method="post" id="postanswer" class="form-container">
        <label for="answer">Your Answer: for question number: '.$question_id.' </label><br>
        <input type="hidden" name="question_id" value= '.$question_id.' >
        <textarea id="answer" name="answer" rows="4" cols="50" required></textarea><br><br>
        <button type="submit" form="postanswer">Post Answer</button>
        </form>';
        
        
        mysqli_close($con);

        ?>
   

</body>
</html>
