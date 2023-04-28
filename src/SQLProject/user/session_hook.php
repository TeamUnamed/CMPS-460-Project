<?php
    session_start();
    header("Content-Type: application/javascript")
?>
session = {userid: null, name: null, email: null};
session['userid'] = <?php echo $_SESSION['userid'] ?? "null" ?>;
session['name']   = "<?php echo $_SESSION['name'] ?? "null" ?>";
session['email']  = "<?php echo $_SESSION['email'] ?? "null" ?>";

function requireSession() {
    if (!<?php echo isset($_SESSION["userid"]) && $_SESSION["userid"] !== false ? "true" : "false"?>) {
        window.location.replace("/SQLProject/user/login.php")
    }
}