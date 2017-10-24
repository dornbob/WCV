<?php
include("loginheader.php");
require("SQLConnection.php");
include("adminHeader.php");
unset($_SESSION["adminSearch"]);

if (isset($_POST["search"])) {
    $newSQL = new SQLConnection();
	$conn = $newSQL->makeConn();
	
    $sql = "select distinct p.personid,firstname,middlename,lastname,email,filelocation,teamname from availability avail 
          inner join person p on avail.personid=p.personid
          inner join documents d on p.personid=d.personid 
          inner join login l on p.personid = l.personid 
          inner join teamstatus ts on p.personid = ts.personid 
          inner join team t on ts.teamid = t.teamid";
    $clause = " where ";

    if (!empty($_POST["nameSearch"])) {
        $fullName = $_POST["nameSearch"];
        $space = strpos($fullName, " ");

        if (empty($space)) {
            $firstName = $fullName;
        } else {
            $firstName = substr($fullName, 0, $space);
            echo "<br/>FirstName:" . $firstName;

            $lastName = substr($fullName, $space);
            echo "<br/>LastName:" . $lastName . "<br/>";

        }

        $sql .= $clause . "(firstname like '%" . $firstName . "%' or lastname like '%" . $firstName . "%'";
        $clause = " and ";

        if (!empty($lastName)) {
            $sql .= $clause . "lastname like '%" . $lastName . "%' or firstname like '%" . $lastName . "%'";
        }
        $sql.=")"; //close parenthesis
    }

    if (isset($_POST["Type"])) {
        $type = $_POST["Type"];
        $parenthesis = "(";
        foreach ($type as $type => $t) {
            if (!empty($t)) {
                $sql .= $clause . $parenthesis . "teamname='" . $t . "'";
                $clause = " or ";
                $parenthesis = "";
            }
        }
        $sql.=")";
        $clause = " and ";
    }

    if (isset($_POST['DOW'])){
        $dow = $_POST['DOW'];
        $parenthesis = "(";
        foreach ($dow as $dow => $d) {
            if (!empty($d)) {
                $sql .= $clause . $parenthesis . "dow like '%" . $d . "%'";
                $clause = " or ";
                $parenthesis = "";
            }
        }
        $sql.=")";
        $clause = " and ";
    }

    if (isset($_POST['Season'])){
        $season = $_POST['Season'];
        $parenthesis = "(";
        foreach ($season as $season => $s) {
            if (!empty($s)) {
                $sql .= $clause . $parenthesis . "season like '%" . $s . "%'";
                $clause = " or ";
                $parenthesis = "";
            }
        }
        $sql.=")";
        $clause = " and ";
    }

    if (isset($_POST['Rabies'])){
        $rabies = $_POST['Rabies'];
        $parenthesis = "(";
        foreach ($rabies as $rabies => $r) {
            if (!is_null($r)) {
                $sql .= $clause . $parenthesis . "rabiesshot ='" . $r . "'";
                $clause = " or ";
                $parenthesis = "";
            }
        }
        $sql.=")";
        $clause = " and ";
    }

    if (isset($_POST['Activity'])){
        $activity = $_POST['Activity'];
        $parenthesis = "(";
        foreach ($activity as $activity => $a) {
            if (!is_null($a)) {
                $sql .= $clause . $parenthesis . "apstatus ='" . $a . "'";
                $clause = " or ";
                $parenthesis = "";
            }
        }
        $sql.=")";
        $clause = " and ";
    }

    if ($clause != ' where ') {
        $clause = " and ";
    }
    $sql .=$clause . "(docName = 'profilepicture') and (apstatus like '%active') order by p.lastname";

    //echo $sql;
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("htmlHead.php")?>
	
	<title>Search | Wildlife Center Volunteers</title>
<!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Caveat+Brush" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Arimo|Caveat+Brush" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Arbutus+Slab" rel="stylesheet">

    <!--Leave this area commented!-->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  
  <body>
  <?php  include ("navHeader.php"); ?>
<div class="container">

	

  <div class="row">
    <div class="col-sm-1">
    <!--Spacer-->
    </div> 
    <div class="col-xs-12 col-sm-10 vellum">

        <?php
        
        $newSQL = new SQLConnection();
		$conn = $newSQL->makeConn();

        global $outreachCount;
            $outreachCount = 0;
        global $animalCareCount;
            $animalCareCount = 0;
        global $transportCount;
            $transportCount = 0;
        global $treatmentCount;
            $treatmentCount = 0;
        global $frontDeskCount;
            $frontDeskCount = 0;
        global $monCount;
            $monCount = 0;
        global $tueCount;
            $tueCount = 0;
        global $wedCount;
            $wedCount = 0;
        global $thuCount;
            $thuCount = 0;
        global $friCount;
            $friCount = 0;
        global $satCount;
            $satCount = 0;
        global $sunCount;
            $sunCount = 0;
        global $rabiesCount;
        $rabiesCount = 0;
        global $noRabiesCount;
        $noRabiesCount = 0;
        global $willingCount;
        $willingCount = 0;
        global $summerCount;
        $summerCount = 0;
        global $fallCount;
        $fallCount = 0;
        global $winterCount;
        $winterCount = 0;
        global $springCount;
        $springCount = 0;
        global $cat1Count;
        $cat1Count = 0;
        global $cat2Count;
        $cat2Count = 0;
        global $cat4Count;
        $cat4Count = 0;
        global $activeCount;
        $activeCount = 0;
        global $inactiveCount;
        $inactiveCount=0;

        $sql2 = "select count(ts.personid) from teamstatus ts inner join team t on ts.teamid=t.teamid where t.teamname = 'Outreach' and ts.apstatus like '%active'";
        $result = $conn->query($sql2);
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $outreachCount = $row['count(ts.personid)'];
            }
        }

        $sql2 = "select count(ts.personid) from teamstatus ts inner join team t on ts.teamid=t.teamid where t.teamname = 'Animal Care' and ts.apstatus like '%active'";
        $result = $conn->query($sql2);
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $animalCareCount = $row['count(ts.personid)'];
            }
        }

        $sql2 = "select count(ts.personid) from teamstatus ts inner join team t on ts.teamid=t.teamid where t.teamname = 'Transporter' and ts.apstatus like '%active'";
        $result = $conn->query($sql2);
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $transportCount = $row['count(ts.personid)'];
            }
        }

        $sql2 = "select count(ts.personid) from teamstatus ts inner join team t on ts.teamid=t.teamid where t.teamname = 'Treatment' and ts.apstatus like '%active'";
        $result = $conn->query($sql2);
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $treatmentCount = $row['count(ts.personid)'];
            }
        }

        $sql2 = "select count(ts.personid) from teamstatus ts inner join team t on ts.teamid=t.teamid where t.teamname = 'Front Desk' and ts.apstatus like '%active'";
        $result = $conn->query($sql2);
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $frontdeskCount = $row['count(ts.personid)'];
            }
        }

        $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
	                              ts.personid = p.personid inner join availability a on p.personid = 
                                   a.personid where a.dow like '%mon%' and ts.apstatus like 
                                  '%active'";
        $result = $conn->query($sql2);
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $monCount = $row['count(distinct ts.personid)'];
            }
        }

        $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
	                              ts.personid = p.personid inner join availability a on p.personid = 
                                   a.personid where a.dow like '%tue%' and ts.apstatus like 
                                  '%active'";
        $result = $conn->query($sql2);
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $tueCount = $row['count(distinct ts.personid)'];
            }
        }

        $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
	                              ts.personid = p.personid inner join availability a on p.personid = 
                                   a.personid where a.dow like '%wed%' and ts.apstatus like 
                                  '%active'";
        $result = $conn->query($sql2);
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $wedCount = $row['count(distinct ts.personid)'];
            }
        }

        $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
	                              ts.personid = p.personid inner join availability a on p.personid = 
                                   a.personid where a.dow like '%thu%' and ts.apstatus like 
                                  '%active'";
        $result = $conn->query($sql2);
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $thuCount = $row['count(distinct ts.personid)'];
            }
        }

        $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
	                              ts.personid = p.personid inner join availability a on p.personid = 
                                   a.personid where a.dow like '%fri%' and ts.apstatus like 
                                  '%active'";
        $result = $conn->query($sql2);
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $friCount = $row['count(distinct ts.personid)'];
            }
        }

        $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
	                              ts.personid = p.personid inner join availability a on p.personid = 
                                   a.personid where a.dow like '%sat%' and ts.apstatus like 
                                  '%active'";
        $result = $conn->query($sql2);
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $satCount = $row['count(distinct ts.personid)'];
            }
        }

        $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
	                              ts.personid = p.personid inner join availability a on p.personid = 
                                   a.personid where a.dow like '%sun%' and ts.apstatus like 
                                  '%active'";
        $result = $conn->query($sql2);
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $sunCount = $row['count(distinct ts.personid)'];
            }
        }

        $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
	                              ts.personid = p.personid inner join availability a on p.personid = 
                                   a.personid where a.season like '%sum%' and ts.apstatus like 
                                  '%active'";
        $result = $conn->query($sql2);
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $summerCount = $row['count(distinct ts.personid)'];
            }
        }

        $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
	                              ts.personid = p.personid inner join availability a on p.personid = 
                                   a.personid where a.season like '%fall%' and ts.apstatus like 
                                  '%active'";
        $result = $conn->query($sql2);
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $fallCount = $row['count(distinct ts.personid)'];
            }
        }

        $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
	                              ts.personid = p.personid inner join availability a on p.personid = 
                                   a.personid where a.season like '%win%' and ts.apstatus like 
                                  '%active'";
        $result = $conn->query($sql2);
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $winterCount = $row['count(distinct ts.personid)'];
            }
        }

        $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
	                              ts.personid = p.personid inner join availability a on p.personid = 
                                   a.personid where a.season like '%spr%' and ts.apstatus like 
                                  '%active'";
        $result = $conn->query($sql2);
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $springCount = $row['count(distinct ts.personid)'];
            }
        }

        $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
                                    ts.personid = p.personid where p.rabiesshot = 1 and ts.apstatus like 
                                    '%active'";
        $result = $conn->query($sql2);
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $rabiesCount = $row['count(distinct ts.personid)'];
            }
        }

        $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
                                    ts.personid = p.personid where p.rabiesshot = 0 and ts.apstatus like 
                                    '%active'";
        $result = $conn->query($sql2);
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $noRabiesCount = $row['count(distinct ts.personid)'];
            }
        }

        $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
                                    ts.personid = p.personid where p.rabiesowncost = 1 and ts.apstatus like 
                                    '%active'";
        $result = $conn->query($sql2);
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $willingCount = $row['count(distinct ts.personid)'];
            }
        }

        $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
                                    ts.personid = p.personid where p.permittype = 'cat 1' and ts.apstatus like 
                                    '%active'";
        $result = $conn->query($sql2);
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $cat1Count = $row['count(distinct ts.personid)'];
            }
        }

        $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
                                    ts.personid = p.personid where p.permittype = 'cat 2' and ts.apstatus like 
                                    '%active'";
        $result = $conn->query($sql2);
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $cat2Count = $row['count(distinct ts.personid)'];
            }
        }

        $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
                                    ts.personid = p.personid where p.permittype = 'cat 4' and ts.apstatus like 
                                    '%active'";
        $result = $conn->query($sql2);
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $cat4Count = $row['count(distinct ts.personid)'];
            }
        }

        $sql2 = "select count(distinct personid) from teamstatus where apstatus = 'active'";
        $result = $conn->query($sql2);
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $activeCount = $row['count(distinct personid)'];
            }
        }

        $sql2 = "select count(distinct personid) from teamstatus where apstatus = 'inactive'";
        $result = $conn->query($sql2);
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $inactiveCount = $row['count(distinct personid)'];
            }
        }
        
