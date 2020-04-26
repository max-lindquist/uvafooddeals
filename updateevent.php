<?php session_start(); ?>

<?php
    include('navbar2.html');
    $connection = require('uvafooddeals-connectdb.php');
?>

<?php

    if ($_SESSION['userID']== $_GET['userID']) {
        updateEvent();
    } else {
        echo "<div class='container'>Please log in or sign up first.</div>";
    }
 
    function updateEvent() {
        $done = false;
        global $db;

        $query = "SELECT * FROM event WHERE eventID = :eventID" ; // grab event we want to update

        $statement = $db->prepare($query);
        $statement->bindValue(':eventID', $_GET['eventID']);
        $statement->execute();

        $r = $statement->fetch();
        $statement->closeCursor();

        $query2 = "SELECT * FROM one_time_event WHERE eventID = :eventID"; // grab date of event we want to update
        $statement = $db->prepare($query2);
        $statement->bindValue(':eventID', $_GET['eventID']);
        $statement->execute();
        $e = $statement->fetch();
        $statement->closeCursor();

        $query3 = "SELECT * FROM sponsors JOIN host ON sponsors.hostID = host.hostID WHERE eventID = :eventID"; // grab host
        $statement = $db->prepare($query3);
        $statement->bindValue(':eventID', $_GET['eventID']);
        $statement->execute();
        $h = $statement->fetch();
        $statement->closeCursor();


        
    if ($_SERVER['REQUEST_METHOD'] == "POST")
        {
            $eventID = $_GET['eventID'];
            $event_name = $_POST['Name'];
            $startTime = $_POST['StartTime'];
            $endTime = $_POST['EndTime'];
            $location = $_POST['Location'];
            $exact_date = $_POST['Date'];
            $host = $_POST['Host'];
            
            if(!empty($event_name)){
                $event_name = $_POST['Name'];
                $eventID = $_GET['eventID'];
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
            if(!empty($host)){
                $query = "UPDATE host SET name = :name WHERE host.hostID = (SELECT hostID FROM sponsors WHERE eventID = :eventID)";
                $statement = $db->prepare($query);
                $statement->bindValue(':name', $host);
                $statement->bindValue(':eventID', $eventID);
                $statement->execute();
                $statement->closeCursor();
            }
            $done = true;
            $msg = "<div class='alert alert-success' style='text-align:center'> You have updated the event!</div>";
        }
        include('updateevent.html');
    }

?>
