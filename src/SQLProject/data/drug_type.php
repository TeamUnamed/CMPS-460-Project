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
    elseif ($func == "add") goto ADD;
    else {
        $payload['code'] = 200_401;
        $payload['error'] = "Invalid Function";
        goto RETURN_PAYLOAD;
    }

    SEARCH:

    $id = $_POST['id'] ?? '';
    $drug_id = $_POST['drugId'] ?? '';
    $desc = $_POST['description'] ?? '';

    $params = [];

    if ($id != '') $params[] = "id=$id";
    if ($drug_id != '') $params[] = "drugId=$drug_id";

    $result = $connection->select("Drug_Types", "*", $params);

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
            $entry['drugId'] = $row['drugId'];
            $entry['description'] = $row['description'];

            $payload['data'][] = $entry;
        }
    }

    goto RETURN_PAYLOAD;

    ADD:

    $id = $_POST['id'];
    $drug_id = $_POST['drugId'];
    $desc = $_POST['description'];

    if ($id == '') $id = null;
    if ($drug_id == '') $drug_id = null;
    if ($desc == '') $desc = null;

    if (!isset($id) || !isset($drug_id) || !isset($desc)) {
        $payload['code'] = 200_402;
        $payload['error'] = "Missing Argument";
        goto RETURN_PAYLOAD;
    }

    $result = $connection->insert('Drug_Types', $id, $drug_id, $desc);

    if (!$result) {
        $error = $connection->getException();
        $payload['code'] = $error->getCode();
        $payload['error'] = $error->getMessage();
        goto RETURN_PAYLOAD;
    }

    $payload['success'] = true;
    $payload['data']['id'] = $id;
    $payload['data']['drugId'] = $drug_id;
    $payload['data']['description'] = $desc;

    RETURN_PAYLOAD:

    echo json_encode($payload);