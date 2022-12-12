<?php
session_start();

// Sletter kun den bestemte session så der logges ud
unset($_SESSION['login']);
header("location: login.php");

?>