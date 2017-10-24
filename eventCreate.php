<?php
include ('SQLConnection.php');
include ('loginheader.php');

//New sql connection
$newSQL = new SQLConnection();
$conn = new mysqli($newSQL->getServerName(), $newSQL->getUserName(), $newSQL->getPassword(), $newSQL->getDB());
$page = isset($_GET['p'])?$_GET['p']:'';

//var_dump(json_decode(file_get_contents('calendar.php'), true));

if ($page =='add') {

    $personID = $_SESSION["personid"];
    /*$title = $_POST['newEventTitle'];
    $description= $_POST['newEventDescrip'];
    $start= $_POST['newEventStart'];
    $end= $_POST['newEventEnd'];
    $editable= $_POST['newEditEvent'];
    $department= $_POST['newEventDept'];
    $type= $_POST['newEventType'];
    $slots= $_POST['newEventSlots'];
    $className= trim(strtolower($department)) . "-event";
    $repeatable= $_POST['newEventRepeat'];
    $repeatweeklyuntil= $_POST['newEventUntil'];*/
    $title = $_POST['title'];
    $description= $_POST['description'];
    $start= $_POST['start'];
    $end= $_POST['end'];
    $editable= $_POST['editable'];
    $untilSelect = $_POST['radio'];
    $department= $_POST['department'];
    $type= $_POST['type'];
    $slots= $_POST['slots'];
    $attend = $_POST['attend'];
    $className= trim(strtolower($department)) . "-event event";
    $repeatable= $_POST['repeatable'];
    $repeatweeklyuntil= (isset($_POST['repeatweeklyuntil']) ? $_POST['repeatweeklyuntil'] : null);


   // $date = preg_replace("/[^0-9,.]/", "", $start);
   // $date = date('Y-m-d H:i:s', $start);
    //$start = $date;
    //$sql = "INSERT INTO wcv.events(title, description, start, end, editable) values (?,?,?,?,?)";
   // $stmt = $conn->prepare($sql);
    //$stmt->bind_param("ssssi", $title, $description, $start, $end, $editable);
    //$stmt->execute();

    if($repeatable == 1)
    {

        $repeatID = 1;
        $sql = "SELECT MAX(repeatableID) AS 'repeatableID' from wcv.events";
        $result = $newSQL->getResult($sql);

        while ($row = mysqli_fetch_assoc($result))
        {
            $repeatID = $row['repeatableID'];
        }
        $repeatID = $repeatID + 1;

        if($untilSelect == 0)
        {
            monthlyReoccuring($title, $description, $start, $end, $repeatID, $editable, $repeatweeklyuntil, $department, $type, $slots, $className, $personID);

            //Signs the creator up for the event
            if($attend == 1)
            {
                $eventID = 0;
                $sql = "SELECT eventID AS 'eventID' from wcv.events WHERE repeatableID = $repeatID" ;
                $result = $newSQL->getResult($sql);

                while ($row = mysqli_fetch_assoc($result))
                {
                    $eventID = $row['eventID'];
                    //Inserts the personevent into the database
                    $sql = "INSERT INTO wcv.personevent (personID, eventID) VALUES (?,?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ii", $personID, $eventID);
                    $stmt->execute();
                }


            }
        }
        else if($untilSelect == 1)
        {
            weeklyReoccuring($title, $description, $start, $end, $repeatID, $editable, $repeatweeklyuntil, $department, $type, $slots, $className, $personID);

            //Signs the creator up for the event
            if($attend == 1)
            {
                $eventID = 0;
                $sql = "SELECT eventID AS 'eventID' from wcv.events WHERE repeatableID = $repeatID";
                $result = $newSQL->getResult($sql);

                while ($row = mysqli_fetch_assoc($result))
                {
                    $eventID = $row['eventID'];
                    //Inserts the personevent into the database
                    $sql = "INSERT INTO wcv.personevent (personID, eventID) VALUES (?,?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ii", $personID, $eventID);
                    $stmt->execute();
                }


            }

        }

    }
    else
    {
        //Inserts the event into the database
        $sql = "INSERT INTO wcv.events (title, description, start, end, editable, department, type, slots, className, 
       creatorID) VALUES (?,?,?,?,?,?,?,?,?,?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssissisi", $title, $description, $start, $end, $editable, $department, $type, $slots, $className,
             $personID);
        $stmt->execute();

        //Signs the creator up for the event
        if($attend == 1)
        {
            $eventID = 0;
            $sql = "SELECT MAX(eventID) AS 'eventID' from wcv.events";
            $result = $newSQL->getResult($sql);

            while ($row = mysqli_fetch_assoc($result))
            {
                $eventID = $row['eventID'];
            }
            //Inserts the personevent into the database
            $sql = "INSERT INTO wcv.personevent (personID, eventID) VALUES (?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $personID, $eventID);
            $stmt->execute();

        }
    }

}

