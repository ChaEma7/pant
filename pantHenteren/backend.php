<?php
    session_start();
    include("mysql.php");

// ================================== OPRET KONTO ======================================
// Funktion som henter alle emails fra pantLogin tabellen og ser om emailen allerede er i brug
    function check_if_username_is_taken($email){
            // For at kunne tilgå mySQL i funktionen, laves den som en global variabel
            global $mySQL;
            
            $sql = "SELECT * FROM pantLogin WHERE email = '$email'";
            $response = $mySQL->query($sql);
            // Fetch_assoc() Henter resultatet af tabellens række som et sammenhængende array
            $email = $response->fetch_assoc();
            // Spørger om emailen allerede findes i arrayet -> hvis ikke gives værdien false
            $is_username_taken = is_array($email) ? is_array($email) : false;
            return $is_username_taken;
        }
    

    // Tager værdier fra createUser formen fra create.php og indsætter dem i de korrekte databaser
    if(isset($_POST['createUser'])){
        $firstname = $_POST['firstname'];
        $zipcode = $_POST['zipcode'];
        $city = $_POST['city'];
        $email = $_POST['userEmail'];
        $userPassword1 = $_POST['password1'];
        $userPassword2 = $_POST['password2'];

        $is_username_taken = check_if_username_is_taken($email);

        // Kontrollerer at koden er længere end 8 cifre. Hvis ikke sendes status i URL'en, som læses på create.php
        if(8 > strlen($userPassword1)) {
            header('Location: create.php?status=passwordTooShort');
            exit;
        }

        // Kontrollerer om emailen allerede findes. Hvis den gør sendes status i URL'en, som læses på create.php
        if($is_username_taken == true){
        header('Location: create.php?status=userTaken');
        exit;
        };
        
        // Kontrollerer om de to indtastede kodeord er ens. Hvis ikke sendes status i URL'en, som læses på create.php
        if($userPassword1 !== $userPassword2)  {
            header("location: create.php?status=passwordCreateFail");
            exit;
        } else {
            // Krypterer kodeordet til en en-vejs hashing
            $passEncrypt = password_hash($userPassword1, PASSWORD_DEFAULT);
            // Her indsættes de rigtige værdier ved brug af proceduren addPantUser
            $sql = "CALL addPantUser ('$firstname', '$zipcode', '$city',  '$email', '$passEncrypt')";
            $result = $mySQL->query($sql);

            // Sørger for, at man automatisk er logget ind, når profilen er blevet oprettet. Ved at vælge det senest oprettede id.
            $sql = "SELECT id FROM pantUsers ORDER BY id DESC LIMIT 1";
            $result = $mySQL->query($sql);
            $user = $result->fetch_assoc();
            // Id'et lægges ind i SESSION'en
            $_SESSION['login'] = $user['id'];
            
            header("location: index.php");
            exit;
        }
        
    }
 // ==================================== LOGIN =======================================

    /* Tager inputtet fra login formen i login.php og kontrollerer, at de indtastede brugerinformationer
       findes i pantLogin databasen */
    if(isset($_POST['login'])){
        $inputUserEmail = $_POST['userEmail'];
        $inputUserPassword = $_POST['password'];


        $sql = "SELECT id, userPassword FROM pantLogin WHERE email = '$inputUserEmail'";
        $response = $mySQL->query($sql);

        $user = $response->fetch_object();

        /*  Verificerer brugernavn og password, hvis ikke kan der ikke logges ind og der gives en 
            en fejlmeddelselse */ 
        if($user == NULL){
            // Giver fejlmeddelses i url'en, som læses af $status i login.php
            header("location: login.php?status=usernameFail");
        } else {
            $passwordVerify = password_verify($inputUserPassword, $user->userPassword);
            if($passwordVerify == true){
                // Token gives
                $_SESSION['login'] = $user->id;
            
                /*  Selecter al data fra pantUsers og email fra pantLogin hvor id'et stemmer overens med token.
                Al data fetches og lægges ind i sessions for at det kan tilgås på hele sitet */
                $userID = $user->id;
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


                // Der bliver logget ind og sendes til profile.php
                header("location: index.php");
            } else {
                // Giver fejlmeddelses i url'en, som læses af $status i login.php
                header("location: login.php?status=passwordFail");
            }
        }


    }

    // ==================================== UPDATE PROFILE =======================================
    // Tager de intastede værdier fra updateUser formen fra update.php og indsætter dem i den korrekte database
    if(isset($_POST['updateUser'])){
        $inputName = $_POST['firstname'];
        $inputProfileText = $_POST['profiletext'];
        $inputZipcode = $_POST['zipcode'];
        $inputCity = $_POST['city'];
        $inputEmail = $_POST['userEmail'];
        $userID = $_SESSION['login'];
        // Finder filen fra inputtet i index
        $file = $_FILES["fileToUpload"];
        //Sørger for at alle billedfiler læses som lowercase og at der kun kan vedlægges bestemte filtyper
        $fileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        $allowedFiles = array("jpg", "jpeg");
        
        // Fil upload
        if($file['name'] != "") {
            if(!in_array($fileType, $allowedFiles)) {
                // Giver fejlmeddelses i url'en, som læses af $status i update.php
                header("location: update.php?status=pictureFail");
                exit;      
            } else {
                // Vælger hvilken (lokal)mappe den uploadede fil skal ligges i
                $targetFolder = "original/";
                // Omdanner den uploadede fils navn til en genkendelig variabel
                $fileName = $_SESSION['login'] . "_" . basename($file["name"]);
                // Flytter den navngivet fil til den rigtige mappe under det rigtige navn
                move_uploaded_file($file["tmp_name"], $targetFolder . $fileName);
                
                if($fileName != ""){
                    $sql = "UPDATE pantUsers SET profilepicture = '$fileName' WHERE id = '$userID'";
                    $result = $mySQL->query($sql);
                } 
            }
        }
        // Hvis inputet ikke er tomt opdateres pantUsers med den nye værdi
        if($inputName != ""){
            $sql = "UPDATE pantUsers SET firstname = '$inputName' WHERE id = '$userID' ";
            $result = $mySQL->query($sql);
        }

        if($inputProfileText != ""){
            $sql = "UPDATE pantUsers SET profiletext = '$inputProfileText' WHERE id = '$userID'";
            $result = $mySQL->query($sql);
        }
        
        if($inputZipcode != ""){
            $sql = "UPDATE pantUsers SET zipcode = '$inputZipcode' WHERE id = '$userID' ";
            $result = $mySQL->query($sql); 
        } 

        if($inputCity != ""){
            $sql = "UPDATE pantUsers SET city = '$inputCity' WHERE id = '$userID' ";
            $result = $mySQL->query($sql); 
        } 
        // Hvis email ændres kontrolleres det igen, at den ønskede email ikke allerede er brugt
        if($inputEmail != ""){
                $is_username_taken = check_if_username_is_taken($inputEmail);

                if($is_username_taken == true){
                    header('Location: update.php?status=userTaken');
                    exit;
                } else {
                    $sql = "UPDATE pantLogin SET email = '$inputEmail' WHERE id = '$userID' ";
                    $result = $mySQL->query($sql); 
                }
        } 

        header("location: my-profile.php"); 
           
    }

    

