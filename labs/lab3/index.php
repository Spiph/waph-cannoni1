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
        'localhost',    // host
        'cannoni1',     // user
        'pass',         // password
        'waph'          // database name
    );

    if ($mysqli->connect_errno) {
        printf("Connection failed: %s\n", $mysqli->connect_error);
        exit();
    }

    // Step 1: Create a SQL prepared statement with '?' placeholders [cite: 285, 287]
    $sql = "SELECT * FROM users WHERE username = ? AND password = md5(?)";
    $stmt = $mysqli->prepare($sql);

    // Step 2: Bind the input variables to the placeholders [cite: 297]
    // The "ss" indicates that both username and password are treated as strings [cite: 75, 297]
    $stmt->bind_param("ss", $username, $pass);

    // Step 3: Execute the statement and get the result [cite: 298]
    $stmt->execute();
    $result = $stmt->get_result();

    // If the query returns exactly one row, the login is successful
    if ($result->num_rows == 1) {
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