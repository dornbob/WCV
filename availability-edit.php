
<?php
include ('loginheader.php');
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
<?php include("navHeader.php");?>
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
require("SQLConnection.php");
//include("loginheader.php");

$newSQL = new SQLConnection();
$conn = new mysqli($newSQL->getServerName(), $newSQL->getUserName(), $newSQL->getPassword(), $newSQL->getDB());

global $personid, $dow, $enter, $monCheck, $tueCheck, $wedCheck, $thuCheck, $friCheck, $satCheck, $sunCheck;
$personid = $_GET['personid'];
$monCheck = "";
$tueCheck = "";
$wedCheck = "";
$thuCheck = "";
$friCheck = "";
$satCheck = "";
$sunCheck = "";


$sql = "select dow from availability where personid =".$personid;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $dow = $row['dow'];

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
        if (strpos($dow, 'sun') !== false) {
            $sunCheck = "checked";
        }
    }
}

?>

            <h1>Availability Fields</h1>

<form action="availability-edit.php?personid=<?php echo $personid; ?>" method="post">
    Day of Week: <br /><input type="checkbox" name="monday" value="1" <?php echo $monCheck; ?>> Monday
    <input type="checkbox" name="tuesday" value="2" <?php echo $tueCheck; ?>> Tuesday
    <input type="checkbox" name="wednesday" value="3" <?php echo $wedCheck; ?>> Wednesday
    <input type="checkbox" name="thursday" value="4" <?php echo $thuCheck; ?>> Thursday
    <input type="checkbox" name="friday" value="5" <?php echo $friCheck; ?>> Friday
    <input type="checkbox" name="saturday" value="6" <?php echo $satCheck; ?>> Saturday
    <input type="checkbox" name="sunday" value="7" <?php echo $sunCheck; ?>>Sunday</br>
   </br>

    <input type="submit" name="add" value="Save"><br />

    <?php


    $dowEntry = "";

    if (isset($_POST["add"])) {
        if(!empty($_POST["sunday"])) {
            $sunday = $_POST["sunday"];
            $dowEntry.='sun';
        }
        if(!empty($_POST["monday"])) {
            $monday = $_POST["monday"];
            $dowEntry.='mon';
        }
        if(!empty($_POST["tuesday"])) {
            $tuesday = $_POST["tuesday"];
            $dowEntry.='tue';
        }
        if(!empty($_POST["wednesday"])) {
            $wednesday = $_POST["wednesday"];
            $dowEntry.='wed';
        }
        if(!empty($_POST["thursday"])) {
            $thursday = $_POST["thursday"];
            $dowEntry.='thu';
        }
        if(!empty($_POST["friday"])) {
            $friday = $_POST["friday"];
            $dowEntry.='fri';
        }
        if(!empty($_POST["saturday"])) {
            $saturday = $_POST["saturday"];
            $dowEntry.='sat';
        }




        $sql = "update availability set dow = '".$dowEntry."' where personid =".$personid;
        $result = $conn->query($sql);


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
</body>
</html>