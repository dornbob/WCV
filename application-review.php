<?php
include("loginheader.php");
require("SQLConnection.php");
include ("adminHeader.php");
$fullName = "";

if (isset($_POST["search"])) {

    $newSQL = new SQLConnection();
	$conn = $newSQL->makeConn();

    $sql = "select distinct p.personid,firstname,middlename,lastname,email,filelocation,teamname, apstatus from availability a inner join person p on p.personid=a.personid
          inner join documents d on p.personid=d.personid 
          inner join login l on p.personid = l.personid 
          inner join teamstatus ts on p.personid = ts.personid 
          inner join team t on ts.teamid = t.teamid ";
    $clause = " where ";
    if (!empty($_POST["nameSearch"])) {
        $fullName = $_POST["nameSearch"];
        $space = strpos($fullName, " ");

        if (empty($space)) {
            $firstName = $fullName;
        } else {
            $firstName = substr($fullName, 0, $space);
            //echo "<br/>FirstName:" . $firstName;

            $lastName = substr($fullName, $space);
            //echo "<br/>LastName:" . $lastName . "<br/>";

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

    if (isset($_POST['Status'])){
        $status = $_POST['Status'];
        $parenthesis = "(";
        foreach ($status as $status => $st) {
            if (!is_null($st)) {
                $sql .= $clause . $parenthesis . "apstatus ='" . $st . "'";
                $clause = " or ";
                $parenthesis = "";
            }
        }
        $sql.=")";
        $clause = " and ";
    }

    if($clause != ' where '){
        $clause = " and ";}
    $sql .=$clause . "(docName = 'profilepicture')";
    $sql .= " and (apstatus not like '%active') order by p.lastname";
    //echo $sql;
}
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
		<?php include('htmlHead.php'); ?>
        <title>Search | Wildlife Center Volunteers</title>
    </head>
    <body>

    <!--display the nav bar -->
    <?php include("navHeader.php"); ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-1">
                <!--Spacer-->
            </div>
            <div class="col-xs-12 col-sm-10 vellum">

				<h1>Application Review</h1>
                <div class="row search">
                    <form action="application-review.php" method="post">
                        <!--Sidebar with checkboxes-->
                        <div class="col-sm-5">
                            <!--Search box-->
                            <input type="text" id="search_box" name="nameSearch" placeholder="Name" value="<?php echo $fullName; ?>">
                            <input type="submit" name="search" class="btn btn-clock" value="Search">
							
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
                            global $pendingCount;
                            $pendingCount = 0;
                            global $deniedCount;
                            $deniedCount = 0;

                            $sql2 = "select count(ts.personid) from teamstatus ts inner join team t on ts.teamid=t.teamid where t.teamname = 'outreach' and ts.apstatus not like '%active'";
                            $result = $conn->query($sql2);
                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $outreachCount = $row['count(ts.personid)'];
                                }
                            }

                            $sql2 = "select count(ts.personid) from teamstatus ts inner join team t on ts.teamid=t.teamid where t.teamname = 'animal care' and ts.apstatus not like '%active'";
                            $result = $conn->query($sql2);
                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $animalCareCount = $row['count(ts.personid)'];
                                }
                            }

                            $sql2 = "select count(ts.personid) from teamstatus ts inner join team t on ts.teamid=t.teamid where t.teamname = 'transporter' and ts.apstatus not like '%active'";
                            $result = $conn->query($sql2);
                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $transportCount = $row['count(ts.personid)'];
                                }
                            }

                            $sql2 = "select count(ts.personid) from teamstatus ts inner join team t on ts.teamid=t.teamid where t.teamname = 'treatment' and ts.apstatus not like '%active'";
                            $result = $conn->query($sql2);
                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $treatmentCount = $row['count(ts.personid)'];
                                }
                            }

                            $sql2 = "select count(ts.personid) from teamstatus ts inner join team t on ts.teamid=t.teamid where t.teamname = 'front desk' and ts.apstatus not like '%active'";
                            $result = $conn->query($sql2);
                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $frontDeskCount = $row['count(ts.personid)'];
                                }
                            }

                            $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
	                              ts.personid = p.personid inner join availability a on p.personid = 
                                   a.personid where a.dow like '%mon%' and ts.apstatus not like 
                                  '%active'";
                            $result = $conn->query($sql2);
                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $monCount = $row['count(distinct ts.personid)'];
                                }
                            }

                            $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
	                              ts.personid = p.personid inner join availability a on p.personid = 
                                   a.personid where a.dow like '%tue%' and ts.apstatus not like 
                                  '%active'";
                            $result = $conn->query($sql2);
                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $tueCount = $row['count(distinct ts.personid)'];
                                }
                            }

                            $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
	                              ts.personid = p.personid inner join availability a on p.personid = 
                                   a.personid where a.dow like '%wed%' and ts.apstatus not like 
                                  '%active'";
                            $result = $conn->query($sql2);
                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $wedCount = $row['count(distinct ts.personid)'];
                                }
                            }

                            $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
	                              ts.personid = p.personid inner join availability a on p.personid = 
                                   a.personid where a.dow like '%thu%' and ts.apstatus not like 
                                  '%active'";
                            $result = $conn->query($sql2);
                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $thuCount = $row['count(distinct ts.personid)'];
                                }
                            }

                            $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
	                              ts.personid = p.personid inner join availability a on p.personid = 
                                   a.personid where a.dow like '%fri%' and ts.apstatus not like 
                                  '%active'";
                            $result = $conn->query($sql2);
                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $friCount = $row['count(distinct ts.personid)'];
                                }
                            }

                            $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
	                              ts.personid = p.personid inner join availability a on p.personid = 
                                   a.personid where a.dow like '%sat%' and ts.apstatus not like 
                                  '%active'";
                            $result = $conn->query($sql2);
                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $satCount = $row['count(distinct ts.personid)'];
                                }
                            }

                            $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
	                              ts.personid = p.personid inner join availability a on p.personid = 
                                   a.personid where a.dow like '%sun%' and ts.apstatus not like 
                                  '%active'";
                            $result = $conn->query($sql2);
                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $sunCount = $row['count(distinct ts.personid)'];
                                }
                            }

                            $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
	                              ts.personid = p.personid inner join availability a on p.personid = 
                                   a.personid where a.season like '%sum%' and ts.apstatus not like 
                                  '%active'";
                            $result = $conn->query($sql2);
                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $summerCount = $row['count(distinct ts.personid)'];
                                }
                            }

                            $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
	                              ts.personid = p.personid inner join availability a on p.personid = 
                                   a.personid where a.season like '%fall%' and ts.apstatus not like 
                                  '%active'";
                            $result = $conn->query($sql2);
                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $fallCount = $row['count(distinct ts.personid)'];
                                }
                            }

                            $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
	                              ts.personid = p.personid inner join availability a on p.personid = 
                                   a.personid where a.season like '%win%' and ts.apstatus not like 
                                  '%active'";
                            $result = $conn->query($sql2);
                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $winterCount = $row['count(distinct ts.personid)'];
                                }
                            }

                            $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
	                              ts.personid = p.personid inner join availability a on p.personid = 
                                   a.personid where a.season like '%spr%' and ts.apstatus not like 
                                  '%active'";
                            $result = $conn->query($sql2);
                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $springCount = $row['count(distinct ts.personid)'];
                                }
                            }

                            $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
                                    ts.personid = p.personid where p.rabiesshot = 1 and ts.apstatus not like 
                                    '%active'";
                            $result = $conn->query($sql2);
                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $rabiesCount = $row['count(distinct ts.personid)'];
                                }
                            }

                            $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
                                    ts.personid = p.personid where p.rabiesshot = 0 and ts.apstatus not like 
                                    '%active'";
                            $result = $conn->query($sql2);
                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $noRabiesCount = $row['count(distinct ts.personid)'];
                                }
                            }

                            $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
                                    ts.personid = p.personid where p.rabiesowncost = 1 and ts.apstatus not like 
                                    '%active'";
                            $result = $conn->query($sql2);
                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $willingCount = $row['count(distinct ts.personid)'];
                                }
                            }

                            $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
                                    ts.personid = p.personid where p.permittype = 'cat 1' and ts.apstatus not like 
                                    '%active'";
                            $result = $conn->query($sql2);
                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $cat1Count = $row['count(distinct ts.personid)'];
                                }
                            }

                            $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
                                    ts.personid = p.personid where p.permittype = 'cat 2' and ts.apstatus not like 
                                    '%active'";
                            $result = $conn->query($sql2);
                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $cat2Count = $row['count(distinct ts.personid)'];
                                }
                            }

                            $sql2 = "select count(distinct ts.personid) from teamstatus ts inner join person p on
                                    ts.personid = p.personid where p.permittype = 'cat 4' and ts.apstatus not like 
                                    '%active'";
                            $result = $conn->query($sql2);
                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $cat4Count = $row['count(distinct ts.personid)'];
                                }
                            }

                            $sql2 = "select count(p.personid) from person p inner join teamstatus ts 
	                              on p.personid = ts.personid where apstatus = 'pending'";
                            $result = $conn->query($sql2);
                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $pendingCount = $row['count(p.personid)'];
                                }
                            }

                            $sql2 = "select count(p.personid) from person p inner join teamstatus ts 
	                              on p.personid = ts.personid where apstatus = 'denied'";
                            $result = $conn->query($sql2);
                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $deniedCount = $row['count(p.personid)'];
                                }
                            }

                            ?>

                            <!--Searchable criteria by category-->

                            <div class="category">
                                <h3>Application Status</h3>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="Status[]" value="pending">Pending</label><span class="badge"><?php echo $pendingCount;?></span>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="Status[]" value="denied">Denied</label><span class="badge"><?php echo $deniedCount;?></span>
                                </div>
                            </div>

                            <div class="category">
                                <h3>Application  Type</h3>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="Type[]" value="outreach">Outreach</label><span class="badge"><?php echo $outreachCount; ?></span>
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
                                    <label><input type="checkbox" name="Type[]" value="front desk">Front Desk</label><span class="badge"><?php echo $frontDeskCount;?></span>
                                </div>
                            </div>

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

                           <!-- <div class="category">
                                <h3>Available Season</h3>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="Season[]" value="sum">Summer</label><span class="badge"><?php //echo $summerCount;?></span>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="Season[]" value="fall">Fall</label><span class="badge"><?php //echo $fallCount;?></span>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="Season[]" value="win">Winter</label><span class="badge"><?php //echo $winterCount;?></span>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="Season[]" value="spr">Spring</label><span class="badge"><?php //echo $springCount;?></span>
                                </div>
                            </div> -->

                            <div class="category">
                                <h3>Rabies</h3>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="Rabies[]" value="1">Vaccinated</label><span class="badge"><?php echo $rabiesCount;?></span>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="Rabies[]" value="0">Not Vaccinated</label><span class="badge"><?php echo $noRabiesCount;?></span>
                                </div>
                                <!--<div class="checkbox">
                                <label><input type="checkbox" value="">Willing to Pay</label><span class="badge"><?php echo $willingCount;?></span>
                            </div>-->
                            </div>

                            <!--<div class="category">
                            <h3>Rehab Permit Type</h3>
                            <div class="checkbox">
                                <label><input type="checkbox" value="">Category I</label><span class="badge"><?php echo $cat1Count;?></span>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="">Category II</label><span class="badge"><?php echo $cat2Count;?></span>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="">Category IV</label><span class="badge"><?php echo $cat4Count;?></span>
                            </div>
                        </div>-->
                    </form>
                </div>
                <!--List of volunteers appears here-->
                <div class="col-sm-7" style="text-align:center">
					<p>Click "search" to view all applicants.</p>
                    <?php
                    if (isset($_POST["search"])) {

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
                        $apstatus = "";
                        $profilePic = "";
                        $teamname = "";

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $id = $row['personid'];
                                $firstname = $row['firstname'];
                                $middlename = $row['middlename'];
                                $lastname = $row['lastname'];
                                $email = $row['email'];
                                $profilePic = $row['filelocation'];
                                $teamname = $row['teamname'];
                                $apstatus = $row['apstatus'];

                                $url = "profile.php";
                                $name = "user";
                                $value = $id;
                                $newurl = $url . "?name=$value";


                                echo '<a href="'.$newurl.'">
                      <div class="row panel">
                          <div class="col-xs-3">
                            <img src="' . $profilePic . '" class="img-responsive profpic" alt="' . $firstname . ' ' . $lastname . '" profile picture"/>
                              <h4>'.$apstatus.'</h4>
                          </div>
                          <div class="col-xs-9">
                              <h3>' . $firstname . ' ' . $middlename . ' ' . $lastname . '</h3>
                              <h4>' . $teamname . ' Volunteer</h4> </a>
                              <form action="view-app.php?$personid='.$id.'&$teamname='.$teamname.'" method="post">
                              <input type="submit" name="view" class="btn btn-blue" value="View Application" onclick="view-app.php"/></form>
                              
                              <p><a href="mailto:'.$email.'?Subject=Hello%20again" target="_top">' . $email . '</a></p>
                          </div>
                      </div>
                      ';

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
                                $apstatus = "";
                                $profilePic = "";
                                $teamname = "";
                            }
                        }
                    }
                    ?>

                </div> <!--End list of volunteers-->
            </div> <!--End row-->
        </div><!--End column-->
    </div><!--End row-->

    <footer>
        <p>© 2017 The Wildlife Center of Virginia. All Rights Reserved.</p>
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    </body>
    </html>










<?php
/**
 * Created by PhpStorm.
 * User: Zoe
 * Date: 4/2/2017
 * Time: 7:38 PM
 */
?>