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
    $ratedID = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
    $allReviews = "SELECT * FROM ratingCards WHERE ratedid = '$ratedID' ORDER BY id DESC";
    $sql = "SELECT firstname FROM pantUsers WHERE id = '$ratedID'";
        $response = $mySQL->query($sql);
        $thisUser = $response->fetch_object();
    $_SESSION['firstname'] = $thisUser->firstname;

    $allReviews = "SELECT * FROM ratingCards WHERE ratedid = '$ratedID' ORDER BY id DESC LIMIT 4";
    $response = $mySQL->query($allReviews);
    $review = $response->fetch_object();


?>
<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PantHenteren</title>
    <link rel="stylesheet" href="style.css">
    <!-- linket er for at få fremvist stjernerne -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/all.css"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
    <body>
        <img class="baggrund" src="img/baggrundsbillede.png" alt="baggrundsbillede">
        <header class="header">
                <button class="tilbage-knap" onclick="history.back()"></button>
                <a href="index.php"><img class="header-logo" src="img/logo.png" alt="panthenter logo"></a>
                <a href=""><img class="noti" src="img/notifikation-ikon.png" alt="notifikation ikon"></a>
        </header>
       <main>
                <h2>Hvad siger folk om <?php echo $_SESSION['firstname'] ?>?</h2>
                <section class="allreviews-kasse">
                    <?php 
                        if($response->num_rows > 0) {
                            // Finder review idet og ligger det i en session som sendes videre til backend, hvis der slettes
                            $_SESSION['reviewID'] = $review->id;
                            $showResult = $mySQL->query($allReviews);
                            while($dataRow = $showResult->fetch_object("RatingDetail")) {
                            echo $dataRow->Reviews();
                        }} else {
                            echo "<p class='dummytekst center dummytekst-profile'>Der er endnu ingen anmeldelser</p>";
                        }                              
                    ?>
                </section>
                <section class='popup' id='popup-detele-review'>
                    <section class='popup-overlay'></section>
                    <section class='popup-content'>
                        <section class='close-btn' onclick='togglePopupDeleteReviewOverview()'><img src='img/luk-ikon.png' alt='luk ikon'></section>
                        <h2 class='release-h2 delete-review-h2'>Er du sikker på, at du vil slette dit anmeldelse af <?php echo $_SESSION['firstname'] ?>?</h2>
                        <section class='popup-btns'>
                            <button class="annuller-btn" onclick="togglePopupDeleteReviewOverview()">Annuller</button>
                            <form method='post' action='backend.php?reviewID=<?php echo $_SESSION['reviewID']?>&userID=<?php echo $ratedID?>'>
                                <input class='delete-btn' type='submit' name='delete-review-from-all-reviews' value='Slet anmeldelse'>
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