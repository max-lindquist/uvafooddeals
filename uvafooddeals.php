<?php
    include('navbar2.html');
    include("uvafooddeals.html");
    ob_start();
    session_start();
?>
<style><?php
    include('uvafooddeals.css'); ?>
</style>
<?php
    require('uvafooddeals-connectdb.php');

    $query = "SELECT COUNT(*) FROM event NATURAL JOIN sponsors NATURAL JOIN host";

    $statement = $db->prepare($query);
    $statement->execute();
    $num_rows = $statement->fetchAll(); 
    $statement->closeCursor();

    foreach ($num_rows as $num_row) {
        if ($num_row['COUNT(*)'] == 0) {
            echo "<center><h4>You have no events! Add an event by clicking the button above.</h4></center>";
        } else {

            if(array_key_exists('popularity', $_POST))
            {
            $query = "SELECT * FROM event NATURAL JOIN sponsors NATURAL JOIN host ORDER BY total_votes DESC";
            }

            else
            {
            $query = "SELECT * FROM event NATURAL JOIN sponsors NATURAL JOIN host ORDER BY eventID DESC";
            }

            $statement = $db->prepare($query);
            $statement->execute();
            $results = $statement->fetchAll();
            $statement->closeCursor();

            // output data of each row
            $count = 0;
            echo "<br>";
            foreach ($results as $result) {
                $eventID = $result["eventID"];
                $location = $result["location"];
                $startTime = $result["startTime"];
                $endTime = $result["endTime"];
                $userID = $result["userID"];
                $total_votes = $result["total_votes"];
                $event_name = $result["event_name"];
                $host = $result["name"];

                $isOneTime = false;
                $exact_date = '';

                $userPosted = false;

                $timing = '';
                $days = array();

                // If one time event
                $query = "SELECT * FROM one_time_event";
                $statement = $db->prepare($query);
                $statement->execute();
                $results_onetime = $statement->fetchAll();
                $statement->closeCursor();
                foreach ($results_onetime as $result_onetime) {
                    if ($eventID == $result_onetime['eventID']) {
                        $exact_date = $result_onetime['exact_date'];
                        $isOneTime = true;
                    }
                }

                // If user logged in was poster
                if (isset($_SESSION['userID'])) {
                    if($_SESSION['userID']== $userID){
                        $userPosted = true;
                    }
                }
                if ($isOneTime == false) {
                    $query = "SELECT * FROM recurring_event";
                    $statement = $db->prepare($query);
                    $statement->execute();
                    $results_rec = $statement->fetchAll();
                    $statement->closeCursor();
                    foreach ($results_rec as $result_rec) {
                        if ($eventID == $result_rec['eventID']) {
                            $timing = $result_rec['timing'];
                        }
                    }

                    $query = "SELECT * FROM recurring_event_days_occurring";
                    $statement = $db->prepare($query);
                    $statement->execute();
                    $results_d = $statement->fetchAll();
                    $statement->closeCursor();
                    foreach ($results_d as $result_d) {
                        if ($eventID == $result_d['eventID']) {
                            array_push($days, $result_d['day']);
                        }
                    }
                }

                /**** ADD EVENTS TO THE PAGE *****/
                echo "<div class='container'>";
                echo "<div class='card'>
                    <div class='card-body'>
                        <h1>Event Name: " . $event_name . "</h1>
                        <p>Location: " . $location . "</p>
                        <p>Hosted By: " . $host . "</p>";

                if ($isOneTime) {
                    echo "<p>Date: " . date('F d, Y ', strtotime($exact_date)) . "</p>";
                } else {
                    echo "<p>Timing: " . $timing . "</p>";
                    echo "<p>Days: ";
                    foreach ($days as $day) {
                        echo $day . " ";
                    }
                    echo "</p>";
                }
                echo "<p>" . date('h:i A', strtotime($startTime)) . ' - ' . date('h:i A', strtotime($endTime)) . "</p>";

                if(isset($_SESSION['userID'])){
                    $currentUser = $_SESSION['userID'];
                    echo "<p style='position:absolute; right:9%; top:47%;color:#17a2b8; font-weight:bold;'>$total_votes</p>";
                    echo "<br><form action='uvafooddeals.php' method='post'>
                            <button class='btn btn-primary' type='submit' name='" . $eventID . "upvote' style='
    background: url(up.png); border: 0; display: block; height: 100;width: 100;position:absolute;right:5%;top:19%;'></button>
                            <button class='btn btn-danger' type='submit' name='" . $eventID . "downvote' style='
    background: url(down.png); border: 0; display: block; height: 100;width: 100;position:absolute;right:5%;top:50%'></button>
                            <input type='hidden' id='eventID' name='eventID' value=$eventID>
                            <input type='hidden' id='userID' name='userID' value=$currentUser>";
                    if ($userID == $_SESSION['userID']) {
                      echo "<button id='delete' class='btn btn-dark' name='" . $eventID . "delete'>Delete</button>";
                    }
                    echo "</form>";}
                    if($userPosted){
                    echo "<form action='updateevent.php' method='get'>
                            <button id='update' class='btn btn-info' type='submit' name='" . $eventID . "update'>Update</button>
                            <input type='hidden' id='eventID' name='eventID' value=$eventID>
                            <input type='hidden' id='userID' name='userID' value=$userID>
                            <input type='hidden' id='isOneTime' name='isOneTime' value=$isOneTime>
                            </form>";
                    }
                echo"</div>
                </div>";
                echo "</div>";

                // if upvote button clicked, call upvote function
                if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST[$eventID . 'upvote'])) {
                    upvote();
                }

                // if downvote button clicked, call downvote function
                if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST[$eventID . 'downvote'])) {
                    downvote();
                }

                // if delete button clicked, call delete function
                if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST[$eventID . 'delete'])) {
                    deleteEvent();
                }
            }
        }
    }
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

    function deleteEvent() {
        require('uvafooddeals-connectdb.php');
        global $db;
        $eventID = $_POST['eventID'];
        $hostID = $_POST['hostID'];

        // Delete from event
        $query = "DELETE FROM event WHERE eventID = :eventID";
        $statement = $db->prepare($query);
        $statement->bindValue(':eventID', $eventID);
        $statement->execute();
        $statement->closeCursor();

        // Delete from one_time_event
        $query = "DELETE FROM one_time_event WHERE eventID = :eventID";
        $statement = $db->prepare($query);
        $statement->bindValue(':eventID', $eventID);
        $statement->execute();
        $statement->closeCursor();

        // Delete from recurring_event
        $query = "DELETE FROM recurring_event WHERE eventID = :eventID";
        $statement = $db->prepare($query);
        $statement->bindValue(':eventID', $eventID);
        $statement->execute();
        $statement->closeCursor();

        // Delete from recurring_event_days_occurring 
        $query = "DELETE FROM recurring_event_days_occurring WHERE eventID = :eventID";
        $statement = $db->prepare($query);
        $statement->bindValue(':eventID', $eventID);
        $statement->execute();
        $statement->closeCursor();

        // Delete from sponsors
        $query = "DELETE FROM sponsors WHERE eventID = :eventID";
        $statement = $db->prepare($query);
        $statement->bindValue(':eventID', $eventID);
        $statement->execute();
        $statement->closeCursor();

        header('Location: uvafooddeals.php'); // refresh after updating vote
    }
?>