?>

    <h1>Search Volunteers</h1>
    <!--<a href="adminhome.php" class="back">Back to homepage</a>-->

  	<div class="row">
    <form action="search.php" method="post">
      <!--Sidebar with checkboxes-->
  	   <div class="col-sm-5">
          <!--Search box-->
			<input type="text" id="search_box" name="nameSearch" placeholder="Name"><br>
           <input type="submit" name="search" value="Search">
           <input type="submit" name="inactive" value="Check for Inactivity">
           <input type="submit" name="mail" value="Send mail to...">
           <?php
           if(isset($_POST['inactive'])) {
               $sqlSelect = "select distinct p.personid, firstname, lastname from person p inner join teamstatus ts on p.personid=ts.personid where apstatus != 'inactive' and datediff(current_date(), lastoutDate) >365";
               $result = $conn->query($sqlSelect);
               if ($result->num_rows > 0) {
                   echo "<br />These people have not been active within the year:<br />";
                   while ($row = mysqli_fetch_assoc($result)) {
                       $fn = $row['firstname'];
                       $ln = $row['lastname'];
                       $pID = $row['personid'];

                       echo "<br /><input type='checkbox' name='change[]' value='" . $pID . "'>";
                       echo "  -" . $fn . " " . $ln;
                   }
                   echo "<br /><input type='submit' name='changestatus' value='Change Status to Inactive'>";


               } else {
                   echo "<br />There are no new inactive people. <br />";
               }
           }
           $sqlSelect = "";
               if(isset($_POST['changestatus'])){

                   if (isset($_POST['change'])) {
                       //echo "help";
                       $change = $_POST['change'];

                       $sqlSelect = "update teamstatus set apstatus='inactive' where ";
                       $clause = "";
                       foreach ($change as $change => $r) {
                           if (!is_null($r)) {
                               $sqlSelect .= $clause . "personid ='" . $r . "'";
                               $clause = " and ";
                               $parenthesis = "";
                           }
                       }
                       $clause = " and ";
                       $result = $conn->query($sqlSelect);

                   }
               }




           ?>

          <!--Searchable criteria by category-->
          <div class="category">
            <h3>Volunteer Type</h3>
            <div class="checkbox">
              <label><input type="checkbox" name="Type[]" value="outreach">Outreach</label><span class="badge"><?php echo $outreachCount;?></span>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" name="Type[]" value="animal care">Animal Care</label><span class="badge"><?php echo $animalCareCount;?></span>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" name="Type[]" value="transporter">Transport</label><span class="badge"><?php echo $transportCount;?></span>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" name="Type[]" value="treatment">Vet/Treatment</label><span class="badge"><?php echo $treatmentCount;?></span>
            </div>
              <div class="checkbox">
                  <label><input type="checkbox" name="Type[]" value="front desk">Front Desk</label><span class="badge"><?php echo $frontdeskCount;?></span>
              </div>
          </div>
