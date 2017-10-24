<!DOCTYPE html>
<html lang="en">
<body>
<form action="testit.php" method="post">
<input id="name" type="text" class="form-control" name="date1" placeholder="start" value="">
<input id="name" type="text" class="form-control" name="date3" placeholder="end" value="">
<input id="name" type="text" class="form-control" name="date2" placeholder="2" value="">
<input type="submit" class="form-control" name="doit" value="doit">
<?php
include("SQLConnection.php");
if(isset($_POST["doit"])) {
    monthlyReoccuring('potatoes', 'more large potatoes', $_POST["date1"], $_POST["date3"], 10, 0, $_POST["date2"], "outreach", "shift", 4, "outreach-event", 1000000);
}


function weeklyReoccuring($title, $description, $start, $end, $repeatableID, $editable, $repeatWeeklyUntil, $department, $type, $slots, $className, $creatorID) {
    //SQL connection and variables
    $newSQL = new SQLConnection();
    $conn = new mysqli($newSQL->getServerName(), $newSQL->getUserName(), $newSQL->getPassword(), $newSQL->getDB());

    $loopUntilDate = strtotime($repeatWeeklyUntil);
    $loopDate = date("Y-m-d", strtotime($start));
    $loopTimeDate = strtotime($loopDate);

    $eventID = null;
    $startTime = date("h:i:s", strtotime($start));
    $endTime = date("h:i:s", strtotime($end));

    echo "<br>";
    while ($loopTimeDate <= $loopUntilDate) {

        $specialStart = $loopDate . " " . $startTime;
        $specialEnd = $loopDate . " " . $endTime;

        $query = "insert into events (eventID, title, description, start, end, repeatableID, editable, repeatweeklyuntil, department, type, slots, className, creatorID) "
                . "values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("issssiisssisi",$eventID, $title, $description, $specialStart, $specialEnd, $repeatableID, $editable, $repeatWeeklyUntil, $department, $type, $slots, $className, $creatorID);
        $stmt->execute();


        echo $loopDate . "  ";
        $jd = gregoriantojd(date("m", strtotime($loopDate)), date("d", strtotime($loopDate)), date("Y", strtotime($loopDate)));
        echo jddayofweek($jd, 1) . "<br>";
        $loopDate = date("Y-m-d", strtotime('+7 days', $loopTimeDate));
        $loopTimeDate = strtotime($loopDate);
    }
}


function monthlyReoccuring($title, $description, $start, $end, $repeatableID, $editable, $repeatWeeklyUntil, $department, $type, $slots, $className, $creatorID) {
    //SQL connection and variables
    $newSQL = new SQLConnection();
    $conn = new mysqli($newSQL->getServerName(), $newSQL->getUserName(), $newSQL->getPassword(), $newSQL->getDB());

    $loopUntilDate = strtotime($repeatWeeklyUntil);
    $loopDate = date("Y-m-d", strtotime($start));
    $loopTimeDate = strtotime($loopDate);

    $eventID = null;
    $startTime = date("h:i:s", strtotime($start));
    $endTime = date("h:i:s", strtotime($end));

    echo "<br>";
    while ($loopTimeDate <= $loopUntilDate) {

        $specialStart = $loopDate . " " . $startTime;
        $specialEnd = $loopDate . " " . $endTime;

        $query = "insert into events (eventID, title, description, start, end, repeatableID, editable, repeatweeklyuntil, department, type, slots, className, creatorID) "
            . "values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("issssiisssisi",$eventID, $title, $description, $specialStart, $specialEnd, $repeatableID, $editable, $repeatWeeklyUntil, $department, $type, $slots, $className, $creatorID);
        $stmt->execute();


        echo $loopDate . "  ";
        $jd = gregoriantojd(date("m", strtotime($loopDate)), date("d", strtotime($loopDate)), date("Y", strtotime($loopDate)));
        echo jddayofweek($jd, 1) . "<br>";
        $loopDate = date("Y-m-d", strtotime("+1 month", $loopTimeDate));
        $loopTimeDate = strtotime($loopDate);

    }
}

?>
</form>
</body>
</html>