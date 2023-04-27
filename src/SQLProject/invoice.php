<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "generic/header_generic.html" ?>

    <title>Submit Invoice</title>
</head>
<body>
    <p>
        <form method="post">
            Name: <input type="text" placeholder="Jane Doe" name="name" /><br>
            ...<br>
            Total Cost: $<input type="number" min="0.01" step="0.01" placeholder="0.00" name="total_cost"/><br>
            <input type="submit"/>
        </form>
</body>
</html>