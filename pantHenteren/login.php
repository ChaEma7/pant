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
    <main>
        <img src="img/logo.png" alt="pant henteren logo">
        <h1>Hej!</h1>
        <p>Måske en fed sætning her!</p>

        <section class="login-container">
                <div>
                    <a href="" class="quikLogin">
                        <figure class="socialLogin-btn">
                            <img src="img/google-ikon.png" alt="google log ind">
                            <figcaption>Log ind med Google</figcaption>
                        </figure>
                    </a>
                    <a href="" class="quikLogin">
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
                    <input type="text" name="userEmail" placeholder="mail@mail.com" required>
                    <p class="input-beskrivelse">Kodeord<strong>*</strong></p>
                    <input type="password" name="password" placeholder="Min. 8 tegn" required>
                    <br>
                    <input id="husk" type="checkbox" name="husk" value="Husk mig">
                    <label for="husk">Husk mig</label>
                    <a href="">Glemt kodeord?</a>
                    <br>
                    <input class="btn" type="submit" name="login" value="Log ind">
                </form>
                <p>Ikke oprettet endnu? <a href="create.php">Opret konto</a></p>
           
            
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