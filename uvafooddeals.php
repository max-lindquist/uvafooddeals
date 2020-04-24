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
echo "<center><h4>You have no classes! Add a class by clicking the button above.</h4></center>";
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
      echo "<center>$eventID, $location, $startTime, $endTime, $userID, $total_votes</center>";
      }
      }
?>