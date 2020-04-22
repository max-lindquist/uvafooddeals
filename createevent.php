<<<<<<< HEAD
<?php session_start(); ?>

<?php
    include('navbar.html');
    include('createevent.html');
?>

<?php

    if ($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $connection = require('uvafooddeals-connectdb.php');
        $startTime = $_POST['StartTime'];
        $endTime = $_POST['EndTime'];
        $location = $_POST['Location'];
        $userID = 300000;
        $total_votes = 0;

        // creating an event
        // the eventID is auto incremented
        // right now, the userID is a static value (since we haven't implemented users yet)
        $query = "INSERT INTO event (startTime, endTime, location, userID, total_votes) VALUES (:startTime,:endTime,:location,:userID,:total_votes)";
        $statement = $db->prepare($query);
        $statement->bindValue(':startTime', $startTime);
        $statement->bindValue(':endTime', $endTime);
        $statement->bindValue(':location', $location);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':total_votes', $total_votes);
        $statement->execute();
        $statement->closeCursor();

        if ($_POST['Timing'] == "One-Time Event")
        {

            // Trying to get the eventID and to use it to insert into the one-time event table
            // Will do this for the recurring event as well

        }


    }
?>