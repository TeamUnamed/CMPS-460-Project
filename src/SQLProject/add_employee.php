<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include "util/FormUtil.php";
    include "util/SQLConnection.php";
    include "base/navbar.html";

    use SQLProject\util\SQLConnection;
    ?>
    <title>Add Employee</title>
</head>
<body>
    <p>
        <form method="post" actions="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
            <?php
                input('number', 'employee_id', 'Employee ID');
                input('text', 'first_name', 'First Name');
                input('text', 'last_name', 'Last Name');
            ?> <br>
            <input type="submit" value="Add">
        </form>
    </p>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        print "<p>";
        print "Adding Employee: <b>" . getData("employee_id") . " (" . getData('employee_first_name') . " (" . getData('employee_last_name') . ") </b><br>";
        $conn = new SQLConnection(SERVER, USERNAME, PASSWORD);
        $conn->connect();
        $result = $conn->selectDatabase(DATABASE, true);
        print "Connected:: " . ($result ? "Yes" : "No") . "<br>";

        $result = $conn->query("INSERT INTO Employees VALUES (" .
            getData('employee_id') . ", " .
            getData('first_name') . ", '" .
            getData('last_name') . "')"
        );

        print "Added:: " . ($result ? "Yes" : "No");
        print "</p>";
    }
    ?>
</body>
</html>