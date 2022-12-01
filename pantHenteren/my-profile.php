<?php 
        session_start();
        include("mysql.php");

              
        if(!isset($_SESSION['login'])){
            // Hvis der ikke er logget ind, sendes man tilbage til index.php
            header('location: login.php');
            exit;
            } else {
                $userID = $_SESSION['login'];

                /*  selecter betemst data fra pantUsers hvor id'et stemmer overens med token
                    al data fetches og ligges ind i sessions */
                $sql = "SELECT firstname, profilepicture, profiletext FROM pantUsers WHERE id = '$userID'";
                $response = $mySQL->query($sql);
                $user = $response->fetch_object();

                $_SESSION['firstname'] = $user->firstname;
                $_SESSION['profilepicture'] = $user->profilepicture;
                $_SESSION['profiletext'] = $user->profiletext;
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>


<body class="body-height">
    <header class="header">
        <button class="tilbage-knap" onclick="history.back()"></button>
        <a href="index.php"><img class="header-logo" src="img/logo.png" alt="panthenter logo"></a>
        <a href="404.php"><img class="noti" src="img/notifikation-ikon.png" alt="notifikation ikon"></a>
    </header>
    <main>
        
            <section>
                <div>
                    <?php
                    /*  Hvis der endnu ikke er uploadet et billede til brugerens profil fremvises et dummy billede 
                        ellers fremvises det sidst uploadet billede i profilen */
                    if(!isset($_SESSION['profilepicture'])){
                        echo "<img class='profilePics' src='img/dummy.jpg'></img>";
                    } else {
                        echo "<img class='profilePics' src='original/" . $_SESSION['profilepicture'] . "'></img>";
                    }
                    //  Her viser den brugerens navn
                    echo "<h2>" . $_SESSION['firstname'] . "</h2> <br>";
                    ?>
                    <a href="update.php"><img src="img/rediger-ikon.png" alt="rediger ikon"></a>
                    <?php
                    if($_SESSION['profiletext'] == NULL) {
                        echo "<p>Jeg har endnu ikke tilføjet en profil tekst, men jeg er rigtig god til at aflevere pant.</p>";
                    } else {
                        echo "<p>" . $_SESSION['profiletext'] . "</p>";
                    }                   
                    ?>
                    
                </div>
            </section> 

            <section class="logout">
                <a href="logout.php"><img src="img/logout-ikon.png" alt="logout ikon"> Log af</a>
            </section>

            <section>
                <br><br><br><br><br>
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