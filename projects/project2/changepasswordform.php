<?php
// changepasswordform.php
require 'session_auth.php';

// Generate a CSRF token
$token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
</head>
<body>
    <h1>Change Your Password</h1>
    <form action="updatepassword.php" method="POST">
        <label>New Password: <input type="password" name="new_password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number, one uppercase and lowercase letter, and at least 8 characters"></label><br>
        <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
        <button type="submit">Change Password</button>
    </form>
</body>
</html>