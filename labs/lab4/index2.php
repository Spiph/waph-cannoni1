<?php
// Lab 4, Task 2.a: index.php with Session Management

// Must be the very first thing on the page
session_start();

// This block handles a new login attempt from form.php
if (isset($_POST["username"]) && isset($_POST["password"])) {
    // checklogin_mysql() is defined below
    if (checklogin_mysql($_POST["username"], $_POST["password"])) {
        // On successful login, set the session variables
        $_SESSION["authenticated"] = TRUE;
        $_SESSION["username"] = htmlentities($_POST["username"]); // Sanitize before storing
    } else {
        // On failed login, destroy any session and show an error
        session_destroy();
        echo "<script>alert('Invalid username/password'); window.location='form.php';</script>";
        die();
    }
}

// This block protects the page, checking if a user is already authenticated
if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== TRUE) {
    session_destroy();
    echo "<script>alert('You have not logged in. Please login first');</script>";
    header("Refresh:0; url=form.php");
    die();
}

// Function to check credentials against the database using prepared statements
function checklogin_mysql($username, $password) {
    // Use your database credentials
    $mysqli = new mysqli('localhost', 'cannoni1', 'pass', 'waph');

    if ($mysqli->connect_errno) {
        error_log("Connection failed: " . $mysqli->connect_error);
        return false;
    }

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
    <br>
    <a href="logout.php">Logout</a>
</body>
</html>