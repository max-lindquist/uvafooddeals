<?php session_start(); ?>

<?php
    include('navbar.html');
?>

<?php

    if ($_SESSION['userID']== $_GET['userID']) {
        updateEvent();
    } else {
        echo "<div class='container'>Please log in or sign up first.</div>";
    }
 
    function updateEvent() {
        include('updateevent.html');
        



        if ($_SERVER['REQUEST_METHOD'] == "POST")
        {
            $connection = require('uvafooddeals-connectdb.php');
            $eventID = $_GET['eventID'];
            $event_name = $_POST['Name'];
            $startTime = $_POST['StartTime'];
            $endTime = $_POST['EndTime'];
            $location = $_POST['Location'];
            $exact_date = $_POST['Date'];
            
            if(!empty($event_name)){
                $query = "UPDATE event SET event_name = :event_name WHERE eventID = :eventID";
                $statement = $db->prepare($query);
                $statement->bindValue(':event_name', $event_name);
                $statement->bindValue(':eventID', $eventID);
                $statement->execute();
                $statement->closeCursor();
            }
            if(!empty($startTime)){
                $query = "UPDATE event SET startTime = :startTime WHERE eventID = :eventID";
                $statement = $db->prepare($query);
                $statement->bindValue(':startTime', $startTime);
                $statement->bindValue(':eventID', $eventID);
                $statement->execute();
                $statement->closeCursor();
            }
            if(!empty($endTime)){
                $query = "UPDATE event SET endTime = :endTime WHERE eventID = :eventID";
                $statement = $db->prepare($query);
                $statement->bindValue(':endTime', $endTime);
                $statement->bindValue(':eventID', $eventID);
                $statement->execute();
                $statement->closeCursor();
            }
            if(!empty($location)){
                $query = "UPDATE event SET location = :location WHERE eventID = :eventID";
                $statement = $db->prepare($query);
                $statement->bindValue(':location', $location);
                $statement->bindValue(':eventID', $eventID);
                $statement->execute();
                $statement->closeCursor();
            }
            if($_GET['isOneTime'] && !empty($exact_date)){
                $query = "UPDATE one_time_event SET exact_date = :exact_date WHERE eventID = :eventID";
                $statement = $db->prepare($query);
                $statement->bindValue(':exact_date', $exact_date);
                $statement->bindValue(':eventID', $eventID);
                $statement->execute();
                $statement->closeCursor();
            }
        }
    }


?>
