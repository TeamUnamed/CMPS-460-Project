<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        include "util/FormUtil.php";
        include "util/SQLConnection.php";
        include "base/navbar.html";

        use SQLProject\util\SQLConnection;

    ?>
    <title>Add Drug Type</title>
</head>
<body>
    <p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <?php
            input('number', 'type_id', 'Type ID');
            input('number', 'drug_id', 'Drug ID');
            input('text', 'type_desc', 'Type Description');
        ?> <br>
        <input type="submit" value="Add">
    </form>
    </p>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            print "<p>";
            print "Adding Drug Type: <b>"
                  . getData("type_name") . " ("
                  . getData('type_id') . ")("
                  . getData('drug_id') . ")</b><br>";
            $conn = new SQLConnection(SERVER, USERNAME, PASSWORD);
            $conn->connect();
            $result = $conn->selectDatabase(DATABASE, true);
            print "Connected:: " . ($result ? "Yes" : "No") . "<br>";

            $result = $conn->query("SELECT id FROM Drugs WHERE id=" . getData('drug_id'));

            if (!$result || $result->num_rows == 0) {
                print "Added:: No -> No Matching Drug ID";
            } else {
                $result = $conn->insert('Drug_Types', getData('type_id'), getData('drug_id'), getData('type_desc'));

                print "Added:: " . ($result ? "Yes" : "No");
                print "</p>";
            }
        }
    ?>
</body>
</html>
