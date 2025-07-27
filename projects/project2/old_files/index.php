<?php
// Final Secure index.php from Lab 4

// 1. Secure Cookie Setup
// These parameters must be set before session_start()
$lifetime = 15 * 60; // Session lifetime in seconds (15 minutes)
$path = "/";
$domain = "localhost"; // Use your domain or IP
$secure = TRUE; // Transmit cookie only over HTTPS
$httponly = TRUE; // Prevent JavaScript access to the cookie

session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
session_start();

// 2. Handle New Login Attempts
if (isset($_POST["username"]) && isset($_POST["password"])) {
    if (checklogin_mysql($_POST["username"], $_POST["password"])) {
        // On successful login, set session variables
        $_SESSION["authenticated"] = TRUE;
        $_SESSION["username"] = htmlentities($_POST["username"]); // Sanitize for safety
        $_SESSION["browser"] = $_SERVER["HTTP_USER_AGENT"]; // Store browser info for security
    } else {
        // On failed login, destroy session and show error
        session_destroy();
        echo "<script>alert('Invalid username/password'); window.location='form.php';</script>";
        die();
    }
}

// 3. Check for Existing Authenticated Session
if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== TRUE) {
    session_destroy();
    echo "<script>alert('You have not logged in. Please login first');</script>";
    header("Refresh:0; url=form.php");
    die();
}

// 4. Defense-in-Depth: Check Browser to Prevent Session Hijacking
if ($_SESSION["browser"] !== $_SERVER["HTTP_USER_AGENT"]) {
    echo "<script>alert('Session hijacking attack is detected!');</script>";
    session_destroy();
    header("Refresh:0; url=form.php");
    die();
}


/**
 * 5. Secure Database Function
 * Checks user credentials against the database using a Prepared Statement.
 * @param string $username The user's username.
 * @param string $password The user's plaintext password.
 * @return bool TRUE on successful login, FALSE otherwise.
 */
function checklogin_mysql($username, $password) {
    $mysqli = new mysqli('localhost', 'cannoni1', 'pass', 'waph');
        
    if ($mysqli->connect_errno) {
        error_log("Connection failed: " . $mysqli->connect_error);
        return FALSE;
    }
    
    // Use a Prepared Statement to prevent SQL Injection
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ? AND password = md5(?)");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows == 1) {
        $stmt->close();
        $mysqli->close();
        return TRUE;
    }
    
    $stmt->close();
    $mysqli->close();
    return FALSE;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <h2>Welcome <?php echo $_SESSION['username']; ?>!</h2>
    <a href="logout.php">Logout</a>
</body>
</html>