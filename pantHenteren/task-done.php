<?php 
    //søger automatisk efter class i folderen og includer den, hvis den bliver kaldt
    spl_autoload_register(function($className) {
            include_once $_SERVER['DOCUMENT_ROOT'] . '/pantHenteren/classes/' . $className . '.php';
        });
    session_start();



        include("mysql.php");

            /* Hvis der ikke er logget ind sendes man tilbage til index.php */
            if(!isset($_SESSION['login'])){
                header('location: index.php');
                exit;
                } else {
                    $userID = $_SESSION['login'];
                }
    // Henter id'et i url'en
    $taskID = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
    $allData = "SELECT * FROM taskCard WHERE id = '$taskID'";
    $creatorIDquery = "SELECT creatorid FROM taskCard WHERE id = '$taskID'";
    $userID = $_SESSION['login'];
    $result = $mySQL->query($creatorIDquery);
    $creatorID = $result->fetch_object()->creatorid;

    $creatorNAME = "SELECT firstname FROM pantUsers WHERE id = '$creatorID'";
    $result = $mySQL->query($creatorNAME);
    $TaskCreator = $result->fetch_object()->firstname;


?>
<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PantHenteren</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href="https://rangeslider.js.org/assets/rangeslider.js/dist/rangeslider.css" rel="stylesheet"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://rangeslider.js.org/assets/rangeslider.js/dist/rangeslider.min.js"></script>
</head>
    <body>
        <img class="baggrund" src="img/baggrundsbillede.png" alt="baggrundsbillede">
        <header class="header">
                <button class="tilbage-knap" onclick="history.back()"></button>
                <a href="index.php"><img class="header-logo" src="img/logo.png" alt="panthenter logo"></a>
                <a href=""><img class="noti" src="img/notifikation-ikon.png" alt="notifikation ikon"></a>
        </header>
       <section class="taskDoneSection">
                <h1 class='release-h2'>Godt klaret!</h1>
                <p class="center">Vi giver <?php echo $TaskCreator ?> besked om, at du har færdiggjort opgaven</p>
                <br>
                <p class="center">Vær med til at give alle en bedre oplevelse</p>
                <form  method="post" action="backend.php?taskID=<?php echo $taskID ?>"> 
                    <input class="btn" type="submit" name="giveRating" value="Giv <?php echo $TaskCreator ?> en anmeldelse">
                </form>
                <!-- <button class='slet-btn rateTask' onclick="location.href = 'your-tasks.php'">Spring over</button> -->
                <button class='slet-btn rateTask' id="noRating">Spring over</button>
        </section>

            
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