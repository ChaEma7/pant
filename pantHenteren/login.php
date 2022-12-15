<?php 
        session_start();
        include("mysql.php");
        // Læser om der er en status i url'en, ellers sættes den som tom
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


<body class="body-height">
    <img class="baggrund" src="img/baggrundsbillede.png" alt="baggrundsbillede">
    <main>
        <img class="stort-logo" src="img/logo.png" alt="pant henteren logo">
        <h1 class="h1-left">Hej!</h1>
        <p>Vær med til at hjælpe dig selv, miljøet og andre!</p>

        <section class="login-container backlayer">
                
                <form  method="post" action="backend.php">
                    <p class="input-beskrivelse">Email<strong>*</strong></p>
                        <input class="text-input" type="text" name="userEmail" placeholder="mail@mail.com" required>
                        <?php
                            if($status == "usernameFail") {
                                // Udskriver status fra url'en
                                echo "<p class='fejlmeddelse'>Ugyldig e-mail</p>";
                            }
                        ?>
                    <p class="input-beskrivelse">Kodeord<strong>*</strong></p>
                        <input class="text-input" type="password" name="password" placeholder="Min. 8 tegn" required>
                        <?php
                            if($status == "passwordFail") {
                                // Udskriver status fra url'en
                                echo "<p class='fejlmeddelse'>Forkert kodeord</p>";
                        }?>
                   
                        <input class="btn" type="submit" name="login" value="Log ind">
                </form>
                <p class="center">Ikke oprettet endnu? <a href="create.php">Opret konto</a></p>
                <br>
        </section>
    </main>
</body>
</html>