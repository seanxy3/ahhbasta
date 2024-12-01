<?php
  include("../phpFiles/dbConnect.php");
  include("../pages/login.php");
?>
<!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8" />
      <title>Calendar</title>
      <?php include("../pages/header.php");?>
      <link rel="stylesheet" href="../styles/calendarAppointment.css" />
      <link rel="stylesheet" href="../styles/calendarDisplay.css" />
      <link rel="stylesheet" href="../styles/transaction.css">
    </head>
    <body>
        <div class="container">
        <?php 
            if($_SESSION["accRole"] == "Admin"){
                include('adminSidebar.php'); 
            }else{
                include('sidebar.php'); 
            } 
          ?>
        <div class="main">
          <div class = "titleCont">
            <h1>Calendar</h1>
          </div>
          <div class = "mainCont">
              <div class = "contianer">
                <div class="calendar">
                  <div class="calendar-header">
                    <span class="month-picker" id="month-picker"> May </span>
                    <div class="year-picker" id="year-picker">
                      <span class="year-change" id="pre-year">
                        <pre><</pre>
                      </span>
                      <span id="year">2020 </span>
                      <span class="year-change" id="next-year">
                        <pre>></pre>
                      </span>
                    </div>
                  </div>
          
                  <div class="calendar-body">
                    <div class="calendar-week-days">
                      <div>Sun</div>
                      <div>Mon</div>
                      <div>Tue</div>
                      <div>Wed</div>
                      <div>Thu</div>
                      <div>Fri</div>
                      <div>Sat</div>
                    </div>
                    <div class="calendar-days">
                    </div>
                  </div>
                  <div class="calendar-footer">
                  </div>
                  <div class="date-time-formate">
                    <!-- <div class="day-text-formate">TODAY</div> -->
                    <div class="date-time-value">
                      <div class="time-formate"></div>
                      <div class="date-formate"></div>
                    </div>
                  </div>
                  <div class="month-list"></div>
                </div>
              </div>

            <div class = "appointmentCont">
              <div class = "searchCont">
                <form action = "calendarAppointment.php" class = "datePicker" name = "datePicker" method = "post">
                  <label for = "inputDate" class = "labelDatePick">Choose Date:</label><br>
                  <input type = "date" min = "" id = "inputDate" name = "inputDate">
                  <input type = "submit" name = "dateSubmit" class = "dateSubmit" value = "SEARCH">
                </form>
              </div>
              <div class = "searchResult">
                <div class="button" id = "addApp">
                      <a href="addAppointment.php"><i class="fa-solid fa-plus"></i></a>
                </div>
                <table class = "mainTbl" cellspacing = "0">
                  <tr>
                    <th class="head">Request ID</th>
                    <th class="head">Patient Name</th>
                    <th class="head">Services</th>
                    <th class="head">Date</th>
                    <th class="head">Time</th>
                    <th class="head">Notes</th>
                    <th class="head">Action</th>
                   </tr>
                   <?php
                      if(isset($_POST["dateSubmit"])){
                        $inputDate = $_POST["inputDate"];
                        
                        $searchDate = "SELECT appointments.requestID, appointments.requestStatus, patients.patientFirstName, patients.patientLastName, appointments.requestServices, appointments.requestDate, appointments.requestTime, appointments.requestNotes 
                        FROM appointments INNER JOIN patients ON appointments.patientID = patients.patientID WHERE appointments.requestDate = '$inputDate' ORDER BY appointments.requestTime ASC";

                        try{
                          $resultApproved = mysqli_query($conn, $searchDate);
                        }catch(mysqli_sql_exception){
                          echo "Error Searching";
                        }
                        
                        if(mysqli_num_rows($resultApproved) > 0){
                          echo "<script>document.getElementById('inputDate').value = '$inputDate'</script>";
                          while($row = mysqli_fetch_assoc($resultApproved)){
                            echo "<tr>";
                            echo "<td>" . " ". $row["requestID"] . " ". "</td>";
                            echo "<td>" . " ". $row["patientFirstName"] . " ". $row["patientLastName"] . "</td>";
                            echo "<td>" . " ". $row["requestServices"] . " ". "</td>";
                            echo "<td>" . " ". $row["requestDate"] . " ". "</td>";
                            echo "<td>" . " ". date("h:i A",strtotime($row["requestTime"])) . " ". "</td>";
                            echo "<td>" . " ". $row["requestNotes"] . " ". "</td>";

                            echo "<td>
                                  <div class='action-buttons'>
                                    <form action='appointmentRequestUpdate.php' method='post'>
                                        <input type='hidden' name='requestID' value='{$row['requestID']}'>
                                        <input type='hidden' name='requestStatus' value='{$row['requestStatus']}'>
                                        <button type='submit'><i class='fas fa-edit'></i></button>
                                    </form>
                                  </td>";
                            echo "</tr>";                            
                          }
                        }else{
                            echo "<tr><th colspan = '7' id = 'noRes'>No Results</th></tr>";
                        }

                      }

                   ?>
                </table>
              </div>
            </div>
          </div>  
        </div>
      </div>

      <script src ="../scripts/calendarDisplay.js"></script>
      <script src ="../scripts/dateToday.js"></script>
    </body>
   
  </html>
    
