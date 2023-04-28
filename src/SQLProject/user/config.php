<?php

    require_once "{$_SERVER['DOCUMENT_ROOT']}/SQLProject/util/SQLConnection.php";
    use SQLProject\util\SQLConnection;

    $wrappedConnection = (new SQLConnection())->connect();
    $db = $wrappedConnection->selectDatabase(DATABASE);

    $db = $wrappedConnection->connection;

    if (!$wrappedConnection->isConnected()) {
        die("Error: connection error. " . mysqli_connect_error());
    }
