<?php
// register.php

session_start();

// --- 1. CSRF Token Validation ---
if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    die("CSRF validation failed. Request blocked.");
}

// --- 2. Input Presence Check ---
if (!isset($_POST['username'], $_POST['password'], $_POST['name'], $_POST['email'])) {
    die("Please fill out all required fields.");
}

// --- 3. Sanitize and Validate Inputs ---
$name = htmlspecialchars(trim($_POST['name']));
$email = htmlspecialchars(trim($_POST['email']));
$username = htmlspecialchars(trim($_POST['username']));
$password = trim($_POST['password']);

$errors = [];

// Validate that fields are not empty.
if (empty($name) || empty($email) || empty($username) || empty($password)) {
    $errors[] = "All fields are required and cannot be empty.";
}

// Validate email format.
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format provided.";
}

// Validate password complexity.
if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $password)) {
    $errors[] = "Password does not meet the complexity requirements.";
}

// --- 4. Check if Username is Already Taken ---
// This check is performed before other validation messages are shown.
$mysqli = new mysqli('localhost', 'cannoni1', 'pass', 'waph');
if ($mysqli->connect_errno) {
    die("Database connection failed: " . $mysqli->connect_error);
}

$stmt_check_user = $mysqli->prepare("SELECT username FROM users WHERE username = ?");
$stmt_check_user->bind_param("s", $username);
$stmt_check_user->execute();
$result = $stmt_check_user->get_result();

if ($result->num_rows > 0) {
    $errors[] = "This username is already taken. Please choose another one.";
}
$stmt_check_user->close();


// --- 5. Final Error Check and Database Insertion ---
// If there are any errors from validation or the username check, display them.
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color:red;'>Error: $error</p>";
    }
    echo "<a href='registrationform.php'>Go back to registration.</a>";
    $mysqli->close(); // Close the connection before dying.
    die();
}

// If all checks pass, hash the password and insert the new user.
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$stmt_insert_user = $mysqli->prepare("INSERT INTO users (username, password, name, email) VALUES (?, ?, ?, ?)");
$stmt_insert_user->bind_param("ssss", $username, $hashed_password, $name, $email);

if ($stmt_insert_user->execute()) {
    echo "Registration successful! <a href='form.php'>Click here to login.</a>";
} else {
    echo "An unexpected error occurred during registration.";
}

$stmt_insert_user->close();
$mysqli->close();
?>
