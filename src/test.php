<?php

    echo "<h1>TESTING SQL TABLE STUFF</h1>";

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test_db";

    function getDatabaseConnection($servername, $username, $password, $dbname) {
        try {
            $conn = new mysqli($servername, $username, $password);
        } catch (mysqli_sql_exception $error) {
            echo "Connection Failed:", $error ->getCode(), "<br>";
            echo $error->getMessage(), "<br>";
            echo $error->getFile(), " [", $error->getLine(), "]";
            die;
        }

        if ($conn -> select_db($dbname)) {
            return $conn;
        }

        $conn -> query("CREATE DATABASE " . $dbname);
        $conn -> select_db($dbname);
        return $conn;
    }

    $conn = getDatabaseConnection($servername, $username, $password, $dbname);
    echo $conn -> ping();