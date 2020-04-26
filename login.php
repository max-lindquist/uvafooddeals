<?php 
    // Author: Alyse Armentrout, Vivian Pham, Max Lindquist, Emily Lin
    require("navbar.html");

    require("uvafooddeals-connectdb.php");

    session_start();
    $msg = "";
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
                $msg = "<div class='alert alert-success' style='text-align:center'>You have successfully logged in.</div>";
            }
        }
    
        if ($loggedin == false) {
            $msg = "<div class='alert alert-danger' style='text-align:center'>Incorrect username or password.</div>";
        }
    }
require("login.html");
    
?>
