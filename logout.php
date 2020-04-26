<?php 
    require("navbar2.html");
    require("logout.html");

    session_start();

    if (isset($_SESSION['userID'])) {
        session_destroy();
        echo "<div class='alert alert-success' style='text-align:center'>You have successfully logged out.</div>";
    } else {
        echo "<div class='alert alert-danger' style='text-align:center'>You are not logged in.</div>";
    }
?>
