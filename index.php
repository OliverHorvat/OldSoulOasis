<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Old Soul Oasis</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Font Awesome (optional for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<header class="bg-header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="#">
                <img src="path_to_your_logo.png" alt="Logo" class="img-fluid">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
                <?php
                    // Provjera da li je korisnik prijavljen
                    session_start();
                    if (isset($_SESSION['id'])) {
                        // Ako je prijavljen
                        echo '<ul class="navbar-nav ml-auto">';
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link" id ="cart-link" href="#">Cart</a>';
                        echo '</li>';
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link" href="#">Profile</a>';
                        echo '</li>';
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link" href="logout.php">Log Out</a>';
                        echo '</li>';
                        echo '</ul>';
                    } else {
                        // Ako nije prijavljen
                        echo '<ul class="navbar-nav ml-auto">';
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link" href="#" data-toggle="modal" data-target="#login-modal">Login</a>';
                        echo '</li>';
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link" href="#">Register</a>';
                        echo '</li>';
                        echo '</ul>';
                    }
                    ?>

            </div>
        </nav>
    </div>
</header>

<!-- Modal -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="login-modal-label">Login</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Login Form -->
                <form id="login-form" method="post">
                    <div class="form-group">
                        <label for="email">Email address:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-block">Log in</button>
                </form>
                <!-- Error or success message -->
                <div id="login-message" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="quantity-modal" tabindex="-1" role="dialog" aria-labelledby="quantity-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="quantity-modal-label">Select Quantity</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="quantity-form">
                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" class="form-control" min="1" value="1" required>
                    </div>
                    <button type="submit" class="add-to-cart-btn btn btn-block">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cart-modal" tabindex="-1" role="dialog" aria-labelledby="cart-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="cart-modal-label">Your Cart</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-group cart-items">   
                </ul>
                <div class="text-center mt-3">
                    <button class="btn btn-block buy-btn">Buy</button>
                </div>
            </div>
        </div>
    </div>
</div>






<div class="container mt-4 search-form">
    <div class="row align-items-center">
        <div class="col-md-6 mb-2 mb-md-0">
            <input class="form-control form-control-lg mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        </div>
        <div class="col-md-2 mb-2 mb-md-0">
            <select class="form-control">
                <option value="">Category</option>
                <option value="category1">Category 1</option>
                <option value="category2">Category 2</option>
                <option value="category3">Category 3</option>
                <option value="category4">Category 4</option>
            </select>
        </div>
        <div class="col-md-2 mb-2 mb-md-0">
            <select class="form-control">
                <option value="">Sort by</option>
                <option value="price_asc">Price: Low to High</option>
                <option value="price_desc">Price: High to Low</option>
                <option value="name_asc">Name: A to Z</option>
                <option value="name_desc">Name: Z to A</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-secondary btn-lg my-2 my-sm-0 btn-block" type="submit">Search</button>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
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
                echo '<button class="details-btn btn btn-block btn-lg">Details</button>';
                echo '<button class="quantity-btn btn btn-block btn-lg" data-id="' . htmlspecialchars($product['id']) . '">Add to cart</button>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        ?>
    </div>
</div>

<footer class="bg-footer text-center text-white mt-5 py-3">
    <p>&copy; 2024 Old Soul Oasis. All rights reserved.</p>
</footer>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Custom script for handling login form submission -->
<script src="script.js"></script>

</body>
</html>