<!-- form.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
  <h1>Login</h1>
  <form action="index.php" method="POST">
    <label>Username: <input type="text" name="username" required></label><br>
    <label>Password: <input type="password" name="password" required></label><br>
    <button type="submit">Login</button>
  </form>
  <br>
  <p>Don't have an account? <a href="registrationform.php">Register here</a>.</p>
</body>
</html>