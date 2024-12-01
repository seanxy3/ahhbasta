<?php
    include("../phpFiles/dbConnect.php");
    session_start();
    $errorPrompt["emailRegExist"] = "";
    $successPrompt["successSubmit"] = "";
    $allTime = array("08:00:00", "08:30:00", "09:00:00", "09:30:00", "10:00:00", "10:30:00", "11:00:00", "13:00:00", "13:30:00", "14:00:00", "14:30:00", "15:00:00", "16:00:00");
    $availableTime = $allTime;
    if(isset($_POST["submitInfo"])){
        $_SESSION["firstName"] = $_POST["fname"];
        $_SESSION["lastName"] = $_POST["lname"];
        $_SESSION["age"] = $_POST["age"];
        $_SESSION["sex"] = $_POST["sex"];
        $_SESSION["mobileNum"] = $_POST["mobileNum"];
        $_SESSION["email"] = $_POST["email"]; 
        $_SESSION["address"] = $_POST["address"]; 
        $_SESSION["occupation"] = $_POST["occupation"]; 

        $firstName = $_POST["fname"];
        $lastName = $_POST["lname"];
        $age = $_POST["age"];
        $sex = $_POST["sex"];
        $mobileNum = $_POST["mobileNum"];
        $email = $_POST["email"]; 
        $address = $_POST["address"]; 
        $occupation = $_POST["occupation"]; 

        $emailCheck = "SELECT * FROM patients WHERE patientEmail = '$email'";
        $emailQuery = mysqli_query($conn, $emailCheck);
        if(mysqli_num_rows($emailQuery) > 0){
            $errorPrompt["emailRegExist"] = "Email Already Exists!<br>";
        }else{
            $errorPrompt["emailRegExist"] = "";
        }  
    }

    if(isset($_POST["submitSelectDate"])){
        $_SESSION["selectedDate"] = $_POST["selectedDate"];
        $selectedDate = $_POST["selectedDate"];
        echo "<script>document.getElementById('date').value = '$selectedDate'</script>";

        $checkDates = "SELECT requestTime FROM requests WHERE requestDate = '$selectedDate'";
        $results = mysqli_query($conn, $checkDates);
        if(mysqli_num_rows($results) > 0){
            while($row = mysqli_fetch_assoc($results)){
                foreach($availableTime as $content){
                    if($row["requestTime"] == $content){
                        $indexNumber = array_search($content, $availableTime);
                        unset($availableTime[$indexNumber]);
                    }       
                }
            }
        }else{
            $availableTime = $allTime;
        }
    }

    if(isset($_POST["finalSubmit"])){
        $_SESSION["selectOption"] = $_POST["selectOption"];
        $_SESSION["serviceChosen"] = implode(", ", $_POST["servicesCheck"]);
        $_SESSION["notes"] = $_POST["notes"];

        $insertToPatients = "INSERT INTO patients(patientFirstName, patientLastName, patientAge, patientSex, patientMobileNo, patientEmail, patientAddress, patientOccupation, patientBalance) 
        VALUES('{$_SESSION["firstName"]}', '{$_SESSION["lastName"]}', '{$_SESSION["age"]}', '{$_SESSION["sex"]}','{$_SESSION["mobileNum"]}',
        '{$_SESSION["email"]}', '{$_SESSION["address"]}', '{$_SESSION["occupation"]}', 0.00)";

        try{
            $insertResults = mysqli_query($conn, $insertToPatients);
        }catch(mysqli_sql_exception){
            echo "Error Searching";
        }

        $findID = "SELECT * FROM patients WHERE patientEmail = '{$_SESSION["email"]}'";

        $resultID = mysqli_query($conn, $findID);
       
        if(mysqli_num_rows($resultID) > 0){
            $row = mysqli_fetch_assoc($resultID);
            $patientID = $row["patientID"];

            $insertToAppointment = "INSERT INTO requests(patientID, requestServices, requestDate, requestTime, requestNotes)
            VALUES('$patientID', '{$_SESSION["serviceChosen"]}', '{$_SESSION["selectedDate"]}', '{$_SESSION["selectOption"]}',
            '{$_SESSION["notes"]}')";

            try{
                $resultID = mysqli_query($conn, $insertToAppointment);
                $successPrompt["successSubmit"] = "Your appointment request has been submitted!<br>Please await confirmation from our staff. Thank you!";
            }catch(mysqli_sql_exception){
                echo "Error Searching";
            }
        }else{
            echo "NO ID FOUND!";
        }  
    }

    function disableInput(){
        echo "<script>document.getElementById('submitInfo').classList.remove('dateLay');
        document.getElementById('submitInfo').classList.add('hideConfirmButton');
        document.getElementById('confirmCheckbox').classList.add('hideConfirmButton');
        document.getElementById('labelConfirm').classList.add('hideConfirmButton');
        document.getElementById('fname').readOnly = true;
        document.getElementById('lname').readOnly = true;
        document.getElementById('age').readOnly = true;
        document.getElementById('email').readOnly = true;
        document.getElementById('email').readOnly = true;
        document.getElementById('sex').disabled = true;
        document.getElementById('mobileNum').readOnly = true;
        document.getElementById('email').readOnly = true;
        document.getElementById('address').readOnly = true;
        document.getElementById('occupation').readOnly = true;</script>";
    }
