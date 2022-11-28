<?php

$host = "mysql50.unoeuro.com";
$username = "cmedia_design_dk";
$password = "ngpt23kdRwbc";
$database = "cmedia_design_dk_db_eaaa";

$mySQL = new mysqli($host, $username, $password, $database);

if(!$mySQL) {
    die("Coundn't connect to the MySQL server " . mysqli_connect_error());
}

?>