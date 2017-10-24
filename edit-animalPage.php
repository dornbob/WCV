<?php
    include("SQLConnection.php");
    include("loginheader.php");
    include("animalCareClass.php");
    include("treatmentClass.php");
    include("transportClass.php");

$newSQL = new SQLConnection();
$conn = new mysqli($newSQL->getServerName(), $newSQL->getUserName(), $newSQL->getPassword(), $newSQL->getDB());
?>

<!DOCTYPE html>
<html lang="en">
<body></body>

<form action="edit-animalPage.php" method="post">
    <input type="submit" name="save" value="save">
    <?php

    $sqlSelect = "select smMam, LrgMam, RVS, eagle, SmRaptor, LrgRaptor, reptile, vet, tech, vetstudent, techstudent, "
            . "vetassistant, medicating, bandaging, woundcare, diag, anesthesia, notes from treatment where treatmentid = " . $_SESSION["personid"];
    $result = $conn->query($sqlSelect);

    $newTreatment = new treatment();

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $newTreatment->setSmMam($row["smMam"]);
            $newTreatment->setLrgMam($row["LrgMam"]);
            $newTreatment->setRVS($row["RVS"]);
            $newTreatment->setEagle($row["eagle"]);
            $newTreatment->setSmRaptor($row["SmRaptor"]);
            $newTreatment->setLrgRaptor($row["LrgRaptor"]);
            $newTreatment->setReptile($row["reptile"]);
            $newTreatment->setVet($row["vet"]);
            $newTreatment->setTech($row["tech"]);
            $newTreatment->setVetStudent($row["vetstudent"]);
            $newTreatment->setTechStudent($row["techstudent"]);
            $newTreatment->setVetAssistant($row["vetassistant"]);
            $newTreatment->setMedicating($row["medicating"]);
            $newTreatment->setBandaging($row["bandaging"]);
            $newTreatment->setWoundCare($row["woundcare"]);
            $newTreatment->setDiag($row["diag"]);
            $newTreatment->setAnesthesia($row["anesthesia"]);
            $newTreatment->setNotes($row["notes"]);
        }
    }

    ?>
<h1>Treatment Fields</h1>

