<?php
include ('personclass.php');
require_once("SQLConnection.php");
global $email, $clocked, $lastIn, $lastOut, $lastInDate, $lastOutDate;
date_default_timezone_set('America/New_York');
session_start();
$person = new Person();
$newSQL = new SQLConnection();
$conn = $newSQL->makeConn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>clockin</title>
    <?php include("htmlHead.php")?>

</head>
<body class="loginimage">
<div class="row">
    <div class="col-sm-3">
        <!--Spacer-->
    </div>
    <div class="col-xs-12 col-sm-6 vellum">
      <div class="row logo-row">
				<img src="images/wcv-black.png" alt="Wildlife Center Logo" class="img-responsive logo-big">
                <h1 class="logo-text">Wildlife Center of Virginia</h1>
            </div>
        <!--End row-->

        <div class="row">
            <div class="col-sm-2">
                <!--Spacer-->
            </div>
            <div class="col-sm-8">
                <h1>Clock In / Clock Out</h1>
                <form action="clockTime.php" method="post">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input id="name" type="text" class="form-control" name="email" placeholder="E-mail" value="<?php
                        if (isset($_SESSION["personid"]) && $_SESSION["personid"] != '') {
                            $sql = "SELECT email from login where personid = " . $_SESSION['personid'];
                            $result = $conn->query($sql);

                            $userEmail = '';
                            if ($result) {
                                while ($row = $result->fetch_assoc()) {
                                    $userEmail = $row["email"];

                                }
                            }
                            echo $userEmail;
                        }
                        ?>">
                    </div>
                    <br>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
                        <input id="password" type="number" min="0" class="form-control" name="miles" placeholder="mileage (optional)">
                    </div>
                    <script>
                        function showDiv() {
                            var x = document.getElementById('transDiv');
                            if (x.style.display === 'none') {
                                x.style.display = 'block';
                            } else {
                                x.style.display = 'none';
                            }
                        }
                    </script>
                    <button name="transport" type="button" onclick="showDiv()" class="btn btn-blue">Transporter?</button>
                    <div id="transDiv" style="display:none">
                        <!--Date of Transport:  <input id="name" type="date" class="form-control" name="transDate">-->
                        Animal(s) Transported: <input id="name" type="text" class="form-control" name="animal" placeholder="">
                        <b>Pickup Address:</b><br>
                        Street: <input id="name" type="text" class="form-control" name="street" placeholder="">
                        City, State, Zip: <input id="name" type="text" class="form-control" name="city" placeholder="">
                    </div>
                    <br>
                    <button type="submit" name="clockTime" class="btn btn-clock">Clock In/Out
                    </button></a>
                    <a href="profile.php"> <button name="back" type="button" class="btn btn-clock">Back</button></a>

                    <?php
                    $lastIn = "";
                    $lastOut = "";

                    $disRecordCreation = "";
                    $truck = "";

                    $miles = null;
                    $transDate = date("Y-m-d");
                    $currentTime = date("h:i:s");
                    $transAnimal = null;
                    $transAddress = null;

                    if (isset($_POST["clockTime"])) {
                        if(!empty($_POST["email"])) {
                            $email = $_POST["email"];
                            $query = "SELECT p.personid, clocked FROM person p INNER JOIN login l ON p.personid = l.personid "
                                    . "inner join teamstatus ts on p.personid = ts.personid WHERE email = ? and apstatus = 'active'";
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param("s", $email);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $personid = null;
                            if ($result) {
                                while ($row = $result->fetch_assoc()) {
                                    $personid = $row["personid"];
                                    $clocked = $row["clocked"]; //if person is clocked in or not (0 if not, 1 if they are)$lastIn = $row['lastintime'];
                                    /*$lastIn = $row['lastintime'];
                                    $lastOut = $row['lastouttime'];
                                    $lastInDate = $row['lastindate'];
                                    $lastOutDate = $row['lastoutdate'];*/
                                }
                            }
                            if ($personid != null) {

                                $sql = "SELECT teamname, apstatus FROM team t INNER JOIN teamstatus ts ON t.teamid = ts.teamid INNER JOIN person p ON ts.personid = p.personid WHERE p.personid = " . $personid;
                                $result = $conn->query($sql);
                                $teamName = "";
                                $apStatus = "";
                                if ($result) {
                                    while ($row = $result->fetch_assoc()) {
                                        $teamName .= $row["teamname"];
                                        if (strtolower($row["teamname"]) == "transporter") {
                                            $apStatus = strtolower($row["apstatus"]);
                                        }
                                    }
                                }

                                if (isset($_POST["miles"])) {
                                    $miles = $_POST["miles"];
                                }
                                if ((strpos(strtolower($teamName), "transporter") && $apStatus == 'active')) {
                                    /*if (!empty($_POST["transDate"])) {
                                        $transDate = $_POST["transDate"];
                                    }*/
                                    if (!empty($_POST["animal"])) {
                                        $transAnimal = $_POST["animal"];
                                    }
                                    if (!empty($_POST["street"])) {
                                        $transAddress = $_POST["street"];
                                    }
                                    if (!empty($_POST["city"])) {
                                        $transAddress .= " " . $_POST["city"];
                                    }
                                } else if (!empty($_POST["transDate"]) || !empty($_POST["animal"]) || !empty($_POST["street"]) || !empty($_POST["city"])){
                                    echo "<font color='red'><h5>You are not a transporter so transporter fields will be ignored</h5></font>";
                                }

                                if ($clocked == 0) {
                                    $theID = null;
                                    $query = "INSERT INTO miles (milesid, dateadded, timeadded, miles, pickupaddress, animaldriven, personid) VALUES (?, ?, ?, ?, ?, ?, ?)";
                                    $stmt = $conn->prepare($query);
                                    $stmt->bind_param("issdssi", $theID, $transDate, $currentTime, $miles, $transAddress, $transAnimal, $personid);
                                    $stmt->execute();
                                    $oneClocked = 1;
                                    $query = "UPDATE person SET clocked = ?, lastinTime = ?, lastinDate = ? WHERE personid = " . $personid;
                                    $stmt = $conn->prepare($query);
                                    $stmt->bind_param("iss", $oneClocked, $currentTime, $transDate);
                                    $stmt->execute();

                                    $query = "SELECT lastintime, lastouttime, lastindate, lastoutdate FROM person p INNER JOIN login l ON p.personid = l.personid "
                                        . "WHERE email = ?";
                                    $stmt = $conn->prepare($query);
                                    $stmt->bind_param("s", $email);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($result) {
                                        while ($row = $result->fetch_assoc()) {
                                            $lastIn = $row['lastintime'];
                                            $lastOut = $row['lastouttime'];
                                            $lastInDate = $row['lastindate'];
                                            $lastOutDate = $row['lastoutdate'];

                                        }
                                    }
                                }


                                if ($clocked == 1) {
                                    $zeroClocked = 0;
                                    $query = "UPDATE person SET clocked = ?, lastoutTime = ?, lastoutDate = ? WHERE personid = " . $personid;
                                    $stmt = $conn->prepare($query);
                                    $stmt->bind_param("iss", $zeroClocked, $currentTime, $transDate);
                                    $stmt->execute();

                                    $getHours = "SELECT concat(lastinDate, ' ', lastinTime) AS clockedIn FROM person WHERE personid = " . $personid;
                                    $stmt = $conn->prepare($getHours);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $hours = null;
                                    $diff = "";
                                    if ($result) {
                                        while ($row = $result->fetch_assoc()) {
                                            $clockedIn = strtotime($row["clockedIn"]);
                                            $clockedOut = date("Y-m-d h:i:s");
                                            $clockedOut = strtotime($clockedOut);
                                            $diff = $clockedOut - $clockedIn;
                                            $hours = number_format(($diff / (60 * 60)), 2);
                                        }
                                    }

                                    $sql = "SELECT max(milesid) AS 'max' FROM miles WHERE personid = " . $personid;
                                    $result = $conn->query($sql);
                                    $mileToUpdate = "";
                                    if ($result) {
                                        while ($row = $result->fetch_assoc()) {
                                            $mileToUpdate = $row["max"];
                                        }
                                    }
                                    if (!empty($miles) && !empty($transDate) && !empty($transAnimal) && !empty($transAddress)) {
                                        $query = "UPDATE miles SET dateadded = ?, timeadded = ?, miles = ?, pickupaddress = ?, animaldriven = ? WHERE milesid = " . $mileToUpdate;
                                        $stmt = $conn->prepare($query);
                                        $stmt->bind_param("ssdss", $transDate, $currentTime, $miles, $transAddress, $transAnimal);
                                        $stmt->execute();
                                    }

                                    $query = "INSERT INTO hours (dateAdded,timeAdded,hours,personid) VALUES (?, ?, ?, ?)";
                                    $stmt = $conn->prepare($query);
                                    $stmt->bind_param("ssdi",$transDate, $currentTime, $hours, $personid);
                                    $stmt->execute();

                                    $sql = "SELECT lastintime, lastouttime, lastindate, lastoutdate FROM person p INNER JOIN login l ON p.personid = l.personid "
                                        . "WHERE email='" . $email . "'";
                                    $result = $conn->query($sql);

                                    if ($result) {
                                        while ($row = $result->fetch_assoc()) {
                                            $lastIn = $row['lastintime'];
                                            $lastOut = $row['lastouttime'];
                                            $lastInDate = $row['lastindate'];
                                            $lastOutDate = $row['lastoutdate'];

                                        }
                                    }
                                }

                                if ($clocked == 0) {
                                    echo "<h5>Clocked in: " . $lastIn . " on " . $lastInDate . "</h5>";
                                } else {
                                    echo "<h5>Clocked in: " . $lastIn . " on " . $lastInDate . "<br />Clocked out: " . $lastOut . " on " . $lastInDate . "</h5>";
                                }
                            } else {
                                echo "<font color='red'><h5>Invalid E-mail entered</h5></font>";
                            }
                        } else {
                            echo "<font color='red'><h5>E-mail must be entered to clock time</h5></font>";
                        }
                    }

                    ?>
                </form>
            </div><!--End centered collumn-->
        </div><!--End row-->
    </div> <!--End column-->
</div><!--End rowr-->

<!-- Footer -->
<footer class="w3-container w3-padding-64 w3-center w3-xlarge">
    <i class="fa fa-facebook-official w3-hover-opacity" onclick="window.location='https://www.facebook.com/wildlifecenter/'"></i>
    <i class="fa fa-instagram w3-hover-opacity" onclick="window.location='https://www.instagram.com/explore/locations/292750036/'"></i>
    <i class="fa fa-youtube w3-hover-opacity" onclick="window.location='https://www.youtube.com/user/WildlifeCenterVA'"></i>
    <i class="fa fa-twitter w3-hover-opacity" onclick="window.location='https://twitter.com/WCVtweets'"></i>
    <i class="fa fa-linkedin w3-hover-opacity" onclick="window.location='https://www.linkedin.com/company/wildlife-center-of-va'"></i>
    <p class="w3-medium">Visit us at <a href="http://wildlifecenter.org/" target="_blank">WildLifeCenter.org</a></p>
    <p class="w3-medium">© 2017 The Wildlife Center of Virginia. All Rights Reserved.</p>
</footer>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>