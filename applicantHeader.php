<?php
//Needs to be on evey page
session_start();
if (!isset($_SESSION['personid']) && !isset($_SESSION['permission'])) {
    header("location:login.php");
}
?>