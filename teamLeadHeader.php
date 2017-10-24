<?php
//Placed on pages which only team lead and above can view
if ($_SESSION['permission'] < 2) {
    header("Location:login.php");
}
?>