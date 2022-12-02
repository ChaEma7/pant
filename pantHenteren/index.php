<?php 
        include("mysql.php");
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
<img class="baggrund" src="img/baggrundsbillede.png" alt="baggrundsbillede">
<body>
        <header class="header">
                <button class="tilbage-knap" onclick="history.back()"></button>
                <a href="index.php"><img class="header-logo" src="img/logo.png" alt="panthenter logo"></a>
                <a href="404.php"><img class="noti" src="img/notifikation-ikon.png" alt="notifikation ikon"></a>
        </header>
        <h1>Index</h1>
        <footer>
                <nav>
                        <a href="tasks.php"><img class="nav-ikon" src="img/liste-ikon.png" alt="opgaveliste ikon"></a>
                        <a href="create-task.php"><img class="add-ikon" src="img/plus-ikon.png" alt="Opret opgave ikon"></a>
                        <a href="my-profile.php"><img class="nav-ikon" src="img/profil-ikon.png" alt="profil ikon"></a>
                </nav>
        </footer>
</body>
</html>