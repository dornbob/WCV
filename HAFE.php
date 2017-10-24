<html>
<head>
    <meta charset="UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	
	<title>Send Email | Wildlife Center of Virginia</title>
	
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
	<h1>Send Email</h1>
	<p><a href="search.php" style="text-decoration:underline">Go Back</a></p>
	<br>
	<form action="HAFE.php" method="post">
		Subject:<br>
		<input type="text"  name="subject" title="Enter a Subject"><br>
		Message:<br>
		<textarea	title="Enter a Message" name="message" style="width:50%"></textarea><br>
		<br>
		<input type="submit" name="send" value="Send Email" class="btn btn-blue">
	</form>
</div>

<?php
//Sends lots of emails
require 'Email.php';
include 'loginheader.php';

//Sends an email to multiple receivers
if(isset($_POST["send"]))
{
    //Gets the subject and message
    $message = (isset($_POST["message"]) ? $_POST["message"] : null);
    $subject = (isset($_POST["subject"]) ? $_POST["subject"] : null);

    //For sending
    $emailArray = $_SESSION['emailArray'];
    $newEmail = new Email();

        //Sends the email
        $newEmail ->sendMultiEmailOutlook($message, $subject, $emailArray);





    header("Location: /search.php");


}


?>