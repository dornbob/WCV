<?php
include ("loginheader.php");
include ("SQLConnection.php");
include ("personclass.php");
include ("emergContactClass.php");
include ("documentClass.php");
include ("Email.php");
global $email;


$newSQL = new SQLConnection();
$conn = $newSQL->makeConn();
$personID = $_SESSION["personid"];
/*$sql = "select firstname,lastname,email from person p
inner join login l on p.personid = l.personid
where p.personid = ".$personID;*/

$sql = "select p.firstname,p.lastname,l.email,p.phone,street,housenumber,citycounty,stateabb,zipcode,rabiesshot,rehabpermit,rabiesOwnCost,
e.firstname as efirstname,e.lastname as elastname,e.phone as ephone,e.relationship 

from person p
inner join login l on p.personid = l.personid 
inner join emergcontact e on p.personid = e.personid
where p.personid = ".$personID;

$result = $newSQL->getResult($sql);

$animalCare = 1;
$frontDesk = 2;
$outreach = 3;
$transporter = 4;
$treatment = 5;

if ($result)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $firstName = $row["firstname"];
        $lastName = $row["lastname"];
        $email = $row["email"];
        $phone = $row["phone"];
        $houseNum = $row["housenumber"];
        $street = $row["street"];
        $cityCounty = $row["citycounty"];
        $stateAbb = $row["stateabb"];
        $zipCode = $row["zipcode"];
        $rabiesShot = $row["rabiesshot"];
        $rehabPermit = $row["rehabpermit"];
        $rabiesOwnShot = $row["rabiesOwnCost"];
        $emergencyFirstName = $row["efirstname"];
        $emergencyLastName = $row["elastname"];
        $emergencyPhone = $row["ephone"];
        $emergencyRelationship = $row["relationship"];

    }
}

$monCheck = "";
$tueCheck = "";
$wedCheck = "";
$thuCheck = "";
$friCheck = "";
$satCheck = "";
$sunCheck = "";

$sql = "select dow from availability where personid =".$personID;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $dow = $row['dow'];

        if (strpos($dow, 'sun') !== false) {
            $sunCheck = "checked";
        }
        if (strpos($dow, 'mon') !== false) {
            $monCheck = "checked";
        }
        if (strpos($dow, 'tue') !== false) {
            $tueCheck = "checked";
        }
        if (strpos($dow, 'wed') !== false) {
            $wedCheck = "checked";
        }
        if (strpos($dow, 'thu') !== false) {
            $thuCheck = "checked";
        }
        if (strpos($dow, 'fri') !== false) {
            $friCheck = "checked";
        }
        if (strpos($dow, 'sat') !== false) {
            $satCheck = "checked";
        }
    }
}

