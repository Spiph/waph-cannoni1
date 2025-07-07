<?php
// index.php (Secure Version for Level 2)

function checklogin_mysql($username, $password) {
    $mysqli = new mysqli('localhost', 'cannoni1', 'pass', 'waph');

    if ($mysqli->connect_errno) {
        die("Connection Failed: " . $mysqli->connect_error);
    }

    // Use a prepared statement to prevent SQL injection [cite: 798, 807]
    // 1. Prepare the SQL template with placeholders (?) [cite: 819, 867]
    $prepared_sql = "SELECT * FROM users WHERE username = ? AND password = md5(?)";
    $stmt = $mysqli->prepare($prepared_sql);

    // 2. Bind the user input to the placeholders [cite: 837, 877]
    // "ss" means both parameters are strings
    $stmt->bind_param("ss", $username, $password);

    // 3. Execute the statement [cite: 839, 878]
    $stmt->execute();
    $result = $stmt->get_result();

    if($result && $result->num_rows == 1) {
        return TRUE;
    }

    return FALSE;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (checklogin_mysql($_POST['username'], $_POST['password'])) {
        // Use htmlspecialchars to prevent XSS on the output
        echo "<h1>Login Success!</h1>Welcome, " . htmlspecialchars($_POST['username']) . "!";
    } else {
        echo "Invalid username/password";
    }
} else {
    include 'form.php';
}
?>