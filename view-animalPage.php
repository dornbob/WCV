<?php
include("SQLConnection.php");
include("loginheader.php");
include("outreachClass.php");
include("animalCareClass.php");
include("treatmentClass.php");
include("transportClass.php");
$newSQL = new SQLConnection();
$conn = new mysqli($newSQL->getServerName(), $newSQL->getUserName(), $newSQL->getPassword(), $newSQL->getDB());




$sqlSelect = "select outreachid, shadowed, shodowed1, shadowed2, shadowed3, intro, leadalone, "
    . "offsite, notes from outreach where outreachid = " . $_SESSION["personid"];
$result = $conn->query($sqlSelect);
$newOutreach = new outreach();
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $newOutreach->setNumShadows($row["shadowed"]);
        $newOutreach->setShadowed1Date($row["shodowed1"]);
        $newOutreach->setShadowed2Date($row["shadowed2"]);
        $newOutreach->setShadowed3Date($row["shadowed3"]);
        $newOutreach->setIntro($row["intro"]);
        $newOutreach->setLeadAlone($row["leadalone"]);
        $newOutreach->setOffsite($row["offsite"]);
        $newOutreach->setNotes($row["notes"]);
    }
}
?>



<h1>Outreach Fields</h1>

Number of times shadowed:</br>
<p> Date of first shadow: <input type="date" name="dateShadow1" readonly value="<?php echo $newOutreach->getShadowed1Date(); ?>"></br>
    Date of second shadow: <input type="date" name="dateShadow2" readonly value="<?php echo $newOutreach->getShadowed2Date(); ?>"></br>
    Date of third shadow: <input type="date" name="dateShadow3" readonly value="<?php echo $newOutreach->getShadowed3Date(); ?>"></br></p>
Introduction:<input type="radio" name="intro" disabled value="1" <?php if ($newOutreach->getIntro() == 1) { echo "checked"; } ?>> Yes
<input type="radio" name="intro" disabled value="0"<?php if ($newOutreach->getIntro() == 0) { echo "checked"; } ?>> No</br>
Lead tour alone:<input type="radio" name="alone" disabled value="1"<?php if ($newOutreach->getLeadAlone() == 1) { echo "checked"; } ?>> Yes
<input type="radio" name="alone" disabled value="0"<?php if ($newOutreach->getLeadAlone() == 0) { echo "checked"; } ?>> No</br>
Offsite:<input type="radio" name="offsite" disabled value="1"<?php if ($newOutreach->getOffsite() == 1) { echo "checked"; } ?>> Yes
<input type="radio" name="offsite" disabled value="0"<?php if ($newOutreach->getOffsite() == 0) { echo "checked"; } ?>> No</br></br>
Notes:</br>
<textarea rows="4" name="outreachNotes" cols="50" maxlength="255" readonly placeholder="Enter notes here."><?php echo $newOutreach->getNotes(); ?></textarea>



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

