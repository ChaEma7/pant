<?php 

session_start();

//søger automatisk efter class i folderen og includer den, hvis den bliver kaldt
spl_autoload_register(function($className) {
        include_once $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $className . '.php';
    });

    include("mysql.php");

        /* Hvis der ikke er logget ind sendes man tilbage til index.php */
        if(!isset($_SESSION['login'])){
            header('location: index.php');
            exit;
            } else {
                $userID = $_SESSION['login'];
            }

$taskID = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
$allData = "SELECT * FROM pantTask WHERE id = '$taskID'";

?>
<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update profil</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href="https://rangeslider.js.org/assets/rangeslider.js/dist/rangeslider.css" rel="stylesheet"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://rangeslider.js.org/assets/rangeslider.js/dist/rangeslider.min.js"></script>
</head>
    <body>
        
            <br><br><br><br><br>
        <footer>
            <nav>
                    <a href="tasks.php"><img class="nav-ikon" src="img/liste-ikon.png" alt="opgaveliste ikon"></a>
                    <a href="create-task.php"><img class="add-ikon" src="img/plus-ikon.png" alt="Opret opgave ikon"></a>
                    <a href="my-profile.php"><img class="nav-ikon" src="img/profil-ikon.png" alt="profil ikon"></a>
            </nav>
        </footer>
        
    </body>
<script src="js.js"></script>
</html>