if (!empty($_POST)) {

    $phone = htmlspecialchars(["phoneNumber"]);
    $houseNum = htmlspecialchars($_POST["houseNumber"]);
    $street = htmlspecialchars($_POST["street"]);
    $cityCounty = htmlspecialchars($_POST["cityCounty"]);
    $stateAbb = htmlspecialchars($_POST["stateAbb"]);
    $zipCode = htmlspecialchars($_POST["zipCode"]);
    $rabiesShot = $_POST["rabiesShot"];
    $rabiesOwnShot = null;
    $rabiesdateQuery = "";
    $rehabPermit = $_POST["rehabPermit"];
    $permitType = null;
    $rabiesShotQuery = "";
    $permitTypeQuery = "";
    $emergencyFirstName = htmlspecialchars($_POST["emergencyFirstName"]);
    $emergencyLastName = htmlspecialchars($_POST["emergencyLastName"]);
    $emergencyPhone = htmlspecialchars($_POST["emergencyPhone"]);
    $emergencyRelationship = htmlspecialchars($_POST["emergencyRelationship"]);


    if ($rabiesShot == 1){
        $rabiesDocInput = "rabiesDoc";
        $rabiesdate = $_POST["rabiesdate"];
        $rabiesdateQuery = ",rabiesdate = '".$rabiesdate."'";
        $rabiesDoc = new Document();
        $rabiesDoc->uploadDocument($personID,$rabiesDocInput,"rabies document","na");
    }
    else{
        $rabiesOwnShot = $_POST["rabiesOwnShot"];
        $rabiesShotQuery = ",rabiesOwnCost =".$rabiesOwnShot;
    }

    if ($rehabPermit == 1 ){
        $permitType = $_POST["permitType"];
        $permitTypeQuery = ",permittype = '".$permitType."'";
    }

    $newPerson = new Person();

    $newPerson->setHouseNumber($houseNum);
    $newPerson->setStreet($street);
    $newPerson->setCityCounty($cityCounty);
    $newPerson->setStateAbb($stateAbb);
    $newPerson->setZip($zipCode);
    $newPerson->setPhone($phone);

    $phone = $newPerson->getPhone();
    $houseNum = $newPerson->getHouseNumber();
    $street = $newPerson->getStreet();
    $cityCounty = $newPerson->getCityCounty();
    $stateAbb = $newPerson->getStateAbb();
    $zipCode = $newPerson->getZip();

    $personUpdate = "update person set housenumber = ?, phone = ?,street = ?
    ,citycounty = ?,stateabb = ?,zipcode = ?, rabiesshot = ".$rabiesShot.$rabiesdateQuery.$rabiesShotQuery.$permitTypeQuery."
    ,rehabpermit = ".$rehabPermit." where personid = ".$personID;

    //echo $personUpdate;

    $stmt = $conn->prepare($personUpdate);
    $stmt->bind_param("isssss",$houseNum,$phone,$street,$cityCounty,$stateAbb,$zipCode);
    $stmt->execute();

    $updateEmergencyContact = "update emergcontact set firstname = ?,lastname = ?,phone = ?,relationship = ? 
      where personid =".$personID;

    $stmt =$conn->prepare($updateEmergencyContact);
    $stmt->bind_param("ssss",$emergencyFirstName,$emergencyLastName,$emergencyPhone,$emergencyRelationship);
    $stmt->execute();

    updateAvailability($personID);


    if (isset($_POST["animalCareSubmit"])){
        $handsOnSA = $_POST["handsOnSA"];
        $deadAnimalsSA = $_POST["deadAnimalsSA"];
        $livePreySA = $_POST["livePreySA"];
        $workOutsideSA = $_POST["workOutsideSA"];
        $liftWeights = (isset($_POST["liftWeights"])) ? $_POST["liftWeights"] : 0;
        $allergiesSA = $_POST["allergiesSA"];
        $shiftCommit = (isset($_POST["shiftCommit"])) ? $_POST["shiftCommit"] : 0;
        $rightsGroupSA = htmlspecialchars($_POST["rightsGroupSA"]);
        $hopeToLearnSA = htmlspecialchars($_POST["hopeToLearnSA"]);
        $passionateIssuesSA = htmlspecialchars($_POST["passionateIssuesSA"]);
        $anythingElseSA = htmlspecialchars($_POST["anythingElseSA"]);

        $sql = "select * from animalcare where ancareid =".$personID;
        $rows = getRowCount($sql);


        if ($rows < 1) {
            $animalCareQuery = "insert into animalcare (ancareid, handsOnSA, deadAnimalsSA, livePreySA, workOutsideSA, liftWeightsa, 
              allergiesSA, shiftCommit, rightsGroupSA, hopeToLearnSA, passionateIssuesSA, anythingElseSA)
              VALUES (" . $personID . ",?,?,?,?," . $liftWeights . ",?," . $shiftCommit . ",?,?,?,?)";
        }
        else {
            $animalCareQuery = "update animalcare set handsOnSA = ?,deadAnimalsSA = ?,livePreySA = ?,workOutsideSA = ?,liftWeightsa = ".$liftWeights.",
              allergiesSA = ?,shiftCommit =".$shiftCommit.",rightsGroupSA = ?,hopeToLearnSA = ?,passionateIssuesSA=?,anythingElseSA = ? where ancareid=".$personID;
        }

        //echo $animalCareQuery;
        $stmt = $conn->prepare($animalCareQuery);
        $stmt->bind_param("sssssssss", $handsOnSA, $deadAnimalsSA, $livePreySA, $workOutsideSA,
            $allergiesSA, $rightsGroupSA, $hopeToLearnSA, $passionateIssuesSA, $anythingElseSA);
        $stmt->execute();

        //echo $animalCareQuery.'<br>';
        teamStatusInsert($personID,$animalCare);
        $newDoc = new Document();

        if (!empty($_FILES["animalCareCover"]["name"])){
            $newDoc->uploadDocument($personID,"animalCareCover","cover letter","animal care");
        }


        if (!empty($_FILES["animalCareResume"]["name"])){
            $newDoc->uploadDocument($personID,"animalCareResume","resume","animal care");
        }


        if (!empty($_FILES["animalCareRec"]["name"])){
            $newDoc->uploadDocument($personID,"animalCareRec","letter of recommendation","animal care");
        }

        sendAppliedEmail('Animal Care', $email);
        sendEmailApplicationReview('Animal Care');

        header("Location:myapplications.php");

    }

    if (isset($_POST["outreachSubmit"])) {
        $outreachPassionateIssuesSA = htmlspecialchars($_POST["outreachPassionateIssuesSA"]);
        $outreachWhyInterestedSA = htmlspecialchars($_POST["outreachWhyInterestedSA"]);
        $publicSpeakingSA = htmlspecialchars($_POST["publicSpeakingSA"]);
        $whatDoYouBringSA = $_POST["whatDoYouBringSA"];

        $sql = "select * from outreach where outreachid =".$personID;
        $rows = getRowCount($sql);

        if ($rows<1) {
            $sql = "insert into outreach (outreachid,passionateIssuesSA,whyInterestedSA,publicSpeakingSA,whatDoYouBringSA)
            values (" . $personID . ",?,?,?,?)";
        }
        else{
            $sql = "update outreach set passionateIssuesSA = ?,whyInterestedSA = ?,publicSpeakingSA = ?,whatDoYouBringSA = ?
              where outreachid =".$personID;
        }
        //echo $sql;
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $outreachPassionateIssuesSA, $outreachWhyInterestedSA, $publicSpeakingSA, $whatDoYouBringSA);
        $stmt->execute();

        teamStatusInsert($personID, $outreach);
        $newDoc = new Document();

        if (!empty($_FILES["outreachCover"]["name"])) {
            $newDoc->uploadDocument($personID, "outreachCover", "cover letter", "outreach");
        }


        if (!empty($_FILES["outreachResume"]["name"])) {
            $newDoc->uploadDocument($personID, "outreachResume", "resume", "outreach");
        }


        if (!empty($_FILES["outreachRec"]["name"])) {
            $newDoc->uploadDocument($personID, "outreachRec", "letter of recommendation", "outreach");
        }

        sendAppliedEmail('Outreach', $email);
        sendEmailApplicationReview('Outreach');
        header("Location:myapplications.php");
    }

    if (isset($_POST["transportSubmit"])){
        $capturerestraint = 0;
        if(isset($_POST['capturerestraint'])){
            $capturerestraint = $_POST['capturerestraint'];
        }
        $howFarWillingSA = $_POST["howFarWillingSA"];
        $animallimits = $_POST['animallimits'];

        $sql = "select * from transport where transportid =".$personID;
        $rows = getRowCount($sql);

        if ($rows < 1) {
            $sql = "insert into transport (transportid, capturerestraint, howFarWillingSA, animallimits) VALUES (" . $personID . ",?,?,?)";
        }
        else {
            $sql = "update transport set capturerestraint = ?, howFarWillingSA = ?, animallimits = ? where transportid =".$personID;
        }

        //echo $sql;
        $stmt->prepare($sql);
        $stmt->bind_param("sss",$capturerestraint, $howFarWillingSA, $animallimits);
        $stmt->execute();

        teamStatusInsert($personID,$transporter);
        $newDoc = new Document();

        if (!empty($_FILES["transportCover"]["name"])){
            $newDoc->uploadDocument($personID,"transportCover","cover letter","transport");
        }


        if (!empty($_FILES["transportResume"]["name"])){
            $newDoc->uploadDocument($personID,"transportResume","resume","transport");
        }


        if (!empty($_FILES["transportRec"]["name"])){
            $newDoc->uploadDocument($personID,"transportRec","letter of recommendation","transport");
        }
        sendAppliedEmail('Transporter', $email);
        sendEmailApplicationReview('Transporter');
        header("Location:myapplications.php");

    }

    if (isset($_POST["treatmentSubmit"])){
        $medicalExperienceSA = $_POST["medicalExperienceSA"];
        $workEnvironment = $_POST["workEnvironmentSA"];
        $euthanasiaSA = $_POST["euthanasiaSA"];
        //$pooStruggleSA = $_POST["pooStruggleSA"];

        $sql = "select * from treatment where treatmentid =".$personID;
        $rows = getRowCount($sql);

        if ($rows<1) {
            $sql = "insert into treatment(treatmentid,medicalExperienceSA,workEnviromentSA,euthanasiaSA)
          VALUES (" . $personID . ",?,?,?)";
        }
        else {
            $sql = "update treatment set medicalExperienceSA = ?,workEnviromentSA = ?,euthanasiaSA = ? where treatmentid =".$personID;
        }

        $stmt->prepare($sql);
        $stmt->bind_param("sss",$medicalExperienceSA,$workEnvironment,$euthanasiaSA);
        $stmt->execute();

        teamStatusInsert($personID,$treatment);
        $newDoc = new Document();

        if (!empty($_FILES["treatmentCover"]["name"])){
            $newDoc->uploadDocument($personID,"treatmentCover","cover letter","treatment");
        }


        if (!empty($_FILES["treatmentResume"]["name"])){
            $newDoc->uploadDocument($personID,"treatmentResume","resume","treatment");
        }


        if (!empty($_FILES["treatmentRec"]["name"])){
            $newDoc->uploadDocument($personID,"treatmentRec","letter of recommendation","treatment");
        }
        sendAppliedEmail('Treatment', $email);
        sendEmailApplicationReview('Treatment');
        header("Location:myapplications.php");

    }


