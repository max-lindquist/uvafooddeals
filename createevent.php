<?php session_start(); ?>

<?php
    include('navbar.html');
?>

<?php

    if (isset($_SESSION['userID'])) {
        createEvent();
    } else {
        echo "<div class='container'>Please log in or sign up first.</div>";
    }
 
    function createEvent() {
        include('createevent.html');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $startTime = $_POST['StartTime'];
            $endTime = $_POST['EndTime'];
            if ($endTime < $startTime) {
                echo "<div class='container' style='color:red;'>Error: start time and end time are inconsistent. Please use 24-hour time.</div>";
            } else {
                $connection = require('uvafooddeals-connectdb.php');
                $startTime = $_POST['StartTime'];
                $endTime = $_POST['EndTime'];
                $location = $_POST['Location'];
                $exact_date = $_POST['Date'];
                $event_name = $_POST['Name'];
                $userID = $_SESSION['userID'];
                $timing = $_POST['Timing'];
                $hostName = $_POST['hostName'];
                $email = $_POST['email'];
                if (isset($_POST['days'])) {
                    $days = $_POST['days'];
                }
                $total_votes = 0;
        
                // creating an event
                // the eventID is auto incremented
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
        
                if ($timing == "One-Time Event")
                {
                    // Trying to get the eventID and to use it to insert into the one-time event table
                    // Will do this for the recurring event as well
        
                    $query = "SELECT MAX(eventID) as maximum FROM event";
                    $result = $db->query($query);
                    $row = $result->fetch(PDO::FETCH_ASSOC);
                    $eventID = $row['maximum']; // This gives us the unique eventID for whatever was just posted
                    $result->closeCursor();
        
                    // Inserting into the one_time_event table
        
                    $query = "INSERT INTO one_time_event(eventID, exact_date) VALUES (:eventID, :exact_date)";
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
        
                    //Inserting into the recurring_event_days_occurring table 
                    foreach ($days as $day) {
                        $query = "INSERT INTO recurring_event_days_occurring(eventID,day) VALUES (:eventID,:day)";
                        $statement = $db->prepare($query);
                        $statement->bindValue(':eventID', $eventID);
                        $statement->bindValue(':day', $day);
                        $statement->execute();
                        $statement->closeCursor();
                    }
                    
                    // Inserting into the recurring_event table
                    $timing = $_POST['Timing'];
                    $query = "INSERT INTO recurring_event(eventID,timing) VALUES (:eventID,:timing)";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':eventID', $eventID);
                    $statement->bindValue(':timing', $timing);
                    $statement->execute();
                    $statement->closeCursor();
                }

                
                // Creating a new Host
                $query = "INSERT INTO host(name, email) VALUES (:hostName, :email)";
                $statement = $db->prepare($query);
                $statement->bindValue(':hostName', $hostName);
                $statement->bindValue(':email', $email);
                $statement->execute();
                $statement->closeCursor();
                    
                // Getting the hostID of the host that was just created
                $query = "SELECT MAX(hostID) as maximum FROM host";
                $result = $db->query($query);
                $row = $result->fetch(PDO::FETCH_ASSOC);
                $hostID = $row['maximum']; 
                $result->closeCursor();

                // Getting the eventID of the event that was just posted
                $query = "SELECT MAX(eventID) as maximum FROM event";
                $result = $db->query($query);
                $row = $result->fetch(PDO::FETCH_ASSOC);
                $eventID = $row['maximum']; // This gives us the unique eventID for whatever was just posted
                $result->closeCursor();

                // Filling Sponsors table
                $query = "INSERT INTO sponsors(eventID, hostID) VALUES (:eventID, :hostID)";
                $statement = $db->prepare($query);
                $statement->bindValue(':eventID', $eventID);
                $statement->bindValue(':hostID', $hostID);
                $statement->execute();
                $statement->closeCursor();


                if($_POST['Host']=="restaurant"){ // If the event is hosted by a restaurant

                    $address_number = $_POST['address_number'];
                    $address_street = $_POST['address_street'];
                    $address_city = $_POST['address_city'];
                    $address_state = $_POST['address_state'];
                    $address_zipcode = $_POST['address_zipcode'];

                    // Creating the restaurant
                    $query = "INSERT INTO restaurant(hostID, address_number, address_street, address_zipcode) VALUES (:hostID, :address_number, :address_street, :address_zipcode)";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':hostID', $hostID);
                    $statement->bindValue(':address_number', $address_number);
                    $statement->bindValue(':address_street', $address_street);
                    $statement->bindValue(':address_zipcode', $address_zipcode);
                    $statement->execute();
                    $statement->closeCursor();

                    // Creating the restaurant_city table
                    $query = "INSERT INTO restaurant_city(address_zipcode, address_city, address_state) VALUES (:address_zipcode, :address_city, :address_state)";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':address_city', $address_city);
                    $statement->bindValue(':address_state', $address_state);
                    $statement->bindValue(':address_zipcode', $address_zipcode);
                    $statement->execute();
                    $statement->closeCursor();

                }
                else { // If the event is hosted by an organization (restaurant and organization are the only 2 options)

                    $description = $_POST['description'];

                    // Creating the organization
                    $query = "INSERT INTO organization(hostID, description) VALUES (:hostID, :description)";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':hostID', $hostID);
                    $statement->bindValue(':description', $description);
                    $statement->execute();
                    $statement->closeCursor();
                }
            }
        }
    }


?>
