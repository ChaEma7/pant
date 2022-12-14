<?php 
//Søger automatisk efter class i folderen og includer den, hvis den bliver kaldt
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
    
// Vælger alle frie opgaver
$allTasks = "SELECT * FROM taskCard WHERE  creatorid != '$userID'  AND takerid IS NULL";
// Vælger opgaver, som brugeren har taget, men som endnu ikke er løst
$opgaverTaget = "SELECT * FROM taskCard WHERE takerid = '$userID' AND active = '1' ORDER BY id DESC";
// Vælger opgaver, som brugeren har oprettet, men som endnu ikke er løst
$opgaverOprettet = "SELECT * FROM taskCard WHERE creatorid = '$userID' AND active = '1' ORDER BY id DESC";
// Vælger opgaver, som brugeren har taget og oprettet, men som er løst
$opgaverAfsluttede = "SELECT * FROM taskCard WHERE (takerid = '$userID' OR creatorid = '$userID') AND active = '0' ORDER BY id DESC";


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

        <section class="tasks-btn-container">
            <!-- Dette bruges ikke, da det gav mere mening for navigationen at tasks.php og your-tasks.php blev delt op i hver deres side. 
                <button type="button" id="all-tasks-btn" class="task-btn active-btn">Alle opgaver</button>
            <button type="button" id="your-tasks-btn" class="task-btn">Mine opgaver</button> -->
            <a href="tasks.php" class="task-btn">Alle opgaver</a>
            <a href="your-tasks.php" class="task-btn active-btn">Mine opgaver</a>
        </section>        

        <section id="yourTasks" class="yourTasks">

            <section>
                <h2>Opgaver du har taget</h2>
                <?php 
                    // Fremviser alle opgaver som at taget af brugeren
                    $showResult = $mySQL->query($opgaverTaget);
                    // num_rows retunerer det antal af rækker som er i resultatsættet $showResult 
                    // Hvis antallet er større end 0 fremvises opgaverne ellers udskrives en dummytekst
                    if($showResult->num_rows > 0) {
                        while($dataRow = $showResult->fetch_object("Task")) {
                            echo $dataRow->TaskCard();
                        }
                    } else {
                        echo "<p class='dummytekst'>Du har ikke booket nogle opgaver</p>";
                    }
                ?>
            </section>

            <section>
                <h2>Opgaver du har oprettet</h2>
                <?php 
                    // Fremviser alle opgaver som er oprettet af brugeren
                    $showResult = $mySQL->query($opgaverOprettet);
                    // num_rows retunerer det antal af rækker som er i resultatsættet $showResult 
                    // Hvis antallet er større end 0 fremvises opgaverne ellers udskrives en dummytekst
                    if($showResult->num_rows > 0) {
                        while($dataRow = $showResult->fetch_object("Task")) {
                            echo $dataRow->TaskCard();
                        }
                    } else {
                        echo "<p class='dummytekst'>Du har ikke oprettet nogle opgaver</p>";
                    }
                ?>
            </section>



            
            <section>
                <h2>Afsluttede opgaver</h2>
                <?php 
                    // Fremviser alle opgaver som at taget og oprettet af brugeren og som er afsluttet
                    $showResult = $mySQL->query($opgaverAfsluttede);
                    // num_rows retunerer det antal af rækker som er i resultatsættet $showResult 
                    // Hvis antallet er større end 0 fremvises opgaverne ellers udskrives en dummytekst
                    if($showResult->num_rows > 0) {
                        while($dataRow = $showResult->fetch_object("Task")) {
                            echo $dataRow->TaskCard();
                        }
                    } else {
                        echo "<p class='dummytekst'>Du har ingen afsluttede opgaver</p>";
                    }
                ?>
            </section>

        </section>
            <br><br><br>
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