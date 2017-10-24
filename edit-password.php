<?php
include("loginheader.php");
include("SQLConnection.php");

$newSQL = new SQLConnection();
$conn = new mysqli($newSQL->getServerName(), $newSQL->getUserName(), $newSQL->getPassword(), $newSQL->getDB());

$profileID = $_SESSION["personid"];

if (isset($_SESSION["adminSearch"]))
{
    $profileID = $_SESSION["adminSearch"];
}
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

    <title>Change Password</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Caveat+Brush" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Arimo|Caveat+Brush" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="row">
    <div class="col-sm-3">
        <!--Spacer-->
    </div>
    <div class="col-xs-12 col-sm-6 vellum">
        <div class="row">
            <div class="col-sm-6">
                <h3>WILDLIFE CENTER OF VIRGINIA</h3>
                <img src="images/nature.png" alt="Logo" class="logo img-responsive">
            </div>
        </div><!--End row-->

        <div class="row">
            <div class="col-sm-2">
                <!--Spacer-->
            </div>
            <div class="col-sm-8">
                <h1>Change Password</h1>

                <form action="edit-password.php" method="post">
                    Enter your current password: <input type="password" name="currentPass" placeholder="Current password" value=""></br>
                    Create a new password: <input type="password" name="newPass1" placeholder="New password" value=""></br>
                    Reenter the new password: <input type="password" name="newPass2" placeholder="Reenter password" value=""></br>
                    <input type="submit" name="set" value="Change Password">
                </form>

                <?php
                $correct = false;

                if(isset($_POST["currentPass"])) {
                    $password = $_POST["currentPass"];

                    //gets hash to compare to
                    $query = "SELECT passwd FROM login WHERE personid = ?";

                    //Prepares and sends the query
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("s", $profileID);
                    $hash = 0;
                    if ($stmt->execute()) {
                        //Gets the results and captures them
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) {
                            $hash = $row['passwd'];
                        }
                    }

                    //checks hash
                    $correct = password_verify($password, $hash);
                }

                if ($correct) {

                    if (isset($_POST["set"]) && isset($_POST["newPass1"]) && isset($_POST["newPass2"])) {
                        $newPassword = $_POST["newPass1"];
                        if ($_POST['newPass1'] != $_POST['newPass2']) {
                            echo "<font color='red'><h5>Please make sure both password entries are the same</h5></font>";
                        } else if (empty($_POST['newPass1']) || empty($_POST['newPass2'])){
                            echo "<font color='red'><h5>All fields must be filled</h5></font>";
                        } else {
                            $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

                            //Inserts into login table
                            $query = "UPDATE wcv.login SET passwd = ? WHERE personid = " . $profileID;
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param("s", $passwordHash);
                            $stmt->execute();
                            echo "<h5>Password successfully changed</h5>";
                            header("Location:profile.php");
                        }
                    } else {
                        echo "<font color='red'><h5>All fields must be filled</h5></font>";
                    }
                }
                else if (isset($_POST["currentPass"])) {
                    echo "<font color='red'><h5>Current password is invalid</h5></font>";
                }
                ?>
            </div><!--End centered collumn-->
        </div><!--End row-->
    </div> <!--End column-->
</div><!--End rowr-->

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
<!-- Include all plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>