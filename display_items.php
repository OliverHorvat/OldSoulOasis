<?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "OldSoulOasis";

        try {
            $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("SELECT * FROM products");
            $stmt->execute();
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