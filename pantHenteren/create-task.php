<?php 
    session_start();
        include("mysql.php");

        /* Hvis der ikke er logget ind sendes man tilbage til index.php */
        if(!isset($_SESSION['login'])){
            header('location: index.php');
            exit;
            } else {
                $userID = $_SESSION['login'];
            }
    $status = isset($_REQUEST['status']) ? $_REQUEST['status'] : "";
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

    <link href="https://rangeslider.js.org/assets/rangeslider.js/dist/rangeslider.css" rel="stylesheet"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://rangeslider.js.org/assets/rangeslider.js/dist/rangeslider.min.js"></script>
</head>

<body>
    <header class="update-header">
       
            <div class="update-logo"><a href="index.php"><img class="header-logo" src="img/logo.png" alt="panthenter logo"></a></div>
            <div class="update-luk"><button class="luk-knap" onclick="history.back()"></button></div>
        
    </header>
<img class="baggrund" src="img/baggrundsbillede.png" alt="baggrundsbillede">
    <main>
        
        
        <section class="backlayer">
            <h1>Opret opgave</h1>
            <form method="post" action="backend.php" enctype="multipart/form-data">
                <div class="header-info">
                    <h2 class="left-h2">Angiv mængde</h2>
                    <img src="img/info-ikon.png" alt="info ikon">
                </div>
                    <section class="emballage"> 
                        <div class="emballage-kasse">
                            <img src="img/poseikon.png" alt="pose ikon">
                            <p>Poser</p>
                        </div>
                        <div class="number-input">
                            <button onclick="this.parentNode.querySelector('input[type=number]').stepDown(); return false" ></button>
                                <input class="quantity" min="0" name="bags" value="0" type="number">
                            <button onclick="this.parentNode.querySelector('input[type=number]').stepUp(); return false" class="plus"></button>
                        </div>
                    </section> 
                    <section class="emballage"> 
                        <div class="emballage-kasse">
                            <img src="img/bagikon.png" alt="pose ikon">
                            <p>Sække</p>
                        </div>
                        <div class="number-input">
                            <button onclick="this.parentNode.querySelector('input[type=number]').stepDown(); return false" ></button>
                                <input class="quantity" min="0" name="sacks" value="0" type="number">
                            <button onclick="this.parentNode.querySelector('input[type=number]').stepUp(); return false" class="plus"></button>
                        </div>
                    </section> 
                    <section class="emballage"> 
                        <div class="emballage-kasse">
                            <img class="kasseikon" src="img/kasseikon.png" alt="pose ikon">
                            <p>Kasser</p>
                        </div>
                        <div class="number-input">
                            <button onclick="this.parentNode.querySelector('input[type=number]').stepDown(); return false" ></button>
                                <input class="quantity" min="0" name="crates" value="0" type="number">
                            <button onclick="this.parentNode.querySelector('input[type=number]').stepUp(); return false" class="plus"></button>
                        </div>
                    </section> 
                <div class="header-info">
                    <h2 class="left-h2">Afhentning</h2>
                    <img src="img/info-ikon.png" alt="info ikon">
                </div>
                    <div class="afhentnings-checkbox">
                        <div>
                            <input id="ftm" type="checkbox" name="pickup" onclick="onlyOne(this)" value="firstpick">
                            <label for="ftm">Først til mølle</label>
                        </div>
                        <div>
                            <input id="ga" type="checkbox" name="pickup" onclick="onlyOne(this)" value="accept">
                            <label for="ga">Godkend afhenter</label>
                        </div>
                    </div>

                <div class="header-info">
                    <h2 class="left-h2">Fordel udbyttet</h2>
                    <img src="img/info-ikon.png" alt="info ikon">
                </div>
                    <div>
                        <input type="range" id="udbytte" name="udbytte" min="0" max="100" value="50" step="5" oninput="this.nextElementSibling.value = this.value">
                        <div class="udbytte-container">
                            <div class="udbytte-kasse">
                                <p>Dig</p>
                                <div><output class="outputGiver">50</output>%</div>
                            </div>
                            <div class="udbytte-kasse udbytte-kasse-afhenter">
                                <p>Afhenter</p>
                                <div><output class="outputAfhenter">50 </output>%</div>
                            </div>
                        </div>
                        <script>
                            $('input[type="range"]');
                            $('#udbytte').on("input", function() {
                            $('.outputGiver').val(parseFloat(this.value).toFixed());
                            $('.outputAfhenter').val(parseFloat(100-this.value).toFixed());
                            }).trigger("change");
                        </script>
                    </div>
                    

                <div class="header-info">
                    <h2 class="left-h2">Angiv tidsrum</h2>
                    <img src="img/info-ikon.png" alt="info ikon">
                </div>
                    <div class="afhentnings-checkbox">
                        <!-- <div>
                            <input id="no-limit" type="checkbox" name="no-limit">
                            <label for="no-limit">Ubegrænset</label>
                        </div>
                        <div>
                            <input id="limit" type="checkbox" name="limit">
                            <label for="limit">Bestemt tidsrum</label>
                        </div> -->
                    </div>
                        <section class="tidsrum">
                            <div>
                                <label for="timefrom">Afhentes fra</label>
                                <input type="datetime-local" id="timefrom" name="timefrom">
                            </div>
                            <div>
                                <label for="timeto">Afhentes til</label>
                                <input type="datetime-local" id="timeto" name="timeto">
                            </div>
                            
                        </section>

                <div class="header-info">
                    <h2 class="left-h2">Angiv afhentnings adresse</h2>
                    <img src="img/info-ikon.png" alt="info ikon">
                </div>
                    <p class="input-beskrivelse">Adresse</p>
                    <input class="update-input" type="text" name="adress" placeholder="Adresse" required>
                    <div class="grid-input">
                        <div class="zipcode">
                            <p class="input-beskrivelse">Postnr.</p>
                                <input class="update-input" type="number" name="zipcode" value="<?php echo $_SESSION['zipcode']?>" required>
                        </div>
                        <div class="city">
                            <p class="input-beskrivelse">By</p>
                                <input class="update-input" type="text" name="city" value="<?php echo $_SESSION['city']?>" required>
                        </div>
                    </div>

                <div class="header-info">
                    <h2 class="left-h2">Note</h2>
                    <img src="img/info-ikon.png" alt="info ikon">
                </div>
                    <textarea name="note" id="note" cols="30" rows="5" placeholder=""></textarea>

                <input class="btn" type="submit" name="createTask" value="Opret opgave">

            </form>
            
        </section>
    </main>
    <script src="js.js"></script>
</body>

</html>