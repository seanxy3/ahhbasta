<?php
    session_start();

    $_SESSION = array();

    session_destroy();

    header("Location: loginReg.php");
    exit();
?>