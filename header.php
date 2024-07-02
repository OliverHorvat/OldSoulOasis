<header class="bg-header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="index.php">
                <img src="images/logo.png" alt="Logo" class="img-fluid">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                </ul>
                <?php
                    session_start();
                    if (isset($_SESSION['id']) && $_SESSION['admin'] === false) {
                        $emailParts = explode('@', $_SESSION['email']);        
                        $emailPrefix = $emailParts[0];
                        echo '<ul class="navbar-nav ml-auto">';
                        echo '<li class="nav-item">';
                        echo '</li>';
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link" id ="cart-link" href="#">';
                        echo 'Cart';
                        echo '<br>';
                        echo '<span class="cart-badge"></span>';
                        echo '</a>';
                        echo '</li>';
                        echo '</li>';
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link" href="profile.php">';
                        echo htmlspecialchars($emailPrefix);
                        echo '<br>';
                        echo '<span class="wallet"></span>';
                        echo '</a>';
                        echo '</li>';
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link" href="logout.php">Log Out</a>';
                        echo '</li>';
                        echo '</ul>';
                    } elseif (isset($_SESSION['id']) && $_SESSION['admin'] === true) {
                        echo '<ul class="navbar-nav ml-auto">';
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link" href="add_product.php">Add Product</a>';
                        echo '</li>';
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link" href="logout.php">Log Out</a>';
                        echo '</li>';
                        echo '</ul>';
                        
                    } else {
                        echo '<ul class="navbar-nav ml-auto">';
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link" href="#" data-toggle="modal" data-target="#login-modal">Login</a>';
                        echo '</li>';
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link" href="#" data-toggle="modal" data-target="#register-modal">Register</a>';
                        echo '</li>';
                        echo '</ul>';
                    }
                ?>
            </div>
        </nav>
    </div>
</header>