<hr class="hr-line">
          <div class="category">
            <h3>Available Days</h3>
            <div class="checkbox">
              <label><input type="checkbox" name="DOW[]" value="mon">Mondays</label><span class="badge"><?php echo $monCount;?></span>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" name="DOW[]" value="tue">Tuesdays</label><span class="badge"><?php echo $tueCount;?></span>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" name="DOW[]" value="wed">Wednesdays</label><span class="badge"><?php echo $wedCount;?></span>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" name="DOW[]" value="thu">Thursdays</label><span class="badge"><?php echo $thuCount;?></span>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" name="DOW[]" value="fri">Fridays</label><span class="badge"><?php echo $friCount;?></span>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" name="DOW[]" value="sat">Saturdays</label><span class="badge"><?php echo $satCount;?></span>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" name="DOW[]" value="sun">Sundays</label><span class="badge"><?php echo $sunCount;?></span>
            </div>
          </div>
<hr class="hr-line">
          <div class="category">
            <h3>Rabies</h3>
            <div class="checkbox">
              <label><input type="checkbox" name="Rabies[]" value="1">Vaccinated</label><span class="badge"><?php echo $rabiesCount;?></span>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" name="Rabies[]" value="0">Not Vaccinated</label><span class="badge"><?php echo $noRabiesCount;?></span>
            </div>
            <!--<div class="checkbox">
              <label><input type="checkbox" value="">Willing to Pay</label><span class="badge"><?php //echo $willingCount;?></span>
            </div>-->
          </div>

          <!--<div class="category">
            <h3>Rehab Permit Type</h3>
            <div class="checkbox">
              <label><input type="checkbox" value="">Cat 1</label><span class="badge"><?php //echo $cat1Count;?></span>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" value="">Cat 2</label><span class="badge"><?php //echo $cat2Count;?></span>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" value="">Cat 4</label><span class="badge"><?php //echo $cat4Count;?></span>
            </div>
          </div>-->
