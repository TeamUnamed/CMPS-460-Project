<?php
    header("Content-Type: application/json; charset=UTF-8");
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        echo json_encode([]);
    }

    require_once "{$_SERVER['DOCUMENT_ROOT']}/SQLProject/util/SQLConnection.php";

    use SQLProject\util\SQLConnection;

    $payload = [];
    $payload['data'] = [];

    $func = $_POST['func'];

    $connection = (new SQLConnection())->connect();
    if (!$connection->isConnected()) {
        $error = $connection->getException();
        $payload['code'] = $error->getCode();
        $payload['error'] = $error->getMessage();
        goto RETURN_PAYLOAD;
    }

    $db_connected = $connection->selectDatabase(DATABASE, true);
    if (!$db_connected) {
        $error = $connection->getException();
        $payload['code'] = $error->getCode();
        $payload['error'] = $error->getMessage();
        goto RETURN_PAYLOAD;
    }

    if ($func == "search") goto SEARCH;
    elseif ($func == "update") {

    } elseif ($func == "delete") {

    } else {
        $payload['code'] = 200_401;
        goto RETURN_PAYLOAD;
    }

    SEARCH:

    $id = $_POST['id'] ?? '';
    $name = $_POST['name'] ?? '';

    $params = [];

    if ($id != '') $params[] = "id=$id";

    $result = $connection->select("Drugs", "*", $params);

    if (!$result) {
        $error = $connection->getException();
        $payload['code'] = $error->getCode();
        $payload['error'] = $error->getMessage();
        goto RETURN_PAYLOAD;
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $entry = [];

            $entry['id'] = $row['id'];
            $entry['name'] = $row['name'];

            $payload['data'][] = $entry;
        }
    }

    RETURN_PAYLOAD:

    echo json_encode($payload);