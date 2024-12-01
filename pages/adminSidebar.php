<head>
    <link rel="stylesheet" type="text/css" href="../styles/sidebar.css"/>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var currentLocation = window.location.href;

            var menuLinks = document.querySelectorAll('.menu a');

            menuLinks.forEach(function (link) {
                if (link.href === currentLocation) {
                    link.parentElement.classList.add('active');
                }
            });
        });
    </script>
</head>

<nav>
    <div class="logo">
        <img src="../images/logoDashboard.png">
        <span class="nav-item">Toothbuds<br>Dental Clinic</span>
    </div>
    <ul class="menu">
        <li>
            <a href="dashboard.php">
                <i class="fa-solid fa-house"></i>
                <span>Home</span>
            </a>
        </li>
        <li>
            <a href="appointmentRequest.php">
                <i class="fas fa-calendar-check"></i>
                <span>Appointment Request</span>
            </a>
        </li>
        <li>
            <a href="patientRecord.php">
                <i class="fa-solid fa-file-medical"></i>
                <span>Patient Record</span>
            </a>
        </li>
        <li>
            <a href="transaction.php">
                <i class="fas fa-clipboard"></i>
                <span>Transaction Record</span>
            </a>
        </li>
        <li>
            <a href="calendarAppointment.php">
                <i class="fas fa-calendar"></i>
                <span>Calendar</span>
            </a>
        </li>
        <li>
            <a href="accountManagement.php">
            <i class="fa-solid fa-address-card"></i>
                <span>Account Management</span>
            </a>
        </li>
        <li class="logout">
            <a href="logout.php">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</nav>