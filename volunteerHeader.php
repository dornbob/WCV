<?php
//Placed on pages which only volunteer and above can view
echo $_SESSION['permission'];
if ($_SESSION['permission'] < 1) {
    header("Location:login.php");
}
?>