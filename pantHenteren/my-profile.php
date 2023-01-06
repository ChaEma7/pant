<?php 
        //søger automatisk efter class i folderen og includer den, hvis den bliver kaldt
        spl_autoload_register(function($className) {
                include_once $_SERVER['DOCUMENT_ROOT'] . '/pantHenteren/classes/' . $className . '.php';
            });
        session_start();
        include("mysql.php");

              
        if(!isset($_SESSION['login'])){
            // Hvis der ikke er logget ind, sendes man tilbage til index.php
            header('location: login.php');
            exit;
            } else {
                $userID = $_SESSION['login'];

                /*  Selecter bestemt data fra pantUsers hvor id'et stemmer overens med token.
                    Al data fetches og ligges ind i sessions */
                $sql = "SELECT firstname, profilepicture, profiletext FROM pantUsers WHERE id = '$userID'";
                $response = $mySQL->query($sql);
                $user = $response->fetch_object();

                $_SESSION['firstname'] = $user->firstname;
                $_SESSION['profilepicture'] = $user->profilepicture;
                $_SESSION['profiletext'] = $user->profiletext;

                $reviews = "SELECT * FROM ratingCards WHERE ratedid = '$userID' ORDER BY id DESC LIMIT 4";
                // Udregner gennemsnittet af den kolonne som hedder rating i pantRating og gemmer det som avg(nyt navn)
                // ROUND afrunder tallet med en enkelt decimal
                $allReviews = "SELECT ROUND(AVG(rating), 1) AS avg FROM pantRating WHERE ratedid = '$userID'";
                $result = $mySQL->query($allReviews);
                $averageRating = $result->fetch_assoc();
            }
    ?>
<!DOCTYPE html>
<html lang="da">
    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panthenteren</title>
    <link rel="stylesheet" href="style.css">
    <!-- linket er for at få fremvist stjernerne -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/all.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>


<body class="body-height">
    <header class="header">
        <button class="tilbage-knap" onclick="history.back()"></button>
        <a href="index.php"><img class="header-logo" src="img/logo.png" alt="panthenter logo"></a>
        <a href=""><img class="noti" src="img/notifikation-ikon.png" alt="notifikation ikon"></a>
    </header>
    <img class="baggrund" src="img/baggrundsbillede.png" alt="baggrundsbillede">
    <main>
        
            <section>
                <?php
                
                /*  Hvis der endnu ikke er uploadet et billede til brugerens profil fremvises et dummy billede 
                    ellers fremvises det sidst uploadet billede i profilen */
                if(!isset($_SESSION['profilepicture'])){
                    echo "<img class='profilePics' src='img/dummy.jpg'></img>";
                } else {
                    echo "<img class='profilePics' src='original/" . $_SESSION['profilepicture'] . "'></img>";
                }
                if($averageRating['avg'] != NULL ){
                echo 
                "<figure class='rating-figur'>
                    <div class='rating-kasse'>
                        <span class='fa fa-star icon fa-star-ratingCard'></span>
                        <p class='userRating'>" . $averageRating['avg'] . "</p>
                    </div>
                </figure>";
                }
                //  Her viser den brugerens navn
                echo "<h2>" . $_SESSION['firstname'] . "</h2> <br>";
                ?>
                
                <a href="update.php"><img class="rediger-ikon" src="img/rediger-ikon.png" alt="rediger ikon"></a>                    
            </section> 

            <section class="backlayer">
                <h2 class="left-h2">Profiltekst</h2>
                    <?php
                    /*  Hvis der endnu ikke er lavet en profiltekst til brugerens profil fremvises et dummy tekst 
                        ellers fremvises profilteksten */
                    if($_SESSION['profiletext'] == NULL) {
                        echo "<p class='profiltekst'>Jeg har endnu ikke tilføjet en profil tekst, men jeg er rigtig god til at aflevere pant.</p>";
                    } else {
                        echo "<p class='profiltekst'>" . $_SESSION['profiletext'] . "</p>";
                    }                   
                    ?>
                
                <section class="index-headers">
                    <h2>Anmeldelser</h2>
                    <a href="all-reviews.php?id=<?php echo $userID ?>">se alle <b class="seAllePil">&rsaquo;</b></a>
                </section>
                <section class="index-scrolls">
                    <?php 
                        $showResult = $mySQL->query($reviews);
                        // var_dump($showResult);
                        while($dataRow = $showResult->fetch_object("RatingCards")) {
                        echo $dataRow->RatingCard();
                        }                                    
                    ?>
                </section>

                <section class="logout">
                    <!-- Navigere til logout.php som sletter sessionen og navigere tilbage til login.php -->
                    <a href="logout.php"><img class="logout-ikon" src="img/logout-ikon.png" alt="logout ikon"> Log af</a>
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