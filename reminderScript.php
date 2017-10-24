<?php
//Script to remind a volunteer that they have an upcoming event

//Redirects a person if they try to access the page
include ('loginheader.php');
include ('Email.php');

//Get all the applicants that have events in the next 24 hours
include ('SQLConnection.php');

$newSQL = new SQLConnection();
$conn = new mysqli($newSQL->getServerName(), $newSQL->getUserName(), $newSQL->getPassword(), $newSQL->getDB());

$sql = "SELECT firstname, lastname, start, title, email from wcv.person p inner join wcv.login l on l.personid = p.personid inner join wcv.personevent pe on p.personid = pe.personID inner join wcv.events e on e.eventID = pe.eventID where (timestampdiff(hour, convert_tz(current_timestamp(),'+00:00' ,'-04:00' ), start) < 24 AND timestampdiff(hour, convert_tz(current_timestamp(),'+00:00' ,'-04:00'), start) > 0);";
$result = $newSQL->getResult($sql);

//Sends email reminders
while ($row = mysqli_fetch_assoc($result))
{
    $firstName = $row['firstname'];
    $lastName = $row['lastname'];
    $start = $row['start'];
    $title = $row['title'];
    $email = $row['email'];

    $name = $firstName . " " . $lastName;
    $newEmail = new Email();
    $newEmail->setRecieverEmail($email);
    $newEmail->setRecieverName($name);
    $newEmail->sendReminder($title, $start);
}

?>