// ==================================== DELETE PROFILE =======================================

    
     if(isset($_POST['deleteUser'])){
        $userID = $_SESSION['login'];
        // Kalder proceduren deletePantUser som sletter brugeren/rækken fra databasen
        $sql = "CALL deletePantUser ('$userID')";
        $result = $mySQL->query($sql);
        header("location: login.php"); 
    }

// ==================================== CREATE TASK =======================================
// Opretter en opgave/række i pantTask tabellen
if(isset($_POST['createTask'])){
        $bags = $_POST['bags'];
        $sacks = $_POST['sacks'];
        $crates = $_POST['crates'];
        $pickup = $_POST['pickup'];
        $earnings = 100 - $_POST['udbytte'];
        $timefrom = $_POST['timefrom'];
        $timeto = $_POST['timeto'];
        $adress = $_POST['adress'];
        $zipcode = $_POST['zipcode'];
        $city = $_POST['city'];
        $note = $_POST['note'];
        $creatorID = $_SESSION['login'];

        if($timefrom > $timeto){
            header("location: create-task.php?status=dateFail");
            exit;
        } else {
            // Kalder addTask proceduren og indsætter de rigtige værdier i de rigtige kolonner
            $sql = "CALL addTask ( '$creatorID', '', '', '$bags', '$sacks', '$crates', '$pickup', '$earnings', '$timefrom', '$timeto', '$adress', '$zipcode', '$city', '$note')";
            $result = $mySQL->query($sql);
            
            header("location: your-tasks.php");
            exit; 
        }               
    }
    
// ==================================== BOOK OPGAVE =======================================

  if(isset($_POST['bookTask'])){
        $userID = $_SESSION['login'];
        $taskID = $_REQUEST['taskID'];

        // Kalder bookTask proceduren som indsætter login id'et i tabellen pantTask som takerid.
        // TaskID vælger den rigtige opgave, som bliver booket
        $sql = "CALL bookTask ('$userID', '$taskID')";
        $result = $mySQL->query($sql);
        
        header("location: your-tasks.php");
        exit;         
    }

