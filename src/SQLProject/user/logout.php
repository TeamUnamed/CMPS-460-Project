<?php

session_start();



if(session_destroy()) {
    header("Location: /SQLProject/login.php");
    exit;
}