Handling Skills:</br>
Small Mammals: <input type="radio" name="sMam" <?php if ($newTreatment->getSmMam() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="sMam" <?php if ($newTreatment->getSmMam() == 0) { echo "checked"; } ?> value="0"> No</br>
Large Mammals: <input type="radio" name="lMam" <?php if ($newTreatment->getLrgMam() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="lMam" <?php if ($newTreatment->getLrgMam() == 0) { echo "checked"; } ?> value="0"> No</br>
RVS: <input type="radio" name="rvs" <?php if ($newTreatment->getRVS() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="rvs" <?php if ($newTreatment->getRVS() == 0) { echo "checked"; } ?> value="0"> No</br>
Eagles: <input type="radio" name="eag" <?php if ($newTreatment->getEagle() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="eag" <?php if ($newTreatment->getEagle() == 0) { echo "checked"; } ?> value="0"> No</br>
Small Raptors: <input type="radio" name="sRap" <?php if ($newTreatment->getSmRaptor() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="sRap" <?php if ($newTreatment->getSmRaptor() == 0) { echo "checked"; } ?> value="0"> No</br>
Large Raptors: <input type="radio" name="lRap" <?php if ($newTreatment->getLrgRaptor() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="lRap" <?php if ($newTreatment->getLrgRaptor() == 0) { echo "checked"; } ?> value="0"> No</br>
Reptiles: <input type="radio" name="rep" <?php if ($newTreatment->getReptile() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="rep" <?php if ($newTreatment->getReptile() == 0) { echo "checked"; } ?> value="0"> No</br>
Veterinarian: <input type="radio" name="vet" <?php if ($newTreatment->getVet() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="vet" <?php if ($newTreatment->getVet() == 0) { echo "checked"; } ?> value="0"> No</br>
Technician: <input type="radio" name="tech" <?php if ($newTreatment->getTech() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="tech" <?php if ($newTreatment->getTech() == 0) { echo "checked"; } ?> value="0"> No</br>
Veterinarian Student: <input type="radio" name="vetStu" <?php if ($newTreatment->getVetStudent() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="vetStu" <?php if ($newTreatment->getVetStudent() == 0) { echo "checked"; } ?> value="0"> No</br>
Technician Student: <input type="radio" name="techStu" <?php if ($newTreatment->getTechStudent() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="techStu" <?php if ($newTreatment->getTechStudent() == 0) { echo "checked"; } ?> value="0"> No</br>
Veterinarian Assistant: <input type="radio" name="vetAs" <?php if ($newTreatment->getVetAssistant() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="vetAs" <?php if ($newTreatment->getVetAssistant() == 0) { echo "checked"; } ?>value="0"> No</br>
Medicating: <input type="radio" name="med" <?php if ($newTreatment->getMedicating() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="med" <?php if ($newTreatment->getMedicating() == 0) { echo "checked"; } ?> value="0"> No</br>
Bandaging: <input type="radio" name="band" <?php if ($newTreatment->getBandaging() == 1) { echo "checked"; } ?>value="1"> Yes
<input type="radio" name="band" <?php if ($newTreatment->getBandaging() == 0) { echo "checked"; } ?> value="0"> No</br>
Wound Care: <input type="radio" name="wCare" <?php if ($newTreatment->getWoundCare() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="wCare" <?php if ($newTreatment->getWoundCare() == 0) { echo "checked"; } ?> value="0"> No</br>
Diagostics: <input type="radio" name="diag" <?php if ($newTreatment->getDiag() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="diag" <?php if ($newTreatment->getDiag() == 0) { echo "checked"; } ?> value="0"> No</br>
Anesthesia: <input type="radio" name="anthe" <?php if ($newTreatment->getAnesthesia() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="anthe" <?php if ($newTreatment->getAnesthesia() == 0) { echo "checked"; } ?> value="0"> No</br></br>

Notes:</br>
<textarea rows="4" name="treatmentNotes" cols="50" maxlength="255" placeholder="Enter notes here."><?php echo $newTreatment->getNotes(); ?></textarea>

<?php
$sqlSelect = "select capturerestraint, distancelimits, animallimits, notes from transport where transportid = " . $_SESSION["personid"];
$result = $conn->query($sqlSelect);
$newTransport = new transport();
if ($result) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $newTransport->setCaptureRestraint($row["capturerestraint"]);
        $newTransport->setDistanceLimits($row["distancelimits"]);
        $newTransport->setAnimalLimitsSA($row["animallimits"]);
        $newTransport->setNotes($row["notes"]);
    }
}
?>

<h1>Transport Fields</h1>

Capture and Restraint class: <input type="radio" name="capR" <?php if ($newTransport->getCaptureRestraint() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="capR" <?php if ($newTransport->getCaptureRestraint() == 0) { echo "checked"; } ?> value="0"> No</br>
Distance limits: <input type="number" name="distance" value="<?php echo $newTransport->getDistanceLimits(); ?>"></br>
Animal Limitations:</br>
<textarea rows="4" name="anLimits" cols="50" maxlength="255" placeholder="Enter limitations here."><?php echo $newTransport->getAnimalLimitsSA(); ?></textarea><br><br>
Notes:</br>
<textarea rows="4" name="transportNotes" cols="50" maxlength="255" placeholder="Enter notes here."><?php echo $newTransport->getNotes(); ?></textarea>


<?php
$sqlSelect = "select notes from frontDesk where frntdskid = " . $_SESSION["personid"];
$result = $conn->query($sqlSelect);
$frntDskNotes = null;
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $frntDskNotes = $row["notes"];
    }
}
?>

<h1>Front Desk Fields</h1>
Notes:</br>
<textarea rows="4" name="frontDeskNotes" cols="50" maxlength="255" placeholder="Enter notes here."><?php echo $frntDskNotes; ?></textarea>

<!--<h1>Outreach Fields</h1>

Number of times shadowed:</br>
<p> Date of first shadow: <input type="date" name="dateShadow1"></br>
    Date of second shadow: <input type="date" name="dateShadow2"></br>
    Date of third shadow: <input type="date" name="dateShadow3"></br></p>
Introduction:<input type="radio" name="introYes" value="yes"> Yes
<input type="radio" name="introNo" value="no"> No</br>
Lead tour alone:<input type="radio" name="aloneYes" value="yes"> Yes
<input type="radio" name="aloneNo" value="no"> No</br>
Offsite:<input type="radio" name="offsiteYes" value="yes"> Yes
<input type="radio" name="offsiteNo" value="no"> No</br></br>
Notes:</br>
<textarea rows="4" name="outreachNotes" cols="50" placeholder="Enter notes here."></textarea>-->

<?php
$sqlSelect = "select shiftCommit, reptileRoom, reptileSoak, snakeFeed, ICU, exICU, aviary, "
    . "mammals, PUE, PUEweigh, fawns, formulas, meals, raptorFeed, ISO, notes from animalcare where ancareid = " . $_SESSION["personid"];
$result = $conn->query($sqlSelect);
$newAnCare = new animalCare();
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $newAnCare->setShiftCommit($row["shiftCommit"]);
        $newAnCare->setReptileRoom($row["reptileRoom"]);
        $newAnCare->setReptileSoak($row["reptileSoak"]);
        $newAnCare->setSnakeFeed($row["snakeFeed"]);
        $newAnCare->setICU($row["ICU"]);
        $newAnCare->setExICU($row["exICU"]);
        $newAnCare->setAviary($row["aviary"]);
        $newAnCare->setMammals($row["mammals"]);
        $newAnCare->setPUE($row["PUE"]);
        $newAnCare->setPUEweigh($row["PUEweigh"]);
        $newAnCare->setFawns($row["fawns"]);
        $newAnCare->setFormulas($row["formulas"]);
        $newAnCare->setMeals($row["meals"]);
        $newAnCare->setRaptorFeed($row["raptorFeed"]);
        $newAnCare->setISO($row["ISO"]);
        $newAnCare->setNotes($row["notes"]);
    }
}
?>

<h1>Animal Care Fields</h1>

Reptile Room: <input type="checkbox" name="rep1" <?php if ($newAnCare->getReptileRoom() > 0) { echo "checked"; } ?> value="1"> 1
<input type="checkbox" name="rep2" <?php if ($newAnCare->getReptileRoom() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="rep3" <?php if ($newAnCare->getReptileRoom() > 2) { echo "checked"; } ?> value="3"> 3<br>
Reptile Room Soak Day:<input type="checkbox" name="repRm1" <?php if ($newAnCare->getReptileSoak() > 0) { echo "checked"; } ?> value="1"> 1
<input type="checkbox" name="repRm2" <?php if ($newAnCare->getReptileSoak() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="repRm3" <?php if ($newAnCare->getReptileSoak() > 2) { echo "checked"; } ?> value="3"> 3<br>
Education Snake Feeding Day:<input type="checkbox" name="snake1" <?php if ($newAnCare->getSnakeFeed() > 0) { echo "checked"; } ?> value="1"> 1
<input type="checkbox" name="snake2" <?php if ($newAnCare->getSnakeFeed() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="snake3" <?php if ($newAnCare->getSnakeFeed() > 2) { echo "checked"; } ?> value="3"> 3<br>
ICU:<input type="checkbox" name="icu1" <?php if ($newAnCare->getICU() > 0) { echo "checked"; } ?> value="1"> 1
<input type="checkbox" name="icu2" <?php if ($newAnCare->getICU() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="icu3" <?php if ($newAnCare->getICU() > 2) { echo "checked"; } ?> value="3"> 3<br>
Expanded ICU:<input type="checkbox" <?php if ($newAnCare->getExICU() > 0) { echo "checked"; } ?> name="eicu1" value="1"> 1
<input type="checkbox" name="eicu2" <?php if ($newAnCare->getExICU() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="eicu3" <?php if ($newAnCare->getExICU() > 2) { echo "checked"; } ?> value="3"> 3<br>
Aviary:<input type="checkbox" name="av1" <?php if ($newAnCare->getAviary() > 0) { echo "checked"; } ?> value="1"> 1
<input type="checkbox" name="av2" <?php if ($newAnCare->getAviary() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="av3" <?php if ($newAnCare->getAviary() > 2) { echo "checked"; } ?> value="3"> 3<br>
Mammals:<input type="checkbox" name="mam1" <?php if ($newAnCare->getMammals() > 0) { echo "checked"; } ?> value="1"> 1
<input type="checkbox" name="mam2" <?php if ($newAnCare->getMammals() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="mam3" <?php if ($newAnCare->getMammals() > 2) { echo "checked"; } ?> value="3"> 3<br>
PU & E:<input type="checkbox" name="pue1" <?php if ($newAnCare->getPUE() > 0) { echo "checked"; } ?> value="1"> 1
<input type="checkbox" name="pue2" <?php if ($newAnCare->getPUE() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="pue3" <?php if ($newAnCare->getPUE() > 2) { echo "checked"; } ?> value="3"> 3<br>
PU & E Weigh Day:<input type="checkbox" name="puew1" <?php if ($newAnCare->getPUEweigh() > 0) { echo "checked"; } ?> value="1"> 1
<input type="checkbox" name="puew2" <?php if ($newAnCare->getPUEweigh() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="puew3" <?php if ($newAnCare->getPUEweigh() > 2) { echo "checked"; } ?> value="3"> 3<br>
Fawns:<input type="checkbox" name="fawn1" <?php if ($newAnCare->getFawns() > 0) { echo "checked"; } ?> value="1"> 1
<input type="checkbox" name="fawn2" <?php if ($newAnCare->getFawns() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="fawn3" <?php if ($newAnCare->getFawns() > 2) { echo "checked"; } ?> value="3"> 3<br>
Formula:<input type="checkbox" name="for1" <?php if ($newAnCare->getFormulas() > 0) { echo "checked"; } ?> value="1"> 1
<input type="checkbox" name="for2" <?php if ($newAnCare->getFormulas() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="for3" <?php if ($newAnCare->getFormulas() > 2) { echo "checked"; } ?> value="3"> 3<br>
Meals:<input type="checkbox" name="meal1" <?php if ($newAnCare->getMeals() > 0) { echo "checked"; } ?> value="1"> 1
<input type="checkbox" name="meal2" <?php if ($newAnCare->getMeals() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="meal3" <?php if ($newAnCare->getMeals() > 2) { echo "checked"; } ?> value="3"> 3<br>
Raptor Feed:<input type="checkbox" name="rapF1" <?php if ($newAnCare->getRaptorFeed() > 0) { echo "checked"; } ?> value="1"> 1
<input type="checkbox" name="rapF2" <?php if ($newAnCare->getRaptorFeed() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="rapF3" <?php if ($newAnCare->getRaptorFeed() > 2) { echo "checked"; } ?> value="3"> 3<br>
ISO: <input type="checkbox" name="iso1" <?php if ($newAnCare->getISO() > 0) { echo "checked"; } ?> value="1"> 1
<input type="checkbox" name="iso2" <?php if ($newAnCare->getISO() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="iso3" <?php if ($newAnCare->getISO() > 2) { echo "checked"; } ?> value="3"> 3</br></br>

Notes:</br>
<textarea rows="4" name="anCareNotes" cols="50" maxlength="255" placeholder="Enter notes here."><?php echo $newAnCare->getNotes(); ?></textarea>

<h1>Availability Fields</h1>

    Day of Week: <input type="checkbox" name="monday" value="1"> Monday
    <input type="checkbox" name="tuesday" value="2"> Tuesday
    <input type="checkbox" name="wednesday" value="3"> Wednesday
    <input type="checkbox" name="thursday" value="4"> Thursday
    <input type="checkbox" name="friday" value="5"> Friday
    <input type="checkbox" name="saturday" value="6"> Saturday
    <input type="checkbox" name="sunday" value="7"> Sunday</br>
    Season: <input type="checkbox" name="spring" value="1"> Spring
    <input type="checkbox" name="summer" value="2"> Summer
    <input type="checkbox" name="fall" value="3"> Fall
    <input type="checkbox" name="winter" value="4"> Winter
    </br>
    Start Time: <input type="time" name="startTime" value=""></br>
    End Time: <input type="time" name="endTime" value=""></br></br>

    <input type="submit" name="add" value="Add">
    <input type="submit" name="remove" value="Remove"></br>

    <?php
    $dayOfWeek = "";
    $season = "";
    $time = "";
    $entry = "";

    if (isset($_POST["add"])) {
        if(!empty($_POST["monday"])) {
            $monday = $_POST["monday"];
            $dayOfWeek .= " Monday,";
        }
        if(!empty($_POST["tuesday"])) {
            $tuesday = $_POST["tuesday"];
            $dayOfWeek .= " Tuesday,";
        }
        if(!empty($_POST["wednesday"])) {
            $wednesday = $_POST["wednesday"];
            $dayOfWeek .= " Wednesday,";
        }
        if(!empty($_POST["thursday"])) {
            $thursday = $_POST["thursday"];
            $dayOfWeek .= " Thursday,";
        }
        if(!empty($_POST["friday"])) {
            $friday = $_POST["friday"];
            $dayOfWeek .= " Friday,";
        }
        if(!empty($_POST["saturday"])) {
            $saturday = $_POST["saturday"];
            $dayOfWeek .= " Saturday,";
        }

        if(!empty($_POST["sunday"])) {
            $sunday = $_POST["sunday"];
            $dayOfWeek .= " Sunday,";
        }


        //season
        if(!empty($_POST["spring"])) {
            $spring = $_POST["spring"];
            $season .= " Spring,";
        }
        if(!empty($_POST["summer"])) {
            $summer = $_POST["summer"];
            $season .= " Summer,";
        }
        if(!empty($_POST["fall"])) {
            $fall = $_POST["fall"];
            $season .= " Fall,";
        }
        if(!empty($_POST["winter"])) {
            $winter = $_POST["winter"];
            $season .= " Winter,";
        }

        $startTime = $_POST["startTime"];
        $endTime = $_POST["endTime"];
        $time = $startTime . " - " . $endTime;

        $entry = $season . " | " . $dayOfWeek . " | " . $time . "\n";

    }
    ?>

    <textarea rows="10" name="availabilityDisplay" cols="70" maxlength="255" placeholder="Enter notes here."><?php echo $entry; ?></textarea></br>
    <input type="submit" name="submit" value="Submit"></br></br>
</form>
</body>
</html>

<?php

if(isset($_POST['save'])) {

    //send animalcare fields into the database
    $repRoom = null;
    if(isset($_POST["rep1"])) { if ($_POST["rep1"] != '') { $repRoom = $_POST["rep1"]; } }
    if(isset($_POST["rep2"])) { if ($_POST["rep2"] != '') { $repRoom = $_POST["rep2"]; } }
    if(isset($_POST["rep3"])) { if ($_POST["rep3"] != '') { $repRoom = $_POST["rep3"]; } }
    $newAnCare->setReptileRoom($repRoom);
    $repSoak = null;
    if(isset($_POST["repRm1"])) { if ($_POST["repRm1"] != '') { $repSoak = $_POST["repRm1"]; } }
    if(isset($_POST["repRm2"])) { if ($_POST["repRm2"] != '') { $repSoak = $_POST["repRm2"]; } }
    if(isset($_POST["repRm3"])) { if ($_POST["repRm3"] != '') { $repSoak = $_POST["repRm3"]; } }
    $newAnCare->setReptileSoak($repSoak);
    $snakeFeed = null;
    if(isset($_POST["snake1"])) { if ($_POST["snake1"] != '') { $snakeFeed = $_POST["snake1"]; } }
    if(isset($_POST["snake2"])) { if ($_POST["snake2"] != '') { $snakeFeed = $_POST["snake2"]; } }
    if(isset($_POST["snake3"])) { if ($_POST["snake3"] != '') { $snakeFeed = $_POST["snake3"]; } }
    $newAnCare->setSnakeFeed($snakeFeed);
    $ICU = null;
    if(isset($_POST["icu1"])) { if ($_POST["icu1"] != '') { $ICU = $_POST["icu1"]; } }
    if(isset($_POST["icu2"])) { if ($_POST["icu2"] != '') { $ICU = $_POST["icu2"]; } }
    if(isset($_POST["icu3"])) { if ($_POST["icu3"] != '') { $ICU = $_POST["icu3"]; } }
    $newAnCare->setICU($ICU);
    $exICU = null;
    if(isset($_POST["eicu1"])) { if ($_POST["eicu1"] != '') { $exICU = $_POST["eicu1"]; } }
    if(isset($_POST["eicu2"])) { if ($_POST["eicu2"] != '') { $exICU = $_POST["eicu2"]; } }
    if(isset($_POST["eicu3"])) { if ($_POST["eicu3"] != '') { $exICU = $_POST["eicu3"]; } }
    $newAnCare->setExICU($exICU);
    $aviary = null;
    if(isset($_POST["av1"])) { if ($_POST["av1"] != '') { $aviary = $_POST["av1"]; } }
    if(isset($_POST["av2"])) { if ($_POST["av2"] != '') { $aviary = $_POST["av2"]; } }
    if(isset($_POST["av3"])) { if ($_POST["av3"] != '') { $aviary = $_POST["av3"]; } }
    $newAnCare->setAviary($aviary);
    $mammals = null;
    if(isset($_POST["mam1"])) { if ($_POST["mam1"] != '') { $mammals = $_POST["mam1"]; } }
    if(isset($_POST["mam2"])) { if ($_POST["mam2"] != '') { $mammals = $_POST["mam2"]; } }
    if(isset($_POST["mam3"])) { if ($_POST["mam3"] != '') { $mammals = $_POST["mam3"]; } }
    $newAnCare->setMammals($mammals);
    $PUE = null;
    if(isset($_POST["pue1"])) { if ($_POST["pue1"] != '') { $PUE = $_POST["pue1"]; } }
    if(isset($_POST["pue2"])) { if ($_POST["pue2"] != '') { $PUE = $_POST["pue2"]; } }
    if(isset($_POST["pue3"])) { if ($_POST["pue3"] != '') { $PUE = $_POST["pue3"]; } }
    $newAnCare->setPUE($PUE);
    $PUEW = null;
    if(isset($_POST["puew1"])) { if ($_POST["puew1"] != '') { $PUEW = $_POST["puew1"]; } }
    if(isset($_POST["puew2"])) { if ($_POST["puew2"] != '') { $PUEW = $_POST["puew2"]; } }
    if(isset($_POST["puew3"])) { if ($_POST["puew3"] != '') { $PUEW = $_POST["puew3"]; } }
    $newAnCare->setPUEweigh($PUEW);
    $fawns = null;
    if(isset($_POST["fawn1"])) { if ($_POST["fawn1"] != '') { $fawns = $_POST["fawn1"]; } }
    if(isset($_POST["fawn2"])) { if ($_POST["fawn2"] != '') { $fawns = $_POST["fawn2"]; } }
    if(isset($_POST["fawn3"])) { if ($_POST["fawn3"] != '') { $fawns = $_POST["fawn3"]; } }
    $newAnCare->setFawns($fawns);
    $formula = null;
    if(isset($_POST["for1"])) { if ($_POST["for1"] != '') { $formula = $_POST["for1"]; } }
    if(isset($_POST["for2"])) { if ($_POST["for2"] != '') { $formula = $_POST["for2"]; } }
    if(isset($_POST["for3"])) { if ($_POST["for3"] != '') { $formula = $_POST["for3"]; } }
    $newAnCare->setFormulas($formula);
    $meals = null;
    if(isset($_POST["meal1"])) { if ($_POST["meal1"] != '') { $meals = $_POST["meal1"]; } }
    if(isset($_POST["meal2"])) { if ($_POST["meal2"] != '') { $meals = $_POST["meal2"]; } }
    if(isset($_POST["meal3"])) { if ($_POST["meal3"] != '') { $meals = $_POST["meal3"]; } }
    $newAnCare->setMeals($meals);
    $rapFeed = null;
    if(isset($_POST["rapF1"])) { if ($_POST["rapF1"] != '') { $rapFeed = $_POST["rapF1"]; } }
    if(isset($_POST["rapF2"])) { if ($_POST["rapF2"] != '') { $rapFeed = $_POST["rapF2"]; } }
    if(isset($_POST["rapF3"])) { if ($_POST["rapF3"] != '') { $rapFeed = $_POST["rapF3"]; } }
    $newAnCare->setRaptorFeed($rapFeed);
    $ISO = null;
    if(isset($_POST["iso1"])) { if ($_POST["iso1"] != '') { $ISO = $_POST["iso1"]; } }
    if(isset($_POST["iso2"])) { if ($_POST["iso2"] != '') { $ISO = $_POST["iso2"]; } }
    if(isset($_POST["iso3"])) { if ($_POST["iso3"] != '') { $ISO = $_POST["iso3"]; } }
    $newAnCare->setISO($ISO);
    $newAnCare->setNotes($_POST["anCareNotes"]);

    $repRoom = $newAnCare->getReptileRoom();
    $repSoak = $newAnCare->getReptileSoak();
    $snakeFeed = $newAnCare->getSnakeFeed();
    $ICU = $newAnCare->getICU();
    $exICU = $newAnCare->getExICU();
    $aviary = $newAnCare->getAviary();
    $mammals = $newAnCare->getMammals();
    $PUE =  $newAnCare->getPUE();
    $PUEW = $newAnCare->getPUEweigh();
    $fawns = $newAnCare->getFawns();
    $formula = $newAnCare->getFormulas();
    $meals = $newAnCare->getMeals();
    $rapFeed = $newAnCare->getRaptorFeed();
    $ISO = $newAnCare->getISO();
    $anCareNote = $newAnCare->getNotes();

    $sqlUpdate = "update animalcare set reptileRoom = ?, reptileSoak = ?, snakeFeed = ?, ICU = ?, exICU = ?, aviary = ?, "
    . "mammals = ?, PUE = ?, PUEweigh = ?, fawns = ?, formulas = ?, meals = ?, raptorFeed = ?, ISO = ?, notes = ? where ancareid = " . $_SESSION["personid"];
    $stmt = $conn->prepare($sqlUpdate);
    $stmt->bind_param("iiiiiiiiiiiiiis", $repRoom, $repSoak, $snakeFeed, $ICU, $exICU, $aviary, $mammals, $PUE, $PUEW, $fawns, $formula, $meals, $rapFeed, $ISO, $anCareNote);
    $stmt->execute();

    $record = $conn->affected_rows;
    if ($record > 0) {
        echo "New records updated successfully";
    }
    if (mysqli_errno($conn) != 0) {
        echo mysqli_errno($conn) . ": " . mysqli_error($conn) . "</br>";
    }


    //send treatment fields into the database
    if(isset($_POST["sMam"])) {
        $newTreatment->setSmMam($_POST["sMam"]);
    }
    if(isset($_POST["lMam"])) {
        $newTreatment->setLrgMam($_POST["lMam"]);;
    }
    if(isset($_POST["rvs"])) {
        $newTreatment->setRVS($_POST["rvs"]);
    }
    if(isset($_POST["eag"])) {
        $newTreatment->setEagle($_POST["eag"]);
    }
    if(isset($_POST["sRap"])) {
        $newTreatment->setSmRaptor($_POST["sRap"]);
    }
    if(isset($_POST["lRap"])) {
        $newTreatment->setLrgRaptor($_POST["lRap"]);
    }
    if(isset($_POST["rep"])) {
        $newTreatment->setReptile($_POST["rep"]);
    }
    if(isset($_POST["vet"])) {
        $newTreatment->setVet($_POST["vet"]);
    }
    if(isset($_POST["tech"])) {
        $newTreatment->setTech($_POST["tech"]);
    }
    if(isset($_POST["vetStu"])) {
        $newTreatment->setVetStudent($_POST["vetStu"]);
    }
    if(isset($_POST["techStu"])) {
        $newTreatment->setTechStudent($_POST["techStu"]);
    }
    if(isset($_POST["vetAs"])) {
        $newTreatment->setVetAssistant($_POST["vetAs"]);
    }
    if(isset($_POST["med"])) {
        $newTreatment->setMedicating($_POST["med"]);
    }
    if(isset($_POST["band"])) {
        $newTreatment->setBandaging($_POST["band"]);
    }
    if(isset($_POST["wCare"])) {
        $newTreatment->setWoundCare($_POST["wCare"]);
    }
    if(isset($_POST["diag"])) {
        $newTreatment->setDiag($_POST["diag"]);
    }
    if(isset($_POST["anthe"])) {
        $newTreatment->setAnesthesia($_POST["anthe"]);
    }
    $newTreatment->setNotes($_POST["treatmentNotes"]);

    $smMam = $newTreatment->getSmMam();
    $lrgMam = $newTreatment->getLrgMam();
    $rVS = $newTreatment->getRVS();
    $eag = $newTreatment->getEagle();
    $smRap = $newTreatment->getSmRaptor();
    $lrgRap = $newTreatment->getLrgRaptor();
    $rep = $newTreatment->getReptile();
    $vet = $newTreatment->getVet();
    $tech = $newTreatment->getTech();
    $vetStu = $newTreatment->getVetStudent();
    $techStu = $newTreatment->getTechStudent();
    $vetAs = $newTreatment->getVetAssistant();
    $med = $newTreatment->getMedicating();
    $band = $newTreatment->getBandaging();
    $wound = $newTreatment->getWoundCare();
    $diag = $newTreatment->getDiag();
    $anthe = $newTreatment->getAnesthesia();
    $treatNote = $newTreatment->getNotes();

    $sqlUpdate = "update treatment set smMam = ?, LrgMam = ?, RVS = ?, eagle = ?, SmRaptor = ?, LrgRaptor = ?, reptile = ?, "
            . "vet = ?, tech = ?, vetstudent = ?, techstudent = ?, vetassistant = ?, medicating = ?, bandaging = ?, woundcare = ?, "
            . "diag = ?, anesthesia = ?, notes = ? where treatmentid = " . $_SESSION["personid"];
    $stmt = $conn->prepare($sqlUpdate);
    $stmt->bind_param("iiiiiiiiiiiiiiiiis", $smMam, $lrgMam, $rVS, $eag, $smRap, $lrgRap, $rep, $vet, $tech, $vetStu, $techStu, $vetAs, $med, $band, $wound, $diag, $anthe, $treatNote);
    $stmt->execute();

    $record = $conn->affected_rows;
    if ($record > 0) {
        echo "New records updated successfully";
    }
    if (mysqli_errno($conn) != 0) {
        echo mysqli_errno($conn) . ": " . mysqli_error($conn) . "</br>";
    }


    //send transport fields into the database
    if(isset($_POST["capR"])) {
        $newTransport->setCaptureRestraint($_POST["capR"]);
    }
    $newTransport->setDistanceLimits($_POST["distance"]);
    $newTransport->setAnimalLimitsSA($_POST["anLimits"]);
    $newTransport->setNotes($_POST["transportNotes"]);

    $capR = $newTransport->getCaptureRestraint();
    $distance = $newTransport->getDistanceLimits() != '' ? $newTransport->getDistanceLimits() : null;
    $anLimits = $newTransport->getAnimalLimitsSA();
    $transportNotes = $newTransport->getNotes();

    $sqlUpdate = "update transport set capturerestraint = ?, distancelimits = ?, animallimits = ?, notes = ? where transportid = " . $_SESSION["personid"];
    $stmt = $conn->prepare($sqlUpdate);
    $stmt->bind_param("iiss", $capR, $distance, $anLimits, $transportNotes);
    $stmt->execute();


    //send front desk fields into the database
    $frntDskNotes = $_POST["frontDeskNotes"];

    $sqlUpdate = "update frontDesk set notes = ? where frntdskid = " . $_SESSION["personid"];
    $stmt = $conn->prepare($sqlUpdate);
    $stmt->bind_param("s", $frntDskNotes);
    $stmt->execute();
}


?>