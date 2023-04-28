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

    if (!isset($func)) {
        $payload['code'] = 200_400;
        $payload['error'] = "Function not defined";
        goto RETURN_PAYLOAD;
    }

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

    if ($func == "search")
        goto SEARCH;
    elseif ($func == "update")
        goto UPDATE;
    else {
        $payload['code'] = 200_401;
        goto RETURN_PAYLOAD;
    }

SEARCH:

    $id         = $_POST['id']         ?? '';
    $first_name = $_POST['first_name'] ?? '';
    $last_name  = $_POST['last_name']  ?? '';
    $birth_date = $_POST['birth_date'] ?? '';
    $address    = $_POST['address']    ?? '';

    $params = [];

    if ($id != '')         $params[] = "id=$id";
    if ($first_name != '') $params[] = "first_name='$first_name'";
    if ($last_name != '')  $params[] = "last_name='$last_name'";
    if ($birth_date != '') $params[] = "birth_date='$birth_date'";
    if ($address != '')    $params[] = "address='$address'";

    $result = $connection->select("Customers", "*", $params);

    if (!$result) {
        $error = $connection->getException();
        $payload['code'] = $error->getCode();
        $payload['error'] = $error->getMessage();
        goto RETURN_PAYLOAD;
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $entry = [];

            $entry['id']         = $row['id'];
            $entry['first_name'] = $row['first_name'];
            $entry['last_name']  = $row['last_name'];
            $entry['birth_date'] = $row['birth_date'];
            $entry['address']    = $row['address'];

            $payload['data'][] = $entry;
        }
    }

    goto RETURN_PAYLOAD;

UPDATE:

    $id = $_POST['id'];
    $address = $_POST['address'] ?? '';

    if (!isset($id)) {
        $payload['code'] = 200_402;
        $payload['error'] = "Missing Argument [id : int]>";
        goto RETURN_PAYLOAD;
    }

    $result = $connection->query("UPDATE Customers SET address='$address' WHERE id=$id");

    if (!$result) {
        $error = $connection->getException();
        $payload['code'] = $error->getCode();
        $payload['error'] = $error->getMessage();
        goto RETURN_PAYLOAD;
    }

    $payload['success'] = true;
    $payload['data']['id'] = $id;
    $payload['data']['address'] = $address;

RETURN_PAYLOAD:

    echo json_encode($payload);




