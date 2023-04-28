<?php
    session_start();

    if (isset($_SESSION["userid"])  && $_SESSION["userid"] !== false) {
        header("location: welcome.php");
        exit;
    }
