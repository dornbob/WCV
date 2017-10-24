<?php
include ('loginheader.php');
include("navHeader.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="The website for Wildlife Center volunteers">
    <meta name="keywords" content="wildlife, volunteer, virginia">
    <meta name="author" content="Shanice McCormick and Nicole Moran">

    <title>Home | Wildlife Center Volunteers</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Caveat+Brush" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Arimo|Caveat+Brush" rel="stylesheet">

    <!--Leave this area commented!-->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-1">
            <!--Spacer-->
        </div>
        <div class="col-xs-12 col-sm-10 vellum">
            <div class="row">
                <div class="col-sm-4">
                    <h3>WILDLIFE CENTER OF VIRGINIA</h3>
                    <img src="images/nature.png" alt="Logo" class="logo img-responsive">
                </div>
            </div><!--End row-->

<?php
global $hoursArray;
global $milesArray;
global $hoursDateArray;
global $milesDateArray;

?>
    <h1>Hours Page</h1>
    <html>
    <head>
        <title>Miles and Hours</title>
    </head>
    <body>
    <form action="edit-hours.php" method="post">
        <input type="submit" value="Save" name="save"><br/>
        Edit Hours <br/>



<?php
include ('SQLConnection.php');
//SQL connection and variables
    $newSQL = new SQLConnection();
	$conn = $newSQL->makeConn();
    $milesArray=array();
    $hoursArray=array();
    $milesDateArray=array();
    $hoursDateArray=array();
    $mileIDArray=array();
    $hourIDArray=array();

$query = "SELECT hoursID, dateAdded, hours from wcv.hours where personid =" . $_SESSION["personid"]. " ORDER BY dateAdded";
$stmt = $conn->prepare($query);

//Executes and captures the query
$stmt->execute();
//Retains the results
$result = $stmt->get_result();
$count = 0;
//Captures the results
while ($row = $result->fetch_assoc()) {
    $date = $row['dateAdded'];
    $hours = $row['hours'];
    $hourID = $row['hoursID'];
    $hourIDArray[$count] = $hourID;
    $hoursArray[$count] = $hours;
    $hoursDateArray[$count] =$date;
    $count++;
}

$query = "SELECT milesID, dateAdded, miles from wcv.miles where personid =" . $_SESSION["personid"]." ORDER BY dateAdded";
$stmt = $conn->prepare($query);

//Executes and captures the query
$stmt->execute();
//Retains the results
$result = $stmt->get_result();
$count = 0;
//Captures the results
while ($row = $result->fetch_assoc()) {
    $date = $row['dateAdded'];
    $miles = $row['miles'];
    $mileID = $row['milesID'];
    $mileIDArray[$count] = $mileID;
    $milesDateArray[$count] = $date;
    $milesArray[$count] = $miles;
    $count++;
}

//Displays the database results in editable text boxes
$hourCount = 1;
$i =0;

foreach($hoursArray as $value)
{


    echo "Date: <input type='date' title='Date' name='$hourCount' value='$hoursDateArray[$i]'/>";

    $hourCount++;

    echo "Hours: <input type='text' title='Hours' name='$hourCount' value='$value'/>";

    echo "<br/>";
    $i++;
    $hourCount++;

}
$hourCount--;
$mileCount = $hourCount + 1;
$i=0;
echo "<br/><br/>Miles<br/>";
foreach($milesArray as $value)
{

    echo "Date: <input type='date' title='Date' name='$mileCount' value='$milesDateArray[$i]'/> ";
    $mileCount++;

    echo "Miles: <input type='text' title='Miles' name='$mileCount' value='$value'/> ";
    echo "<br/>";
    $i++;
    $mileCount++;
}

$mileCount--;

//When the save button is pressed
if(isset($_POST["save"]))
{
    $idMileCount = sizeof($mileIDArray);
    $idHourCount = sizeof($hourIDArray);
    $counter = $idMileCount;
    $idMileCount--;


    //Gets the updated values for mile
    for($y = $counter; $y > 0; $y--) {
        $miles = isset($_POST[$mileCount]) ? $_POST[$mileCount] : '';
        $mileCount--;
        $date = isset($_POST[$mileCount]) ? $_POST[$mileCount] : '';
        $mileCount--;
        $id = $mileIDArray[$idMileCount];
        $idMileCount--;

        //Sends those values to the database
        if($miles != '' && $date != '')
        {
            $query = "UPDATE wcv.miles SET miles = ?, dateAdded = ? WHERE milesID = $id";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ds",$miles, $date);

            $stmt->execute();
        }
        else
        {
            echo "
		<script type=\"text/javascript\">					
	    alert(\"Update not committed because date or miles is empty \");
		</script>;";
        }
    }
    $counter = $idHourCount;
    $idHourCount--;
    //Gets the updated values for hours
    for($c = $counter; $c > 0; $c--) {
        $hours = isset($_POST[$hourCount]) ? $_POST[$hourCount] : '';

        $hourCount--;
        $date = isset($_POST[$hourCount]) ? $_POST[$hourCount] : '';

        $hourCount--;
        $id = $hourIDArray[$idHourCount];
        $idHourCount--;
        echo "<br/>";

        //Sends those values to the database
        if($hours != '' && $date != '')
        {
            $query = "UPDATE wcv.hours SET hours = ?, dateAdded = ? WHERE hoursID = $id";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ds",$hours, $date);
            $stmt->execute();
        }
        else
        {
            echo "
		<script type=\"text/javascript\">					
	    alert(\"Update not committed because date or hours is empty \");
		</script>;";
        }

    }
}
?>
    </form>

        </div><!--End row-->
    </div> <!--End user view-->
</div><!--End vellum column-->
</div><!--End row-->

<footer>
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

    </form>
    </body>
    </html>
