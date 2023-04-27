<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include "util/FormUtil.php";
    include "util/SQLConnection.php";
    include "generic/header_generic.html";

    use SQLProject\util\SQLConnection;
    ?>
    <title>Add Drug</title>
</head>
<body>
    <p>
        <form method="post" actions="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
            <?php
                input('number', 'drug_id', 'Drug ID');
                input('text', 'drug_name', 'Drug Name');
            ?> <br>
            <input type="submit" value="Add">
        </form>
    </p>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        print "<p>";
        print "Adding Drug: <b>" . getData("drug_name") . " (" . getData('drug_id') .  ") </b><br>";
        $conn = new SQLConnection(SERVER, USERNAME, PASSWORD);
        $conn->connect();
        $result = $conn->selectDatabase(DATABASE, true);
        print "Connected:: " . ($result ? "Yes" : "No") . "<br>";

        $result = $conn->insert('Drugs', getData('drug_id'), getData('drug_name'));

        print "Added:: " . ($result ? "Yes" : "No") . '<br>';
        if (!$result) {
            $exception = $conn->getException();
            print '<b>Error:</b> ' . $exception->getCode() . '<br>';
            print '<b>Message:</b> "' . $exception->getMessage() . '"<br>';
            print '<b>At Line: </b>' . $exception->getLine() . ' <b> in: </b>' . $exception->getFile() . '<br>';
            print $exception->getTraceAsString() . '<br>';
            print $exception->getLine();
        }
        print "</p>";
    }
    ?>
</body>
</html>
