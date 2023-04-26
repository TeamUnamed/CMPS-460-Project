<?php
$first_name = $last_name = $phone_number = $birth_date = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];
    $birth_date = $_POST['birth_date'];
}

function input($type, $name, $label, $placeholder = "") {
    print "<label>" . $label . ": ";
    print "<input";
    print " type=\"" . $type . "\"";
    print " name=\"" . $name . "\"";
    print " value=\"" . $GLOBALS[$name] . "\"";
    print " placeholder=\"" . $placeholder . "\"";
    print " /> </label><br>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lookup Patient</title>
</head>
<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <?php
        input('text', 'first_name', 'First Name', 'Jane');
        input('text', 'last_name', 'Last Name',  'Doe');
        input('text', 'phone_number', 'Phone Number',  '555-555-5555');
        input('text', 'birth_date', 'Birth Date',  'DD/MM/YYYY');
        ?>
        <input type="submit"/>
    </form>
</body>
</html>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {

    echo "<p>";
    echo "Searching Database for:<br>";
    echo "<b>" . $first_name . " " . $last_name . " (" . $phone_number . ") " . $birth_date . "</b>";
    echo "</p><p>";

    echo "</p>";
}
?>