<?php
//Placed on pages which only admin and above can view
echo $_SESSION['permission'];
if ($_SESSION['permission'] < 2) {
    header("Location:index.php");
}
?>