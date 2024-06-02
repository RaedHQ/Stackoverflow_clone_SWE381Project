<?php 
session_start();

include("../src/db.php"); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StackOverflow-like Web Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        .container {
            width: 80%;
            margin: auto;
            padding-top: 20px;
        }
        .header {
            background-color: #333;
            color: #f2f2f2;
            padding: 10px 0;
            text-align: center;
        }
        .navigation {
            background-color: #444;
            color: #f2f2f2;
            padding: 10px;
            text-align: center;
        }
        .navigation a{
            color:#f2f2f2;
        }
        .question-section {
            margin-top: 20px;
        }
        .question-card {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .question-card h2 {
            margin-top: 0;
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
    .delete_btn{
        background: none;
        border: none;
        padding: 0;
        color: blue;
        cursor: pointer;
        font-size: 18px;
    }    
    </style>
</head>
<body>
    <script>
    function deleteRecord(id) {
        if(confirm("Are you sure you want to delete ?")){
            alert(`question: ${id} deleted`)
            window.location.replace(`/381Project/src/delquestion.php/${id}`)
        }
        else{
            
        }

    }
    </script>
    <div class="header">
        <h1>Welcome to StackOverflow-like Web Application</h1>
        <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            echo ' <h2>Welcome, ' . $_SESSION['username']."</h2>";
             } else {
            echo '<h2>User not logged in</h2>';
           }
         ?>
    </div>
    <div class="navigation">
        <a href="signup.php">Sign Up</a> |
        <a href="signin.php">Sign In</a> |
        <a href="signout.php">Sign Out</a>
    </div>
    <div class="container">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
            $search_query = mysqli_real_escape_string($con, $_POST['query']);
            $query = "SELECT id, title, description, created_at FROM Question WHERE title LIKE '%$search_query%' OR description LIKE '%$search_query%' OR id LIKE '%$search_query%' ORDER BY created_at DESC";
            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result) > 0) {
                echo "<h2>Result</h2>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "Question ID: " . $row["id"] . "<br>";
                    echo "Title: " . $row["title"] . "<br>";
                    echo "Description: " . $row["description"] . "<br>";
                    echo "Created At: " . $row["created_at"] . "<br>";
                    echo "<div> <a href=answer_form.php/$row[id]> Answer </a> </div>";
                    echo "<div> <a href=comment_question.php/$row[id]> Comment </a>";
                    echo "<hr>";
                }
            } else {
                echo "No matching questions found";
            }
            mysqli_free_result($result);
        }
        ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form-container">
    <input type="text" name="query" placeholder="Search questions...">
    <button type="submit" name="search">Search</button>
    </form>

        
        <h2>Recent Questions</h2>
        <div class="question-section">
            <div class="question-card">
            <?php
            $query = "SELECT id, title, description, created_at FROM Question ORDER BY created_at DESC LIMIT 10";

            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                 echo "Question ID: " . $row["id"] . "<br>";
                 echo "Title: " . $row["title"] . "<br>";
                 echo "Description: " . $row["description"] . "<br>";
                 echo "Created At: " . $row["created_at"] . "<br>";
                 echo "<div> <a href=answer_form.php/$row[id]> Answer </a> </div>";
                 echo "<div> <a href=comment_question.php/$row[id]> Comment </a>";


                 echo "<hr>";

                 echo "<hr>";
                  }
                } 
                else {
                    echo "No recent questions found";
                }

                mysqli_free_result($result);
                ?>

                
            </div>
        </div>
        <h2>Top Questions</h2>
        <div class="question-section">
            <div class="question-card">
                <?php
                $query = "SELECT q.id, q.title, q.description, COUNT(a.id) AS num_answers
                FROM Question q
                LEFT JOIN Answer a ON q.id = a.question_id
                GROUP BY q.id
                ORDER BY num_answers DESC
                LIMIT 10";

                $result = mysqli_query($con, $query);
      
                if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
              echo "Question ID: " . $row["id"] . "<br>";
              echo "Title: " . $row["title"] . "<br>";
              echo "Description: " . $row["description"] . "<br>";
              echo "Number of Answers: " . $row["num_answers"] . "<br>";
              echo "<div> <a href=answer_form.php/$row[id]> Answer </a> </div>";
              echo "<div> <a href=comment_question.php/$row[id]> Comment </a>";
              echo "<hr> <hr>";
            }
        } else {
            echo "No questions found";
        }
                ?>
            </div>
            <br>
        </div>
        <h2>My Questions</h2>
        <div class="question-section">
            <?php
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            
                $records_per_page = 10; 
            
                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
            
                $offset = ($page - 1) * $records_per_page;
            
                $query = "SELECT * FROM question WHERE user_id = ? LIMIT ?, ?";
                $stmt = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt, "iii", $_SESSION['id'], $offset, $records_per_page);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
            
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "Question ID: " . $row["id"] . "<br>";
                        echo "Title: " . $row["title"] . "<br>";
                        echo "Description: " . $row["description"] . "<br>";
                        echo "Created At: " . $row["created_at"] . "<br>";
                        echo "<div> <a href=answer_form.php/$row[id]> Answer </a> </div>";
                        echo"<div> <button onclick='deleteRecord($row[id])' class='delete_btn'>delete</button></div>";
                        echo"<div> <a href=../src/editquestion.php/$row[id]> Edit </a>";
                        echo"<div> <a href=comment_question.php/$row[id]> Comment </a>";


                        echo "<hr> <hr>";
                        
                    }
            
                    $query_count = "SELECT COUNT(*) AS total FROM question WHERE user_id = ?";
                    $stmt_count = mysqli_prepare($con, $query_count);
                    mysqli_stmt_bind_param($stmt_count, "i", $_SESSION['id']);
                    mysqli_stmt_execute($stmt_count);
                    $result_count = mysqli_stmt_get_result($stmt_count);
                    $row_count = mysqli_fetch_assoc($result_count);
                    $total_pages = ceil($row_count["total"] / $records_per_page);
            
                    echo "<div>";
                    echo "<ul class='pagination'>";
                    for ($i = 1; $i <= $total_pages; $i++) {
                        echo "<li><a href='?page=" . $i . "'>" . $i . "</a></li>";
                    }
                    echo "</ul>";
                    echo "</div>";
                } else {
                    echo "No questions found";
                }
            } else {
                echo "User not logged in";
            }


            
            
            ?>
            <div class="question-card">
                <h2>My answers</h2>
                <?php
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                    include("../src/db.php"); 
                
                    $records_per_page = 10; 
                
                    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
                
                    $offset = ($page - 1) * $records_per_page;
                
                    $query = "SELECT * FROM answer WHERE user_id = ? LIMIT ?, ?";
                    $stmt = mysqli_prepare($con, $query);
                    mysqli_stmt_bind_param($stmt, "iii", $_SESSION['id'], $offset, $records_per_page);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "Answer ID: " . $row["id"] . "<br>";
                            echo "Question ID: " . $row["question_id"] . "<br>";
                            echo "Body: " . $row["body"] . "<br>";
                            echo"<div> <a href=../src/delanswer.php/$row[id]> Delete </a>";
                            echo"<div> <a href=../src/editanswer.php/$row[id]> Edit </a>";
                            echo"<div> <a href=comment_answer.php/$row[id]> Comment </a>";
    
    
                            echo "<hr>";
                            
                        }
                
                        $query_count = "SELECT COUNT(*) AS total FROM question WHERE user_id = ?";
                        $stmt_count = mysqli_prepare($con, $query_count);
                        mysqli_stmt_bind_param($stmt_count, "i", $_SESSION['id']);
                        mysqli_stmt_execute($stmt_count);
                        $result_count = mysqli_stmt_get_result($stmt_count);
                        $row_count = mysqli_fetch_assoc($result_count);
                        $total_pages = ceil($row_count["total"] / $records_per_page);
                
                        echo "<div>";
                        echo "<ul class='pagination'>";
                        for ($i = 1; $i <= $total_pages; $i++) {
                            echo "<li><a href='?page=" . $i . "'>" . $i . "</a></li>";
                        }
                        echo "</ul>";
                        echo "</div>";
                    } else {
                        echo "No questions found";
                    }
                } else {
                    echo "User not logged in";
                }                 
                
                ?>
                
            </div>
        </div>
    </div>
    
    
    <h2>Search in my questions</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form-container">
    <input type="text" name="question_query" placeholder="Search my questions...">
    <button type="submit" name="search_question">Search</button><br><br><hr>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_question'])) {
        $question_query = mysqli_real_escape_string($con, $_POST['question_query']);
        $query = "SELECT id, title, description, created_at FROM Question WHERE user_id = ? AND (title LIKE '%$question_query%' OR description LIKE '%$question_query%') ORDER BY created_at DESC";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "i", $_SESSION['id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "Question ID: " . $row["id"] . "<br>";
                echo "Title: " . $row["title"] . "<br>";
                echo "Description: " . $row["description"] . "<br>";
                echo "Created At: " . $row["created_at"] . "<br>";
                echo "<div> <a href=answer_form.php/$row[id]> Answer </a> </div>";
                echo"<div> <button onclick='deleteRecord($row[id])' class='delete_btn'>delete</button></div>";
                echo"<div> <a href=../src/editquestion.php/$row[id]> Edit </a>";
                echo"<div> <a href=comment_question.php/$row[id]> Comment </a>";


                echo "<hr>";
                
            }
        }
    }
    ?>
    
    <h2>Search in my answers</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form-container">
    <input type="text" name="answer_query" placeholder="Search my answers...">
    <button type="submit" name="search_answer">Search</button><br><br><hr>
    </form>
   

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_answer'])) {
        $answer_query = mysqli_real_escape_string($con, $_POST['answer_query']);
        $query = "SELECT a.id, a.question_id, a.body, a.created_at FROM Answer a INNER JOIN Question q ON a.question_id = q.id WHERE a.user_id = ? AND a.body LIKE '%$answer_query%' ORDER BY a.created_at DESC";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "i", $_SESSION['id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "Answer ID: " . $row["id"] . "<br>";
                echo "Question ID: " . $row["question_id"] . "<br>";
                echo "Body: " . $row["body"] . "<br>";
                echo"<div> <a href=../src/delanswer.php/$row[id]> Delete </a>";
                echo"<div> <a href=../src/editanswer.php/$row[id]> Edit </a>";
                echo"<div> <a href=comment_answer.php/$row[id]> Comment </a>";


                echo "<hr>";
                
            }
   
    }
}
    ?>

    <?php 
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true)
    echo ' <h2>Post Question</h2><form action="../src/post_question.php" method="post" class="form-container">
    <label for="title">Title:</label><br>
    <input type="text" id="title" name="title" required><br><br>
    <label for="description">Description:</label><br>
    <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>
    <button type="submit">Post Question</button>
    </form>';
    

    mysqli_close($con);
    ?>
    
</body>
</html>
