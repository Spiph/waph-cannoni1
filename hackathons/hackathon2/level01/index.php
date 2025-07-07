<?php
// index.php (Insecure Version for Levels 0 & 1)

function checklogin_mysql($username, $pass) {
    // Single database connection inside the function
    $mysqli = new mysqli('localhost', 'cannoni1', 'pass', 'waph');
    
    if ($mysqli->connect_errno) {
        // Use die() to stop execution on connection failure
        die("Connection failed: " . $mysqli->connect_error);
    }
    
    // INSECURE: Concatenating user input directly into the SQL query [cite: 781, 1008]
    $sql = "SELECT * FROM users WHERE username='" . $username . "' AND password = md5('" . $pass . "')";

    $result = $mysqli->query($sql);

    // Level 0 checks if rows > 0. Level 1 might check for == 1.
    // We'll use >= 1 for practice. You'll need to adapt your attack for the real hackathon.
    if($result && $result->num_rows >= 1) {
        return TRUE;
    }
    
    return FALSE;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // The username from POST is not sanitized, which is part of the vulnerability [cite: 745]
    if (checklogin_mysql($_POST['username'], $_POST['password'])) {
        // The output is also unsanitized, making it vulnerable to XSS [cite: 745]
        echo "Welcome " . $_POST['username'] . "!";
    } else {
        echo "Invalid username/password";
    }
} else {
    include 'form.php';
}
?>