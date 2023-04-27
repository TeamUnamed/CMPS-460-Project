<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include "util/FormUtil.php";
    include "generic/header_generic.html";
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
}
?>