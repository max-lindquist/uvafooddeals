<?php
    include('navbar.html');
    include("uvafooddeals.html");
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
                        </form>
                    </div>
                  </div>
            ";
            echo "</div>";
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