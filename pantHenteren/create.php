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
</head>

<body>
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
                    <p class="input-beskrivelse">Postnr.<strong>*</strong></p>
                        <input type="number" name="zipcode" placeholder="0000" required>
                    <p class="input-beskrivelse">By<strong>*</strong></p>
                        <input type="text" name="city" placeholder="Bynavn" required>
                    <p class="input-beskrivelse">Email<strong>*</strong></p>
                        <input type="text" name="userEmail" placeholder="mail@mail.com" required>
                    <p class="input-beskrivelse">Kodeord<strong>*</strong></p>
                        <input type="password" name="password1" placeholder="Min. 8 tegn" required>
                    <p class="input-beskrivelse">Gentag kodeord<strong>*</strong></p>
                        <input type="password" name="password2" placeholder="Min. 8 tegn" required>
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