<?php

// Check if the form was submitted with username and password
if (isset($_POST["username"]) && isset($_POST["password"])) {
    // Call the new function to add the user to the database
    if (addnewuser($_POST["username"], $_POST["password"])) {
        echo "Registration succeeded! You can now <a href='../lab4/form.php'>login</a>.";
    } else {
        echo "Registration failed. The username may already exist. Please try again.";
    }
} else {
    // If the form wasn't submitted, redirect back to the registration form
    header("Location: registrationform.php");
    die();
}

/**
 * Adds a new user to the database.
 * @param string $username The username to add.
 * @param string $password The plaintext password.
 * @return bool TRUE on success, FALSE on failure.
 */
function addnewuser($username, $password) {
    // Use your database credentials
    $mysqli = new mysqli('localhost', 'cannoni1', 'pass', 'waph');

    if ($mysqli->connect_errno) {
        error_log("Connection failed: " . $mysqli->connect_error);
        return false;
    }

    // Use a prepared statement with an INSERT query
    $stmt = $mysqli->prepare("INSERT INTO users (username, password) VALUES (?, md5(?))");
    
    // Bind the parameters
    $stmt->bind_param("ss", $username, $password);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        $stmt->close();
        $mysqli->close();
        return TRUE; // Success
    }
    
    // If execute() fails, it's likely a duplicate username
    $stmt->close();
    $mysqli->close();
    return FALSE; // Failure
}

?>