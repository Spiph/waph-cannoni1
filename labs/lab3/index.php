<?php
// index.php

$mysqli = new mysqli(
  'localhost',        // host
  'webuser',          // user
  'cads',             // password
  'secure_app'        // database name
);


function checklogin_mysql($user, $pass) {
    // Insecure: no input validation, echoes raw queries
    $mysqli = new mysqli('localhost', 'webuser', 'YOUR_PASSWORD', 'secure_app');
    if ($mysqli->connect_errno) {
        die("Connection failed: (" 
        . $mysqli->connect_errno . ") " 
        . $mysqli->connect_error);
    }
    // INSECURE: building SQL with string interpolation!
    $sql = "SELECT password FROM Users WHERE username = '$user'";
    error_log("DEBUG SQL: " . $sql);
    $result = $mysqli->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        // insecure: storing plaintext comparison
        return password_verify($pass, $row['password']);
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (checklogin_mysql($_POST['username'], $_POST['password'])) {
        echo "Welcome, " . htmlspecialchars($_POST['username']) . "!";
    } else {
        echo "Invalid username or password.";
    }
} else {
    include 'form.php';
}
