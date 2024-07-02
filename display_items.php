<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "OldSoulOasis";

$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT * FROM products WHERE name LIKE :search";
    $params = [':search' => '%' . $search . '%'];

    // Dodavanje sortiranja
    if ($sort == 'price_asc') {
        $query .= " ORDER BY price ASC";
    } elseif ($sort == 'price_desc') {
        $query .= " ORDER BY price DESC";
    } elseif ($sort == 'name_asc') {
        $query .= " ORDER BY name ASC";
    } elseif ($sort == 'name_desc') {
        $query .= " ORDER BY name DESC";
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($products as $product) {
        echo '<div class="col-md-12 mb-4">';
        echo '<div class="item d-flex">';
        echo '<div class="image-container">';
        echo '<img class="image" src="' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '">';
        echo '</div>';
        echo '<div class="basic-information">';
        echo '<h2 class="product-name">' . htmlspecialchars($product['name']) . '</h2>';
        echo '<p class="product-price">$' . htmlspecialchars($product['price']) . '</p>';
        echo '</div>';
        echo '<div class="buttons">';
        echo '<button class="details-btn btn btn-block btn-lg" data-id="' . htmlspecialchars($product['id']) . '">Details</button>';
        echo '<button class="quantity-btn btn btn-block btn-lg" data-id="' . htmlspecialchars($product['id']) . '">Add to cart</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
