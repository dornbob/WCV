<?php
require_once 'Email.php';

$newEmail = new Email();
$newEmail ->setRecieverEmail('jimmylaria@yahoo.com');
$newEmail ->setRecieverName('Jimmy Laria');
$newEmail ->emailForgotPassword('linkidylinklink');



?>