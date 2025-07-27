<?php
// editprofileform.php
require 'session_auth.php';

// Generate a CSRF token and store it in the session
$token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
</head>
<body>
    <h1>Edit Your Profile</h1>
    <form action="updateprofile.php" method="POST">
        <label>Name: <input type="text" name="name" required></label><br>
        <label>Email: <input type="email" name="email" required></label><br>
        <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
        <button type="submit">Update Profile</button>
    </form>
</body>
</html>