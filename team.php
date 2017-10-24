<?php
include("SQLConnection.php");
include("loginheader.php");
include("outreachClass.php");
include("animalCareClass.php");
include("treatmentClass.php");
include("transportClass.php");

$profileID = $_SESSION["personid"];

if (isset($_SESSION["adminSearch"]))
{
    $profileID = $_SESSION["adminSearch"];
}

$newSQL = new SQLConnection();
$conn = $newSQL->makeConn();

//determine which types of volunteers the user is and then display the relevant information
$teamName = array();
$apStatus = array();
$sqlSelect = "select teamname, apstatus from team t inner join teamstatus ts on t.teamid = ts.teamid inner join person p "
    . "on ts.personid = p.personid where p.personid = " . $profileID;
$result = $conn->query($sqlSelect);
if ($result) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $teamName[] = $row["teamname"];
        $apStatus[] = $row["apstatus"];
    }
}

$anCare = 0;
$ftDesk = 0;
$outreach = 0;
$trans = 0;
$treat = 0;

for ($i = 0; $i < count($teamName); $i++) {
    if (strtolower($teamName[$i]) == 'animal care') {
        if (strtolower($apStatus[$i]) == 'active') {
            $anCare = 1;
        }
    } else if (strtolower($teamName[$i]) == 'front desk') {
        if (strtolower($apStatus[$i]) == 'active') {
            $ftDesk = 1;
        }
    } else if (strtolower($teamName[$i]) == 'outreach') {
        if (strtolower($apStatus[$i]) == 'active') {
            $outreach = 1;
        }
    } else if (strtolower($teamName[$i]) == 'transporter') {
        if (strtolower($apStatus[$i]) == 'active') {
            $trans = 1;
        }
    } else if (strtolower($teamName[$i]) == 'treatment') {
        if (strtolower($apStatus[$i]) == 'active') {
            $treat = 1;
        }
    }
}
?>

