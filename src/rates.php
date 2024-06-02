<?php 
    session_start();

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../src/signin.php");
    exit;
    }
       if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $url_parts = explode('/', $_SERVER['REQUEST_URI']);
        $tmp = end($url_parts);
        $aid = intval($tmp);        
        $rate = $_POST["rating"];
        $user_id = $_SESSION["id"];
    
        include("../src/db.php"); 

      
            $query = "INSERT INTO rating (answer_id, rating, user_id) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, "iii", $aid,$rate, $user_id);
            
            if (mysqli_stmt_execute($stmt)) {
                echo "Rate posted successfully";
            } else {
                echo "Error posting rate: " . mysqli_error($con);
             
    }
    }
        header("Location: ../../public/home.php"); 
        mysqli_close($con);
        ?>
