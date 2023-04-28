<?php

require_once "config.php";
require_once "session.php";


$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if(empty($email)) {
        $error .= '<p class="error">Please enter email.</p>';
    }

    if(empty($password)) {
        $error .= '<p class="error">Please enter your password.</p>';
    }

    if(empty($error)) {
        if($query = $db->prepare("SELECT * FROM Users WHERE email = ?")) {
            $query->bind_param('s', $email);
            $query->execute();
            $query->bind_result($userId, $name, $hash, $email);
            $row = $query->fetch();
            if($row) {
                if (password_verify($password, $hash)) {
                    $_SESSION["userid"] = $userId;
                    $_SESSION["name"] = $name;
                    $_SESSION["email"] = $email;

                    redirect("index.html");
                    exit;
                } else {
                    $error .= '<p class="error">The password is not valid.</p>';
                }
            } else {
                $error .= '<p class="error">No User exist with that email.</p>';
            }
        }
        $query->close();
    }
    mysqli_close($db);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="session_hook.php"></script>
        <script src="../navbarInclude.js"></script>

        <div class="navbar"></div>
    </head>
    <body>
        <?php
            if (!empty($error))
                print $error;
        ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Login</h2>
                    <p>Please fill in your email and password.</p>
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="=btn btn-primary" value="Submit">
                        </div>
                        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>