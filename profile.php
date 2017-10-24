
<!DOCTYPE html>
<?php
include(SQLConnection.php);
include(PersonClass.php);
include(EmergContactClass.php);
include(loginheader.php);
?>
<html lang="en">
  <head>
    <title>User Profile | Wildlife Center Volunteers</title>
    <?php  include(htmlHead.php);?>
  </head>

<body>
<?php  include(navHeader.php);?>

  <div class="row">
    <div class="col-sm-1">
    <!--Spacer-->
    </div> 
    <div class="col-sm-10 vellum">
        <?php
        $newSQL = new SQLConnection();
        $conn = $newSQL->makeConn();

        global $profileID;
        $profileID = $_SESSION["personid"];

        if (isset($_GET["name"]))
        {
            $_SESSION["adminSearch"] = $_GET["name"];
            $profileID = $_SESSION["adminSearch"];
        }
        ?>

        <h1>My Profile <span class="edit"><a href="edit-profile.php?personid=<?php echo $profileID; ?>"><button type="button" class="btn btn-blue"><span class="glyphicon glyphicon-cog"></span>   Edit</button></a></span></h1>

        <div class="row profpic">
            <div class="col-xs-8 col-sm-4">
                <?php


                $sqlSelect = "select firstname, middlename, lastname, passwd, email, phone, housenumber, street, citycounty, " .
                    "stateabb, countryabb, zipcode, dob, rabiesowncost, rabiesshot, rabiesdate, rehabpermit, permittype, " .
                    "clocked, lastinDate, lastinTime, lastoutDate, lastoutTime, carpentryskills from person p inner join login l on p.personid = l.personid " .
                    "where p.personid = " . $profileID;
                $result = $conn->query($sqlSelect);

                $newPerson = new Person();

                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $newPerson->setFirstName($row["firstname"]);
                        $newPerson->setMiddleInitial($row["middlename"]);
                        $newPerson->setLastName($row["lastname"]);
                        $newPerson->setPassword($row["passwd"]);
                        $newPerson->setEmail($row["email"]);
                        $newPerson->setPhone($row["phone"]);
                        $newPerson->setHouseNumber($row["housenumber"]);
                        $newPerson->setStreet($row["street"]);
                        $newPerson->setCityCounty($row["citycounty"]);
                        $newPerson->setStateAbb($row["stateabb"]);
                        $newPerson->setCountryAbb($row["countryabb"]);
                        $newPerson->setZip($row["zipcode"]);
                        $newPerson->setDOB($row["dob"]);
                        $newPerson->setRabiesOwnCost($row["rabiesowncost"]);
                        $newPerson->setRabiesShot($row["rabiesshot"]);
                        $newPerson->setRabiesDate($row["rabiesdate"]);
                        $newPerson->setRehabilitationPermit($row["rehabpermit"]);
                        $newPerson->setPermitType($row["permittype"]);
                        $newPerson->setClocked($row["clocked"]);
                        $newPerson->setLastInDate($row["lastinDate"]);
                        $newPerson->setLastInTime($row["lastinTime"]);
                        $newPerson->setLastOutDate($row["lastoutDate"]);
                        $newPerson->setLastOutTime($row["lastoutTime"]);
                        $newPerson->setCarpentrySkills($row["carpentryskills"]);

                    }
                }

                $newEmergContact = new EmergContact();
                $sqlSelect = "SELECT * from wcv.emergcontact where personid = " . $profileID;
                $result = $conn->query($sqlSelect);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {

                        $newEmergContact->setFirstName($row["firstname"]);
                        $newEmergContact->setLastName($row["lastname"]);
                        $newEmergContact->setPhone($row["phone"]);
                        $newEmergContact->setRelationship($row["relationship"]);
                    }
                }

                $apStatus = array();
                $sqlSelect = "select apstatus from teamstatus ts inner join person p on ts.personid = p.personid where p.personid = " . $profileID;
                $result = $conn->query($sqlSelect);
                if ($result) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $apStatus[] = $row["apstatus"];
                    }
                }

                $sqlSelect = "select filelocation from documents where personid = " . $profileID . " and docname = 'profilepicture'";
                $result = $conn->query($sqlSelect);
                $picLocation = "profilePictures/profile.jpg";
                if ($result) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $picLocation = $row["filelocation"];
                    }
                }
                ?>
                <img src="<?php echo $picLocation; ?>" class="img-responsive profpicture" alt="Profile picture"/>
            </div>
            <div class="col-xs-12 col-sm-8">
                <script>
                    function resizeTextBox(txt) {
                        txt.style.width = "1px";
                        txt.style.width = (1 + txt.scrollWidth) + "px";
                    }
                </script>
                <h1>
                    <?php echo $newPerson->getFirstName(); ?>
                    <?php echo $newPerson->getMiddleInitial(); ?>
                    <?php echo $newPerson->getLastName(); ?>
                </h1>
                <h3>
                <?php
                $apStatDisplay = "Inactive";
                if (in_array('active', $apStatus)) {
                    $apStatDisplay = "Active";
                } else if (in_array('pending', $apStatus)) {
                    $apStatDisplay = "Pending";
                } else if (in_array('denied', $apStatus)) {
                    $apStatDisplay = "Denied";
                }
                echo $apStatDisplay . " Volunteer<br>";
                ?>
                </h3>
            </div>

            <!--First column-->
            <div class="col-xs-12 col-sm-4">
                <div>
                    <h3><span class="glyphicon glyphicon-envelope"></span>  Contact Info</h3>
                    <div class="infoblock profSize">
                        <p>
                            <?php
                            echo $newPerson->getHouseNumber() . " " . ucwords($newPerson->getStreet()) . "</br>" .
                                ucwords($newPerson->getCityCounty()) . " " . strtoupper($newPerson->getStateAbb()) . " " . $newPerson->getZip() . "</br>" .
                                $newPerson->getPhone() . "</br>" .
                                $newPerson->getEmail();
                            ?>

                            <!--<a href=\"mailto:someone@example.com?Subject=Hello%20again\" target=\"_top\">emailexample@example.com</a></p>-->
                        </p>
                    </div>
                </div>
            </div><!--End column-->

            <!--second column-->
            <div class="col-xs-12 col-sm-4">
                <div>
                    <h3><span class="glyphicon glyphicon-warning-sign"></span> Emergency Contact</h3>
                    <div class="infoblock profSize">
                        <p>
                            <?php
                            echo ucwords($newEmergContact->getFirstName()) . " " . ucwords($newEmergContact->getLastName()) . "</br>" .
                                ucwords($newEmergContact->getRelationship()) . "</br>" .
                                $newEmergContact->getPhone();
                            ?>

                        </p>
                    </div>
                </div>
            </div><!--End column-->
            <div class="col-xs-12 col-sm-4">
                    <h3><span class="glyphicon glyphicon-time"></span> Availability</h3>
                    <div class="infoblock profSize">
                    <p>
                        <?php
                        global $personid, $dow, $season, $starttime, $endtime, $dayOfWeek, $dayOfWeek2;

                        $sql = "select distinct dow, season, starttime, endtime from availability where personid = ".$profileID;

                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $dayOfWeek2 = "";
                            while ($row = mysqli_fetch_assoc($result)) {
                                $dayOfWeek = "";
                                $dow = $row['dow'];
                                $season = $row['season'];
                                $starttime = $row['starttime'];
                                $endtime = $row['endtime'];

                                if (strpos($dow, 'sun') !== false) {
                                    echo "Sunday<br />";
                                }
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

                            }

                        }else{echo "No current availability";}

                        ?>

                    </p>
                    </div>
            </div>
        </div> <!--End row-->

    <br>

        <ul class="nav nav-tabs">
            <li id="profile" role="presentation"><button id="button1" class="btn tab active">General</button></li>
            <li id="team" role="presentation"><button id="button2" class="btn tab">Team</button></li>
            <li id="hours" role="presentation"><button id="button3" class="btn tab">Hours/Miles</button></li>
            <li id="documents" role="presentation"><button id="button4" class="btn tab">Documents</button></li>
            <li id="change password" role="presentation" class=""><button id="button6" class="btn tab">Change Password</button></li>
        </ul>

        <div id="tab_stuff">
                <!--Profile info from the tabs will go here-->
        </div>
    </div><!--End vellum box-->
</div><!--End row-->

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
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/customscript.js"></script>
  </body>
</html>