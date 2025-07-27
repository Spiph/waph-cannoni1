<?php
// session_auth.php

// Secure session setup
$lifetime = 15 * 60; // 15 minutes
$path = '//project2//';
$domain = "localhost"; // Change to your domain if needed
$secure = TRUE;
$httponly = TRUE;
session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
session_start();

// Check if user is authenticated
if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== TRUE) {
    session_destroy();
    echo "<script>alert('You have not logged in. Please login first');</script>";
    header("Refresh:0; url=form.php");
    die();
}

// Defense-in-Depth: Check browser to prevent session hijacking
if ($_SESSION["browser"] !== $_SERVER["HTTP_USER_AGENT"]) {
    echo "<script>alert('Session hijacking attack is detected!');</script>";
    session_destroy();
    header("Refresh:0; url=form.php");
    die();
}
?>