<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include "util/FormUtil.php";
    include "util/SQLConnection.php";
    include "generic/header_generic.html";

    use SQLProject\util\SQLConnection;
    ?>
    <title>Add Patient</title>
</head>
<body>
    <p>
        <form method="post" actions="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <?php
                input('text', 'first_name', 'First Name', 'Jane');
                input('text', 'last_name', 'Last Name', 'Doe');
                input('date', 'birth_date', 'Birth Date');
                input('text', 'address', 'Address');
            ?>
            <input type="submit" value="Add">
        </form>
    </p>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        print "<p>";
        print "Adding Patient: <b>" . getData("first_name") . " " . getData("last_name") . "</b><br>";

        $conn = new SQLConnection(SERVER, USERNAME, PASSWORD);
        $conn -> connect();
        $result = $conn -> selectDatabase(DATABASE, true);

        print "Connected:: " . ($result ? "Yes" : "No") . "<br>";

        $result = $conn->insert('Customers', 'DEFAULT', getData('first_name'), getData('last_name'),
            getData('birth_date'), getData('address'));

        print ":: " . ($result ? "Added" : "Error");

        print "</p>";
    }
    ?>
</body>
</html>