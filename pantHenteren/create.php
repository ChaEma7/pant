<?php 
        session_start();
        include("mysql.php");
        $status = isset($_REQUEST['status']) ? $_REQUEST['status'] : "";
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

<body>
    <img class="baggrund" src="img/baggrundsbillede.png" alt="baggrundsbillede">
<main>
    <img class="stort-logo" src="img/logo.png" alt="pant henteren logo">
        <h1 class="h1-left">Velkommen til!</h1>
        <p>Vær med til at hjælpe dig selv, miljøet og andre!</p>

         <section class="login-container backlayer">
                <form method="post" action="backend.php" enctype="multipart/form-data">
                    <p class="input-beskrivelse">Navn<strong>*</strong></p>
                        <input class="text-input" type="text" name="firstname" placeholder="Fornavn" required>
                        <div class="grid-input">
                            <div class="zipcode">
                                <p class="input-beskrivelse">Postnr.</p>
                                    <input class="text-input" type="number" name="zipcode" placeholder="0000">
                            </div>
                            <div class="city">
                                <p class="input-beskrivelse">By</p>
                                    <input class="text-input" type="text" name="city" placeholder="Bynavn">
                            </div>
                        </div>
                    <p class="input-beskrivelse">Email<strong>*</strong></p>
                        <input class="text-input" type="text" name="userEmail" placeholder="mail@mail.com" required>
                        <?php
                        // angiver fejlmeddelse, hvis den findes i URL'en
                        if($status == "userTaken") {
                            // udskriver status fra url'en
                            echo "<p class='fejlmeddelse'>Denne email er allerede brugt. <a class='brugt-email-link' href='login.php'>Log ind</a></p>";
                        }
                        ?>
                    <p class="input-beskrivelse">Kodeord<strong>*</strong></p>
                        <input class="text-input" type="password" name="password1" placeholder="Min. 8 tegn" required>
                    <p class="input-beskrivelse">Gentag kodeord<strong>*</strong></p>
                        <input class="text-input" type="password" name="password2" placeholder="Min. 8 tegn" required>
                        <?php
                        if($status == "passwordTooShort") {
                            // udskriver status fra url'en
                            echo "<p class='fejlmeddelse'>Koden skal være minimum 8 tegn lang</p>";
                        }
                        if($status == "passwordCreateFail") {
                            // udskriver status fra url'en
                            echo "<p class='fejlmeddelse'>Kodeord stemmer ikke overens</p>";
                        }
                        ?>
                    <br>
                    
                    <br>
                    <input class="btn" type="submit" name="createUser" value="Opret konto">
                </form>
                
                <p class="center">Har du allerede en bruger? <a href="login.php">Log ind</a></p>
                <br>
           
            
        </section>
    
</main>

    
</body>
</html>