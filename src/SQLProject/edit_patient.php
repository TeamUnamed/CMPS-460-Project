<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include "util/FormUtil.php";
    include "generic/header_generic.html";
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
    <p> <b>
        <?php
            print getData('first_name') . '<br>';
            print getData('last_name') . '<br>';
            print getData('birth_date') . '<br>';
            print getData('address') . '<br>';
        ?> </b>
    </p>
</body>
</html>