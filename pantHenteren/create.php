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
    <title>Opret konto</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<body>
    <img class="baggrund" src="img/baggrundsbillede.png" alt="baggrundsbillede">
<main>
    <img src="img/logo.png" alt="pant henteren logo">
        <h1>Velkommen til!</h1>
        <p>Vær med til at hjælpe dig selv, miljøet og andre!</p>

         <section class="login-container">
                <div>
                    <a href="" class="quikLogin">
                        <figure class="socialLogin-btn">
                            <img src="img/google-ikon.png" alt="google log ind">
                            <figcaption>Opret med Google</figcaption>
                        </figure>
                    </a>
                    <a href="" class="quikLogin">
                        <figure class="socialLogin-btn">
                            <img src="img/facebook-ikon-rund.png" alt="facebook log ind">
                            <figcaption>Opret med Facebook</figcaption>
                        </figure>
                    </a>
                </div>
                <div>
                    <p class="opdeler">eller opret med mail</p>
                </div>
                <form method="post" action="backend.php" enctype="multipart/form-data">
                    <p class="input-beskrivelse">Navn<strong>*</strong></p>
                        <input type="text" name="firstname" placeholder="Fornavn" required>
                        <div class="grid-input">
                            <div class="zipcode">
                                <p class="input-beskrivelse">Postnr.</p>
                                    <input type="number" name="zipcode" placeholder="0000">
                            </div>
                            <div class="city">
                                <p class="input-beskrivelse">By</p>
                                    <input type="text" name="city" placeholder="Bynavn">
                            </div>
                        </div>
                    <p class="input-beskrivelse">Email<strong>*</strong></p>
                        <input type="text" name="userEmail" placeholder="mail@mail.com" required>
                        <?php
                        if($status == "userTaken") {
                            // udskriver status fra url'en
                            echo "Denne email er allerede brugt";
                        }
                        ?>
                    <p class="input-beskrivelse">Kodeord<strong>*</strong></p>
                        <input type="password" name="password1" placeholder="Min. 8 tegn" required>
                    <p class="input-beskrivelse">Gentag kodeord<strong>*</strong></p>
                        <input type="password" name="password2" placeholder="Min. 8 tegn" required>
                        <?php
                        if($status == "passwordTooShort") {
                            // udskriver status fra url'en
                            echo "Koden skal være minimum 8 tegn lang";
                        }
                        ?>
                    <br>
                    
                    <br>
                    <input class="btn" type="submit" name="createUser" value="Opret konto">
                </form>
                <?php
                if($status == "passwordCreateFail") {
                    // udskriver status fra url'en
                    echo "Kodeord stemmer ikke overens";
                }
                
                ?>
                <p>Har du allerede en bruger? <a href="login.php">Log ind</a></p>
           
            
        </section>


        </form>
    
</main>

    
</body>
</html>