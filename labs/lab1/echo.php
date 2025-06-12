<?php
// echo.php: Echo back the “message” parameter from the URL
if (isset($_GET['message'])) {
    $message = $_GET['message'];
} else {
    $message = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Echo Application</title>
</head>
<body>
  <h1>Echo Application</h1>
  <p>You submitted: <strong><?php echo $message; ?></strong></p>
  <form method="get" action="echo.php">
    <label for="message">Enter a submission to be echoed:</label>
    <input type="text" id="message" name="message" placeholder="Enter a submission" />
    <button type="submit">Submit</button>
  </form>
</body>
</html>
