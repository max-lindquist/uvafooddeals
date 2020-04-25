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
        $exact_date = $_POST['Date'];
        $event_name = $_POST['Name'];
        $userID = 300000;
        $total_votes = 0;

        // creating an event
        // the eventID is auto incremented
        // right now, the userID is a static value (since we haven't implemented users yet)
        $query = "INSERT INTO event (startTime, endTime, location, userID, total_votes, event_name) VALUES (:startTime,:endTime,:location,:userID,:total_votes,:event_name)";
        $statement = $db->prepare($query);
        $statement->bindValue(':startTime', $startTime);
        $statement->bindValue(':endTime', $endTime);
        $statement->bindValue(':location', $location);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':total_votes', $total_votes);
        $statement->bindValue(':event_name', $event_name);
        $statement->execute();
        $statement->closeCursor();

        if ($_POST['Timing'] == "One-Time Event")
        {

            // Trying to get the eventID and to use it to insert into the one-time event table
            // Will do this for the recurring event as well

            $query = "SELECT MAX(eventID) as maximum FROM event";
            $result = $db->query($query);
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $eventID = $row['maximum']; // This gives us the unique eventID for whatever was just posted
            $result->closeCursor();

            // Inserting into the one_time_event table

            $query = "INSERT INTO one_time_event(eventID,exact_date) VALUES (:eventID,:exact_date)";
            $statement = $db->prepare($query);
            $statement->bindValue(':eventID', $eventID);
            $statement->bindValue(':exact_date', $exact_date);
            $statement->execute();
            $statement->closeCursor();

        }
        else // This is if the event is recurring (one-time and recurring are the only 2 options)
        {
            // Getting the eventID of the event that was just posted

            $query = "SELECT MAX(eventID) as maximum FROM event";
            $result = $db->query($query);
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $eventID = $row['maximum']; // This gives us the unique eventID for whatever was just posted
            $result->closeCursor();

            //Inserting into the recurring_event_days_occurring table (using dummy data right now!!!)
            $day = "Monday";

            $query = "INSERT INTO recurring_event_days_occurring(eventID,day) VALUES (:eventID,:day)";
            $statement = $db->prepare($query);
            $statement->bindValue(':eventID', $eventID);
            $statement->bindValue(':day', $day);
            $statement->execute();
            $statement->closeCursor();


            // Inserting into the recurring_event table
            $timing = "weekly";
            $query = "INSERT INTO recurring_event(eventID,timing) VALUES (:eventID,:timing)";
            $statement = $db->prepare($query);
            $statement->bindValue(':eventID', $eventID);
            $statement->bindValue(':timing', $timing);
            $statement->execute();
            $statement->closeCursor();
        }
    }


?>
