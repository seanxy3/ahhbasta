<!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8" />
      <title>Appointment</title>
      <link rel="stylesheet" href="../styles/optionAppointment.css" />
      <?php include("../pages/header.php");?>
    </head>
    <body>
        <div class="center">
            <h1>Select Patient</h1>
            <form method="post">
                <a href="oldPatient.php" target="_self">
              <input type="button" value="Old Patient">
            </a>
            <a href="newPatient.php" target="_self">
              <input type="button" value="New Patient">
            </a>
            </form>
          </div>
    </body>
  </html>