function weeklyReoccuring($title, $description, $start, $end, $repeatableID, $editable, $repeatWeeklyUntil, $department, $type, $slots, $className, $creatorID) {
    //SQL connection and variables
    $newSQL = new SQLConnection();
    $conn = new mysqli($newSQL->getServerName(), $newSQL->getUserName(), $newSQL->getPassword(), $newSQL->getDB());

    $loopUntilDate = strtotime($repeatWeeklyUntil);
    $loopDate = date("Y-m-d", strtotime($start));
    $loopTimeDate = strtotime($loopDate);

    $eventID = null;
    $startTime = date("h:i:s", strtotime($start));
    $endTime = date("h:i:s", strtotime($end));

    echo "<br>";
    while ($loopTimeDate <= $loopUntilDate) {

        $specialStart = $loopDate . " " . $startTime;
        $specialEnd = $loopDate . " " . $endTime;

        $query = "insert into events (eventID, title, description, start, end, repeatableID, editable, repeatweeklyuntil, department, type, slots, className, creatorID) "
            . "values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("issssiisssisi",$eventID, $title, $description, $specialStart, $specialEnd, $repeatableID, $editable, $repeatWeeklyUntil, $department, $type, $slots, $className, $creatorID);
        $stmt->execute();


        echo $loopDate . "  ";
        $jd = gregoriantojd(date("m", strtotime($loopDate)), date("d", strtotime($loopDate)), date("Y", strtotime($loopDate)));
        echo jddayofweek($jd, 1) . "<br>";
        $loopDate = date("Y-m-d", strtotime('+7 days', $loopTimeDate));
        $loopTimeDate = strtotime($loopDate);
    }
}


function monthlyReoccuring($title, $description, $start, $end, $repeatableID, $editable, $repeatWeeklyUntil, $department, $type, $slots, $className, $creatorID) {
    //SQL connection and variables
    $newSQL = new SQLConnection();
    $conn = new mysqli($newSQL->getServerName(), $newSQL->getUserName(), $newSQL->getPassword(), $newSQL->getDB());

    $loopUntilDate = strtotime($repeatWeeklyUntil);
    $loopDate = date("Y-m-d", strtotime($start));
    $loopTimeDate = strtotime($loopDate);

    $eventID = null;
    $startTime = date("h:i:s", strtotime($start));
    $endTime = date("h:i:s", strtotime($end));

    echo "<br>";
    while ($loopTimeDate <= $loopUntilDate) {

        $specialStart = $loopDate . " " . $startTime;
        $specialEnd = $loopDate . " " . $endTime;

        $query = "insert into events (eventID, title, description, start, end, repeatableID, editable, repeatweeklyuntil, department, type, slots, className, creatorID) "
            . "values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("issssiisssisi",$eventID, $title, $description, $specialStart, $specialEnd, $repeatableID, $editable, $repeatWeeklyUntil, $department, $type, $slots, $className, $creatorID);
        $stmt->execute();


        echo $loopDate . "  ";
        $jd = gregoriantojd(date("m", strtotime($loopDate)), date("d", strtotime($loopDate)), date("Y", strtotime($loopDate)));
        echo jddayofweek($jd, 1) . "<br>";
        $loopDate = date("Y-m-d", strtotime("+1 month", $loopTimeDate));
        $loopTimeDate = strtotime($loopDate);

    }
}

if($page =='delete')
{
    $permission = $_SESSION["permission"];
    if($permission >= 2) {
        $eventID = $_POST['eventID'];
        $delete = $_POST['type'];
        if ($delete == 'series') {
            $repeatID = 0;
            //Selects the repeatableID for the event
            $sql = "SELECT repeatableID AS 'repeatID' FROM wcv.events WHERE eventID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $eventID);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $repeatID = $row['repeatID'];
            }

            //Selects the eventIDs where repeatableID is correct
            $sql = "SELECT eventID AS 'eventID' FROM wcv.events WHERE repeatableID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $repeatID);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $eventsID = $row['eventID'];
                //Deletes all the personevents where eventID matches with repeatableID
                $sql = "DELETE FROM wcv.personevent WHERE eventID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $eventsID);
                $stmt->execute();
            }

            //Deletes the events
            $sql = "DELETE FROM wcv.events WHERE repeatableID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $repeatID);
            $stmt->execute();
        } else if ($delete == 'instance') {
            //Deletes the personevent table for the eventID
            $sql = "DELETE FROM wcv.personevent WHERE eventID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $eventID);
            $stmt->execute();

            //Deletes that event
            $sql = "DELETE FROM wcv.events WHERE eventID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $eventID);
            $stmt->execute();

        } else {
            exit;
        }
    }
    else{
        echo "<script> alert('Only admins and staff can delete an event')</script>";
    }
}

if($page == 'signup')
{

        $eventID = $_POST['eventID'];
        $personID = $_SESSION["personid"];
        $slots = 0;

        //Deletes the personevent table for the eventID
        $sql = "INSERT INTO wcv.personevent (eventID, personID) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $eventID, $personID);
        $stmt->execute();

        //Selects the eventIDs where repeatableID is correct
        $sql = "SELECT slots AS 'slots' from wcv.events WHERE eventID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $eventID);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc())
        {
            $slots = $row['slots'];
        }

        if($slots > 0)
        {
            $slots = --$slots;
            //Updates the events table for the eventID
            $sql = "UPDATE wcv.events set slots = ? WHERE  eventID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $slots, $eventID);
            $stmt->execute();
        }
}

if($page == 'cancel')
{
    $eventID = $_POST['eventID'];
    $personID = $_SESSION["personid"];
    $slots = $_POST['eventSlots'];

    //Deletes the personevent table for the eventID
    $sql = "DELETE FROM wcv.personevent WHERE eventID = ? and personID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $eventID, $personID);
    $stmt->execute();


    //Selects the eventIDs where repeatableID is correct
    $sql = "SELECT slots AS 'slots' from wcv.events WHERE eventID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eventID);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc())
    {
        $slots = $row['slots'];
    }

    $slots = ++$slots;
    //Updates the events table for the eventID
    $sql = "UPDATE wcv.events set slots = ? WHERE  eventID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $slots, $eventID);
    $stmt->execute();
}
?>
