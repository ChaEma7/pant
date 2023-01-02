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
    $takerIDquery = "SELECT takerid FROM taskCard WHERE id = '$taskID'";
    $creatorIDquery = "SELECT creatorid FROM taskCard WHERE id = '$taskID'";
    $activeQuery = "SELECT active FROM taskCard WHERE id = '$taskID'";
    $userID = $_SESSION['login'];

    // Bruges i if funktionen, som bestemmer hvilken knap, der skal fremvises alt efter om du er opgave opretter eller tager
    $result = $mySQL->query($takerIDquery);
    $takerID = $result->fetch_object()->takerid;
    $result = $mySQL->query($creatorIDquery);
    $creatorID = $result->fetch_object()->creatorid;
    // Vælger og fetcher attributten active fra viewet taskCard hvor id'et stemmer overens med $taskID
    $result = $mySQL->query($activeQuery);
    $activeStatus = $result->fetch_object()->active;

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

        <section class="detail-billede">
            <img class="detalje-billede" src="img/detalje-flasker.png" alt="flaske billede">
        </section>

        <section class="backlayer backlayerSolid">

                <?php 
                    $showResult = $mySQL->query($allData);

                    if($showResult->num_rows > 0) {
                        while($dataRow = $showResult->fetch_object("TaskDetail")) {
                            echo $dataRow->TaskDetail();
                        }
                    } else {
                        echo "<p class='dummytekst'>Du har ingen afsluttede opgaver</p>";
                    }
                    
                    // Bestemmer hvilken knap der skal fremvises alt efter om opgaven af aktiv eller taget
                    // og hvis du har oprettet opgaven
                    if($activeStatus != '1') {
                        echo "<p class='opgave-afsluttet'>Opgaven er afsluttet</p>";
                    } else if($creatorID == $userID){
                        echo "<form id='book-form' method='post' action='backend.php?taskID=$taskID'>
                                <input class='btn' type='submit' name='editTask' value='Redigér opgave'>
                            <button class='slet-btn nedtonet' onclick='togglePopup(); return false'>Slet opgave</button>
                            
                            <section class='popup' id='popup-delete'>
                                <section class='popup-overlay'></section>
                                <section class='popup-content'>
                                    <section class='close-btn' onclick='togglePopup()'><img src='img/luk-ikon.png' alt='luk ikon'></section>
                                    <h2>Er du sikker på, at du vil slette opgaven?</h2>
                                    <section class='popup-btns'>
                                        <button class='annuller-btn' onclick='togglePopup(); return false'>Annuller</button>
                                        <input class='delete-btn' type='submit' name='cancelTask' value='Slet opgave'>
                                    </section>
                                </section>
                            </section>

                        </form>";
                    } else if($takerID == $userID) {
                        echo "<form  id='book-form' method='post' action='backend.php?taskID=$taskID'>
                            <input class='btn' type='submit' name='taskDone' value='Afslut opgave'>   
                            <button class='slet-btn nedtonet' onclick='togglePopupReleaseTask(); return false'>Annuller og frigiv opgave</button>

                            <section class='popup' id='popup-frigiv'>
                                <section class='popup-overlay'></section>
                                <section class='popup-content'>
                                    <section class='close-btn' onclick='togglePopupReleaseTask() '><img src='img/luk-ikon.png' alt='luk ikon'></section>
                                    <h2 class='release-h2'>Er du sikker på, at du vil annullere opgaven?</h2>
                                    <section class='popup-btns'>
                                        <input class='btn release-btn' type='submit' name='releaseTask' value='Annuller og frigiv opgave'>
                                    </section>
                                </section>
                            </section>

                        </form>";
                    } else {
                        echo "<form id='book-form' method='post' action='backend.php?taskID=$taskID'>
                            <button class='btn' onclick='togglePopupBookTask(); return false'>Book opgave</button>
                            

                            <section class='popup' id='popup-book'>
                                <section class='popup-overlay'></section>
                                <section class='popup-content popup-content-book'>
                                    <section class='close-btn' onclick='togglePopupBookTask()'><img src='img/luk-ikon.png' alt='luk ikon'></section>
                                    <h2 class='release-h2'>Er du sikker på, at du vil booke opgaven?</h2>
                                    <p class='popup-text'>Når du har bekræftet bookingen, kan du finde opgaven under ''Mine opgaver''.</p>
                                    <section class='popup-btns'>
                                        <input class='btn book-btn' type='submit' name='bookTask' value='Bekræft booking'>
                                    </section>
                                </section>
                            </section>

                            
                        </form>";
                    } 
                ?>

                
                
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