// passionateIssuesSA, whyInterestedSA, publicSpeakingSA, whatDoYOuBringSA
       // sendEmailApplicationReview('Animal Care');
}

//Function to get the persons email and name to send that they applied
function sendAppliedEmail($teamName, $email)
{
    //Declares variables
    $firstName = "";
    $lastName = "";
    
    //Gets the team lead email and name
    $newSQL = new SQLConnection();
    $conn = $newSQL->makeConn();
    $sql ="SELECT firstname, lastname FROM wcv.person INNER JOIN wcv.login on person.personid = login.personid WHERE login.email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc())
    {
        $firstName = $row['firstname'];
        $lastName = $row['lastname'];
    }
    $name = $firstName . " " . $lastName;
    //echo $email;
    //Creates a new email object and sends the email
    $newEmail = new Email();
    $newEmail ->setRecieverEmail($email);
    $newEmail ->setRecieverName($name);
    $newEmail ->sendApplied($teamName);
}

//Function to get the team lead email for application and send a review email
function sendEmailApplicationReview($teamName)
{
    //Declares variables
    $firstName = "";
    $lastName = "";
    $email = "";

    //Gets the team lead email and name
    $newSQL = new SQLConnection();
	$conn = $newSQL->makeConn();
    $sql ="SELECT l.email, tl.firstName, tl.lastName FROM login l inner join team t on l.teamLeadid = t.teamLeadid 
        inner join teamlead tl on tl.teamLeadid = t.teamLeadid where t.teamname = '$teamName'";

    $result = $conn->query($sql);
    while ($row = mysqli_fetch_assoc($result))
    {
        $email = $row['email'];
        $firstName = $row['firstName'];
        $lastName = $row['lastName'];
    }
    $name = $firstName . " " . $lastName;

    //Creates a new email object and sends the email
    $newEmail = new Email();
    $newEmail ->setRecieverEmail($email);
    $newEmail ->setRecieverName($name);
    $newEmail ->sendPendingApplication($teamName);

}