<h1>Team Page <span><small> <?php if($_SESSION["permission"] > 1) { echo '<a href="edit-profile.php"><button type="button">Edit</button></a></small></span>'; } ?></h1>
<div class="row">

    <!--<p>
    123 Main Street<br>
    Harrisonburg, VA<br>
    22801<br>
    <a href="mailto:someone@example.com?Subject=Hello%20again\" target=\"_top\">jimsemail@email.com</a></p>-->

    <!--Second column-->
    <?php
    if ($outreach == 1) {
    echo '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="team">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
				<div class="panel-heading" role="tab" id="headingOne">
						<h4 class="panel-title">
							Outreach
						</h4>
                </div>
				</a>
                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body profSize">';

                      $sqlSelect = "select concat(tl.firstname, ' ', tl.lastname) as 'name' from teamlead tl inner join "
                          . "team t on tl.teamLeadid = t.teamleadid inner join teamstatus ts on t.teamid = ts.teamid inner join "
                          . "person p on ts.personid = p.personid where teamname = 'outreach' and p.personid = " . $profileID;
                      $result = $conn->query($sqlSelect);
                      $teamLead = "";
                      if ($result) {
                          // output data of each row
                          while ($row = $result->fetch_assoc()) {
                              $teamLead = $row["name"];
                          }
                      }
                      echo '<div>
                          <h3>Team Leader</h3>
                          
                              <p>' . $teamLead . '</p>
                          
                      </div>';
                      $sqlSelect = "select outreachid, shadowed, shodowed1, shadowed2, shadowed3, intro, leadalone, "
                      . "offsite, notes from outreach where outreachid = " . $profileID;
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




                      echo "<h1>Outreach Fields</h1>
                      Number of times shadowed:   <span class='profResult'>" . $newOutreach->getNumShadows($row["shadowed"]) . "</span></br>
                      Date of first shadow:  <span class='profResult'>" . $newOutreach->getShadowed1Date() . "</span><br>
                      Date of second shadow:  <span class='profResult'>" . $newOutreach->getShadowed2Date() . "</span><br>
                      Date of third shadow:  <span class='profResult'>" . $newOutreach->getShadowed3Date() . "</span><br>
                      Introduction:   ";
                      if ($newOutreach->getIntro() == 1) { echo "<span class='profResult'>Yes</span>"; } else { echo "<span class='profResult'>No</span>"; }
                      echo "<br>Lead tour alone:   <span class='profResult'>";
                      if ($newOutreach->getLeadAlone() == 1) { echo "Yes"; } else { echo "No"; }
                      echo "</span><br>Offsite:   <span class='profResult'>";
                      if ($newOutreach->getOffsite() == 1) { echo "Yes"; } else { echo "No"; } echo "</span><br>";
                      echo "Animals Handled:<br />";
                      echo "<dl>";
                      $sql = "Select species, animalname from animal a inner join handling h on a.animalid=h.animalid inner join person p on h.handlingid=p.personid where personid=".$profileID;
                      //echo $sql;
                      $result = $conn->query($sql);
                      if($result->num_rows >0) {
                          while ($row = mysqli_fetch_assoc($result)) {
                              $animalname = $row['animalname'];
                              $species = $row['species'];
                              echo "<span class='profResult'>" . $animalname . "</span><br><span class='profResultTwo'>  -" . $species . "</span><br>";
                          }
                      }
                      if ($_SESSION["permission"] > 1) {
                          echo "</span><br>Notes:</br><span class='profResult'>" . $newOutreach->getNotes() . "</span>";
                      }
               echo "</div>
                </div>
            </div>"; }
    if ($anCare == 1) {
        echo '<div class="team">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
				<div class="panel-heading" role="tab" id="headingTwo">
				 <h4 class="panel-title">
                    Animal Care
                  </h4>
                </div>
				</a>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                  <div class="panel-body profSize">';

        $sqlSelect = "SELECT concat(tl.firstname, ' ', tl.lastname) AS 'name' FROM teamlead tl INNER JOIN "
            . "team t ON tl.teamLeadid = t.teamleadid INNER JOIN teamstatus ts ON t.teamid = ts.teamid INNER JOIN "
            . "person p ON ts.personid = p.personid WHERE teamname = 'animal care' AND p.personid = " . $profileID;
        $result = $conn->query($sqlSelect);
        $teamLead = "";
        if ($result) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $teamLead = $row["name"];
            }
        }
        echo '<div>
            <h3>Team Leader</h3>
            
                <p>' . $teamLead . '</p>
            
        </div>';
        $sqlSelect = "select shiftCommit, reaptileRoom, reptileSoak, snakeFeed, ICU, exICU, aviary, "
            . "mammals, PUE, PUEweigh, fawns, formulas, meals, raptorFeed, ISO, notes from animalcare where ancareid = " . $profileID;
        $result = $conn->query($sqlSelect);
        $newAnCare = new animalCare();
        if ($result) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $newAnCare->setShiftCommit($row["shiftCommit"]);
                $newAnCare->setReptileRoom($row["reaptileRoom"]);
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


        echo '<h1>Animal Care Fields</h1>

             Reptile Room:  <span class=\'profResult\'>' . $newAnCare->getReptileRoom() . '</span><br>' .
            'Reptile Room Soak Day:  <span class=\'profResult\'>' . $newAnCare->getReptileSoak() . '</span><br>' .
            'Education Snake Feeding Day:  <span class=\'profResult\'>' . $newAnCare->getSnakeFeed() . '</span><br>' .
            'ICU:  <span class=\'profResult\'>' . $newAnCare->getICU() . '</span><br>' .
            'Expanded ICU:  <span class=\'profResult\'>' . $newAnCare->getExICU() . '</span><br>' .
            'Aviary:  <span class=\'profResult\'>' . $newAnCare->getAviary() . '</span><br>' .
            'Mammals:  <span class=\'profResult\'>' . $newAnCare->getMammals() . '</span><br>' .
            'PU & E:  <span class=\'profResult\'>' . $newAnCare->getPUE() . '</span><br>' .
            'PU & E Weigh Day: <span class=\'profResult\'>' . $newAnCare->getPUEweigh() . '</span><br>' .
            'Fawns:  <span class=\'profResult\'>' . $newAnCare->getFawns() . '</span><br>' .
            'Formula:  <span class=\'profResult\'>' . $newAnCare->getFormulas() . '</span><br>' .
            'Meals:  <span class=\'profResult\'>' . $newAnCare->getMeals() . '</span><br>' .
            'Raptor Feed:  <span class=\'profResult\'>' . $newAnCare->getRaptorFeed() . '</span><br>' .
            'ISO:  <span class=\'profResult\'>' . $newAnCare->getISO() . '</span><br><br>';
            if ($_SESSION["permission"] > 1) {
                echo 'Notes:<br><span class=\'profResult\'>'
                    . $newAnCare->getNotes() . '</span>';
            }
             echo '</div>
                </div>
            </div>';
    }
