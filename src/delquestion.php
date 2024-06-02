<?php 
        $url_parts = explode('/', $_SERVER['REQUEST_URI']);
        $tmp = end($url_parts);
        $qid = intval($tmp);
        
        include("../src/db.php"); 

        $query = "Delete From question where id = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "i", $qid);
        $stmt->execute();
        header("Location: ../../public/home.php"); 

        mysqli_close($con);

        ?>
