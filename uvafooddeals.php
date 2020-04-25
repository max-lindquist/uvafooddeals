<?php
    include('navbar.html');
    include("uvafooddeals.html");
    ob_start();
?>

<?php
    require('uvafooddeals-connectdb.php');
    $query = "SELECT * FROM event";
    $result = $db->query($query);
    $num_rows = $result->rowCount();

    if ($num_rows == 0)
        {
            echo "<center><h4>You have no events! Add an event by clicking the button above.</h4></center>";
        }

    else {
    // output data of each row
    $count = 0;
    echo "<br>";
    while($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            $eventID = $row{"eventID"};
            $location = $row["location"];
            $startTime = $row["startTime"];
            $endTime = $row["endTime"];
            $userID = $row["userID"];
            $total_votes = $row["total_votes"];
            $event_name = $row["event_name"];
            // echo "<center>$eventID, $location, $startTime, $endTime, $userID, $total_votes</center>";

            /**** ADD EVENTS TO THE PAGE *****/
            echo "<div class='container'>";
            echo "<div class='card'>
                    <div class='card-body'>
                        <p>Event Name: " . $event_name . "</p>
                        <p>Location: " . $location . "</p>
                        <p>Start time: " . $startTime . "</p>
                        <p>End time: " . $endTime . "</p>
                        <p>Votes: " . $total_votes . "</p>
                        <form action='uvafooddeals.php' method='post'>
                            <button class='btn btn-primary' type='submit' name='" . $eventID . "upvote'>Upvote</button>
                            <button class='btn btn-danger' type='submit' name='" . $eventID . "downvote'>Downvote</button>
                            <input type='hidden' id='eventID' name='eventID' value=$eventID>
                            <input type='hidden' id='userID' name='userID' value=$userID>
                        </form>
                    </div>
                  </div>
            ";
            echo "</div>";

            // if upvote button clicked, call upvote function
            if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST[$eventID . 'upvote']))
            {
                upvote();
            }

            // if downvote button clicked, call downvote function
            if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST[$eventID . 'downvote']))
            {
                downvote();
            }
        }
    }
    
        
/*
            echo " <div class='card'> 
                        <div class='card-body'> 
                            <p class='ratingReview'>" . formatStarsReview($result['numStars']) . "</p>
                            <p>" . $result['userText'] . "</p> 
                        </div> 
                   </div> 
                   <br> ";
            // echo "userText: " . $result['userText'] . "numStars: " . $result['numStars'] . "<br/>";
    }
    */
?>

<?php
    function upvote()
    {
        global $db;
        $eventID = $_POST['eventID'];
        $userID = $_POST['userID'];
        $query = "SELECT * FROM votes WHERE eventID = :eventID AND userID = :userID";

        $statement = $db->prepare($query);
        $statement->bindValue(':eventID', $eventID);
        $statement->bindValue(':userID', $userID);
        $statement->execute();

        $results = $statement->fetch();
        $statement->closeCursor();

        if($statement->rowCount() > 0) { // if user already voted on event
           if($results['upvote'] != 1) { // downvoted but want to change to upvote
               $query = "UPDATE votes SET upvote = 1 WHERE eventID = :eventID AND userID = :userID";
               $statement = $db->prepare($query);
               $statement->bindValue(':eventID', $eventID);
               $statement->bindValue(':userID', $userID);
               $statement->execute();

               $query = "UPDATE votes SET downvote = 0 WHERE eventID = :eventID AND userID = :userID";
               $statement = $db->prepare($query);
               $statement->bindValue(':eventID', $eventID);
               $statement->bindValue(':userID', $userID);
               $statement->execute();

               $query = "UPDATE event SET total_votes = total_votes + 1 WHERE eventID = :eventID";
               $statement = $db->prepare($query);
               $statement->bindValue(':eventID', $eventID);
               $statement->execute();
               $statement->closeCursor();
           }
        }
        else{
            $query = "INSERT INTO votes VALUES(:eventID, :userID, 1, 0)";
            $statement = $db->prepare($query);
            $statement->bindValue(':eventID', $eventID);
            $statement->bindValue(':userID', $userID);

            $statement->execute();
            $statement->closeCursor();

            $query = "UPDATE event SET total_votes = total_votes + 1 WHERE eventID = :eventID";
            $statement = $db->prepare($query);
            $statement->bindValue(':eventID', $eventID);
            $statement->execute();
            $statement->closeCursor();
        }
        header('Location: uvafooddeals.php'); // refresh after updating vote
    }

    function downvote()
    {
        global $db;
        $eventID = $_POST['eventID'];
        $userID = $_POST['userID'];
        $query = "SELECT * FROM votes WHERE eventID = :eventID AND userID = :userID";

        $statement = $db->prepare($query);
        $statement->bindValue(':eventID', $eventID);
        $statement->bindValue(':userID', $userID);
        $statement->execute();

        $results = $statement->fetch();
        $statement->closeCursor();
        if($statement->rowCount() > 0) { // if user already voted on event
            if($results['downvote'] != 1) { // upvoted but want to change to downvote
                $query = "UPDATE votes SET upvote = 0 WHERE eventID = :eventID AND userID = :userID";
                $statement = $db->prepare($query);
                $statement->bindValue(':eventID', $eventID);
                $statement->bindValue(':userID', $userID);
                $statement->execute();

                $query = "UPDATE votes SET downvote = 1 WHERE eventID = :eventID AND userID = :userID";
                $statement = $db->prepare($query);
                $statement->bindValue(':eventID', $eventID);
                $statement->bindValue(':userID', $userID);
                $statement->execute();

                $query = "UPDATE event SET total_votes = total_votes - 1 WHERE eventID = :eventID";
                $statement = $db->prepare($query);
                $statement->bindValue(':eventID', $eventID);
                $statement->execute();
                $statement->closeCursor();
            }
        }
        else{
            $query = "INSERT INTO votes VALUES(:eventID, :userID, 0, 1)";
            $statement = $db->prepare($query);
            $statement->bindValue(':eventID', $eventID);
            $statement->bindValue(':userID', $userID);

            $statement->execute();
            $statement->closeCursor();

            $query = "UPDATE event SET total_votes = total_votes - 1 WHERE eventID = :eventID";
            $statement = $db->prepare($query);
            $statement->bindValue(':eventID', $eventID);
            $statement->execute();
            $statement->closeCursor();
        }
        header('Location: uvafooddeals.php'); // refresh after updating vote
    }
?>
