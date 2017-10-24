<?php

include("SQLConnection.php");
include("loginheader.php");

?>
<html>
<form action="uploadDoc.php" method="post" enctype="multipart/form-data">


    Select document to upload:</br>
    <input type="file" name="fileToUpload" id="fileToUpload"></br>
    <select name="documentType">
        <option value="resume">Resume</option>
        <option value="cover letter">Cover Letter</option>
        <option value="rabies document">Rabies Document</option>
        <option value="other">Other</option>
    </select></br>
    <select name="appType">
        <option value="animal care">Animal Care</option>
        <option value="outreach">Outreach</option>
        <option value="transport">Transport</option>
        <option value="treatment">Treatment</option>

    </select></br>
    <input type="submit" value="Upload Doc" name="btnDoc">
<?php
$newSQL = new SQLConnection();
$conn = new mysqli($newSQL->getServerName(), $newSQL->getUserName(), $newSQL->getPassword(), $newSQL->getDB());

// Check if image file is a actual image or fake image
if(isset($_POST["btnDoc"])) {
    $fileType = $_POST['documentType'];
    $appType = $_POST['appType'];
    echo $appType;
    $target_dir = "documents/";
    $extension = strtolower(pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION));

    $query = "select max(documentID) as 'maxid' from documents";
    $stmt = $conn->prepare($query);
    $conn->query($query);
    $result = $conn->query($query);
    $documentID = 0;
    if ($result) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $documentID = $row["maxid"] + 1;
        }
    }

    $query = "select concat(firstname, ' ', lastname) as 'name' from person where personid = " . $_SESSION['personid'];
    $stmt = $conn->prepare($query);
    $conn->query($query);
    $result = $conn->query($query);
    $personName = "person";
    if ($result) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $personName = $row["name"];
        }
    }

    $query = "select count(*) as 'count' from documents d inner join person p on d.personid = p.personid where p.personid = " . $_SESSION['personid'];
    $stmt = $conn->prepare($query);
    $conn->query($query);
    $result = $conn->query($query);
    $docCount = 12;
    if ($result) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $docCount = $row["count"];
        }
    }

    $fileName = $personName . " - " . $fileType . " - " . $documentID . "." . $extension;
    $target_file = $target_dir . $fileName;

    $uploadOk = 1;
    //only allow 10 document uploads
    if ($docCount >= 11) {
        echo "maximum of 10 documents already uploaded" . "</br>";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 20000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats

    $allowedExts = array("pdf", "doc", "docx", "txt");
    if (($_FILES["fileToUpload"]["type"] == "text/plain") ||
        ($_FILES["fileToUpload"]["type"] == "application/pdf") ||
        ($_FILES["fileToUpload"]["type"] == "application/msword") ||
        ($_FILES["fileToUpload"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") &&
        in_array($extension, $allowedExts)){
    }
    else {
        $uploadOk = 0;
        echo "Upload is not a text, pdf, or word file. ";
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";

            $todayDate = date("Y-m-d");
            $query = "insert into documents values (null, " . $_SESSION['personid'] . ", '" . $fileType . "', '"
                        . $extension . "', '" . $fileName . "', '" . $target_file . "', '" . $appType . "', '" .  $todayDate . "')";
            $stmt = $conn->prepare($query);
            $conn->query($query);

        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
</form>
</html>
