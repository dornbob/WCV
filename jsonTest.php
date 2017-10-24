<!DOCTYPE html>
<html>
<head>
    <title>JSON</title>
</head>
    <body>
    <form action="jsonTest.php" method="post">
        <input type="submit" name="submit" value="JSON to database">
        <input type="submit" name="get" value="DB to JSON">
    </form>
<?php
include ("SQLConnection.php");

$newSQL = new SQLConnection();
$conn = new mysqli($newSQL->getServerName(), $newSQL->getUserName(), $newSQL->getPassword(), $newSQL->getDB());

if (isset($_POST["get"])) {


    $sql = "SELECT * FROM wcv.events";
    $result = $conn->query($sql);

    $json_array = array();
    $return_array = array();

    while ($row = mysqli_fetch_assoc($result)) {

        $json_array['id'] = $row['eventID'];
        $json_array['title'] = $row['title'];
        $json_array['description'] = $row['description'];
        $json_array['start'] = $row['start'];
        $json_array['editable'] = $row['editable'];
        $json_array['department'] = $row['department'];
        $json_array['type'] = $row['type'];
        $json_array['slots'] = $row['slots'];
        $json_array['className'] = $row['className'];

        array_push($return_array, $json_array);
    }

    $jsonEncode = json_encode($return_array);
//echo '<pre>';
//print_r($json_array);
//echo '</pre>';

    if (file_put_contents('events.json',$jsonEncode, null)) {
        echo 'working';
    } else {
        echo 'not working';
    }
}

if(isset($_POST["submit"]))
{
    //Gets the JSON file and decodes it
    $json = file_get_contents("events.json");
    $json = json_decode($json, true);

    //
    $sql = "";
    foreach ($json as $row) {
        $sql = "INSERT INTO wcv.events (title, description, start, editable, department, type, slots, className) 
          VALUES ('".$row["title"]."', '".$row["description"]."', '".$row["start"]."', ".$row["editable"].", 
          '".$row["department"]."', '".$row["type"]."', '".$row["slots"]."', '".$row["className"]."') ";
        echo $sql;
        echo '<br/>';
        mysqli_query($conn, $sql);
    }
}

?>
</body>



</html>