Reptile Room: <input type="checkbox" name="rep1" disabled <?php if ($newAnCare->getReptileRoom() > 0) { echo "checked"; } ?> value="1"> 1
<input type="checkbox" name="rep2" disabled <?php if ($newAnCare->getReptileRoom() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="rep3" disabled <?php if ($newAnCare->getReptileRoom() > 2) { echo "checked"; } ?> value="3"> 3<br>
Reptile Room Soak Day:<input type="checkbox" name="repRm1" disabled <?php if ($newAnCare->getReptileSoak() > 0) { echo "checked"; } ?> value="1"> 1
<input type="checkbox" name="repRm2" disabled <?php if ($newAnCare->getReptileSoak() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="repRm3" disabled <?php if ($newAnCare->getReptileSoak() > 2) { echo "checked"; } ?> value="3"> 3<br>
Education Snake Feeding Day:<input type="checkbox" name="snake1" disabled <?php if ($newAnCare->getSnakeFeed() > 0) { echo "checked"; } ?> value="1"> 1
<input type="checkbox" name="snake2" disabled <?php if ($newAnCare->getSnakeFeed() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="snake3" disabled <?php if ($newAnCare->getSnakeFeed() > 2) { echo "checked"; } ?> value="3"> 3<br>
ICU:<input type="checkbox" name="icu1" disabled <?php if ($newAnCare->getICU() > 0) { echo "checked"; } ?> value="1"> 1
<input type="checkbox" name="icu2" disabled <?php if ($newAnCare->getICU() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="icu3" disabled <?php if ($newAnCare->getICU() > 2) { echo "checked"; } ?> value="3"> 3<br>
Expanded ICU:<input type="checkbox" disabled <?php if ($newAnCare->getExICU() > 0) { echo "checked"; } ?> name="eicu1" value="1"> 1
<input type="checkbox" name="eicu2" disabled <?php if ($newAnCare->getExICU() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="eicu3" disabled <?php if ($newAnCare->getExICU() > 2) { echo "checked"; } ?> value="3"> 3<br>
Aviary:<input type="checkbox" name="av1" disabled <?php if ($newAnCare->getAviary() > 0) { echo "checked"; } ?> value="1"> 1
<input type="checkbox" name="av2" disabled <?php if ($newAnCare->getAviary() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="av3" disabled <?php if ($newAnCare->getAviary() > 2) { echo "checked"; } ?> value="3"> 3<br>
Mammals:<input type="checkbox" name="mam1" disabled <?php if ($newAnCare->getMammals() > 0) { echo "checked"; } ?> value="1"> 1
<input type="checkbox" name="mam2" disabled <?php if ($newAnCare->getMammals() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="mam3" disabled <?php if ($newAnCare->getMammals() > 2) { echo "checked"; } ?> value="3"> 3<br>
PU & E:<input type="checkbox" name="pue1" disabled <?php if ($newAnCare->getPUE() > 0) { echo "checked"; } ?> value="1"> 1
<input type="checkbox" name="pue2" disabled <?php if ($newAnCare->getPUE() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="pue3" disabled <?php if ($newAnCare->getPUE() > 2) { echo "checked"; } ?> value="3"> 3<br>
PU & E Weigh Day:<input type="checkbox" name="puew1" disabled <?php if ($newAnCare->getPUEweigh() > 0) { echo "checked"; } ?> value="1"> 1
<input type="checkbox" name="puew2" disabled <?php if ($newAnCare->getPUEweigh() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="puew3" disabled <?php if ($newAnCare->getPUEweigh() > 2) { echo "checked"; } ?> value="3"> 3<br>
Fawns:<input type="checkbox" name="fawn1" disabled <?php if ($newAnCare->getFawns() > 0) { echo "checked"; } ?> value="1"> 1
<input type="checkbox" name="fawn2" disabled <?php if ($newAnCare->getFawns() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="fawn3" disabled <?php if ($newAnCare->getFawns() > 2) { echo "checked"; } ?> value="3"> 3<br>
Formula:<input type="checkbox" name="for1" disabled <?php if ($newAnCare->getFormulas() > 0) { echo "checked"; } ?> value="1"> 1
<input type="checkbox" name="for2" disabled <?php if ($newAnCare->getFormulas() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="for3" disabled <?php if ($newAnCare->getFormulas() > 2) { echo "checked"; } ?> value="3"> 3<br>
Meals:<input type="checkbox" name="meal1" disabled <?php if ($newAnCare->getMeals() > 0) { echo "checked"; } ?> value="1"> 1
<input type="checkbox" name="meal2" disabled <?php if ($newAnCare->getMeals() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="meal3" disabled <?php if ($newAnCare->getMeals() > 2) { echo "checked"; } ?> value="3"> 3<br>
Raptor Feed:<input type="checkbox" name="rapF1" disabled <?php if ($newAnCare->getRaptorFeed() > 0) { echo "checked"; } ?> value="1"> 1
<input type="checkbox" name="rapF2" disabled <?php if ($newAnCare->getRaptorFeed() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="rapF3" disabled <?php if ($newAnCare->getRaptorFeed() > 2) { echo "checked"; } ?> value="3"> 3<br>
ISO: <input type="checkbox" name="iso1" disabled <?php if ($newAnCare->getISO() > 0) { echo "checked"; } ?> value="1"> 1
<input type="checkbox" name="iso2" disabled <?php if ($newAnCare->getISO() > 1) { echo "checked"; } ?> value="2"> 2
<input type="checkbox" name="iso3" disabled <?php if ($newAnCare->getISO() > 2) { echo "checked"; } ?> value="3"> 3</br></br>

Notes:</br>
<textarea rows="4" name="anCareNotes" cols="50" maxlength="255" readonly placeholder="Enter notes here."><?php echo $newAnCare->getNotes(); ?></textarea>



<?php
$sqlSelect = "select capturerestraint, distancelimits, animallimits, notes from transport where transportid = " . $_SESSION["personid"];
$result = $conn->query($sqlSelect);
$newTransport = new transport();
if ($result->num_rows > 0) {
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

Capture and Restraint class: <input type="radio" name="capR" disabled <?php if ($newTransport->getCaptureRestraint() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="capR" disabled <?php if ($newTransport->getCaptureRestraint() == 0) { echo "checked"; } ?> value="0"> No</br>
Distance limits: <input type="number" name="distance" readonly value="<?php echo $newTransport->getDistanceLimits(); ?>"></br>
Animal Limitations:</br>
<textarea rows="4" name="anLimits" cols="50" maxlength="255" readonly placeholder="Enter limitations here."><?php echo $newTransport->getAnimalLimitsSA(); ?></textarea><br><br>
Notes:</br>
<textarea rows="4" name="transportNotes" cols="50" maxlength="255" readonly placeholder="Enter notes here."><?php echo $newTransport->getNotes(); ?></textarea>



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
Small Mammals: <input type="radio" name="sMam" disabled <?php if ($newTreatment->getSmMam() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="sMam" disabled <?php if ($newTreatment->getSmMam() == 0) { echo "checked"; } ?> value="0"> No</br>
Large Mammals: <input type="radio" name="lMam" disabled <?php if ($newTreatment->getLrgMam() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="lMam" disabled <?php if ($newTreatment->getLrgMam() == 0) { echo "checked"; } ?> value="0"> No</br>
RVS: <input type="radio" name="rvs" disabled <?php if ($newTreatment->getRVS() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="rvs" disabled <?php if ($newTreatment->getRVS() == 0) { echo "checked"; } ?> value="0"> No</br>
Eagles: <input type="radio" name="eag" disabled <?php if ($newTreatment->getEagle() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="eag" disabled <?php if ($newTreatment->getEagle() == 0) { echo "checked"; } ?> value="0"> No</br>
Small Raptors: <input type="radio" name="sRap" disabled <?php if ($newTreatment->getSmRaptor() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="sRap" disabled <?php if ($newTreatment->getSmRaptor() == 0) { echo "checked"; } ?> value="0"> No</br>
Large Raptors: <input type="radio" name="lRap" disabled <?php if ($newTreatment->getLrgRaptor() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="lRap" disabled <?php if ($newTreatment->getLrgRaptor() == 0) { echo "checked"; } ?> value="0"> No</br>
Reptiles: <input type="radio" name="rep" disabled <?php if ($newTreatment->getReptile() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="rep" disabled <?php if ($newTreatment->getReptile() == 0) { echo "checked"; } ?> value="0"> No</br>
Veterinarian: <input type="radio" name="vet" disabled <?php if ($newTreatment->getVet() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="vet" disabled <?php if ($newTreatment->getVet() == 0) { echo "checked"; } ?> value="0"> No</br>
Technician: <input type="radio" name="tech" disabled <?php if ($newTreatment->getTech() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="tech" disabled <?php if ($newTreatment->getTech() == 0) { echo "checked"; } ?> value="0"> No</br>
Veterinarian Student: <input type="radio" name="vetStu" disabled <?php if ($newTreatment->getVetStudent() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="vetStu" disabled <?php if ($newTreatment->getVetStudent() == 0) { echo "checked"; } ?> value="0"> No</br>
Technician Student: <input type="radio" name="techStu" disabled <?php if ($newTreatment->getTechStudent() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="techStu" disabled <?php if ($newTreatment->getTechStudent() == 0) { echo "checked"; } ?> value="0"> No</br>
Veterinarian Assistant: <input type="radio" name="vetAs" disabled <?php if ($newTreatment->getVetAssistant() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="vetAs" disabled <?php if ($newTreatment->getVetAssistant() == 0) { echo "checked"; } ?>value="0"> No</br>
Medicating: <input type="radio" name="med" disabled <?php if ($newTreatment->getMedicating() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="med" disabled <?php if ($newTreatment->getMedicating() == 0) { echo "checked"; } ?> value="0"> No</br>
Bandaging: <input type="radio" name="band" disabled <?php if ($newTreatment->getBandaging() == 1) { echo "checked"; } ?>value="1"> Yes
<input type="radio" name="band" disabled <?php if ($newTreatment->getBandaging() == 0) { echo "checked"; } ?> value="0"> No</br>
Wound Care: <input type="radio" name="wCare" disabled <?php if ($newTreatment->getWoundCare() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="wCare" disabled <?php if ($newTreatment->getWoundCare() == 0) { echo "checked"; } ?> value="0"> No</br>
Diagostics: <input type="radio" name="diag" disabled <?php if ($newTreatment->getDiag() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="diag" disabled <?php if ($newTreatment->getDiag() == 0) { echo "checked"; } ?> value="0"> No</br>
Anesthesia: <input type="radio" name="anthe" disabled <?php if ($newTreatment->getAnesthesia() == 1) { echo "checked"; } ?> value="1"> Yes
<input type="radio" name="anthe" disabled <?php if ($newTreatment->getAnesthesia() == 0) { echo "checked"; } ?> value="0"> No</br></br>

Notes:</br>
<textarea rows="4" name="treatmentNotes" cols="50" maxlength="255" readonly placeholder="Enter notes here."><?php echo $newTreatment->getNotes(); ?></textarea>


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
<textarea rows="4" name="frontDeskNotes" cols="50" maxlength="255" readonly placeholder="Enter notes here."><?php echo $frntDskNotes; ?></textarea>