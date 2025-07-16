<?php
// logout.php
session_start();
session_destroy();
echo "<p>You are logged out!</p>";
echo "<a href='form.php'>Login again</a>";
?>