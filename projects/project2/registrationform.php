<!-- registrationform.php -->
<?php
// Must start session to store the token
session_start();
// Generate a token and store it in the session
$token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
</head>
<body>
  <h1>New User Registration</h1>
  <form action="register.php" method="POST">
    <!-- ... other form fields ... -->
    <label>Name: <input type="text" name="name" required></label><br>
    <label>Email: <input type="email" name="email" required></label><br>
    <label>Username: <input type="text" name="username" required pattern="\w+"></label><br>
    <label>Password: <input type="password" name="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="..."></label><br>
    
    <!-- Add the hidden CSRF token field -->
    <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
    
    <button type="submit">Register</button>
  </form>
</body>
