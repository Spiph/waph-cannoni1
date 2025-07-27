<?php
// updatepassword.php
require 'session_auth.php';

// Check the CSRF token
if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    die("CSRF attack detected!");
}

if (isset($_POST['new_password'])) {
    $new_password = trim($_POST['new_password']);

    // Add server-side validation for the new password
    if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $new_password)) {
        die("Password does not meet the complexity requirements. <a href='changepasswordform.php'>Try again.</a>");
    }

    // Hash the new password using the same method as registration
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    $mysqli = new mysqli('localhost', 'cannoni1', 'pass', 'waph');
    if ($mysqli->connect_errno) {
        die("Connection Failed");
    }

    // Update the query to use the hashed password
    $stmt = $mysqli->prepare("UPDATE users SET password = ? WHERE username = ?");
    // Bind the hashed password and the username from the session
    $stmt->bind_param("ss", $hashed_password, $_SESSION['username']);

    if ($stmt->execute()) {
        echo "Password changed successfully! <a href='index.php'>Go back to profile.</a>";
    } else {
        echo "Error changing password.";
    }
    $stmt->close();
    $mysqli->close();
}
?>
