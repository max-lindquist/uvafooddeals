<?php 
    session_start();

    require("navbar.html");
    $msg = "";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username_input = $_POST['username'];
        $password_input = $_POST['pwd'];
        $confirm_password = $_POST['confirmPwd'];

        if ($password_input == $confirm_password) {
            require('uvafooddeals-connectdb.php');
            $password = hash('sha256', $_POST['pwd']);

            $query = "INSERT INTO registered_user (name, password) VALUES (:name, :password)";
            $statement = $db->prepare($query);
            $statement->bindValue(':name', $username_input); // placeholder, value
            $statement->bindValue(':password', $password);
            $statement->execute();
            $statement->closeCursor();
    
            $msg = "<div class='alert alert-success' style='text-align:center'>You have successfully signed up. Go to the login page to log in.</div>";
        } else {
            $msg = "<div class='alert alert-danger' style='text-align:center'>Passwords do not match. Please try again.</div>";
        }
    }
    require("signup.html");
?>
