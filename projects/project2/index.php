<?php
// index.php

// This must be the very first thing on the page to handle sessions.
session_start();

// --- 1. Handle Login Attempt ---
// This block only runs when the login form is submitted to this page.
if (isset($_POST["username"]) && isset($_POST["password"])) {
    // The checklogin function is updated to use password_verify().
    if (checklogin_with_password_hash($_POST["username"], $_POST["password"])) {
        // If login is successful, set session variables.
        $_SESSION["authenticated"] = TRUE;
        $_SESSION["username"] = htmlentities($_POST["username"]); // Sanitize username before storing.
        $_SESSION["browser"] = $_SERVER["HTTP_USER_AGENT"];
    } else {
        // If login fails, destroy the session and show an error.
        session_destroy();
        echo "<script>alert('Invalid username or password.'); window.location.href='form.php';</script>";
        die();
    }
}

// --- 2. Authenticate and Authorize Page Access ---
// This will run on every page load. It ensures that only logged-in users can see the profile page.
// If a user is not logged in and tries to access index.php directly, they will be redirected.
require 'session_auth.php';

// --- 3. Fetch User Data for Display ---
// This code has a single purpose: get the logged-in user's data.
// All the incorrect registration validation has been removed.
$user = null; // Initialize user variable.
$mysqli = new mysqli('localhost', 'cannoni1', 'pass', 'waph');

if ($mysqli->connect_errno) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// We get the username from the SESSION, which is secure because we set it after a successful login.
$username_from_session = $_SESSION['username'];

// This query is now correct. It selects the name and email for the logged-in user.
$stmt = $mysqli->prepare("SELECT name, email FROM users WHERE username = ?");
// This bind_param is also correct: "s" for one string variable.
$stmt->bind_param("s", $username_from_session); 
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc(); // Fetch the user's data into an associative array.

$stmt->close();
$mysqli->close();

/**
 * Checks a user's login credentials against the database using modern password_verify().
 * This is the required counterpart to password_hash().
 *
 * @param string $username The username provided by the user.
 * @param string $password The password provided by the user.
 * @return bool True if the credentials are valid, false otherwise.
 */
function checklogin_with_password_hash($username, $password) {
    $mysqli = new mysqli('localhost', 'cannoni1', 'pass', 'waph');
    if ($mysqli->connect_errno) {
        return false;
    }

    $stmt = $mysqli->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        return false; // User not found.
    }

    $user_data = $result->fetch_assoc();
    $stored_hash = $user_data['password'];

    // Use password_verify() to securely compare the provided password with the stored hash.
    $is_valid = password_verify($password, $stored_hash);

    $stmt->close();
    $mysqli->close();
    return $is_valid;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <style>
        body { font-family: sans-serif; padding: 2em; }
        nav a { margin-right: 1em; }
    </style>
</head>
<body>
    <?php if ($user): ?>
        <h2>Welcome, <?php echo htmlentities($user['name']); ?>!</h2>
        <p><strong>Username:</strong> <?php echo htmlentities($username_from_session); ?></p>
        <p><strong>Email:</strong> <?php echo htmlentities($user['email']); ?></p>
    <?php else: ?>
        <p>Could not retrieve user profile. Please try logging out and back in.</p>
    <?php endif; ?>

    <hr>
    <nav>
        <a href="editprofileform.php">Edit Profile</a> |
        <a href="changepasswordform.php">Change Password</a> |
        <a href="logout.php">Logout</a>
    </nav>
</body>
</html>
