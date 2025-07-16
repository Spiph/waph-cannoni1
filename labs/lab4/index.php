<?php
// index.php

$lifetime = 15 * 60; // 15 minutes
$path = "/";
$domain = "localhost"; // e.g., "192.168.56.101" or "localhost"
$secure = TRUE; // for HTTPS
$httponly = TRUE; // prevent JavaScript access

session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
session_start();

if (isset($_POST["username"]) && isset($_POST["password"])) {
    if (checklogin_mysql($_POST["username"], $_POST["password"])) {
        $_SESSION["authenticated"] = TRUE;
        $_SESSION["username"] = $_POST["username"];
        $_SESSION["browser"] = $_SERVER["HTTP_USER_AGENT"];
    } else {
        session_destroy();
        echo "<script>alert('Invalid username/password'); window.location='form.php';</script>";
        die();
    }
}

if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] != TRUE) {
    if ($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]) {
    echo "<script>alert('Session hijacking attack is detected!');</script>";
    session_destroy();
    header("Refresh:0; url=form.php");
    die();
}

}

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
?>

<h2>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</h2>
<a href="logout.php">Logout</a>





// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Note: The username from POST is not sanitized, which is part of the vulnerability.
//     if (checklogin_mysql($_POST['username'], $_POST['password'])) {
//         // The output here is also unsanitized, making it vulnerable to XSS.
//         echo "Welcome " . $_POST['username'] . "!";
//     } else {
//         echo "Invalid username/password";
//     }
// } else {
//     include 'form.php';
// }