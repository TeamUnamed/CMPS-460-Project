<?php
    header("Content-Type: application/json; charset=UTF-8");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $tst = $_GET['first_name'] ?? 'none';

        $obj = [];
        $obj["first_name"] = $tst;
        $obj["last_name"] = "Miller";
        $obj["birth_date"] = "1995-04-10";
        $obj["address"] = "101 Lost Street";
        $obj["subs"] = [];
        $obj["subs"]["one"] = 1;
        $obj["subs"]["two"] = 2;

        echo json_encode($obj);
    } else {
        echo json_encode([]);
    }
