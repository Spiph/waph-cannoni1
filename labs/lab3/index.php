<?php
// index.php

$mysqli = new mysqli(
  'localhost',        // host
  'cannoni1',          // user
  'pass',    // password
  'waph'              // database name
);

function checklogin_mysql($username, $pass) {
    $mysqli = new mysqli(
        'localhost',        // host
        'cannoni1',          // user
        'pass',    // password
        'waph'              // database name
        );
        
    if ($mysqli->connect_errno) {
        printf("Connection failed: %s\n", $mysqli->connect_error);
    }
    
    // INSECURE: Building SQL query with user input. This is vulnerable!
    $sql = "SELECT * FROM users WHERE username='" . $username . "' AND password = md5('" . $pass . "')";

    // For debugging
    echo "DEBUG>sql= " . $sql;

    $result = $mysqli->query($sql);

    // If the query returns exactly one row, the login is successful
    if($result->num_rows == 1) {
        return TRUE;
    }
    
    return FALSE;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Note: The username from POST is not sanitized, which is part of the vulnerability.
    if (checklogin_mysql($_POST['username'], $_POST['password'])) {
        // The output here is also unsanitized, making it vulnerable to XSS.
        echo "Welcome " . $_POST['username'] . "!";
    } else {
        echo "Invalid username/password";
    }
} else {
    include 'form.php';
}