if ($trans == 1) {
            echo '<div class="team">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
				<div class="panel-heading" role="tab" id="headingThree">
                  <h4 class="panel-title">Transport</h4>
                </div>
				</a>
                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                  <div class="panel-body profSize">';
                      $sqlSelect = "select concat(tl.firstname, ' ', tl.lastname) as 'name' from teamlead tl inner join "
                          . "team t on tl.teamLeadid = t.teamleadid inner join teamstatus ts on t.teamid = ts.teamid inner join "
                          . "person p on ts.personid = p.personid where teamname = 'transporter' and p.personid = " . $profileID;
                      $result = $conn->query($sqlSelect);
                      $teamLead = "";
                      if ($result) {
                          // output data of each row
                          while ($row = $result->fetch_assoc()) {
                              $teamLead = $row["name"];
                          }
                      }

                      echo '<div>
                          <h3>Team Leader</h3>
                          
                              <p>' . $teamLead . '</p>
                          
                      </div>';
                      $sqlSelect = "select capturerestraint, distancelimits, animallimits, notes from transport where transportid = " . $profileID;
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


                      echo '<h1>Transport Fields</h1>

                      Capture and Restraint class:  <span class=\'profResult\'>';
                      if ($newTransport->getCaptureRestraint() == 1) { echo "Yes"; } else { echo "No"; }
                      echo '</span></br>
                      Distance limits:  <span class=\'profResult\'>' . $newTransport->getDistanceLimits() . '</span></br>' .
                      'Animal Limitations:  <span class=\'profResult\'></br>' .
                      $newTransport->getAnimalLimitsSA() . '</span><br><br>';
                      if ($_SESSION["permission"] > 1) {
                          echo 'Notes:</br><span class=\'profResult\'>' .
                              $newTransport->getNotes() .
                              '</span>';
                      }
              echo '</div>
                </div>
            </div>';
}
if ($treat == 1) {
    echo '<div class="team">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
				<div class="panel-heading" role="tab" id="headingFour">
                      <h4 class="panel-title">Treatment</h4>
                </div>
				</a>
                <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                  <div class="panel-body profSize">';

    $sqlSelect = "SELECT concat(tl.firstname, ' ', tl.lastname) AS 'name' FROM teamlead tl INNER JOIN "
        . "team t ON tl.teamLeadid = t.teamleadid INNER JOIN teamstatus ts ON t.teamid = ts.teamid INNER JOIN "
        . "person p ON ts.personid = p.personid WHERE teamname = 'treatment team' AND p.personid = " . $profileID;
    $result = $conn->query($sqlSelect);
    $teamLead = "";
    if ($result) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $teamLead = $row["name"];
        }
    }

                      echo '<div>
                          <h3>Team Leader</h3>
                          
                              <p>' . $teamLead . '</p>
                          
                      </div>';
                      $sqlSelect = "select smMam, LrgMam, RVS, eagle, SmRaptor, LrgRaptor, reptile, vet, tech, vetstudent, techstudent, "
                          . "vetassistant, medicating, bandaging, woundcare, diag, anesthesia, notes from treatment where treatmentid = " . $profileID;
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

                      echo '<h1>Treatment Fields</h1>

                      Small Mammals:  <span class=\'profResult\'>';
                      if ($newTreatment->getSmMam() == 1) { echo "Yes"; } else { echo "No"; } echo '</span><br>
                      Large Mammals:  <span class=\'profResult\'>';
                      if ($newTreatment->getLrgMam() == 1) { echo "Yes"; } else { echo "No"; } echo '</span><br>
                      RVS:  <span class=\'profResult\'>';
                      if ($newTreatment->getRVS() == 1) { echo "Yes"; } else { echo "No"; } echo '</span><br>
                      Eagles:  <span class=\'profResult\'>';
                      if ($newTreatment->getEagle() == 1) { echo "Yes"; } else { echo "No"; } echo '</span><br>
                      Small Raptors:  <span class=\'profResult\'>';
                      if ($newTreatment->getSmRaptor() == 1) { echo "Yes"; } else { echo "No"; } echo '</span><br>
                      Large Raptors:  <span class=\'profResult\'>';
                      if ($newTreatment->getLrgRaptor() == 1) { echo "Yes"; } else { echo "No"; } echo '</span><br>
                      Reptiles:  <span class=\'profResult\'>';
                      if ($newTreatment->getReptile() == 1) { echo "Yes"; } else { echo "No"; } echo '</span><br>
                      Veterinarian:  <span class=\'profResult\'>';
                      if ($newTreatment->getVet() == 1) { echo "Yes"; } else { echo "No"; } echo '</span><br>
                      Technician:  <span class=\'profResult\'>';
                      if ($newTreatment->getTech() == 1) { echo "Yes"; } else { echo "No"; } echo '</span><br>
                      Veterinarian Student:  <span class=\'profResult\'>';
                      if ($newTreatment->getVetStudent() == 1) { echo "Yes"; } else { echo "No"; } echo '</span><br>
                      Technician Student:  <span class=\'profResult\'>';
                      if ($newTreatment->getTechStudent() == 1) { echo "Yes"; } else { echo "No"; } echo '</span><br>
                      Veterinarian Assistant:  <span class=\'profResult\'>';
                      if ($newTreatment->getVetAssistant() == 1) { echo "Yes"; } else { echo "No"; } echo '</span><br>
                      Medicating:  <span class=\'profResult\'>';
                      if ($newTreatment->getMedicating() == 1) { echo "Yes"; } else { echo "No"; } echo '</span><br>
                      Bandaging:  <span class=\'profResult\'>';
                      if ($newTreatment->getBandaging() == 1) { echo "Yes"; } else { echo "No"; } echo '</span><br>
                      Wound Care:  <span class=\'profResult\'>';
                      if ($newTreatment->getWoundCare() == 1) { echo "Yes"; } else { echo "No"; } echo '</span><br>
                      Diagostics:  <span class=\'profResult\'>';
                      if ($newTreatment->getDiag() == 1) { echo "Yes"; } else { echo "No"; } echo '</span><br>
                      Anesthesia:  <span class=\'profResult\'>';
                      if ($newTreatment->getAnesthesia() == 1) { echo "Yes"; } else { echo "No"; } echo '</span><br><br>';
                      if ($_SESSION["permission"] > 1) {
                          echo 'Notes:</br><span class=\'profResult\'>' .
                              $newTreatment->getNotes() .
                              '</span>';
                      }
               echo '</div>
                </div>
            </div>';
}
if ($ftDesk == 1) {
            echo '<div class="team">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
				<div class="panel-heading" role="tab" id="headingFive">
                      <h4 class="panel-title">Front Desk</h4>
                </div>
				</a>
                <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                  <div class="panel-body profSize">';
                      $sqlSelect = "select concat(tl.firstname, ' ', tl.lastname) as 'name' from teamlead tl inner join "
                          . "team t on tl.teamLeadid = t.teamleadid inner join teamstatus ts on t.teamid = ts.teamid inner join "
                          . "person p on ts.personid = p.personid where teamname = 'front desk' and p.personid = " . $profileID;
                      $result = $conn->query($sqlSelect);
                      $teamLead = "";
                      if ($result) {
                          // output data of each row
                          while ($row = $result->fetch_assoc()) {
                              $teamLead = $row["name"];
                          }
                      }

                      echo '<div>
                          <h3>Team Leader</h3>
                          
                              <p>' . $teamLead . '</p>
                          
                      </div>';

                      $sqlSelect = "select notes from frontDesk where frntdskid = " . $profileID;
                      $result = $conn->query($sqlSelect);
                      $frntDskNotes = null;
                      if ($result->num_rows > 0) {
                          // output data of each row
                          while ($row = $result->fetch_assoc()) {
                              $frntDskNotes = $row["notes"];
                          }
                      }

                      echo '<h1>Front Desk Fields</h1>';
                      echo 'Front desk training: ' . '<span class="profResult">  Yes</span><br>';
                      if ($_SESSION["permission"] > 1) {
                          echo 'Notes:</br><span class=\'profResult\'>'
                              . $frntDskNotes .
                              '</span>';
                      }
                  echo '</div>
                </div>
            </div>
          </div>';
}?>
</div><!--End row-->