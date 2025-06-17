<?php
// echo.php: Securely echo back the “message” parameter
function sanitize($data) {
    return htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['message'])) {
    $message = sanitize($_GET['message']);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $message = sanitize($_POST['message']);
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
