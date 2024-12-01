<?php
    include("../phpFiles/dbConnect.php");
    session_start();
    $errorPrompt = array();
    
    if(isset($_POST["login"])){
        $emailLog = $_POST["emailLogin"];
        $passLog= $_POST["passwordLogin"];
        
        $checkExistence = "SELECT * FROM accounts WHERE accEmail = '$emailLog'";
        try{
            $resultExist = mysqli_query($conn, $checkExistence);
        }catch(mysqli_sql_exception){
            echo "Login Error";
        }

        if(mysqli_num_rows($resultExist) > 0){
            $row = mysqli_fetch_assoc($resultExist);
            $dbAccountRole = $row["accRole"];
            $dbEmail = $row["accEmail"];
            $dbPass = $row["accPassword"];

            if($dbPass != $passLog){
                $errorPrompt["passIncorrect"] = "Incorrect Password<br>";
            }else{
                $_SESSION["activeUser"] = $row["accFirstName"] . " ". $row["accLastName"];
                $_SESSION["accRole"] = $dbAccountRole;
                $_SESSION['loggedIn'] = true;
                header("Location: dashboard.php");
            }
        }else{
            $errorPrompt["noEmail"] = "Email Doesn't Exist<br>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome!</title>
    <?php include("../pages/header.php");?>
    <link rel="stylesheet" href = "../styles/loginReg.css">
    <script type="text/javascript" src ="../scripts/loginLoad.js"></script>
</head> 
    <body>
        <section id = "mainWelcome">
            <div class = "logRegCont">
                <div class = "leftSide" id ="left">
                    <a href="index.php">
                    <img src = "../images/clinic_logo.png" id = "logoClinic">
                    </a>
                    <h1>Welcome Back</h1>
                    <form autocomplete="off" action = "loginReg.php" id = "formLog" class = "inputFormLog" name ="formLog" method = "post">
                        <ion-icon name="mail-outline" class = "icon"></ion-icon>
                        <input type ="email" id = "emailLogin" class = "inputLogin" name = "emailLogin" placeholder="Email" required><br>
                        <ion-icon name="key-outline" class = "icon"></ion-icon>
                        <input type ="password" id = "passwordLogin" class = "inputLogin" name = "passwordLogin" placeholder="Password" required> 
                        <img src = "../images/hidePass.png" id ="passImageLog" class = "passImg"><br>
                        <p class = "errorOutput" id = "errorOutput">
                            <?php 
                                if(isset($errorPrompt["noEmail"])){
                                    echo $errorPrompt["noEmail"];
                                }elseif(isset($errorPrompt["passIncorrect"])){
                                    echo $errorPrompt["passIncorrect"];
                                    echo "<script>document.getElementById('emailLogin').value = '$emailLog'</script>";
                                }elseif(isset($errorPrompt["emailRegExist"])){
                                    echo $errorPrompt["emailRegExist"];
                                }else{
                                    echo"";
                                }
                            ?>
                        </p>
                        <input type = "submit" id ="submitBtn" class = "mainBtn" name = "login" value = "LOG IN" onclick= "e.preventDefault()">
                    </form>
                </div>
                <div class = "rightSide" id ="right"> 
                    <img src = "../images/clinic_logo.png" id = "logoClinic">
                </div>
            </div>
        </section>
        
        <script src ="../scripts/passwordToggle.js"></script>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <script>
            if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
            }
        </script>
    </body>
</html>
