<?php 
        session_start();
        include("mysql.php");
        // læser om der er en status i url'en, ellers sættes den som tom
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
        <p>Måske en fed sætning her!</p>

        <section class="login-container backlayer">
                <div class="quikLogin">
                    <a href="">
                        <figure class="socialLogin-btn">
                            <img src="img/google-ikon.png" alt="google log ind">
                            <figcaption>Log ind med Google</figcaption>
                        </figure>
                    </a>
                    <a href="">
                        <figure class="socialLogin-btn">
                            <img src="img/facebook-ikon-rund.png" alt="facebook log ind">
                            <figcaption>Log ind med Facebook</figcaption>
                        </figure>
                    </a>
                </div>
                <div>
                    <p class="opdeler">eller log ind med mail</p>
                </div>
                <form  method="post" action="backend.php">
                    <p class="input-beskrivelse">Email<strong>*</strong></p>
                        <input class="text-input" type="text" name="userEmail" placeholder="mail@mail.com" required>
                    <p class="input-beskrivelse">Kodeord<strong>*</strong></p>
                        <input class="text-input" type="password" name="password" placeholder="Min. 8 tegn" required>
                    <div class="kode-box">
                        <div>
                            <input id="husk-input" type="checkbox" name="husk" >
                            <label for="husk-input">Husk mig</label>
                        </div>
                        <a href="">Glemt kodeord?</a>
                    </div>
                        <input class="btn" type="submit" name="login" value="Log ind">
                </form>
                <p class="center">Ikke oprettet endnu? <a href="create.php">Opret konto</a></p>
           
            
        </section>
        <section>
            <?php
                if($status == "passwordFail") {
                    // udskriver status fra url'en
                    echo "Password incorrect";
                }
                if($status == "usernameFail") {
                    // udskriver status fra url'en
                    echo "Username incorrect";
                }
            ?>
        </section>
    </main>
</body>
</html>