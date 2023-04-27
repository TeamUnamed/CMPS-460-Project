<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include "Wrapper/SQLConnection.php";
    include "generic/header_generic.html";

    use SQLProject\Wrapper\SQLConnection;
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

    //    $conn = getDatabaseConnection($servername, $username, $password, $dbname);
//
//    $query = "CREATE TABLE IF NOT EXISTS `test_tbl` (
//                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//                first_name VARCHAR(30) NOT NULL,
//                last_name VARCHAR(30) NOT NULL,
//                birth_date DATE NOT NULL,
//                phone_number VARCHAR(10)
//              )";
//    $result = $conn -> query($query);
//    if ($result === false) {
//        echo "Error";
//    } else {
//        echo "Good";
//    }
//    SQLConnect\getDefConnection();
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