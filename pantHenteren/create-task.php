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
            <h1>Opret opgave</h1>
            <form method="post" action="backend.php" enctype="multipart/form-data">
                <div class="header-info">
                    <h2 class="left-h2">Angiv mængde</h2>
                    <img src="" alt="">
                </div>
                <!--
                <div class="amount">
                    <span class="minus">-</span>
                    <form action="">
                        <input class="amount-input" type="number" ><span class="amount-input">0</span>
                    </form>
                    <span class="plus">+</span>
                </div> -->

                <div class="number-input">
                    <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" ></button>
                        <input class="quantity" min="0" name="quantity" value="0" type="number">
                    <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button>
                </div>
                

            </form>
            
        </section>
    </main>
    
</body>

</html>