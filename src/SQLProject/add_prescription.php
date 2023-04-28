<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include "util/FormUtil.php";
    include "util/SQLConnection.php";
    include "base/navbar.html";

    use SQLProject\util\SQLConnection;
    ?>
    <title>Add Prescription</title>
</head>
<body>
<p>
<form method="post" actions="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
    <?php
    input('number', 'drug_id', 'Prescription ID');
    input('number', 'customer_id', 'Customer ID');
    input('number', 'type_id', 'Drug Type ID');
    input('number', 'employee_id', 'Employee ID');
    input('number', 'count', 'Count');
    input('number', 'refills', 'Refills');
    input('date', 'fill_date', 'Fill Date');
    ?> <br>
    <input type="submit" value="Add">
</form>
</p>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "POST";
}
?>
</body>
</html>
