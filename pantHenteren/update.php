<?php 
        session_start();
        include("mysql.php");
        $status = isset($_REQUEST['status']) ? $_REQUEST['status'] : "";

        if(!isset($_SESSION['login'])){
            // Hvis der ikke er logget ind, sendes man tilbage til index.php
            header('location: login.php');
            exit;
        } else {
            $userID = $_SESSION['login'];

            /*  selecter betemst data fra pantUsers hvor id'et stemmer overens med token
                al data fetches og ligges ind i sessions */
            $sql = "SELECT * FROM pantUsers WHERE id = '$userID'";
            $response = $mySQL->query($sql);
            $user = $response->fetch_object();

            $_SESSION['firstname'] = $user->firstname;
            $_SESSION['zipcode'] = $user->zipcode;
            $_SESSION['city'] = $user->city;
            $_SESSION['profilepicture'] = $user->profilepicture;
            $_SESSION['profiletext'] = $user->profiletext;

            $sql = "SELECT email FROM pantLogin WHERE id = '$userID'";
            $response = $mySQL->query($sql);
            $user = $response->fetch_object();

            $_SESSION['email'] = $user->email;
        }
?>
<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update profil</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
</head>

<body>
    <header class="update-header">
       
            <div class="update-logo"><a href="index.php"><img class="header-logo" src="img/logo.png" alt="panthenter logo"></a></div>
            <div class="update-luk"><button class="luk-knap" onclick="history.back()"></button></div>
        
    </header>
<img class="baggrund" src="img/baggrundsbillede.png" alt="baggrundsbillede">
    <main>
        
        
        <section class="backlayer">
            <h1>Rediger profil</h1>
            <form id="update-form" method="post" action="backend.php" enctype="multipart/form-data">
                <?php
                    if(!isset($_SESSION['profilepicture'])){
                            echo "<img class='profilePics' src='img/dummy.jpg'></img>";
                        } else {
                            echo "<img class='profilePics' src='original/" . $_SESSION['profilepicture'] . "'></img>";
                        } 
                ?>
                <p class="input-beskrivelse">Opdater dit profilbillede</p>
                    <input class="file-upload" type="file" name="fileToUpload">
                <br>
                <br>
                <p class="input-beskrivelse">Opdater din profiltekst</p>
                    <textarea name="profiletext" id="protext" cols="30" rows="5" placeholder="Din profiltekst..."><?php echo $_SESSION['profiletext'] ?></textarea>
                <p class="input-beskrivelse">Navn</p>
                    <input class="update-input" type="text" name="firstname" placeholder="<?php echo $_SESSION['firstname']?>">
                    <div class="grid-input">
                        <div class="zipcode">
                            <p class="input-beskrivelse">Postnr.</p>
                                <input class="update-input" type="number" name="zipcode" placeholder="<?php echo $_SESSION['zipcode']?>">
                        </div>
                        <div class="city">
                            <p class="input-beskrivelse">By</p>
                                <input class="update-input" type="text" name="city" placeholder="<?php echo $_SESSION['city']?>">
                        </div>
                    </div>
                <p class="input-beskrivelse">Email</p>
                    <input class="update-input" type="text" name="userEmail" placeholder="<?php echo $_SESSION['email']?>">
                    <br>
                    <?php
                    if($status == "userTaken") {
                        // udskriver status fra url'en
                        echo "Den indtastede email er allerede brugt";
                    }
                    ?>
                <br>
                <a class="nedtonet" href="">Ændre adgangskode</a>
                <br>
                <input class="btn" type="submit" name="updateUser" value="Gem ændringer">
                <br>
                <button class="slet-btn nedtonet" onclick="togglePopup(); return false">Slet konto</button>

                <section class="popup" id="popup-delete">
                    <section class="popup-overlay"></section>
                    <section class="popup-content">
                        <section class="close-btn" onclick="togglePopup()"><img src="img/luk-ikon.png" alt="luk ikon"></section>
                        <h2>Er du sikker på, at du vil slette din konto?</h2>
                        <section class="popup-btns">
                            <button class="annuller-btn" onclick="togglePopup(); return false">Annuller</button>
                            <input class="delete-btn" type="submit" name="deleteUser" value="Slet konto">
                        </section>
                    </section>
                </section>
            
            </form>
            
        </section>

        
    </main>
    <script src="js.js"></script>
</body>

</html>