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
$userID = $_SESSION['login'];
$allTasks = "SELECT * FROM taskCard WHERE  creatorid != '$userID' AND takerid IS NULL ORDER BY id ASC LIMIT 4";
$lastChance = "SELECT * FROM taskCard WHERE creatorid != '$userID' AND takerid IS NULL ORDER BY dateto ASC LIMIT 4";
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
</head>
<img class="baggrund" src="img/baggrundsbillede.png" alt="baggrundsbillede">
<body>
        <header class="header">
                <button class="tilbage-knap" onclick="history.back()"></button>
                <a href="index.php"><img class="header-logo" src="img/logo.png" alt="panthenter logo"></a>
                <a href=""><img class="noti" src="img/notifikation-ikon.png" alt="notifikation ikon"></a>
        </header>
        <main> 
                <section class="cta-section">
                        <a href="create-task.php">
                                <figure class="index-cta cta-green">
                                        <img src="img/flasker-ikon.png" alt="flasker ikon">
                                        <figcaption>Opret opgave</figcaption>
                                </figure>
                        </a>

                        <a href="tasks.php">
                                <figure class="index-cta cta-white">
                                        <img src="img/greenpose-ikon.png" alt="pose ikon">
                                        <figcaption>Find opgave</figcaption>
                                </figure>
                        </a>
                </section>

                <section class="index-kategorier">
                        <section class="index-headers">
                                <h2>Nyeste opgaver</h2>
                                <a href="tasks.php">se alle <b class="seAllePil">&rsaquo;</b></a>
                        </section>
                        <section class="index-scrolls">
                                <?php 
                                        $showResult = $mySQL->query($allTasks);
                                        while($dataRow = $showResult->fetch_object("IndexTaskCards")) {
                                        echo $dataRow->TaskCard();
                                        }
                                ?>
                        </section>
                </section>

                <section class="index-kategorier">
                        <section class="index-headers">
                                <h2>Hent inden det er for sent</h2>
                                <a href="tasks.php">se alle <b class="seAllePil">&rsaquo;</b></a>
                        </section>
                        <section class="index-scrolls">
                                <?php 
                                        $showResult = $mySQL->query($lastChance);
                                        while($dataRow = $showResult->fetch_object("IndexTaskCards")) {
                                        echo $dataRow->TaskCard();
                                        }
                                ?>
                        </section>
                </section>
        </main> 

        <footer>
                <nav>
                        <a href="tasks.php"><img class="nav-ikon" src="img/liste-ikon.png" alt="opgaveliste ikon"></a>
                        <a href="create-task.php"><img class="add-ikon" src="img/plus-ikon.png" alt="Opret opgave ikon"></a>
                        <a href="my-profile.php"><img class="nav-ikon" src="img/profil-ikon.png" alt="profil ikon"></a>
                </nav>
        </footer>
</body>
</html>