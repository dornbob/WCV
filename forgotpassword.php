<!DOCTYPE html>
<html>
<head>
    
	<meta charset="UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	
	<title>Forgot Password</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="images/thumbnail_wcv.png">
    
    <meta name="description" content="The website for Wildlife Center volunteers">
    <meta name="keywords" content="wildlife, volunteer, virginia">
    <meta name="author" content="Drop Data Base">

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
<body class="passwordpage">
<br>
<br>
<br>
<div class="row new-nav">
	<div class="col-sm-3">
		<!--Spacer-->
	</div>
	<div class="col-xs-12 col-sm-6">
		<img src="images/wcv-black.png" alt="Wildlife Center logo" class="img-responsive logo-big">
	</div>
</div>

<div class="row new-nav">
	<h1>Forgot Your Password?</h1>
	<p>Enter your email and we'll send you a code. Then follow the link in the email to reset your password.</p>
	<p><a href="index.php" style="text-decoration:underline">Back to login</a></p>
	<br>
	<form action="forgotpassword.php" method="post">
		Email: <input  title= "Forgot Password" type="text" name="email"> <br/>
		<br>
		Code: <input  title= "Forgot Password" type="text" name="code"> <br/>
		<br>
		<input type="submit" name="submit" class="btn btn-blue">
	</form>
</div>
	
<?php
include 'SQLConnection.php';
if (isset($_POST["submit"]))
{
    //Gets variables
    $databaseCode = "";
    $code = (isset($_POST["code"]) ? $_POST["code"] : null);
    $email = (isset($_POST["email"]) ? $_POST["email"] : null);

    //SQL connection
    $newSQL = new SQLConnection();
    $conn = new mysqli($newSQL->getServerName(), $newSQL->getUserName(), $newSQL->getPassword(), $newSQL->getDB());
    $newSQL->checkConnection();

    //Creates the query
    $query = "SELECT randompass FROM wcv.login WHERE email = ?";

    //Prepares and executes the query
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s",$email);
    if ($stmt->execute()) {
        //Retains the results
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $databaseCode = $row["randompass"];
        }
    }
    else
    {
        echo "
		<script type=\"text/javascript\">					
	    alert(\"Email address does not match our records\");
		</script>;";
    }

    //Evaluates the code
    if($databaseCode === $code)
    {
        header("Location: newpassword.php");
        exit;
    }
    else
    {
        echo "
		<script type=\"text/javascript\">					
	    alert(\"Recovery code does not match\");
		</script>;";
    }
}
?>
</body>
</html>