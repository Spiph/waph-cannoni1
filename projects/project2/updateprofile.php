<?php
// updateprofile.php
require 'session_auth.php';

// Check if the CSRF token is valid
if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    die("CSRF attack detected!");
}

if (isset($_POST['name'], $_POST['email'])) {
    $mysqli = new mysqli('localhost', 'cannoni1', 'pass', 'waph');
    if ($mysqli->connect_errno) {
        die("Connection Failed");
    }

    $stmt = $mysqli->prepare("UPDATE users SET name = ?, email = ? WHERE username = ?");
    $stmt->bind_param("sss", $_POST['name'], $_POST['email'], $_SESSION['username']);

    if ($stmt->execute()) {
        echo "Profile updated successfully! <a href='index.php'>Go back to profile.</a>";
    } else {
        echo "Error updating profile.";
    }
    $stmt->close();
    $mysqli->close();
}
?>
