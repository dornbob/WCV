<?php
include("loginheader.php");
include("SQLConnection.php");
include("documentClass.php");

$newSQL = new SQLConnection();
$conn = new mysqli($newSQL->getServerName(), $newSQL->getUserName(), $newSQL->getPassword(), $newSQL->getDB());

$sqlSelect = "select documentid, personid, docname, doctype, filename, filelocation, apptype, dateadded from documents where personid = " . $_SESSION['personid'];
$result = $conn->query($sqlSelect);

$count = 0;
$documents = array();
if ($result) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $documents[$count] = new Document();
        $documents[$count]->setDocumentID($row["documentid"]);
        $documents[$count]->setPersonID($row["personid"]);
        $documents[$count]->setDocName($row["docname"]);
        $documents[$count]->setDocType($row["doctype"]);
        $documents[$count]->setFileName($row["filename"]);
        $documents[$count]->setFileLocation($row["filelocation"]);
        $documents[$count]->setAppType($row["apptype"]);
        $documents[$count]->setDateAdded($row["dateadded"]);
        $count++;

    }
}
?>

<!DOCTYPE html>
<html lang="en">
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
    <meta name="author" content="Shanice McCormick and Nicole Moran">

    <title>Upload Document</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Caveat+Brush" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Arimo|Caveat+Brush" rel="stylesheet">

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
    <div class="col-xs-12 col-sm-6 vellum">

        <div class="row">
            <div class="col-sm-2">
                <!--Spacer-->
            </div>
            <div class="col-sm-12">
                <form action="edit-documents.php" method="post" enctype="multipart/form-data">
                    <div class="col-xs-12">
                        <h1>Upload Document</h1>
                        <div>
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
                                <option value="na">N/A</option>
                            </select></br>
                            <input type="submit" value="Upload Doc" name="btnDoc">
                            <?php
                            $newSQL = new SQLConnection();
                            $conn = new mysqli($newSQL->getServerName(), $newSQL->getUserName(), $newSQL->getPassword(), $newSQL->getDB());

                            // Check if image file is a actual image or fake image
                            if(isset($_POST["btnDoc"])) {
                                $fileType = $_POST['documentType'];
                                $appType = $_POST['appType'];
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
                                    echo "<font color='red'><h5>maximum of 10 documents already uploaded</h5></font>";
                                    $uploadOk = 0;
                                }
                                // Check file size
                                /*if ($_FILES["fileToUpload"]["size"] > 20000000) {
                                    echo "<font color='red'><h5>Sorry, your file is too large</h5></font>";
                                    $uploadOk = 0;
                                }*/
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
                                    echo "<font color='red'><h5>Upload is not a text, pdf, or word file</h5></font>";
                                }

                                // Check if $uploadOk is set to 0 by an error
                                if ($uploadOk == 1) {
                                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                                        echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";

                                        $todayDate = date("Y-m-d");
                                        $query = "insert into documents values (null, " . $_SESSION['personid'] . ", '" . $fileType . "', '"
                                            . $extension . "', '" . $fileName . "', '" . $target_file . "', '" . $appType . "', '" .  $todayDate . "')";
                                        echo "<br>" . $query;
                                        $conn->query($query);
                                        header("Location:profile.php");

                                    } else {
                                        echo "<font color='red'><h5>Sorry, there was an error uploading your file</h5></font>";
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                </form>
            </div><!--End centered collumn-->
        </div><!--End row-->
    </div> <!--End column-->
</div><!--End rowr-->

<!-- Footer -->
<footer class="w3-container w3-padding-64 w3-center w3-xlarge">
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