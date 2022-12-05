<?php
    session_start();
    include("mysql.php");

// ================================== OPRET KONTO ======================================
    function check_if_username_is_taken($email){
            global $mySQL;
            //
            $sql = "SELECT * FROM pantLogin WHERE email = '$email'";
            $response = $mySQL->query($sql);
            // fetch_assoc() Henter resultatet af tabellens række som et sammenhængende array
            $email = $response->fetch_assoc();
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

        if(8 > strlen($userPassword1)) {
            header('Location: create.php?status=passwordTooShort');
            exit;
        }

        
        if($is_username_taken == true){
        header('Location: create.php?status=userTaken');
        exit;
        };
        
        if($userPassword1 !== $userPassword2)  {
            header("location: create.php?status=passwordCreateFail");
            exit;
        } else {
            // krypterer kodeordet til en en-vejs hashing
            $passEncrypt = password_hash($userPassword1, PASSWORD_DEFAULT);
            // Her indsættes de rigtige værdier ved brug af proceduren addPantUser
            $sql = "CALL addPantUser ('$firstname', '$zipcode', '$city',  '$email', '$passEncrypt')";
            $result = $mySQL->query($sql);

            $sql = "SELECT id FROM pantUsers ORDER BY id DESC LIMIT 1";
            $result = $mySQL->query($sql);
            $user = $result->fetch_assoc();

            $_SESSION['login'] = $user['id'];
            
            header("location: index.php");
            exit;
        }
        
    }
 // ==================================== LOGIN =======================================

    /* tager inputtet fra login formen i login.php og kontrollerer at de indtastede bruger informationer
       findes i meUsersLogin databasen */
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
                // token gives
                $_SESSION['login'] = $user->id;
                // der bliver logget ind og sendes til profile.php
                header("location: index.php");
            } else {
                // Giver fejlmeddelses i url'en, som læses af $status i login.php
                header("location: login.php?status=passwordFail");
            }
        }


    }

    // ==================================== UPDATE PROFILE =======================================

    if(isset($_POST['updateUser'])){
        $inputName = $_POST['firstname'];
        $inputProfileText = $_POST['profiletext'];
        $inputZipcode = $_POST['zipcode'];
        $inputCity = $_POST['city'];
        $inputEmail = $_POST['userEmail'];
        $userID = $_SESSION['login'];
        // Finder filen fra inputtet i index
        $file = $_FILES["fileToUpload"];

        $fileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        $allowedFiles = array("jpg", "jpeg");

        //var_dump($fileType);
        //exit;
        
        // File Upload
        if($file['name'] != "") {
            if(!in_array($fileType, $allowedFiles)) {
                $error_message = "<p>Beklager, din fil skal være af formatet jpg eller jpeg</p>";
                echo $error_message;
                exit;      
            } else {
                // Vælger hvilken (lokal)mappe den oploadet fil skal ligges i
                $targetFolder = "original/";
                // omdanner den uploadet fils navn til en genkendelig variabel???
                $fileName = $_SESSION['login'] . "_" . basename($file["name"]);
                // Flytter den navngivet fil til den rigtige mappe under det rigtige navn?
                move_uploaded_file($file["tmp_name"], $targetFolder . $fileName);

                if($fileName != ""){
                    $sql = "UPDATE pantUsers SET profilepicture = '$fileName' WHERE id = '$userID'";
                    $result = $mySQL->query($sql);
                } 
            }
        }

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

        $sql = "CALL deletePantUser ('$userID')";
        $result = $mySQL->query($sql);
        header("location: login.php"); 
    }

// ==================================== CREATE TASK =======================================

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
   
        
        $sql = "CALL addTask ( '$creatorID', '', '', '$bags', '$sacks', '$crates', '$pickup', '$earnings', '$timefrom', '$timeto', '$adress', '$zipcode', '$city', '$note')";
        $result = $mySQL->query($sql);
        // var_dump($sql);
        // exit;
        header("location: index.php");
        exit;                
    }
    
    
?>