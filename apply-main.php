<?php
include('SQLConnection.php');
include('Email.php');
date_default_timezone_set('America/New_York');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Account | Wildlife Center Volunteers</title>
	<?php include("htmlHead.php")?>
</head>
<body class="loginimage">
<div class="container">
    <div class="row">
        <div class="col-sm-3">
            <!--Spacer-->
        </div>
        <!--Logo-->
        <div class="col-xs-12 col-sm-6 vellum">
            <div class="row">
                <div class="row logo-row">
				<img src="images/wcv-black.png" alt="Wildlife Center Logo" class="img-responsive logo-big">
                <h1 class="logo-text">Wildlife Center of Virginia</h1>
                </div>
            </div><!--End row-->


            <div class="row">
                <div class="col-sm-2">
                    <!--Spacer-->
                </div>
                <div class="col-sm-8">

                    <h1>Create an Account</h1>

                    <!--Basic application form-->
                    <form id="apply" method="post" action="apply-main.php">
                    First name:<br>
                    <input class="apply-main name" type="text" name="firstName" value="<?php echo isset($_POST["firstName"]) ? $_POST["firstName"] : ""; ?>" required><br>
                    Middle name:<br>
                    <input class="apply-main name" type="text" name="middleName" value="<?php echo isset($_POST["middleName"]) ? $_POST["middleName"] : ""; ?>"><br>
                    Last name:<br>
                    <input class="apply-main name" type="text" name="lastName" value="<?php echo isset($_POST["lastName"]) ? $_POST["lastName"] : ""; ?>" required><br>
                    <br>
                    Email(Username):<br>
                    <input class="apply-main name" type="email" name="email" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : ""; ?>" required><br>
                    <br>
                    Password:<br>
                    <input class="apply-main" type="password" name="pass" value="<?php echo isset($_POST["pass"]) ? $_POST["pass"] : ""; ?>" required><br>
                    Re-enter Password:<br>
                    <input class="apply-main" type="password" name="pass2" value="<?php echo isset($_POST["pass2"]) ? $_POST["pass2"] : ""; ?>" required><br>
                    <br>
                    Date of birth:<br>
                    <input class="apply-main" type="date" name="DOB" value="<?php echo isset($_POST["DOB"]) ? $_POST["DOB"] : ""; ?>" required><br>
                    <?php

                    $firstName = "";
                    $middleName = "";
                    $lastName = "";
                    $email = "";
                    $password = "";
                    $DOB = "";

                    if(isset($_POST["submitButton"])){
                        if($_POST['pass']!=$_POST['pass2']){
                            echo "<font color='red'><h5>Please make sure both password entries are the same</h5></font>";
                        }
                        else{
                            $firstName = array_key_exists('firstName', $_POST) ? $_POST['firstName']:null;
                            $lastName = array_key_exists('lastName', $_POST) ? $_POST['lastName']:null;
                            $DOB = array_key_exists('DOB', $_POST) ? $_POST['DOB']:null;
                            $password = array_key_exists('pass', $_POST) ? $_POST['pass']:null;

                            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                            if (!empty($_POST['middleName'])){
                                $middleName = array_key_exists('middleName', $_POST) ? $_POST['middleName']:null;
                            }
                            if (!empty($_POST['email'])){
                                $email = array_key_exists('email', $_POST) ? $_POST['email']:null;
                            }
                            if (!empty($_POST['DOB'])){
                                $DOB = array_key_exists('DOB', $_POST) ? $_POST['DOB']:null;
                            }
                            if (!empty($_POST['phone'])){
                                $phone = array_key_exists('$phone', $_POST) ? $_POST['$phone']:null;
                            }

                            insertPerson($firstName, $middleName, $lastName, $email, $passwordHash, $DOB);

                            echo "<a href='home.php'></a>";
                        }

                    }

                    //Inserts a person into the appropriate tables
                    function insertPerson($firstName, $middleInitial, $lastName, $email, $passwordHash, $DOB){

                        //Variables
                        $personid = "";

                        //sql connection
                        $newSQL = new SQLConnection();
                        $conn = $newSQL->makeConn();

                        //Error connecting
                        if (!$conn) {
                            die("<h5>Connection failed: " . mysqli_connect_error() . "</h5>");
                        }

                        $testDate = date('Y-m-d', strtotime($DOB));
                        if(validateAge($testDate)) {

                            //Creates query
                            $query = "INSERT INTO wcv.person (firstname, middlename, lastname, DOB) VALUES (?,?,?,?)";
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param("ssss", $firstName, $middleInitial, $lastName, $DOB);

                            //Sends query
                            if ($stmt->execute()) {
                                echo "Person created successfully.";

                                //Creates query to get the newly added person's personid
                                $query = "SELECT personid FROM wcv.person WHERE firstname = ? AND middlename = ? AND lastname = ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("sss", $firstName, $middleInitial, $lastName);

                                //Executes and captures the query
                                $stmt->execute();
                                //Retains the results
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    $personid = $row["personid"];
                                    //echo $personid;
                                }

                                //Inserts into login table
                                $query = "INSERT INTO wcv.login(email, passwd, personid, permissionLevel) VALUES (?,?,$personid,0)";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("ss", $email, $passwordHash);
                                $stmt->execute();

                                //Account creation email
                                $name = $firstName . " " . $lastName;
                                $newEmail = new Email();
                                $newEmail->setRecieverEmail($email);
                                $newEmail->setRecieverName($name);
                                $newEmail->sendAccountSuccess();

                                $query = "INSERT INTO emergcontact (emergid, personid) VALUES (NULL, " . $personid . ")";
                                $conn->query($query);

                                $todayDate = date("Y-m-d");
                                $query = "INSERT INTO documents VALUES (NULL, " . $personid . ", 'profilepicture', 'jpg', 'profile.jpg', 'profilepictures/profile.jpg', NULL, '" . $todayDate . "')";
                                $conn->query($query);

                                $query = "INSERT INTO availability (personid) VALUES (" . $personid . ")";
                                $conn->query($query);

                                //To login page
                                header("Location: index.php");
                                exit;
                            } else {
                                echo "Error: " . $query . "<br>" . mysqli_error($conn);
                            }
                        } else {
                            echo "<font color='red'><h5>You must be 18 years of age to sign up</h5></font>";
                        }
                    }

                    function validateAge($age)
                    {
                        $age = strtotime($age);
                        //The age to be over, over 25 and not older than 75
                        $minAge = strtotime('+18 years', $age);
                        if(time() < $minAge) {
                            return false;
                        }
                        else {
                            return true;
                        }
                    }

                    ?>

                    <input type="submit" class="btn btn-blue" value="Submit" name="submitButton"/>
                    <a href="index.php"><button type="button" class="btn btn-blue">Back</button></a>
                    </form>
                </div><!--End centered collumn-->
            </div><!--End row-->
        </div><!--End column-->
    </div><!--End row-->



</div>
</div>
</body>


<footer>
	<?php include("footer.php")?>
</footer>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>



