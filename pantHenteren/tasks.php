<?php 

session_start();
        include("mysql.php");
        include("classes.php");

        /* Hvis der ikke er logget ind sendes man tilbage til index.php */
        if(!isset($_SESSION['login'])){
            header('location: index.php');
            exit;
            } else {
                $userID = $_SESSION['login'];
            }
    $status = isset($_REQUEST['status']) ? $_REQUEST['status'] : "";

$allTasks = "SELECT * FROM taskCard";

$showResult = $mySQL->query($allTasks);
    while($dataRow = $showResult->fetch_object("Task")) {
        echo $dataRow->TaskCard();
    }


?>