// ==================================== ANULLER OPGAVE =======================================
// Fjerner takerid på pantTask og sætter den tilbage til NULL, hvilket frigiver opgaven, så andre kan booke den
  if(isset($_POST['releaseTask'])){
        $taskID = $_REQUEST['taskID'];

        $sql = "CALL releaseTask ('$taskID')";
        $result = $mySQL->query($sql);
        
        header("location: your-tasks.php");
        exit;         
    }

    // ==================================== AFSLUT OPGAVE =======================================
// Ændrer værdien active i pantTask fra 1 til 0, hvilket afslutter opgaven
  if(isset($_POST['taskDone'])){
        $taskID = $_REQUEST['taskID'];

        $sql = "CALL taskDone ('$taskID')";
        $result = $mySQL->query($sql);
        
        header("location: task-done.php?id=$taskID");
        exit;         
    }

// ==================================== REDIGER OPGAVE =======================================

// Vidersender til edit-task.php?id=$taskID når der trykkes på redigér knappen på task-detals.php
  if(isset($_POST['editTask'])){  
        $taskID = $_REQUEST['taskID'];
        $userID = $_SESSION['login'];

        header("location: edit-task.php?id=$taskID");
        exit;
    }

// Tager de intastede værdier fra updateTask formen fra edit-task.php og indsætter dem i den korrekte database
  if(isset($_POST['updateTask'])){
        $taskID = $_REQUEST['taskID'];
        
        $inputbags = $_POST['bags'];
        $inputsacks = $_POST['sacks'];
        $inputcrates = $_POST['crates'];
        $inputpickup = $_POST['pickup'];
        $inputearnings = 100 - $_POST['udbytte'];
        $inputdatefrom = $_POST['timefrom'];
        $inputdateto = $_POST['timeto'];
        $inputadress = $_POST['adress'];
        $inputzipcode = $_POST['zipcode'];
        $inputcity = $_POST['city'];
        $inputnote = $_POST['note'];

        // Hvis inputet ikke er tomt opdateres pantTask med den nye værdi
        if($inputbags != ""){
            $sql = "UPDATE pantTask SET bags = '$inputbags' WHERE id = '$taskID' ";
            $result = $mySQL->query($sql);
        }

        if($inputsacks != ""){
            $sql = "UPDATE pantTask SET sacks = '$inputsacks' WHERE id = '$taskID' ";
            $result = $mySQL->query($sql);
        }

        if($inputcrates != ""){
            $sql = "UPDATE pantTask SET crates = '$inputcrates' WHERE id = '$taskID' ";
            $result = $mySQL->query($sql);
        }

        if($inputpickup != ""){
            $sql = "UPDATE pantTask SET pickup = '$inputpickup' WHERE id = '$taskID' ";
            $result = $mySQL->query($sql);
        }

        if($inputearnings != ""){
            $sql = "UPDATE pantTask SET earnings = '$inputearnings' WHERE id = '$taskID' ";
            $result = $mySQL->query($sql);
        }

        if($inputdatefrom != ""){
            $sql = "UPDATE pantTask SET datefrom = '$inputdatefrom' WHERE id = '$taskID' ";
            $result = $mySQL->query($sql);
        }

        if($inputdateto != ""){
            $sql = "UPDATE pantTask SET dateto = '$inputdateto' WHERE id = '$taskID' ";
            $result = $mySQL->query($sql);
        }

        if($inputadress != ""){
            $sql = "UPDATE pantTask SET adress = '$inputadress' WHERE id = '$taskID' ";
            $result = $mySQL->query($sql);
        }

        if($inputzipcode != ""){
            $sql = "UPDATE pantTask SET zipcode = '$inputzipcode' WHERE id = '$taskID' ";
            $result = $mySQL->query($sql);
        }

        if($inputcity != ""){
            $sql = "UPDATE pantTask SET city = '$inputcity' WHERE id = '$taskID' ";
            $result = $mySQL->query($sql);
        }

        if($inputnote != ""){
            $sql = "UPDATE pantTask SET note = '$inputnote' WHERE id = '$taskID' ";
            $result = $mySQL->query($sql);
        }

        header("location: task-detail.php?id=$taskID");
        exit;
    }

    


// ==================================== ANNULLER OPGAVE =======================================
// Sletter opgaven/rækken fra pantTask
  if(isset($_POST['cancelTask'])){
        $taskID = $_REQUEST['taskID'];

        $sql = "CALL deleteTask ('$taskID')";
        $result = $mySQL->query($sql);
        
        header("location: your-tasks.php");
        exit;         
    }

// ==================================== ANMELD =======================================

// Vidersender til edit-task.php?id=$taskID når der trykkes på redigér knappen på task-detals.php
  if(isset($_POST['giveRating'])){  
        $taskID = $_REQUEST['taskID'];
        $userID = $_SESSION['login'];

        header("location: rate-user.php?id=$taskID");
        exit;
    }

?>