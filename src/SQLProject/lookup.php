<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include "util/FormUtil.php";
    include "util/SQLConnection.php";
    include "generic/header_generic.html";

    use SQLProject\util\SQLConnection;
    ?>
    <title>Lookup Patient</title>
</head>
<body>
    <p>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <?php
            input('text', 'first_name', 'First Name', 'Jane');
            input('text', 'last_name', 'Last Name',  'Doe');
            input('date', 'birth_date', 'Birth Date');
            input('text', 'address', 'Address',  '101 Addressed Road');
            ?>
            <input type="submit" />
        </form>
    </p>

    <?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $first_name = getData('first_name');
        $last_name = getData('last_name');
        $birth_date = getData('birth_date');
        $address = getData('address');

        $params = [];
        if ($first_name != '') $params[] = "first_name='$first_name'";
        if ($last_name != '')  $params[] = "last_name='$last_name'";
        if ($birth_date != '') $params[] = "birth_date='$birth_date'";
        if ($address != '')    $params[] = "address='$address'";

        $conn = new SQLConnection(SERVER, USERNAME, PASSWORD);
        $conn->connect();
        $result = $conn->selectDatabase(DATABASE, true);

        if (!$result) die('FAILED TO CONNECT TO DATABASE');

        $result = $conn->select('Customers', '*', $params);

        print '<b>Search Results:</b><br>';

        if (!$result) {
            $exception = $conn->getException();
            print '<b>Error:</b> ' . $exception->getCode() . '<br>';
            print '<b>Message:</b> "' . $exception->getMessage() . '"<br>';
            print '<b>At Line: </b>' . $exception->getLine() . ' <b> in: </b>' . $exception->getFile() . '<br>';
            print $exception->getTraceAsString() . '<br>';
            print $exception->getLine() . '<br><br>';
            print $conn->sql . '<br>';
        }

        if ($result->num_rows > 0) {
            print '<table>'
                . '<tr>'
                . '<th>ID</th>'
                . '<th>First Name</th>'
                . '<th>Last Name</th>'
                . '<th>Birth Date</th>'
                . '<th>Address</th>'
                . '</tr>';
            while ($row = $result->fetch_assoc()) {
                print '<tr>'
                    . '<td>' . $row['id'] . '</td>'
                    . '<td>' . $row['first_name'] . '</td>'
                    . '<td>' . $row['last_name'] . '</td>'
                    . '<td>' . $row['birth_date'] . '</td>'
                    . '<td>' . $row['address'] . '</td>'
                    . '</tr>';
            }
            print '</table>';
        } else {
            print '<b>No Results</b>';
        }

        echo "</p>";
    }
    ?>
</body>
</html>