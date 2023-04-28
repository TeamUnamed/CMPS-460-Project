<?php
    header("Content-Type: application/json; charset=UTF-8");
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        echo json_encode([]);
    }

    require_once "{$_SERVER['DOCUMENT_ROOT']}/SQLProject/util/SQLConnection.php";

    use SQLProject\util\SQLConnection;

    function orDefault(string $var, $default = null, $mutator = null) {
        $temp = $_POST[$var];
        return ($temp == null || $temp == '') ? $default : (($mutator == null) ? $temp : $mutator->__invoke($temp));
    }

    function isNull(... $vars) : bool {
        if (in_array(null, $vars)) {
            return true;
        }

        return false;
    }

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
    elseif ($func == "delete") goto DELETE;
    else {
        $payload['code'] = 200_401;
        $payload['error'] = "Invalid Function";
        goto RETURN_PAYLOAD;
    }

    SEARCH:

    $params = [];

    $pId       = orDefault('pId'      , '', function($val) use (&$params) {$params[] = "id=$val";});
    $cId       = orDefault('cId'      , '', function($val) use (&$params) {$params[] = "customerId=$val";});
    $dId       = orDefault('dId'      , '', function($val) use (&$params) {$params[] = "drugId=$val";});
    $eId       = orDefault('eId'      , '', function($val) use (&$params) {$params[] = "employeeId=$val";});
    $count     = orDefault('count'    , '', function($val) use (&$params) {$params[] = "count=$val";});
    $refills   = orDefault('refills'  , '', function($val) use (&$params) {$params[] = "refills=$val";});
    $fill_date = orDefault('fill_date', '', function($val) use (&$params) {$params[] = "fill_date=$val";});

    $result = $connection->select("Prescriptions", "*", $params);

    if (!$result) {
        $error = $connection->getException();
        $payload['code'] = $error->getCode();
        $payload['error'] = $error->getMessage();
        goto RETURN_PAYLOAD;
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $entry = [];

            $entry['pId'] = $row['id'];
            $entry['cId'] = $row['customerId'];
            $entry['dId'] = $row['drugId'];
            $entry['eId'] = $row['employeeId'];
            $entry['count'] = $row['count'];
            $entry['refills'] = $row['refills'];
            $entry['fill_date'] = $row['fill_date'];

            $payload['data'][] = $entry;
        }
    }

    goto RETURN_PAYLOAD;

    ADD:

    $pId = orDefault('pId', 'DEFAULT');
    $cId = orDefault('cId');
    $dId = orDefault('dId');
    $eId = orDefault('eId');
    $count = orDefault('count');
    $refills = orDefault('refills');
    $fill_date = orDefault('fill_date');

    if (isNull($pId, $cId, $dId, $eId, $count, $refills, $refills, $fill_date)) {
        $payload['code'] = 200_402;
        $payload['error'] = "Missing Argument";
        goto RETURN_PAYLOAD;
    }

    $result = $connection->insert('Prescriptions', $pId, $cId, $dId, $eId, $count, $refills, $fill_date);

    if (!$result) {
        $error = $connection->getException();
        $payload['code'] = $error->getCode();
        $payload['error'] = $error->getMessage();
        goto RETURN_PAYLOAD;
    }

    $payload['success'] = true;
    $payload['data']['pId'] = $pId;
    $payload['data']['cId'] = $cId;
    $payload['data']['dId'] = $dId;
    $payload['data']['eId'] = $eId;
    $payload['data']['count'] = $count;
    $payload['data']['refills'] = $refills;
    $payload['data']['fill_date'] = $fill_date;

    goto RETURN_PAYLOAD;

    DELETE:

    RETURN_PAYLOAD:

    echo json_encode($payload);