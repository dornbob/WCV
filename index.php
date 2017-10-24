<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | Wildlife Center Volunteers</title>
    <?php include("htmlHead.php")?>
</head>
<body class="loginimage">
<div class="row">
    <div class="col-sm-3">
        <!--Spacer-->
    </div>
    <div class="col-xs-12 col-sm-6 vellum">
        <div class="row logo-row">
				<img src="images/wcv-black.png" alt="Wildlife Center Logo" class="img-responsive logo-big">
                <h1 class="logo-text">Wildlife Center of Virginia</h1>
        </div><!--End row-->

        <div class="row">
            <div class="col-sm-2">
                <!--Spacer-->
            </div>

            <div class="col-sm-8">
                <h1>Sign In</h1>
                <form action="index.php" method="post">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="name" type="text" class="form-control" name="email" placeholder="E-mail">
                    </div>
                    <br>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <?php
                    require ('SQLConnection.php');
                    $newSQL = new SQLConnection();
                    //$conn = new mysqli("wcv.c0iweg5fv44n.us-east-1.rds.amazonaws.com", "wcvuser", "DukeDog7","wcvdb", "3306");
					$conn = $newSQL->makeConn();
					
                    if (isset($_POST["login"]))
                    {
                        session_start();
                        if (!empty($_POST['email']) and !empty($_POST['password'])) {
                            $email = $_POST['email'];
                            $password = $_POST['password'];
                            //echo $email . "<br/>" . $password . "</br>";

                            //gets hash to compare to
                            $query = "SELECT passwd FROM login where email = ?";

                            //Prepares and sends the query
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param("s",$email);
                            if ($stmt->execute()) {

                                //Gets the results and captures them
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    $hash = $row['passwd'];
                                }
                            }
                            //initializes hash if no password found
                            if (!isset($hash)) {
                                $hash = 0;
                            }
                            //checks hash
                            $correct = password_verify($password, $hash);

                            if ($correct) {
                                //echo "<br/>" . "display here" . $hash . "<br/>";

                                //determine user type
                                $query = "select personid, teamLeadid, adminid from login where email = ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("s",$email);
                                $stmt->execute();

                                if ($stmt->execute()) {
                                    $result = $stmt->get_result();

                                    while ($row = $result->fetch_assoc()) {
                                        $person = $row["personid"];
                                        $teamLead = $row["teamLeadid"];
                                        $admin = $row["adminid"];
                                    }
                                }

                                $query = "";
                                if ($person != '') {
                                    $query = "SELECT p.personid, permissionLevel FROM person p inner join login l on p.personid = l.personid where email = ? and passwd = ?";
                                } elseif ($teamLead != '') {
                                    $query = "SELECT t.teamleadid, permissionLevel FROM teamlead t inner join login l on t.teamleadid = l.teamleadid where email = ? and passwd = ?";
                                } elseif ($admin != '') {
                                    $query = "SELECT a.adminid, permissionLevel FROM administrator a inner join login l on a.adminid = l.adminid where email = ? and passwd = ?";
                                } else {
                                    $query = "SELECT p.personid, permissionLevel FROM person p inner join login l on p.personid = l.personid where email = ? and passwd = ?";
                                }

                                //echo $query . "</br>";
                                //$query = "SELECT p.personid FROM person p inner join login l on p.personid = l.personid where email = ? and passwd = ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("ss",$email,$hash);
                                $stmt->execute();

                                $result = $stmt->get_result();
                                $count = mysqli_num_rows($result);
                                //echo "Count:".$count;

                                //If the posted values are equal to the database values, then session will be created for the user.
                                if ($count == 1) {
                                    while ($row = $result->fetch_assoc()) {
                                        if ($person != '') {
                                            $_SESSION['personid'] = $row['personid'];
                                            $_SESSION['permission'] = $row['permissionLevel'];
                                        } elseif ($teamLead != '') {
                                            $_SESSION['personid'] = $row['teamleadid'];
                                            $_SESSION['permission'] = $row['permissionLevel'];
                                        } elseif ($admin != '') {
                                            $_SESSION['personid'] = $row['adminid'];
                                            $_SESSION['permission'] = $row['permissionLevel'];
                                        } else {
                                            $_SESSION['personid'] = $row['personid'];
                                            $_SESSION['permission'] = $row['permissionLevel'];
                                        }
                                    }

                                } else {
                                    $invalidLogin = "Incorrect Username or Password"; //this doesn't display anywhere
                                }

                                if ($admin != '' || $teamLead != '') {
                                    if (isset($_SESSION['personid']) && isset($_SESSION['permission'])) {
                                        header("Location: /search.php"); //takes user to homepage after login
                                    }
                                } else {
                                    if (isset($_SESSION['personid']) && isset($_SESSION['permission'])) {
                                        header("Location: /profile.php"); //takes user to homepage after login
                                    }
                                }
                                /*if (isset($_SESSION['personid']) && isset($_SESSION['permission'])) {
                                    header("Location: /home.php"); //takes user to homepage after login
                                }*/
                            } else {
                                $invalidLogin = "Incorrect Username or Password"; //this doesn't display anywhere
                            }
                        } else {
                            $invalidLogin = "Fields left empty";
                        }
                    }

                    ?>
                    <a href="ForgotPasswordPrompt.php" class="back">Forgot your password?</a><br/>
                    <?php if(isset($invalidLogin)) { echo "<font color='red'><h5>" . $invalidLogin . "</h5></font>"; } ?>
                    <a href="home.php"><input type="submit" name="login" class="btn btn-default" value ="Sign In"></a>
                    <a href="apply-main.php"> <button type="button" class="btn btn-default">Sign Up </button></a>
                    <a href="clockTime.php"> <button type="button" class="btn btn-default">Clock Time </button></a>


                </form>

            </div><!--End column-->

        </div><!--End row-->

    </div> <!--End column-->
</div><!--End rowr-->

<!-- Footer -->
<footer class="w3-container w3-center-align w3-xlarge">
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