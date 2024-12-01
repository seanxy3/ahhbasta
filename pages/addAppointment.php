<?php
    include("../phpFiles/dbConnect.php");
    include("../pages/login.php");
    $errorPrompt["emailRegExist"] = "";
    $successPrompt["successSubmit"] = "";
    $allTime = array("08:00:00", "08:30:00", "09:00:00", "09:30:00", "10:00:00", "10:30:00", "11:00:00", "13:00:00", "13:30:00", "14:00:00", "14:30:00", "15:00:00", "16:00:00");
    $availableTime = $allTime;

    if(isset($_POST["submitInfoOld"])){
        $_SESSION["email"] = $_POST["email"]; 

        $email = $_POST["email"]; 

        $emailCheck = "SELECT * FROM patients WHERE patientEmail = '$email'";
        $emailQuery = mysqli_query($conn, $emailCheck);
        if(mysqli_num_rows($emailQuery) == 0){
            $errorPrompt["emailRegExist"] = "Email Doesn't Exist!<br>";
        }else{
            $errorPrompt["emailRegExist"] = "";
        }  
    }

    if(isset($_POST["submitSelectDateOld"])){
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

    if(isset($_POST["finalSubmitOld"])){
        $_SESSION["selectOption"] = $_POST["selectOption"];
        $_SESSION["serviceChosen"] = implode(", ", $_POST["servicesCheck"]);
        $_SESSION["notes"] = $_POST["notes"];

        $findID = "SELECT * FROM patients WHERE patientEmail = '{$_SESSION["email"]}'";
        $resultID = mysqli_query($conn, $findID);
       
        if(mysqli_num_rows($resultID) > 0){
            $row = mysqli_fetch_assoc($resultID);
            $patientID = $row["patientID"];

            $insertToAppointment = "INSERT INTO requests(patientID, requestServices, requestDate, requestTime, requestNotes, requestStatus)
            VALUES('$patientID', '{$_SESSION["serviceChosen"]}', '{$_SESSION["selectedDate"]}', '{$_SESSION["selectOption"]}',
            '{$_SESSION["notes"]}', 'Approved')";

            try{
                $resultID = mysqli_query($conn, $insertToAppointment);
                $successPrompt["successSubmit"] = "Appointment Added Successfully!";
                unset($_SESSION["email"]);
                unset($_SESSION["selectedDate"]);
                unset($_SESSION["selectOption"]);
                unset($_SESSION["serviceChosen"]);
                unset($_SESSION["notes"]);
                

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
        document.getElementById('email').readOnly = true;
        </script>";
    }
?>
<!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8" />
      <title>Add Appointment</title>
      <link rel="stylesheet" href="../styles/patientForm.css" />
      <?php include("../pages/header.php");?>
    </head>
    <body>
        <div class="am-container">
            <div class="am-body">
               <div class="am-head">
                <h1>Appointment Request</h1>
               </div>
               <a href="calendarAppointment.php"><i class="fas fa-arrow-alt-circle-left"></i></a>
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
                
               <form class="am-body-box" action = "addAppointment.php" autocomplete="off" method = "post">
                    <div>
                        <div>
                            <p>Email: </p>
                            <input type="email" name="email" id="email" placeholder="e.g. sample@gmail.com">
                        </div>
                    </div>
                    <div>
                        <input type = "submit" name = "submitInfoOld"  id = "submitInfo" class = "dateLay" value = "SUBMIT INFORMATION" disabled = true>
                        <input type="checkbox" id="confirmCheckbox" name="confirmCheckbox[]" value="showSubmitInfo" onchange = "showButtonSubmit();">
                        <label for = "confirmCheckbox" id ="labelConfirm">Before proceeding to check the time availability of the appointment request, I hereby certify that the information provided is complete, true and correct to the best of my knowledge.</label>
                    </div>
                </form>

                <form class="am-body-box" action = "addAppointment.php" autocomplete="off" method = "post">
                    <?php
                        if(!empty($_POST["submitInfoOld"])){
                            if($errorPrompt["emailRegExist"] == "Email Doesn't Exist!<br>"){
                                echo "<script>
                                document.getElementById('email').value = '$email';
                                </script>";
                            }else{
                                echo"<script>
                                document.getElementById('email').value = '$email';
                                </script>";
                                
                                disableInput();
                            }
                        }
                    ?>
                    <div class="datePicker">
                        <p>Select Date:</p>
                        <?php 
                            if(($errorPrompt["emailRegExist"] == "" and (!empty($_POST["submitInfoOld"]))) or ($errorPrompt["emailRegExist"] == "" and (!empty($_POST["submitSelectDateOld"])))){
                                echo "<input type='date' name='selectedDate' id='date' class = 'dateLay' required>";
                                echo "<input type ='submit' name = 'submitSelectDateOld'  id = 'submitSelectDate' class = 'dateLay' value = 'CHECK AVAILABLE TIME' onclick = 'e.preventDefault()'>";
                                echo "<script>
                                document.getElementById('email').value = '{$_SESSION["email"]}';
                                </script>";

                                disableInput();
                            }else{
                                echo "<input type='date' name='selectedDate' id='date' class = 'dateLay' disabled>";
                            }
                            ?>
                    </div>
                </form>
                <form class="am-body-box" action = "addAppointment.php" autocomplete="off" method = "post"  id = "timeServiceForm">
                    <div class="timeCont">
                        <label for = "dateSelect"> Choose Time: </label>
                        <?php
                            if((!empty($_POST["submitSelectDateOld"]) and $errorPrompt["emailRegExist"] == "")){
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
                            <textarea name="notes" id="notes" cols="3" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="buttonCont">
                        <div class="am-col-3">
                            <?php 
                                if((!empty($_POST["submitSelectDateOld"]) and $errorPrompt["emailRegExist"] == "")){
                                echo"<input type ='submit' name = 'finalSubmitOld'  id = 'finalSubmit' value = 'SUBMIT APPOINTMENT'>";
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