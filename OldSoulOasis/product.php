<?php
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "OldSoulOasis";

try {
    // Establish database connection
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if product ID is provided
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Prepare and execute SQL query to fetch product details by ID
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        // If product with provided ID doesn't exist, display error message
        if (!$product) {
            echo "Product not found.";
            exit;
        }
    } else {
        // If product ID is missing, display error message
        echo "Product ID is missing.";
        exit;
    }
} catch (PDOException $e) {
    // If there's an error with the database connection, display error message
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <h1><?php echo htmlspecialchars($product['name']); ?></h1>
    </header>
    <div class="product-details">
        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
        <p><?php echo htmlspecialchars($product['description']); ?></p>
        <p>Price: $<?php echo htmlspecialchars($product['price']); ?></p>
        <input type="number" id="quantity" name="quantity" min="1" value="1">
        <button id="add-to-cart" data-id="<?php echo $product['id']; ?>">Add to Cart</button>
    </div>
    <script>
        document.getElementById('add-to-cart').addEventListener('click', function() {
            var productId = this.getAttribute('data-id');
            var quantity = document.getElementById('quantity').value;
            var cart = JSON.parse(localStorage.getItem('cart')) || {};
            if (cart[productId]) {
                cart[productId] += parseInt(quantity);
            } else {
                cart[productId] = parseInt(quantity);
            }
            localStorage.setItem('cart', JSON.stringify(cart));
        });
    </script>
</body>
</html>
