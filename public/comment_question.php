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
        $cid = intval($tmp);
        ?>
        <?php 
        $url_parts = explode('/', $_SERVER['REQUEST_URI']);
        $tmp = end($url_parts);
        $cid = intval($tmp);
        ?>
    <h2>Comments</h2>
    <?php
include("../src/db.php"); 
 
    $query = "SELECT * FROM Question_comment WHERE q_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $cid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "Comment ID: " . $row["id"] . "<br>";
            echo "Comment: " . $row["body"] . "<br>";
            echo "<hr>";
        }
    } else {
        echo "No Comment found for question ID: " . $cid;
    }
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === True)     
        echo' <h2>Post Comment</h2>
        <form action="../../src/post_question_comment.php" method="post" class="form-container"> 
        <label for="answer">Your Comment: for question number<?php echo" $cid";  ?></label><br>
        <input type="hidden" name="cid" value='."$cid".'>
        <textarea id="comment" name="comment" rows="4" cols="50" required></textarea><br><br>
        <button type="submit">Post Comment</button>
        </form>';  
    ?>

   
</body>
</html>
