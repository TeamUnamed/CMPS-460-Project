<?php
    const DBSERVER = 'localhost';
    const DBUSERNAME = 'root';
    const DBPASSWORD = '';
    const DBNAME = 'pharmacy';

    $db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);

    if ($db === false) {
        die("Error: connection error. " . mysqli_connect_error());
    }
