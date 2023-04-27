<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include "util/SQLConnection.php";
    include "generic/header_generic.html";

    use SQLProject\util\SQLConnection;
    ?>
    <title>Test</title>

    <h1>TESTING SQL TABLE STUFF</h1>
</head>
<body>
    <form method="get" action="test.php">
        <label>A<input type="text" name="a"/></label><br>
        <label>B<input type="text" name="b"/></label><br>
        <label>C<input type="text" name="c"/></label><br>
        <input type="submit" />
    </form>
    <?php

    include_once "constants.php";
    $conn = new SQLConnection(SERVER, USERNAME, PASSWORD);
    print "Connection Active: " . (($conn -> connect()) ? "Yes" : "No") . "<br>";
    print "Database Connection: " . (($conn -> selectDatabase(DATABASE, true)) ? "Yes" : "No") . "<br>";
//    print __DIR__;
    ?>
</body>
<script>
</script>
</html>