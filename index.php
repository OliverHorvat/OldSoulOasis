<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Web Shop</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <div class="user-buttons">
            <?php
            session_start();
            if (isset($_SESSION['email'])) {
                echo '<div class="user-info">';
                echo '<p class="welcome">Welcome, ' . $_SESSION['email'] . '</p>';
                echo '<a href="logout.php"><button class="new-button">Logout</button></a>';
                echo '</div>';
            } else {
                echo '<a href="login.html"><button class="new-button">Login</button></a>';
                echo '<a href="register.html"><button class="new-button">Register</button></a>';
            }
            ?>
        </div>
        <p></p>
        <h1>Web Shop</h1>
        <p></p>
        <?php
        if (isset($_SESSION['email'])) {
            echo '<div class="cart-container">
                    <button class="cart-button">Cart <span class="cart-badge">0</span></button>
                  </div>';
            echo '<p class="wallet"></p>';
        }
        ?>
        <input type="text" class="filter" placeholder="Search item">
    </header>

    <div class="items-grid">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "oliverhorvat_lv4";

        try {
            $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->query("SELECT * FROM products");
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit;
        }

        foreach ($products as $product) {
            echo '<div class="item">';
            echo '<img class="image" src="' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '">';
            echo '<h2>' . htmlspecialchars($product['name']) . '</h2>';
            echo '<p>$' . htmlspecialchars($product['price']) . '</p>';
            echo '<button class="add-to-cart-btn" data-id="' . $product['id'] . '">Add to cart</button>';
            echo '</div>';
        }
        ?>
    </div>

    <div class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Cart</h2>
            <ul class="cart-items"></ul>
            <button class="buy-btn">Buy</button>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
