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
            input('text', 'phone_number', 'Phone Number',  '555-555-5555');
            input('text', 'birth_date', 'Birth Date',  'DD/MM/YYYY');
            ?>
            <input type="submit" />
        </form>
</body>
</html>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {

    echo "<p>";
    echo "Searching Database for:<br>";
    echo "<b>" . getData('first_name')
        . " "  . getData('last_name')
        . " (" . getData('phone_number')
        . ") " . getData('birth_date') . "</b>";
    echo "</p><p>";

    echo "</p>";

    $conn = new SQLConnection(SERVER, USERNAME, PASSWORD);
    $conn->connect();
    $result = $conn->selectDatabase(DATABASE, true);
    print "Connected:: " . ($result ? "Yes" : "No") . "<br>";

    $result = $conn->select('Customers', '*');
    print $result->num_rows . " rows";
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
    }
}
?>