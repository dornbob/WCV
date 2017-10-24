<?php
include ('personclass.php');
require_once("SQLConnection.php");
include('loginheader.php');
include('navHeader.php');


$newSQL = new SQLConnection();
$conn = $newSQL->makeConn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Education Animals</title>
    <?php include("htmlHead.php")?>
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
            <div class="row">
                <h1>Education Animals</h1>
                    <div class="col-sm-6">
                        <h3>Raptors</h3>
                        <?php
                            $sql = "select animalname, handle, remove, notes from animal where species = 'raptor'";
                            $result = $conn->query($sql);
                            if($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    $animalname = $row['animalname'];
                                    $handle = $row['handle'];
                                    $remove = $row['remove'];
                                    $notes = $row['notes'];

                                    echo "<h4>".$animalname."</h4><h5><b>How to handle:</b><br />   ".$handle."<br /><b>How to remove from enclosure: </b><br />   ".$remove."<br /><b>Notes: </b><br />   ".$notes."</h5><br /><br />";
                                }
                            }


                        ?>
                    </div>
                    <div class="col-sm-6">
                        <h3>Reptiles</h3>
                        <?php
                        $sql = "select animalname, handle, remove, notes from animal where species = 'reptile'";
                        $result = $conn->query($sql);
                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                                $animalname = $row['animalname'];
                                $handle = $row['handle'];
                                $remove = $row['remove'];
                                $notes = $row['notes'];

                                echo "<h4>".$animalname."</h4><h5><b>How to handle:</b> <br />   ".$handle."<br /><b>How to remove from enclosure: </b><br />   ".$remove."<br /><b>Notes: </b><br />   ".$notes."</h5><br /><br />";
                            }
                        }


                        ?>
                    </div>



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