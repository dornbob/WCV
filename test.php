<html>
<head>
    <title>Test</title>
</head>
<body>
<form action="test.php" method="post">
Email(separate multiple by a comma) <input  title= "Enter an Email" type="text" name="email"> <br/>
Password <input title= "Enter a Password" type="text" name="password"> <br/>
    Message <input title="Enter a Message" type="text" name="message"><br/>
<input type="submit" name="submit">
   Subject <input type="text"  name="subject" title="Enter a Subject">
    <input type="submit" name="send" value="Send Email">
<input type="submit" value= "Forgot Password" name= "pls">
</form>
<?php

    require 'SQLConnection.php';
    require 'Server.php';


    if (isset($_POST["submit"]))
    {
        $email = (isset($_POST["email"]) ? $_POST["email"] : null);
        $password = (isset($_POST["password"]) ? $_POST["password"] : null);

        echo "Email: " . $email;
        echo "<br/>" . "Password: " . $password;

        $hash = password_hash($password, PASSWORD_DEFAULT);

        echo "<br/>Hash: " . $hash;

        $correct = password_verify($password, $hash);
        echo "<br/>Verify: " . password_verify($password, PASSWORD_DEFAULT);
    }

//Sends an email to multiple receivers
if(isset($_POST["send"]))
{

    //For sending
    $newEmail = new Email();
    $emailArray = $_POST['Email'];
    $count = 0;
    foreach($emailArray as $email)
    {
        ${'newEmail' . $count} = new Email();
        ${'newEmail' . $count} ->setRecieverEmail($email);
        //Sends the email
        ${'newEmail' . $count} ->sendEmailOutlook($message, $subject);

        $count++;

    }


    //Stuff
    $message = (isset($_POST["message"]) ? $_POST["message"] : null);
    $subject = (isset($_POST["subject"]) ? $_POST["subject"] : null);
    $multiEmail = (isset($_POST["email"]) ? $_POST["email"] : null);

    //Gets the multiple emails to an array
    $array=explode(',',$multiEmail);



    //Sets the emails for each in there
    foreach($array as $email)
    {

    }


}
if (isset($_POST["pls"]))
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

        //Sets the reset link
        $newServer = new Server();
        $newServer->discoverIPAddress();
        $server = $newServer->getServerIP();
        $actualLink = "http://$server/forgotPassword.php";
        $resetLink = "<a href=$actualLink>Change Password</a>";

        //Sends email with generated number
        if($name != "")
        {
            $newEmail = new Email();
            $newEmail ->setRecieverEmail($email);
            $newEmail ->setRecieverName($name);
            $newEmail ->setResetLink($resetLink);
            $newEmail ->emailForgotPassword($resetLink, $passwordRecoveryNumber);
        }

    }
}

function generatePasswordRecovery()
{
    $recoveryNumber = "";
    for($i = 0; $i < 6; $i++)
    {
        $recoveryNumber .= rand(1,9);
    }
    return $recoveryNumber;
}

/*
        $newSQL = new SQLConnection();

        $conn = new mysqli($newSQL->getServerName(), $newSQL->getUserName(), $newSQL->getPassword(), $newSQL->getDB());

        $newSQL->checkConnection();

        //create query and insert into the database
        $sqlInsert = "INSERT INTO wcv.person (email,password) VALUES(?, ?)";
        $stmt = $conn->prepare($sqlInsert);
        $stmt->bind_param("ss",$email,$hash);
        $stmt->execute();

        $record = $conn->affected_rows;
        if ($record > 0) {
            global $disRecordCreation;
            $disRecordCreation = "New records created successfully";
        }
        if (mysqli_errno($conn) != 0) {
            $disRecordCreation = mysqli_errno($conn) . ": " . mysqli_error($conn) . "</br>";
        }
<<<<<<< HEAD

    }
=======
    }*/

function validateLogin($email,$password)
{
    $newSQL = new SQLConnection();
    $conn = new mysqli($newSQL->getServerName(), $newSQL->getUserName(), $newSQL->getPassword(), $newSQL->getDB());
    $newSQL->checkConnection();
    $hash = "";

    $query = mysqli_query($conn, "SELECT password FROM PERSON WHERE email ='".$email."'");

    if ($result = $conn->query($query))
    {
        while ($row = $result->fetch_assoc()){
            $hash = $row["password"];
        }
    }

    return (password_verify($password,$hash));

}

function MatchEmailName($email, $passwordRecoveryNumber)
{
    $newSQL = new SQLConnection();
    $conn = new mysqli($newSQL->getServerName(), $newSQL->getUserName(), $newSQL->getPassword(), $newSQL->getDB());
    $newSQL->checkConnection();
    $firstName = "";
    $lastName = "";
    $name = "";
    echo $passwordRecoveryNumber;

    $query = "SELECT firstname, lastname FROM wcv.person WHERE email = '$email'";
    echo $query;
    if ($result = $conn->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $firstName = $row["firstname"];
            $lastName = $row["lastname"];
        }
        $name = $firstName . " ". $lastName;
    }
    $query = "UPDATE wcv.person SET randompass = $passwordRecoveryNumber WHERE email = '$email'";
    echo $query;
    if ($result = $conn->query($query)) {

    }
    if ($name == "") {
        echo "
		<script type=\"text/javascript\">					
	    alert(\"Email does not match records!\");
		</script>;";
    } else {
        return $name;
    }
    return "";
}

?>

</body>
</html>

