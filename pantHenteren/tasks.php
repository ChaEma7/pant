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
    
$today = date("Y-m-d");
$allTasks = "SELECT * FROM taskCard WHERE  creatorid != '$userID'  AND takerid IS NULL AND dateto >= '$today'";
$opgaverTaget = "SELECT * FROM taskCard WHERE takerid = '$userID' AND active = '1'";
$opgaverOprettet = "SELECT * FROM taskCard WHERE creatorid = '$userID' AND active = '1'";
$opgaverAfsluttede = "SELECT * FROM taskCard WHERE (takerid = '$userID' OR creatorid = '$userID') AND active = '0'";


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
            <!-- <button type="button" id="all-tasks-btn" class="task-btn active-btn">Alle opgaver</button>
            <button type="button" id="your-tasks-btn" class="task-btn">Mine opgaver</button> -->
            <a href="tasks.php" class="task-btn active-btn">Alle opgaver</a>
            <a href="your-tasks.php" class="task-btn">Mine opgaver</a>
        </section>  
        <section class="sorting-container">
            <button class="sorting" onclick="togglePopupSortTask(); return false">Sortér efter <b class="pilned"> &#8964; </b></button>
            
            <section class="popup" id="popup-sorting">
                <section class="popup-overlay"></section>
                <section class="popup-content">
                    <form id="sort-form" method="post" action="tasks.php">
                        <div class="sorterings-kasse">
                            <label class="sorting-text" for="nyesteTask">Nyeste opgave</label>
                            <input class="sortering" type="checkbox" id="nyesteTask" name="sortThis" onclick="onlyOneSort(this)" value="nyesteTask">
                        </div>
                        <div class="sorterings-kasse">
                            <label class="sorting-text" for="mestPant">Mest pant</label>
                            <input class="sortering" type="checkbox" id="mestPant" name="sortThis" onclick="onlyOneSort(this)" value="mestPant">
                        </div>
                        <div class="sorterings-kasse">
                            <label class="sorting-text" for="mestUdbytte">Størst udbytte</label>
                            <input class="sortering" type="checkbox" id="mestUdbytte" name="sortThis" onclick="onlyOneSort(this)" value="mestUdbytte">
                        </div>
                        <input class="btn" type="submit" name="sort" value="Anvend">
                    </form>  
                </section>
            </section>
        </section>

        <section id="allTasks" class="allTasks">
            <p class="allTask-p">Sorteret efter: 

            <?php 
                $sorting = isset($_REQUEST['sortThis']) ? $_REQUEST['sortThis'] : "nyesteTask";
                if($sorting == 'nyesteTask') {
                    $allTasks .= ' ORDER BY dt DESC';
                    echo "<b>Nyeste opgaver</b>";
                }
                
                if($sorting == 'mestPant') {
                    $allTasks .= ' ORDER BY totalPant DESC';
                    echo "<b>Mest pant</b>";
                }

                if($sorting == 'mestUdbytte') {
                    $allTasks .= ' ORDER BY earnings DESC';
                    echo "<b>Størst udbytte</b>";
                }
                echo "</p>";
                
                $showResult = $mySQL->query($allTasks);
                while($dataRow = $showResult->fetch_object("Task")) {
                    echo $dataRow->TaskCard();
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