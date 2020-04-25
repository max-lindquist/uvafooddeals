<?php 
    require("navbar.html");
    require("signup.html");

    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username_input = $_POST['username'];
        $password_input = $_POST['pwd'];
        $confirm_password = $_POST['confirmPwd'];

        if ($password_input == $confirm_password) {
            require('uvafooddeals-connectdb.php');

            $query = "INSERT INTO registered_user (name, password) VALUES (:name, :password)";
            $statement = $db->prepare($query);
            $statement->bindValue(':name', $username_input); // placeholder, value
            $statement->bindValue(':password', $password_input);
            $statement->execute();
            $statement->closeCursor();
    
            echo "<div class='container'>You have successfully signed up. Go to the login page to log in.</div>";
        } else {
            echo "<div class='container' style='color: red;'>Passwords do not match. Please try again.</div>";
        }
    }
?>