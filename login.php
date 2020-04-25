<?php 
    // Author: Alyse Armentrout, Vivian Pham, Max Lindquist, Emily Lin
    require("navbar.html");
    require("login.html");
    require("uvafooddeals-connectdb.php");

    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username_input = $_POST['username'];
        $password_input = $_POST['pwd'];
    
        $query = "SELECT * FROM registered_user";
        $statement = $db->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll();  
        $statement->closeCursor();
    
        $loggedin = false;
        foreach($results as $result)
        {
            if (($result['name'] == $username_input) && ($result['password'] == $password_input)) {
                $_SESSION['userID'] = $result['userID'];
                $loggedin = true;
                echo "<div class='container'>You have successfully logged in.</div>";
            }
        }
    
        if ($loggedin == false) {
            echo "<div class='container'>Incorrect username or password.</div>";
        }
    }
    
?>