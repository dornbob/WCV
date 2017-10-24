<html>
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
    <meta name="author" content="Drop Data Base">

    <title>Forgot Password | Wildlife Center Volunteers</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!--<link href="css/custom.css" rel="stylesheet">-->
    <link href="https://fonts.googleapis.com/css?family=Caveat+Brush" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Arimo|Caveat+Brush" rel="stylesheet">
	
	<style>
		.password {
			text-align:center;
		}
		.btn-blue {
			background-color: #09476b;
			color: white;
			border-color: none;
			margin-top: 10px;
		}
		.btn-default {
			background-color: #9ABF8B;
			border-color: none;
			margin-top:10px;
		}
		.btn:hover {
			transform:scale(1.05);
			box-shadow:3px 3px 2px #888888;
		}
		.btn-blue:hover {
			transform:scale(1.05);
			box-shadow:3px 3px 2px #888888;
			color:white;
		}
	</style>

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
    <div class="col-xs-12 col-sm-6 password">
		<h1>Uh oh!</h1>
		<p>Enter your email to reset your password.</p>
		<form action="ForgotPasswordPrompt.php" method="post">
			<input  title= "email" type="text" name="email"><br>
			<input type="submit" name="submit" class="btn btn-blue"><br>
		</form>
        <form action="index.php" method="post">
            <a href="index.php"><button class="btn btn-default">Never Mind</button></a>
        </form>
	</div>
</div><!--end row-->

<?php

//File requires
require 'SQLConnection.php';
require 'Email.php';
require 'Server.php';

//On submit button click
if (isset($_POST["submit"]))
{
    $email = (isset($_POST['email']) ? $_POST['email'] : null);
    if($email == "")
    {
        echo "
		<script type=\"text/javascript\">					
	    alert(\"Enter an email and click again\");
		</script>;";
    }
    else
    {
        //Generates random recovery number
        $passwordRecoveryNumber = generatePasswordRecovery();

        //Makes sure the email matches and returns the account owner name
        $name = MatchEmailName($email, $passwordRecoveryNumber);

        //If name was found
        if($name != "")
        {
            //Sets the reset link
            $newServer = new Server();
            $newServer->discoverIPAddress();
            $server = $newServer->getServerIP();
            $actualLink = "http://$server/forgotPassword.php";
            $resetLink = "<a href=$actualLink>Change Password</a>";

            //Sends email
            $newEmail = new Email();
            $newEmail ->setRecieverEmail($email);
            $newEmail ->setRecieverName($name);
            $newEmail ->setResetLink($resetLink);
            $newEmail ->emailForgotPassword($resetLink, $passwordRecoveryNumber);
        }

    }
}

//Function to generate a password recovery code
function generatePasswordRecovery()
{
    $recoveryNumber = "";
    for($i = 0; $i < 6; $i++)
    {
        $recoveryNumber .= rand(1,9);
    }
    return $recoveryNumber;
}

//Function to make sure the email is valid and gets the email owners name
function MatchEmailName($email, $passwordRecoveryNumber)
{
    $newSQL = new SQLConnection();
    $conn = new mysqli($newSQL->getServerName(), $newSQL->getUserName(), $newSQL->getPassword(), $newSQL->getDB());
    $newSQL->checkConnection();
    $firstName = "";
    $lastName = "";
    $name = "";

    //Creates and prepares the query
    $query = "SELECT firstname, lastname FROM wcv.person INNER JOIN wcv.login on person.personid = 
            login.personid WHERE login.email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s",$email);

    //Sends the query
    if ($stmt->execute()) {
        //Retains the results
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $firstName = $row["firstname"];
            $lastName = $row["lastname"];
        }
        $name = $firstName . " ". $lastName;
    }

    //Creates and prepares the query
    $query = "UPDATE wcv.login SET randompass = $passwordRecoveryNumber WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);

    //Email validation
    if ($name == "") {
        echo "
		<script type=\"text/javascript\">					
	    alert(\"Email does not match records!\");
		</script>;";
    } else {
        //Sends the query
        if ($stmt->execute()) {
            echo "<script type=\"text/javascript\">					
	    alert(\"Check your email for password recovery!\");
		</script>;";
        }
        return $name;
    }
    return "";
}
?>

</body>
</html>