<hr class="hr-line">
           <div class="category">
               <h3>Activity</h3>
               <div class="checkbox">
                   <label><input type="checkbox" name="Activity[]" value="active">Active</label><span class="badge"><?php echo $activeCount;?></span>
               </div>
               <div class="checkbox">
                   <label><input type="checkbox" name="Activity[]" value="inactive">Inactive</label><span class="badge"><?php echo $inactiveCount;?></span>
               </div>
           </div>

           <a href="excel.php"><button type="button" class="btn btn-blue">DownLoad Excel</button></a><br>
           <a href="Tableau.php"><button type="button" class="btn btn-blue">Tableau</button></a>
    </form>
       </div>

      <!--List of volunteers appears here-->
      <div class="col-sm-7">
		<p>Click "search" to see all volunteers.</p>
      <?php
            if($_SESSION['emailArray']==null){$_SESSION['emailArray']= array();}

        if (isset($_POST["search"])) {
            //echo "<input type=\"submit\" name=\"mail\" value=\"Send mail to...\">";
            $_SESSION['emailArray']= array();
            $firstname = "";
            $middlename = "";
            $lastname = "";
            $email = "";
            $num1 = "";
            $num2 = "";
            $num3 = "";
            $num4 = "";
            $num5 = "";
            $animalcare = "";
            $treatment = "";
            $transport = "";
            $outreach = "";
            $frontdesk = "";
            $inactive = "";
            $profilePic = "";
            $teamname = "";
            $volBox1 = "";
            $volBox2 = "turd ferguson";
            $id1 = "";


            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($result)) {

                    $num1 = "";
                    $num2 = "";
                    $num3 = "";
                    $num4 = "";
                    $num5 = "";
                    $animalcare = "";
                    $treatment = "";
                    $transport = "";
                    $outreach = "";
                    $frontdesk = "";
                    $inactive = "";
                    $profilePic = "";
                    $teamname = "";

                    $id = $row['personid'];
                    $firstname = $row['firstname'];
                    $middlename = $row['middlename'];
                    $lastname = $row['lastname'];
                    $email = $row['email'];
                    $profilePic = $row['filelocation'];
                    $teamname = $row['teamname'];

                    //echo '<h1>'.$id.'</h1>';
                    $sql3 = "select * from teamstatus where apstatus = 'inactive' and personid = '" . $id . "'";
                    $resultB = $conn->query($sql3);
                    if ($resultB->num_rows > 0) {
                        $inactive = "**INACTIVE**";
                        //echo "<h1>" . $inactive . "</h1>";
                    } else {


                        $sql3 = "select ts.personid from teamstatus ts inner join team t on ts.teamid=t.teamid where personid = '" . $id . "' and t.teamname = 'animal care' and ts.apstatus = 'active'";
                        $resultB = $conn->query($sql3);
                        if ($resultB->num_rows > 0) {
                            while ($rowB = mysqli_fetch_assoc($resultB)) {
                                $num1 = $rowB['personid'];
                                if ($num1 != "") {
                                    $animalcare = "Animal Care Volunteer <br />";
                                }
                            }
                        }


                        $sql3 = "select ts.personid from teamstatus ts inner join team t on ts.teamid=t.teamid where personid = '" . $id . "' and t.teamname = 'Treatment' and ts.apstatus = 'active'";
                        $resultB = $conn->query($sql3);
                        if ($resultB->num_rows > 0) {
                            while ($rowB = mysqli_fetch_assoc($resultB)) {
                                $num2 = $rowB['personid'];
                                if ($num2 != "") {
                                    $treatment = "Vet/Treatment Volunteer <br />";
                                }
                            }
                        }

                        $sql3 = "select ts.personid from teamstatus ts inner join team t on ts.teamid=t.teamid where personid = '" . $id . "' and t.teamname = 'Transporter' and ts.apstatus = 'active'";
                        $resultB = $conn->query($sql3);
                        if ($resultB->num_rows > 0) {
                            while ($rowB = mysqli_fetch_assoc($resultB)) {
                                $num3 = $rowB['personid'];
                                if ($num3 != "") {
                                    $transport = "Transport Volunteer <br />";
                                }
                            }
                        }

                        $sql3 = "select ts.personid from teamstatus ts inner join team t on ts.teamid=t.teamid where personid = '" . $id . "' and t.teamname = 'Outreach' and ts.apstatus = 'active'";
                        $resultB = $conn->query($sql3);
                        if ($resultB->num_rows > 0) {
                            while ($rowB = mysqli_fetch_assoc($resultB)) {
                                $num4 = $rowB['personid'];
                                if ($num4 != "") {
                                    $outreach = "Outreach Volunteer <br />";
                                }
                            }
                        }

                        $sql3 = "select ts.personid from teamstatus ts inner join team t on ts.teamid=t.teamid where personid = '" . $id . "' and t.teamname = 'Front Desk' and ts.apstatus = 'active'";
                        $resultB = $conn->query($sql3);
                        if ($resultB->num_rows > 0) {
                            while ($rowB = mysqli_fetch_assoc($resultB)) {
                                $num5 = $rowB['personid'];
                                if ($num5 != "") {
                                    $frontdesk = "Front Desk Volunteer <br />";
                                }
                            }
                        }

                    }


                    if($id1 == $id){continue;}else{

                        $url = "profile.php";
                        $name = "user";
                        $value = $id;
                        $newurl = $url . "?name=$value";

                        $volBox1 = '<a href="' . $newurl . '">
                      <div class="row panel">
                          <div class="col-xs-3">
                              <img src="' . $profilePic . '" class="img-responsive profpic" alt="' . $firstname . ' ' . $lastname . '" profile picture"/>
                          </div>
                          <div class="col-sm-9">
                              <h1>' . $firstname . ' ' . $middlename . ' ' . $lastname . '</h1>
                              <h4>' . $inactive . $animalcare . $treatment . $transport . $outreach . $frontdesk . '</h4>
                              <!--<h4>' . $teamname . ' Volunteer</h4>-->
                              <p><a href="mailto:'.$email.'?Subject=Hello%20again" target="_top">' . $email . '</a></p>
                          </div>
                      </div>
                      </a>';

                        echo $volBox1;

                        $id1 = $id;


                        $_SESSION['emailArray'][] = $email;
                    }
                }
            }

        }


      if (isset($_POST['mail'])) {
           // print_r($_SESSION['emailArray']);
            echo "<script> window.location = '/HAFE.php'</script>";
      }

            ?>

    </div> <!--End list of volunteers-->
    </div> <!--End row-->
    </div><!--End column-->
    </div><!--End row-->
  </div>
<?php include("footer.php")?>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    </body>
    </html>