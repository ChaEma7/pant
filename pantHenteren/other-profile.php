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
                $userID = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
                // Hvis der trykkes på eget billede sendes man til sin egen profil
                if($userID == $_SESSION['login']){
                    header('location: my-profile.php');
                    exit; 
                }
                // Hvis der trykkes på en anden bruger sendes man til brugerens profil.
                // Den aktuelle brugers oplysninger bliver gemt i sessions og fremvist på siden.
                // $userID bliver sendt med i url'en når der navigeres til siden (TaskDetail.php klassen).
                $sql = "SELECT firstname, profilepicture, profiletext FROM pantUsers WHERE id = '$userID'";
                $response = $mySQL->query($sql);
                $user = $response->fetch_object();

                $_SESSION['firstname'] = $user->firstname;
                $_SESSION['profilepicture'] = $user->profilepicture;
                $_SESSION['profiletext'] = $user->profiletext;

                $reviews = "SELECT * FROM ratingCards WHERE ratedid = '$userID' ORDER BY id DESC LIMIT 4";
                $response = $mySQL->query($reviews);
                $review = $response->fetch_object();

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
                    <div class="backlayer">
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

                        <section class="reviews-kasse">  
                            <section class="index-headers">
                                <h2>Anmeldelser</h2>
                                <a href="all-reviews.php?id=<?php echo $userID ?>">se alle <b class="seAllePil">&rsaquo;</b></a>
                            </section>
                            <section class="index-scrolls">
                                <?php 
                                    if($response->num_rows > 0) {
                                        // Finder review idet og ligger det i en session som sendes videre til backend, hvis der slettes
                                        $_SESSION['reviewID'] = $review->id;
                                        $showResult = $mySQL->query($reviews);
                                        while($dataRow = $showResult->fetch_object("RatingCards")) {
                                        echo $dataRow->RatingCard();}
                                    } else {
                                        echo "<p class='dummytekst center dummytekst-profile'>Der er endnu ingen anmeldelser</p>";
                                    }                     
                                ?>
                            </section>
                        </section>  
                    </div>
            </section> 

            <section class='popup' id='popup-detele-review'>
                <section class='popup-overlay'></section>
                <section class='popup-content'>
                    <section class='close-btn' onclick='togglePopupDeleteReview()'><img src='img/luk-ikon.png' alt='luk ikon'></section>
                    <h2 class='release-h2 delete-review-h2'>Er du sikker på, at du vil slette dit anmeldelse af <?php echo $_SESSION['firstname'] ?>?</h2>
                    <section class='popup-btns'>
                        <button class="annuller-btn" onclick="togglePopupDeleteReview()">Annuller</button>
                        <form method='post' action='backend.php?reviewID=<?php echo $_SESSION['reviewID']?>&userID=<?php echo $userID?>'>
                            <input class='delete-btn' type='submit' name='delete-review-from-other-profile' value='Slet anmeldelse'>
                        </form>
                    </section>
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
<script src="js.js"></script>
</html>