?>

<!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8" />
      <title>New Patient Appointment</title>
      <?php include("../pages/header.php");?>
      <link rel="stylesheet" href="../styles/patientForm.css" />
    </head>
    <body>
        <div class="am-container">
            <div class="am-body">
            <div class="am-head">
                <h1>Appointment Request</h1>
            </div>
            <a href="optionAppointment.php"><i class="fas fa-arrow-alt-circle-left"></i></a>
            <p class = "error">
                <?php
                    if(isset($errorPrompt["emailRegExist"])){
                        echo  $errorPrompt["emailRegExist"];
                    }else{
                        echo "";
                    }
                ?>
            </p>
            <p class = "success">
                <?php
                    if(isset($successPrompt["successSubmit"])){
                        echo $successPrompt["successSubmit"];
                    }else{
                        echo "";
                    }
                ?>
            </p>
            <form class="am-body-box" action = "newPatient.php" autocomplete="off" method = "post">
                    <div class="am-row">
                        <div class="am-col-6">
                            <p>First Name: </p>
                            <input type="text" name="fname" id="fname" placeholder="e.g. Juan" required>
                        </div>
                        <div class="am-col-6">
                            <p>Last Name: </p>
                            <input type="text" name="lname" id="lname" placeholder="e.g. Dela Cruz" required>
                        </div>
                    </div>
                    <div class="am-row">
                        <div class="am-col-6">
                            <p>Age: </p>
                            <input type="number" name="age" id="age" min = 1 placeholder="e.g. 18" required>
                        </div>
                        <div class="am-col-6">
                            <p>Sex: </p>
                            <select name="sex" id = "sex" required>
                                <option value="M" id ="maleOp">Male</option>
                                <option value="F" id ="femaleOp">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="am-row">
                        <div class="am-col-6">
                            <p>Mobile Number: </p>
                            <input type="text" name="mobileNum" id="mobileNum" placeholder="e.g. 09**-****-***" required>
                        </div>
                        <div class="am-col-6">
                            <p>Email Address: </p>
                            <input type="email" name="email" id="email" placeholder="e.g. sample@gmail.com" required>
                        </div>
                    </div>
                    <div class="am-row">
                        <div class="am-col-6">
                            <p>Address: </p>
                            <input type="text" name="address" id="address" placeholder="e.g. National Highway, Sta Rita,Batangas City, Batangas, Philippines " required>
                        </div>
                        <div class="am-col-6">
                            <p>Occupation: </p>
                            <input type="text" name="occupation" id="occupation" placeholder="e.g. Student/Dentist/Unemployed" required>
                        </div>
                    </div>
                    <div>
                        <input type = "submit" name = "submitInfo"  id = "submitInfo" class = "dateLay" value = "SUBMIT INFORMATION" disabled = true>
                        <input type="checkbox" id="confirmCheckbox" name="confirmCheckbox[]" value="showSubmitInfo" onchange = "showButtonSubmit();">
                        <label for = "confirmCheckbox" id ="labelConfirm">Before I proceed to checking time availability of my appointment request, I hereby certify that the information provided is complete, true and correct to the best of my knowledge.</label>
                    </div>
                </form>
                <form class="am-body-box" action = "newPatient.php" autocomplete="off" method = "post">
                    <?php
                        if(!empty($_POST["submitInfo"])){
                            if($errorPrompt["emailRegExist"] == "Email Already Exists!<br>"){
                                echo "<script>document.getElementById('fname').value = '$firstName';
                                document.getElementById('lname').value = '$lastName';
                                document.getElementById('age').value = '$age';
                                document.getElementById('sex').value = '$sex';
                                document.getElementById('mobileNum').value = '$mobileNum';
                                document.getElementById('address').value = '$address';
                                document.getElementById('occupation').value = '$occupation'; </script>";
                            }else{
                                echo"<script>
                                document.getElementById('fname').value = '$firstName';
                                document.getElementById('lname').value = '$lastName';
                                document.getElementById('age').value = '$age';
                                document.getElementById('email').value = '$email';
                                document.getElementById('sex').value = '$sex';
                                document.getElementById('mobileNum').value = '$mobileNum';
                                document.getElementById('address').value = '$address';
                                document.getElementById('occupation').value = '$occupation';</script>";
                                
                                disableInput();
                            }
                        }
                    ?>
                    <div class="datePicker">
                        <p>Select Date:</p>
                        <?php 
                            if(($errorPrompt["emailRegExist"] == "" and (!empty($_POST["submitInfo"]))) or ($errorPrompt["emailRegExist"] == "" and (!empty($_POST["submitSelectDate"])))){
                                echo "<input type='date' name='selectedDate' id='date' class = 'dateLay' required>";
                                echo "<input type ='submit' name = 'submitSelectDate'  id = 'submitSelectDate' class = 'dateLay' value = 'CHECK AVAILABLE TIME' onclick = 'e.preventDefault()'>";
                                echo "<script>document.getElementById('fname').value = '{$_SESSION["firstName"]}';
                                document.getElementById('lname').value = '{$_SESSION["lastName"]}';
                                document.getElementById('age').value = '{$_SESSION["age"]}';
                                document.getElementById('sex').value = '{$_SESSION["sex"]}';
                                document.getElementById('email').value = '{$_SESSION["email"]}';
                                document.getElementById('mobileNum').value = '{$_SESSION["mobileNum"]}';
                                document.getElementById('address').value = '{$_SESSION["address"]}';
                                document.getElementById('occupation').value = '{$_SESSION["occupation"]}';</script>";

                                disableInput();
                            }else{
                                echo "<input type='date' name='selectedDate' id='date' class = 'dateLay' disabled>";
                            }
                            ?>
                    </div>
                </form>
                <form class="am-body-box" action = "newPatient.php" autocomplete="off" method = "post" id = "timeServiceForm">
                    <div class="timeCont">
                        <label for = "dateSelect"> Choose Time: </label>
                        <?php
                            if((!empty($_POST["submitSelectDate"]) and $errorPrompt["emailRegExist"] == "")){
                                echo "<script>document.getElementById('date').value = '$selectedDate'</script>";
                                echo '<select name="selectOption" id = "dateSelect">?';    
                            }else{
                                echo '<select name="selectOption" id = "dateSelect" disabled>';
                            }

                            foreach($availableTime as $content){
                                $displayTime = strtotime($content);
                                $finalTime = date("h:i A", $displayTime);
                                echo "<option value= '$content'> $finalTime </option>";
                            }
                            echo "</select>";
                        ?>
                    </div>
                    <div class="am-row">
                        <div class="am-col-7">
                            <p>Select Services: </p>
                            <input type="checkbox" id="consultation" name="servicesCheck[]" value="Consultation">
                            <label for="consultation"> Consultation</label><br>
                            <input type="checkbox" id="orthodontics" name="servicesCheck[]" value="Orthodontics Treatment">
                            <label for="orthodontics"> Orthodontics</label><br>
                            <input type="checkbox" id="surgery" name="servicesCheck[]" value="Surgery">
                            <label for="surgery"> Surgery</label>
                        </div>

                        <div class="am-col-7">
                            <br>
                            <input type="checkbox" id="rootCanal" name="servicesCheck[]" value="Root Canal">
                            <label for="rootCanal"> Root Canal</label><br>
                            <input type="checkbox" id="extraction" name="servicesCheck[]" value="Extraction">
                            <label for="extraction"> Extraction</label><br>
                            <input type="checkbox" id="restoration" name="servicesCheck[]" value="Restoration">
                            <label for="restoration"> Restoration</label>
                        </div>
                        <div class="am-col-7">
                            <br>
                            <input type="checkbox" id="dentures" name="servicesCheck[]" value="Dentures">
                            <label for="dentures"> Dentures</label><br>
                            <input type="checkbox" id="crown" name="servicesCheck[]" value="Crown">
                            <label for="crown"> Crown</label><br>
                            <input type="checkbox" id="bleaching" name="servicesCheck[]" value="Bleaching">
                            <label for="bleaching"> Bleaching</label>
                        </div>
                        <div class="am-col-7">
                            <br>
                            <input type="checkbox" id="oralProphylaxis" name="servicesCheck[]" value="Oral Prophylaxis">
                            <label for="oralProphylaxis"> Oral Prophylaxis</label><br>
                        </div>
                    </div>
                    <div class="am-row">
                        <div class="am-col-12">
                            <p>Appointment Notes (Optional):</p>
                            <textarea name="notes" id="notes" cols="3" rows="10" placeholder="Please provide any additional information."></textarea>
                        </div>
                    </div>
                    <div class="buttonCont">
                        <div class="am-col-3">
                            <?php 
                                if((!empty($_POST["submitSelectDate"]) and $errorPrompt["emailRegExist"] == "")){
                                echo"<input type ='submit' name = 'finalSubmit'  id = 'finalSubmit' value = 'SUBMIT APPOINTMENT' onclick = 'confirmSubmit()'>";
                                }
                            ?>
                        </div>
                    </div>
                </form>

                <div class="am-footer">
                    <p>Toothbuds Dental Clinic</p>
                </div>
            </div>
        </div>
        
        <script src ="../scripts/dateToday.js"></script>
        <script src ="../scripts/checkRequired.js"></script>
        <script src ="../scripts/formAppLanding.js"></script>
    </body>
  </html>