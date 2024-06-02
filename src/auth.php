<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("../src/db.php"); 
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $query = "SELECT * FROM user WHERE username = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_assoc($result);
        if ($password == $row['password']) {

            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['loggedin'] = true;
            header("Location: ../public/home.php");

        } else {
           
            echo "Incorrect password";
        }
    } else {
        
        echo "User not found";
    }
}
mysqli_close($con);

?>