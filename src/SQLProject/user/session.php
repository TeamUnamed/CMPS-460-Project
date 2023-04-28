<?php
    session_start();

    function redirect(string $url, bool $local = false): void
    {
        $root = $local ? "" : "/SQLProject/";
        header("location: $root$url");
    }

    if (isset($_SESSION["userid"]) && $_SESSION["userid"] !== false) {
        redirect("index.html");
        exit;
    }
