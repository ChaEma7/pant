<?php
session_start();

// sletter kun den bestemte session
unset($_SESSION['login']);
header("location: login.php");

?>