function getRowCount($sql){
    $newSQL = new SQLConnection();
    $result = $newSQL->getResult($sql);
    if ($result){
        $rows = $result->num_rows;
    }
    else{
        $rows= 0;
    }
    return $rows;
}

function teamStatusInsert($personid,$teamid){
    require_once("SQLConnection.php");
    $newSQL = new SQLConnection();
    $sql = "select * from teamstatus where teamid =".$teamid." and personid=".$personid;
    $rows = getRowCount($sql);

    echo $sql."<br>";
    echo "Rows: ".$rows;

    if ($rows === 0) { //only one insert into teamstatus per person
        $sql = "insert into teamstatus values (null," . $teamid . "," . $personid . ",'pending',CURRENT_DATE)";
        echo $sql;
        $newSQL->sendQuery($sql);
    }
}

function updateAvailability($personid){
    require_once ("SQLConnection.php");
    $newSQL = new SQLConnection();
    $sun = isset($_POST["availSun"])?"sun":null;
    $mon = isset($_POST["availMon"])?"mon":null;
    $tue = isset($_POST["availTue"])?"tue":null;
    $wed = isset($_POST["availWed"])?"wed":null;
    $thu = isset($_POST["availThu"])?"thu":null;
    $fri = isset($_POST["availFri"])?"fri":null;
    $sat = isset($_POST["availSat"])?"sat":null;
    $sql = "update availability set DOW = '".$sun.$mon.$tue.$wed.$thu.$fri.$sat."' where personid =".$personid;
    //echo $sql;
    $newSQL->sendQuery($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Apply | Wildlife Center Volunteers</title>
    <?php include("htmlHead.php")?>
  </head>

<body>
<?php include("navHeader.php");?>
<div class="container">
  <div class="row">
    <div class="col-sm-1">
        <!--Spacer-->
    </div>
    <div class="col-xs-12 col-sm-10 vellum">

        <h1>Volunteer Applications</h1>
		<a href="myapplications.php"><button class="btn btn-blue" style="float:right">My Applications</button></a>

        <div class="row">
            <form enctype="multipart/form-data" method="post" action="apply-specific.php">
            <div class="col-sm-4 personalapp">

                
				<div class="appblock">
					<h3>Personal Information</h3>
					First name: <?php echo $firstName?><br>
					Last name: <?php echo $lastName?><br>
					Email: <?php echo $email ?><br>
					Phone Number: <input required type="text" name="phoneNumber" placeholder="(xxx)xxx-xxxx" value="<?php if(isset($phone)){echo $phone;} ?>">
				</div>
                
				<div class="appblock">
					<h4>Address:</h4>
					House Number: <input required name="houseNumber" type="number" value="<?php if(isset($houseNum)){echo $houseNum;} ?>" ><br>
					Street: <input required name="street" type="text" value="<?php if(isset($street)){echo $street;} ?>"><br>
					City: <input name="cityCounty" type="text" value="<?php if(isset($cityCounty)){echo $cityCounty;} ?>"><br>
					State: 
						<?php
						
						$sql = "select stateAbb,stateName from homestate";
						$select = '<select name="stateAbb"';
						$result = $newSQL->getResult($sql);

						while ($row = mysqli_fetch_array($result))
						{
							if ($row["stateAbb"] == $stateAbb) {
								$select.='<option value="'.$row["stateAbb"].'" selected >'.$row["stateName"].'</option>';
							} else {
								$select.='<option value="'.$row["stateAbb"].'">'.$row["stateName"].'</option>';
							}
						}
						$select.='</select>';
						echo $select;
						
						?>
					<br>
					Zipcode: <input name="zipCode" type="number" value="<?php if(isset($zipCode)){echo $zipCode;} ?>">
				</div>

				<div class="appblock">
					Have you been vaccinated for rabies?<br>
					<input required id="yesRabies" name="rabiesShot" type="radio" value="1" onclick="javascript:yesNoRabies();" <?php if (isset($rabiesShot)){if ($rabiesShot==1){echo "checked";}} ?>>Yes<br>
					<input name="rabiesShot" type="radio" value="0" onclick="javascript:yesNoRabies();" <?php if (isset($rabiesShot)){if ($rabiesShot==0){echo "checked";}}?>>No<br>

					<div id="ifRabies" style="display:none">
						<br>If yes, please upload your rabies form.<br>
						<input id="rabiesDoc" name="rabiesDoc" type="file"><br>
						Please enter the date of your most recent rabies vaccination.<br>
						<input type="date" name="rabiesdate">
					</div>

					<div id="ifNoRabies" style="display:none;">
						<br>If not, are you willing to become vaccinated at your own cost?<br>
						<input name="rabiesOwnShot" value="1" type="radio" <?php if (isset($rabiesOwnShot)){if ($rabiesOwnShot==1){echo "checked";}} ?>>Yes<br>
						<input name="rabiesOwnShot" value="0" type="radio" <?php if (isset($rabiesOwnShot)){if ($rabiesOwnShot==0){echo "checked";}} ?>>No<br>
					</div>

					<script type="text/javascript">
						function yesNoRabies() {
							if (document.getElementById('yesRabies').checked) {
								document.getElementById('ifRabies').style.display = 'block';
								document.getElementById('ifNoRabies').style.display = 'none';
								document.getElementById('rabiesDoc').setAttribute("required","");
								//document.getElementById('rabiesOwnShot').removeAttribute("required");
							}
							else {
								document.getElementById('ifRabies').style.display = 'none';
								document.getElementById('ifNoRabies').style.display = 'block';
								document.getElementById('rabiesDoc').removeAttribute("required");
								document.getElementById('rabiesOwnShot').setAttribute("required","");
							}
						}

						function yesNoRehab() {
							if (document.getElementById('yesPermit').checked) {
								document.getElementById('ifPermit').style.display = 'block';
							}
							else document.getElementById('ifPermit').style.display = 'none';
						}
					</script>

					<br>Do you have a rehabilitation permit?<br>
					<input required id="yesPermit" name="rehabPermit" type="radio" value="1" onclick="yesNoRehab()" <?php if (isset($rehabPermit)){if ($rehabPermit==1){echo "checked";}} ?>>Yes<br>
					<input name="rehabPermit" type="radio" value="0" onclick="yesNoRehab()" <?php if (isset($rehabPermit)){if ($rehabPermit==0){echo "checked";}} ?>>No<br>

					<div id="ifPermit" style="display:none">
						<br>If so, please select the permit type below.<br>
						<select name="permitType">
							<option value="Cat 1">Category 1</option>
							<option value="Cat 2">Category 2</option>
							<option value="Cat 3">Category 3</option>
							<option value="Cat 4">Category 4</option>
						</select>
					</div>
				</div>
				
				
                <div class="appblock">
					What days are you available?<br>
					<input type="checkbox" name="availSun" value="sun" <?php echo $sunCheck ?>>Sunday
					<input type="checkbox" name="availMon" value="mon" <?php echo $monCheck ?>>Monday
					<input type="checkbox" name="availTue" value="tue" <?php echo $tueCheck ?>>Tuesday
					<input type="checkbox" name="availWed" value="wed" <?php echo $wedCheck ?>>Wednesday<br>
					<input type="checkbox" name="availThu" value="thu" <?php echo $thuCheck ?>>Thursday
					<input type="checkbox" name="availFri" value="fri" <?php echo $friCheck ?>>Friday
					<input type="checkbox" name="availSat" value="sat" <?php echo $satCheck ?>>Saturday
					<br>
					<h3>Emergency Contact</h3>
					First name:<br>
					<input required name="emergencyFirstName" type="text" value="<?php if(isset($emergencyFirstName)){echo $emergencyFirstName;} ?>"><br>
					Last name:<br>
					<input required name="emergencyLastName" type="text" value="<?php if(isset($emergencyLastName)){echo $emergencyLastName;} ?>"><br>
					Phone number:<br>
					<input required name="emergencyPhone" type="text" placeholder="(xxx)xxx-xxx" value="<?php if(isset($emergencyPhone)){echo $emergencyPhone;} ?>"><br>
					Relationship:<br>
					<input required name="emergencyRelationship" type="text" value="<?php if(isset($emergencyRelationship)){echo $emergencyRelationship;} ?>" >
				</div>
            </div><!--End column-->

            <div class="col-sm-6">

            <!--This dropdown determines what application shows up below-->
            <h3>Choose a volunteer type:</h3>
            <select id="volunteer_type">
            <option value="1">Animal Care</option>
              <option value="2">Outreach</option>
              <option value="3">Transport</option>
              <option value="4">Veterinary</option>
            </select>
            <button id="volunteer_type_submit" class="btn btn-blue" type="button" onclick="vtype()">See application</button>
            <!--Application form for specific types of volunteers-->
            <!--Each type is in a div that appears/disappears depending on what you pick in the dropdown above.-->
                <!--Animal care application-->
                <div id="animal_care">
                    <h3>Animal Care Application</h3>
                    <p>Animal care volunteers work closely with the rehabilitation staff as they perform daily tasks including meal preparation and daily feeding/watering; monitoring progress of patients; recording weights and food intake; cage set-up and maintaining proper environment; daily exercise of raptor patients; assisting staff with capture and restraint of patients; hand-feeding orphaned birds; cleaning, hosing, and scrubbing pens of all animals housed in indoor and outdoor enclosures; and general cleaning including sweeping/mopping floors, washing dishes, disinfecting counters/sinks. Pre-exposure rabies vaccination is required to work with all juvenile and adult mammals. Responsibilities increase with experience and demonstrated commitment.</p>
                    <p>Requirements: Animal care volunteers must be at least 18 years of age and able to commit to a minimum of one shift per week for either six months or one year. Shifts run from 8:00 a.m. to 1:00 p.m., seven days per week. Space is limited to one volunteer per shift.</p>

                    Please briefly describe your relevant hands-on experience with animals, if any. What did you enjoy about the experience? What did you dislike?<br>
                    <textarea name="handsOnSA" rows="4" cols="50" maxlength="255"></textarea><br>
                    <br>
                    Carnivorous patients are sometimes unable to eat food items whole due to their injuries; you may be required to cut and divide dead rodents, chicks, and fishes into smaller portions. Are you comfortable handling dead animals for this purpose?<br>
                    <textarea name="deadAnimalsSA" rows="4" cols="50" maxlength="255"></textarea><br>
                    <br>
                    Prior to release from the Wildlife Center, many predatory birds are presented with live mice in order to evaluate their ability to capture prey in a controlled and measurable environment. What is your opinion on using live-prey for this purpose?<br>
                    <textarea name="livePreySA" rows="4" cols="50" maxlength="255"></textarea><br>
                    <br>
                    Wildlife rehabilitation requires daily outdoor work -- year-round and regardless of weather conditions. Are you able to work outside during all seasons? If not, what are your limitations?<br>
                    <textarea name="workOutsideSA" rows="4" cols="50" maxlength="255"></textarea><br>
                    <br>
                    Are you able to lift 40 pounds on potentially uneven surfaces with minimal assistance?<br>
                    <input name="liftWeights"  type="radio" value="1">Yes<br>
                    <input name="liftWeights" type="radio" value="0">No<br>
                    <br>
                    Will you be able to commit to either a six-month or one-year schedule, with at least one shift (four hours) per week?<br>
                    <input name="shiftCommit"  type="radio" value="1">Yes<br>
                    <input name="shiftCommit" type="radio" value="0">No<br>
                    <br>
                    Do you belong to any animal rights groups (PETA, The Humane Society, etc.)?<br>
                    <input id="yesGroup" name="animalRights" onclick="yesNoGroups()" type="radio">Yes<br>
                    <input name="animalRights" onclick="yesNoGroups()" type="radio">No<br>
                    <br>

                    <div id="ifGroup" style="display:none">
                    If yes, which ones?
                        <textarea name="rightsGroupSA" rows="4" cols="50" maxlength="255" ></textarea>
                    </div>

                    <br>
                    <script type="text/javascript">
                        function yesNoGroups() {
                            if (document.getElementById('yesGroup').checked) {
                                document.getElementById('ifGroup').style.display = 'block';
                            }
                            else {
                                document.getElementById('ifGroup').style.display = 'none';
                            }
                        }
                    </script>

                    What do you hope to learn or accomplish by volunteering at the Wildlife Center of Virginia?<br>
                    <textarea name="hopeToLearnSA" rows="4" cols="50" maxlength="255"></textarea><br>
                    <br>
                    Please describe an environmental or wildlife-based issue you feel passionately about, and why:<br>
                    <textarea name="passionateIssuesSA" rows="4" cols="50" maxlength="255"></textarea><br>
                    <br>
                    Please list all food and animal allergies, if any:<br>
                    <textarea name="allergiesSA" rows="4" cols="50" maxlength="255"></textarea><br>
                    <br>
                    Is there anything else that you’d like us to know about yourself or your experience?<br>
                    <textarea name="anythingElseSA" rows="4" cols="50" maxlength="255"></textarea><br>
                    <br>
                    <strong>In order to be considered for a volunteer position, applicants must submit the following additional documents:</strong><br>
                    <br><strong>Resume and/or CV:</strong> This should include information about your education and relevant work history.<br>
                    <strong>Letter of Recommendation:</strong> The letter should be sent directly from your reference.<br>
                    <br>Cover Letter
                    <input name="animalCareCover" type="file"><br>
                    Resume
                    <input name="animalCareResume" type="file"><br>
                    Letter of Recommendation
                    <input name="animalCareRec" type="file"><br>


                    The Letter of Recommendation may be emailed to <a href="mailto:lmcdaniel@wildlifecenter.org">lmcdaniel@wildlifecenter.org</a> or mailed to:<br><br>
                    Linda McDaniel<br>
                    P.O. Box 1557<br>
                    Waynesboro, VA 22980<br>
                    <input type="submit" class="btn btn-blue" name="animalCareSubmit" value="Submit Application">
                </div>
                <!--End animal care application-->

                <!--Outreach volunteer application-->
                <div id="outreach">
                    <h3>Outreach Application</h3>
                        Why are you interested in volunteering as an outreach volunteer?<br>
                        <textarea name="outreachPassionateIssuesSA" rows="4" cols="50" maxlength="255"></textarea><br>
                        <br>
                        What’s an environmental or wildlife issue you feel passionately about, and why?<br>
                        <textarea name="outreachWhyInterestedSA" rows="4" cols="50" maxlength="255"></textarea><br>
                        <br>
                        Do you have prior experience speaking to the public? Please describe.<br>
                        <textarea name="publicSpeakingSA" rows="4" cols="50" maxlength="255"></textarea><br>
                        <br>
                        What do you think you’d bring to the outreach volunteer team?<br>
                        <textarea name="whatDoYouBringSA" rows="4" cols="50" maxlength="255"></textarea><br>
                        <br>
                        <strong>In order to be considered for a volunteer position, applicants must submit the following additional documents:</strong><br>
                        <br><strong>Resume and/or CV:</strong> This should include information about your education and relevant work history.<br>
                        <strong>Letter of Recommendation:</strong> The letter should be sent directly from your reference.<br>
                        <br>Cover Letter
                        <input name="outreachCover" type="file"><br>
                        Resume
                        <input name="outreachResume" type="file"><br>
                        Letter of Recommendation
                        <input name="outreachRec" type="file"><br>


                        The Letter of Recommendation may be emailed to <a href="mailto:lmcdaniel@wildlifecenter.org">lmcdaniel@wildlifecenter.org</a> or mailed to:<br><br>
                        Linda McDaniel<br>
                        P.O. Box 1557<br>
                        Waynesboro, VA 22980<br>
                    <input type="submit" class="btn btn-blue" name="outreachSubmit" value="Submit Application">
                </div>
                <!--End outreach application-->

                <!--Transporter application-->
                <div id="transport">
                    <h3>Transport Application</h3>
                    <p>Volunteer transporters provide a vital service to both the Wildlife Center of Virginia and the community by facilitating the rescue of wild animals. We appreciate that our volunteer transporters share the use of their vehicles, cost of gasoline, and valuable time to assist wildlife. Volunteer transporters provide a life-saving service.</p>

                    <p>If you’d like to join this pool of volunteers, please fill out this form. After we receive your application, we will send you an email with additional information. Unless you otherwise specify, we will add you to our active referral list immediately and you may be start receiving calls from the public for transport help right away, or you may not get any calls for six months or more.</p>

                    Would you be willing to assist with capturing animals, if needed?<br>
                    <input type="checkbox" name="capturerestraint" value="1">Yes</input><br>
                    <br>
                    How far are you willing to travel for transport (i.e., 30-45 miles from your location, to a specific location, etc)?<br>
                    <textarea name="howFarWillingSA" rows="4" cols="50" maxlength="255"></textarea><br>
                    <br>
                    Do you have any limits on which animals you are willing to handle?
                    <textarea name="animallimits" rows="4" cols="50" maxlength="255"></textarea><br>
                    <br>
                    <strong>In order to be considered for a volunteer position, applicants must submit the following additional documents:</strong><br>
                    <br><strong>Resume and/or CV:</strong> This should include information about your education and relevant work history.<br>
                    <strong>Letter of Recommendation:</strong> The letter should be sent directly from your reference.<br>
                    <br>Cover Letter
                    <input name="transportCover" type="file"><br>
                    Resume
                    <input name="transportResume" type="file"><br>
                    Letter of Recommendation
                    <input name="transportRec" type="file"><br>


                    The Letter of Recommendation may be emailed to <a href="mailto:lmcdaniel@wildlifecenter.org">lmcdaniel@wildlifecenter.org</a> or mailed to:<br><br>
                    Linda McDaniel<br>
                    P.O. Box 1557<br>
                    Waynesboro, VA 22980<br>
                    <input type="submit" class="btn btn-blue" name="transportSubmit" value="Submit Application">
                </div>
                <!--End transporter application-->

                <!--Veterinary application-->
                <div id="veterinary">
                    <h3>Veterinary Application</h3>
                    Please describe any previous medical or veterinary training you have completed.
                    <textarea name="medicalExperienceSA" rows="4" cols="50" maxlength="255"></textarea><br><br>
                    The case load at the Center can be unpredictable and vary greatly depending on the time of year.  Please describe the work environment that you work best in including how you best retain information that is taught to you.<br>
                    <textarea name="workEnvironmentSA" rows="4" cols="50" maxlength="255"></textarea><br><br>
                    The Center admits many trauma cases from all over the state.  In order for a patient to be released back into the wild it must be able to successfully survive on its own in the wild free of chronic pain or debilitation.  Due to this fact, the Center does humanely euthanize patients that do not meet this standard.  Do you have personal experience with euthanasia and how does it affect you?<br>
                    <textarea name="euthanasiaSA" rows="4" cols="50" maxlength="255"></textarea><br><br>

                    <strong>In order to be considered for a volunteer position, applicants must submit the following additional documents:</strong><br>
                    <br><strong>Resume and/or CV:</strong> This should include information about your education and relevant work history.<br>
                    <strong>Letter of Recommendation:</strong> The letter should be sent directly from your reference.<br>
                    <br>Cover Letter
                    <input name="treatmentCover" type="file"><br>
                    Resume
                    <input name="treatmentResume" type="file"><br>
                    Letter of Recommendation
                    <input name="treatmentRec" type="file"><br>

                    <input type="submit" class="btn btn-blue" name="treatmentSubmit" value="Submit Application">
                </div>
                <!--End veterinary application-->
            </div><!--End collumn-->
            </form>
        </div><!--End row-->
        </div><!--End column-->
  	</div><!--End row-->

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