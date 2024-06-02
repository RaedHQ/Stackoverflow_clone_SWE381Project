<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>asdad</title>
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
include("../src/db.php"); 
$url_parts = explode('/', $_SERVER['REQUEST_URI']);
     $tmp = end($url_parts);
     $answer_id = intval($tmp);
     echo'answer id:'. $answer_id;

     $query = "SELECT * FROM answer WHERE id = ?";
     $stmt = mysqli_prepare($con, $query);
     mysqli_stmt_bind_param($stmt, "i", $answer_id);
     mysqli_stmt_execute($stmt);
     $result = mysqli_stmt_get_result($stmt);
     $row = $result->fetch_assoc();

    ?>
     <form action="../post_edited_a.php" method="post" class="form-container">
        <label for="body">Body:</label><br>
        <textarea id="body" name="body" rows="4" cols="50" required><?php echo $row['body'];?></textarea><br><br>
        <input type="hidden" name="aid" value=<?php echo"$answer_id" ?>>
        <button type="submit">Edit Answer</button>
    </form>
    
    <?php
    mysqli_close($con);
    ?>
</body>
</html>