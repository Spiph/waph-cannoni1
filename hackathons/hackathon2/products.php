<?php
// products.php (Vulnerable Page for Level 2)

// Establish database connection
$mysqli = new mysqli('localhost', 'cannoni1', 'pass', 'waph');
if ($mysqli->connect_errno) {
    die("Connection Failed: " . $mysqli->connect_error);
}

echo "<h1>Product Details</h1>";

// Check if an ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Get the input directly from the URL

    // INSECURE: Concatenating user input, this is the vulnerability for Level 2
    $sql = "SELECT name, price, description FROM products WHERE id = " . $id;

    $result = $mysqli->query($sql);

    if ($result && $result->num_rows > 0) {
        // Display results in a simple format
        while($row = $result->fetch_assoc()) {
            echo "<h2>" . $row['name'] . "</h2>";
            echo "<h3>Price: $" . $row['price'] . "</h3>";
            echo "<p>" . $row['description'] . "</p><hr>";
        }
    } else {
        echo "Product not found.";
    }
} else {
    echo "Please select a product ID. Try <a href='products.php?id=1'>ID 1</a> or <a href='products.php?id=2'>ID 2</a>.";
}
?>