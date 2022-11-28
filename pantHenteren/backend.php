<?php
    session_start();
    include("mysql.php");

// ================================== OPRET KONTO ======================================
    function check_if_username_is_taken($email){
            $sql = "SELECT * FROM pantLogin WHERE email = '$email'";
            $response = $mySQL->query($sql);
            // fetch_assoc() fetches a result row as an associative array
            $email = $response->fetch_assoc();
            $is_username_taken = is_array($email) ? is_array($email) : false;
            return $is_username_taken;
        }
    

    // Tager værdier fra signup formen fra index.php og indsætter dem i de korrekte databaser
    if(isset($_POST['createUser'])){
        $firstname = $_POST['firstname'];
        $zipcode = $_POST['zipcode'];
        $city = $_POST['city'];
        $email = $_POST['userEmail'];
        $userPassword1 = $_POST['password1'];
        $userPassword2 = $_POST['password2'];

        $is_username_taken = check_if_username_is_taken($email);

        if($is_username_taken == true){
        $_SESSION['user_message'] = "Denne email er allerede brugt!";
        header('Location: create.php');
        };
        
        if($userPassword1 !== $userPassword2)  {
            header("location: create.php?status=passwordCreateFail");
            
        } else {
            // krypterer kodeordet til en en-vejs hashing
            $passEncrypt = password_hash($userPassword1, PASSWORD_DEFAULT);
            // Her indsættes de rigtige værdier ved brug af proceduren addPantUser
            $sql = "CALL addPantUser ('$firstname', '$zipcode', '$city',  '$email', '$passEncrypt')";
            $result = $mySQL->query($sql);
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

?>