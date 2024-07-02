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

<!-- Register Modal -->
<div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-labelledby="register-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="register-modal-label">Register</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Register Form -->
                <form id="register-form" method="post" action="register.php">
                    <div class="form-group">
                        <label for="register-email">Email address:</label>
                        <input type="email" id="register-email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="register-password">Password:</label>
                        <input type="password" id="register-password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-block">Register</button>
                </form>
                <!-- Error or success message -->
                <div id="register-message" class="mt-3"></div>
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
                <ul class="list-group cart-items"></ul>
                <div class="text-center mt-3">
                    <button class="btn btn-block buy-btn">Buy</button>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal for Product Details -->
<div class="modal fade" id="product-details-modal" tabindex="-1" role="dialog" aria-labelledby="product-details-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="product-details-modal-label">Product Details</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4>Track list:</h4>
                <p id="product-description"></p>
            </div>
        </div>
    </div>
</div>