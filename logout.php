<?php 
    require("navbar.html");
    require("logout.html");

    session_start();

    if (isset($_SESSION['userID'])) {
        session_destroy();
        echo "<div class='container'>You have successfully logged out.</div>";
    } else {
        echo "<div class='container'>You are not logged in.</div>";
    }
?>