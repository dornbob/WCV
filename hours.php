
<?php
include ('loginheader.php');
include ('SQLConnection.php');
global $hoursArray;
global $milesArray;
global $hoursDateArray;
global $milesDateArray;
date_default_timezone_set('America/New_York');

$profileID = $_SESSION["personid"];

if (isset($_SESSION["adminSearch"]))
{
    $profileID = $_SESSION["adminSearch"];
}

//SQL connection and variables
$newSQL = new SQLConnection();
$conn = $newSQL->makeConn();
?>
<html>
<head>
    <title>Miles and Hours</title>
</head>
<body>
<div class="profSize">
    <h1>Hours and Miles Page</h1>

    <form action="hours.php" method="post">
        <?php
        $sqlSelect = "select sum(hours) as 'hours' from hours where personid = " . $profileID;
        $result = $conn->query($sqlSelect);
        $totalHours = 0;
        if ($result) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $totalHours = $row["hours"];
            }
        }
        echo "<h4>Total Hours Volunteered:  " . $totalHours . "</h4>";
        ?>
        <h3>Add Hours and Miles</h3>
        <p>Hours: <input title= "Enter Hours" type="number" min="0" name="hours" placeholder="0.00"></p>
        <p>Miles: <input title="Enter Miles" type="number" min="0" name="miles" placeholder="0.00"></p>
        <p>Date: <input title="Enter Date" required type="date" name="date"><br/></p>
        <input type="submit" class="btn btn-green" value="Add" name="add">
        <input type="submit" class="btn btn-blue" value="Edit" name="edit"><br/>
        <br>

        <h3>Current Hours </h3>
    </form>
        <?php
        //Displays the users hours
        $milesArray=array();
        $hoursArray=array();
        $milesDateArray=array();
        $hoursDateArray=array();

        //When the Add button is pressed
        if(isset($_POST["add"])){
            $hours = (!empty($_POST["hours"]) ? $_POST["hours"] : null);
            $miles = (!empty($_POST["miles"]) ? $_POST["miles"] : null);
            $date = (!empty($_POST["date"]) ? $_POST["date"] : null);
            $currentTime = date("h:i:s");

            //Creates queries
            if($hours != null)
            {
                $query = "INSERT into wcv.hours (dateAdded, timeAdded, hours, personid) values (?, ?,?,?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ssdi",$date, $currentTime, $hours, $profileID);
                $stmt->execute();
            }
            if($miles != null)
            {
                $query = "INSERT into wcv.miles (dateAdded, miles, personid) values (?,?," . $profileID." )";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sd",$date, $miles);
                $stmt->execute();
            }
            header('Location: profile.php');
            exit;
        }
        //Displays total hours
        $totalMeasure = 0.0;

        $query = "SELECT dateAdded, hours from wcv.hours where personid =" . $profileID. " ORDER BY dateAdded";
        $stmt = $conn->prepare($query);

        //Executes and captures the query
        $stmt->execute();
        //Retains the results
        $result = $stmt->get_result();
        $count = 0;
        $firstDay = strtotime(date("Y") . "-01-01");
        echo '<textarea rows="10" name="txtHours" cols="20" readonly placeholder="No hours entered to date">';
        //Shows the results
        while ($row = $result->fetch_assoc()) {
            $date = $row['dateAdded'];
            $hours = $row['hours'];
            $checkDateHr = strtotime($date);
            if ($hours != 0 && $checkDateHr >= $firstDay) {
                //$totalMeasure += $hours;
                echo "On: " . $date . " You Clocked: " . $hours . " hours " . "\n";
                $hoursArray[$count] = $hours;
                $hoursDateArray[$count] = $date;
                $count++;
            }
        }
        echo "</textarea>";
        $query = "call YTDHours(" . $profileID . ")";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $totalMeasure = $row['totalhours'];
        }
        $stmt->close();
        echo "<strong>Total hours this year: " . $totalMeasure . "</strong><br>";
        echo '<br/>';
        echo '<h3>Current Miles</h3>';

        //Displays total miles
        $totalMeasure = 0.0;

        $sqlSelect = "SELECT dateAdded, miles from wcv.miles where personid = " . $profileID." ORDER BY dateAdded";
        $stmt = $conn->prepare($sqlSelect);

        //Executes and captures the query
        $stmt->execute();
        //Retains the results
        $result = $stmt->get_result();
        $count = 0;
        echo '<textarea rows="10" name="txtHours" cols="20" readonly placeholder="No miles entered to date">';
        //Shows the results
        while ($row = $result->fetch_assoc()) {
            $date = $row['dateAdded'];
            $miles = $row['miles'];
            $checkDateMi = strtotime($date);
            if ($miles != 0 && $checkDateMi >= $firstDay) {
                //$totalMeasure += $miles;
                echo "On: $date You Clocked: $miles miles " . "\n";
                $milesDateArray[$count] = $date;
                $milesArray[$count] = $miles;
                $count++;
            }
        }
        echo "</textarea>";
        $query = "call YTDMiles(" . $profileID . ")";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $totalMeasure = $row['totalmiles'];
        }
        $stmt->close();
        echo "<strong>Total Miles this year: $totalMeasure ". "</strong><br>";


        //When the edit button is pressed
        if(isset($_POST["edit"])){
            header('Location: edit-hours.php');
            exit;
        }
        ?>

</div>
</body>
</html>

