<h1>Availability</h1>


    <?php
    require("SQLConnection.php");
    include("loginheader.php");

    $newSQL = new SQLConnection();
    $conn = new mysqli($newSQL->getServerName(), $newSQL->getUserName(), $newSQL->getPassword(), $newSQL->getDB());

    global $personid, $dow, $season, $starttime, $endtime, $dayOfWeek, $dayOfWeek2;

    $profileID = $_SESSION["personid"];

    if (isset($_SESSION["adminSearch"]))
    {
        $profileID = $_SESSION["adminSearch"];
    }

    $sql = "select dow, season, starttime, endtime from availability where personid = ".$profileID;

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $dayOfWeek2 = "";
        while ($row = mysqli_fetch_assoc($result)) {
            $dayOfWeek = "";
            $dow = $row['dow'];
            $season = $row['season'];
            $starttime = $row['starttime'];
            $endtime = $row['endtime'];

                if (strpos($dow, 'mon') !== false) {
                    echo "Monday<br />";
                }
                if (strpos($dow, 'tue') !== false) {
                    echo "Tuesday<br />";
                }
                if (strpos($dow, 'wed') !== false) {
                    echo "Wednesday<br />";
                }
                if (strpos($dow, 'thu') !== false) {
                    echo "Thursday<br />";
                }
                if (strpos($dow, 'fri') !== false) {
                    echo "Friday<br />";
                }
                if (strpos($dow, 'sat') !== false) {
                    echo "Saturday<br />";
                }
                if (strpos($dow, 'sun') !== false) {
                    echo "Sunday<br />";
                }
        }

    }else{echo "hello";}

    ?>
<form action="availability-edit.php?personid=<?php echo $profileID; ?>" method="post">
    <br /><br /><br />
    <button type="submit" name="edit" href="availability-edit.php?personid=<?php echo $profileID; ?>">Edit Availability</button></br></br>
</form>