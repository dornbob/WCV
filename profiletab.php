<?php
include("SQLConnection.php");
include("PersonClass.php");
include("EmergContactClass.php");
include("loginheader.php");
?>
<h1>General Info</h1>
<div class="col-xs-12 profSize">

            <?php
            $newSQL = new SQLConnection();
            $conn = $newSQL->makeConn();

            $profileID = $_SESSION["personid"];

            if (isset($_SESSION["adminSearch"]))
            {
                $profileID = $_SESSION["adminSearch"];
            }

            $sqlSelect = "select firstname, middlename, lastname, passwd, email, phone, housenumber, street, citycounty, " .
                "stateabb, countryabb, zipcode, dob, rabiesowncost, rabiesshot, rabiesdate, rehabpermit, permittype, " .
                "clocked, lastinDate, lastinTime, lastoutDate, lastoutTime, carpentryskills from person p inner join login l on p.personid = l.personid " .
                "where p.personid = " . $profileID;
            $result = $conn->query($sqlSelect);

            $newPerson = new Person();

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {

                    $newPerson->setRabiesOwnCost($row["rabiesowncost"]);
                    $newPerson->setRabiesShot($row["rabiesshot"]);
                    $newPerson->setRabiesDate($row["rabiesdate"]);
                    $newPerson->setRehabilitationPermit($row["rehabpermit"]);
                    $newPerson->setPermitType($row["permittype"]);
                    $newPerson->setClocked($row["clocked"]);
                    $newPerson->setLastOutDate($row["lastoutDate"]);
                    $newPerson->setLastOutTime($row["lastoutTime"]);
                    $newPerson->setCarpentrySkills($row["carpentryskills"]);

                }
            }
            ?>

<div class="row">
    <!--First column-->
    <div class="col-sm-8">
        <div>
            <p>Shift Status (Clocked In/Clocked Out):  <span class='profResult'><?php if($newPerson->getClocked() == 1) { echo "Clocked In"; } else { echo "Clocked Out"; } ?></span></p>
            <?php
            $query = "call YTDHours(" . $profileID . ")";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            $totalHours = 0;
            while ($row = $result->fetch_assoc()) {
                $totalHours = $row['totalhours'];
            }
            $stmt->close();

            $query = "call YTDMiles(" . $profileID . ")";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            $totalMiles = 0;
            while ($row = $result->fetch_assoc()) {
                $totalMiles = $row['totalmiles'];
            }
            $stmt->close();
            ?>
            <p>Last Shift:  <span class='profResult'><?php
                if($newPerson->getLastOutDate() != '') { echo $newPerson->getLastOutDate() . " | " . $newPerson->getLastOutTime();
                } else { echo "No shifts worked to date"; } ?></span></p>
            <p>Total YTD Hours:  <span class='profResult'><?php echo $totalHours; ?></span></p>
            <p>Total YTD Miles:  <span class='profResult'><?php echo $totalMiles; ?></span></p>
            <p>Rabies Vaccinated:  <span class='profResult'><?php if($newPerson->getRabiesShot() == 1) { echo "Completed on " . $newPerson->getRabiesDate(); } else { echo "No"; } ?></span></p>
            <P>Rehabilitation Permit:  <span class='profResult'><?php if($newPerson->getRehabilitationPermit() == 1) { echo $newPerson->getPermitType(); } else { echo "No"; } ?></span></P>
            <p>Carpentry Skills:  <span class='profResult'><?php if($newPerson->getCarpentrySkills() == 1) { echo "Yes"; } else { echo "No"; } ?></span></p>
        </div>
    </div>
</div><!--End column-->