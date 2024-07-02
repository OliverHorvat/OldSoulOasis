document.addEventListener('DOMContentLoaded', function() {
    updateCartBadge();

    const cartLink = document.getElementById('cart-link');
    const cartBadge = document.querySelector('.cart-badge');
    const buyButton = document.querySelector('.buy-btn');
    const cartItemsList = document.querySelector('.cart-items');
    const filter = document.querySelector('.filter');
    const wallet = document.querySelector('.wallet');
    const items = document.querySelectorAll('.item');
    const loginForm = document.getElementById('login-form');
    const loginMessage = document.getElementById('login-message');
    const registerForm = document.getElementById('register-form');
    const registerMessage = document.getElementById('register-message');
    let productId = -1;

    setupFilter();

    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevents the form from being submitted through the traditional process
            const formData = new FormData(loginForm);
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'login.php');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            // Login is successful, you can perform the desired actions
                            // For example, updating the interface or redirecting
                            loginMessage.innerHTML = '<div class="alert alert-success mt-3" role="alert">You have successfully logged in!</div>';
                            setTimeout(function() {
                                location.reload(); // Refresh the page after login
                            }, 1000); // Refresh the page after 1 second
                        } else {
                            // Displays an error message if login failed
                            loginMessage.innerHTML = '<div class="alert alert-danger mt-3" role="alert">Incorrect email address or password. Please try again.</div>';
                        }
                    } catch (error) {
                        console.error('Error parsing JSON response:', error);
                    }
                } else {
                    console.error('Request failed. Status:', xhr.status);
                }
            };
            xhr.onerror = function() {
                console.error('Request error.');
            };
            xhr.send(formData);
        });
    }    
    
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent the form from being submitted traditionally
            const formData = new FormData(registerForm);
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'register.php');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            // Registration is successful, display success message
                            registerMessage.innerHTML = '<div class="alert alert-success mt-3" role="alert">Registration successful! Logging you in...</div>';
                            setTimeout(function() {
                                $('#register-modal').modal('hide'); // Hide the modal after 2 seconds
                                registerMessage.innerHTML = ''; // Clear the message
                                registerForm.reset(); // Reset the form
                                location.reload(); // Reload the page after successful registration and login
                            }, 2000); // Hide the modal after 2 seconds
                        } else {
                            // Display error message if registration failed
                            registerMessage.innerHTML = '<div class="alert alert-danger mt-3" role="alert">' + response.error + '</div>';
                        }
                    } catch (error) {
                        console.error('Error parsing JSON response:', error);
                    }
                } else {
                    console.error('Request failed. Status:', xhr.status);
                }
            };
            xhr.onerror = function() {
                console.error('Request error.');
            };
            xhr.send(formData);
        });
    }

    if (cartLink) {
        cartLink.addEventListener('click', function() {
            checkCart();
            $('#cart-modal').modal('show');
        });
    }

    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function() {
            event.preventDefault();
            const quantity = document.getElementById('quantity').value;
            addToCart(productId, quantity);
        });
    });

    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            productId = this.getAttribute('data-id');
            $('#quantity-modal').modal('show');
        });
    });

    document.querySelectorAll('.details-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            showProductDetails(productId);
        });
    });

    function addToCart(productId, quantity) {
        console.log("kokoska");
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'add_to_cart.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        updateCartBadge();
                        $('#quantity-modal').modal('hide');
                        alert("Product successfully added to cart.")
                    } else {
                        alert(response.message);
                    }
                } catch (error) {
                    console.error("Error parsing JSON response:", error);
                    console.error("Response:", xhr.responseText);
                }
            } else {
                alert('An error occurred while processing the request.');
            }
        };
        xhr.onerror = function() {
            alert('An error occurred while sending the request.');
        };
        xhr.send(`product_id=${productId}&quantity=${quantity}`);
    }

    function showProductDetails(productId) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `get_product_details.php?id=${productId}`, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const product = JSON.parse(xhr.responseText);
                document.getElementById('product-details-modal-label').textContent = product.name;
                document.getElementById('product-description').textContent = product.description;
                $('#product-details-modal').modal('show');
            } else {
                console.error('Failed to fetch product details.');
            }
        };
        xhr.onerror = function() {
            console.error('Error fetching product details.');
        };
        xhr.send();
    }

    function updateCartBadge() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_cart_contents.php');
        xhr.onload = function() {
            if (xhr.status === 200) {
                const cartContents = JSON.parse(xhr.responseText);
                let totalItems = 0;
                cartContents.forEach(item => {
                    totalItems += parseInt(item.quantity);
                });
                cartBadge.textContent = `(${totalItems})`;
            } else {
                console.error('Failed to fetch cart contents.');
            }
        };
        xhr.onerror = function() {
            console.error('Error fetching cart contents.');
        };
        xhr.send();
    }

    function checkCart() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_cart_contents.php');
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const cartContents = JSON.parse(xhr.responseText);
                    if (cartContents.length > 0) {
                        let message = "";
                        let totalPrice = 0;
                        cartContents.forEach(item => {
                            totalPrice += item.price * item.quantity;
                            message += `
                                <div class="cart-row">
                                    <div class="cart-column">
                                        <h5 class="item-name">${item.name}</h5>
                                        <h6 class="item-name">Quantity: ${item.quantity}</h6>
                                        <h6 class="item-name">Price: $${item.price}</h6>
                                        <h6 class="item-name">Total price: $${item.quantity * item.price}</h6>
                                    </div>
                                    <input type="number" class="form-control quantity-input remove-quantity" data-id="${item.product_id}" min="1" max="${item.quantity}" value="1">
                                    <button class="remove-btn btn-block" data-id="${item.product_id}">Remove</button>
                                </div>
                            `;
                        });
                        message += `<h4>Total price: $${totalPrice.toFixed(2)}</h4>`;
                        cartItemsList.innerHTML = message;
                        buyButton.style.display = 'block';
                    } else {
                        cartItemsList.innerHTML = "<h5>Cart is empty!</h5>";
                        buyButton.style.display = 'none';
                    }

                    document.querySelectorAll('.remove-btn').forEach(button => {
                        button.addEventListener('click', function() {
                            const productId = this.getAttribute('data-id');
                            const quantity = this.parentElement.querySelector('.quantity-input').value;
                            removeFromCart(productId, quantity);
                        });
                    });
                } catch (error) {
                    console.error("Error parsing JSON response:", error);
                    console.error("Response:", xhr.responseText);
                }
            } else {
                alert('Failed to fetch cart contents.');
            }
        };
        xhr.onerror = function() {
            alert('Error fetching cart contents.');
        };
        xhr.send();
    }

    function removeFromCart(productId, quantity) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'remove_from_cart.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        updateCartBadge();
                        checkCart();
                    } else {
                        alert(response.message);
                    }
                } catch (error) {
                    console.error("Error parsing JSON response:", error);
                    console.error("Response:", xhr.responseText);
                }
            } else {
                alert('Failed to remove product from cart.');
            }
        };
        xhr.onerror = function() {
            alert('Error removing product from cart.');
        };
        xhr.send(`product_id=${productId}&quantity=${quantity}`);
    }

    function clearCart() {
        cart = {};
        cartItemsCount = 0;
        cartBadge.textContent = "(0)";

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'clear_cart.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        cartItemsList.innerHTML = "<p>Cart is empty!</p>";
                        buyButton.style.display = 'none';
                    } else {
                        alert('Error clearing cart: ' + response.error);
                    }
                } catch (error) {
                    console.error("Error parsing JSON response:", error);
                    console.error("Response:", xhr.responseText);
                }
            } else {
                alert('Failed to clear cart.');
            }
        };
        xhr.onerror = function() {
            alert('Error clearing cart.');
        };
        xhr.send();
    }

    function buy() {
        const isProfilePage = window.location.pathname.includes('profile.php');
    
        const xhrCart = new XMLHttpRequest();
        xhrCart.open('GET', 'get_cart_contents.php');
        xhrCart.onload = function() {
            if (xhrCart.status === 200) {
                try {
                    const cartContents = JSON.parse(xhrCart.responseText);
                    if (cartContents.length > 0) {
                        let totalPrice = 0;
                        cartContents.forEach(item => {
                            totalPrice += item.price * item.quantity;
                        });
    
                        const xhrWallet = new XMLHttpRequest();
                        xhrWallet.open('GET', 'get_wallet_amount.php');
                        xhrWallet.onload = function() {
                            if (xhrWallet.status === 200) {
                                try {
                                    const walletData = JSON.parse(xhrWallet.responseText);
                                    let walletAmountFromDB = parseFloat(walletData.amount);
    
                                    if (totalPrice <= walletAmountFromDB) {
                                        walletAmountFromDB -= totalPrice;
                                        updateWallet(walletAmountFromDB);
                                        updateWalletInDatabase(walletAmountFromDB);
    
                                        // Clear the cart and update UI
                                        clearCart();
                                        updateCartBadge();
    
                                        // Save transaction to database
                                        saveTransaction(cartContents);
    
                                        alert("Purchase successful!");
    
                                        // Redirect to index.html if on profile.php
                                        if (isProfilePage) {
                                            window.location.href = "index.php";
                                        }
                                    } else {
                                        alert("Not enough money!");
                                    }
                                } catch (error) {
                                    console.error("Error parsing JSON response:", error);
                                    console.error("Response:", xhrWallet.responseText);
                                }
                            } else {
                                alert('Failed to fetch wallet amount.');
                            }
                        };
                        xhrWallet.onerror = function() {
                            alert('Error fetching wallet amount.');
                        };
                        xhrWallet.send();
                    } else {
                        alert("Your cart is empty!");
                    }
                } catch (error) {
                    console.error("Error parsing JSON response:", error);
                    console.error("Response:", xhrCart.responseText);
                }
            } else {
                alert('Failed to fetch cart contents.');
            }
        };
        xhrCart.onerror = function() {
            alert('Error fetching cart contents.');
        };
        xhrCart.send();
    }
    

    function saveTransaction(cartContents) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'save_transaction.php');
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        console.log("Transaction saved successfully.");
                    } else {
                        alert(response.message);
                    }
                } catch (error) {
                    console.error("Error parsing JSON response:", error);
                    console.error("Response:", xhr.responseText);
                }
            } else {
                alert('Failed to save transaction.');
            }
        };
        xhr.onerror = function() {
            alert('Error saving transaction.');
        };
        xhr.send(JSON.stringify({ cart_contents: cartContents }));
    }

    function getWalletAmount() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_wallet_amount.php');
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.amount !== undefined) {
                        wallet.textContent = '$' + response.amount;
                    } else {
                        console.error('Amount not found in response:', response);
                    }
                } catch (error) {
                    console.error('Error parsing JSON response:', error);
                    console.error('Response:', xhr.responseText);
                }
            } else {
                console.error('Error fetching wallet amount. Status:', xhr.status);
            }
        };
        xhr.onerror = function() {
            console.error('Error fetching wallet amount. Network error.');
        };
        xhr.send();
    }

    function updateWalletInDatabase(newAmount) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_wallet.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            console.log(xhr.responseText);
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    console.log('Wallet updated successfully.');
                } else {
                    console.error('Error updating wallet:', response.error);
                }
            } else {
                console.error('Failed to update wallet. Server returned status:', xhr.status);
            }
        };
        xhr.onerror = function() {
            console.error('Error updating wallet. XMLHttpRequest error.');
        };
        xhr.send(`new_amount=${newAmount}`);
    }

    function updateWallet(amount) {
        wallet.textContent = `$${amount.toFixed(2)}`;
    }

    function setupFilter() {
        if (filter) {
            filter.addEventListener('input', function() {
                const search = filter.value.toLowerCase();
                items.forEach(item => {
                    const itemName = item.querySelector('h2').textContent.toLowerCase();
                    if (itemName.includes(search)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }
    }

    function setupSort() {
        const sortButton = document.querySelector('.sort-button');
        if (sortButton) {
            sortButton.addEventListener('click', function() {
                const itemsArray = Array.from(items);
                itemsArray.sort((a, b) => {
                    const nameA = a.querySelector('h2').textContent.toLowerCase();
                    const nameB = b.querySelector('h2').textContent.toLowerCase();
                    return nameA.localeCompare(nameB);
                });
                const itemsContainer = document.querySelector('.items-container');
                itemsContainer.innerHTML = '';
                itemsArray.forEach(item => {
                    itemsContainer.appendChild(item);
                });
                resetEventListeners();
            });
        }
    }

    function resetEventListeners() {
        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            button.removeEventListener('click', addToCartHandler);
            button.addEventListener('click', addToCartHandler);
        });

        document.querySelectorAll('.quantity-btn').forEach(button => {
            button.removeEventListener('click', quantityBtnHandler);
            button.addEventListener('click', quantityBtnHandler);
        });

        document.querySelectorAll('.details-btn').forEach(button => {
            button.removeEventListener('click', detailsBtnHandler);
            button.addEventListener('click', detailsBtnHandler);
        });
    }

    function addToCartHandler(event) {
        event.preventDefault();
        const quantity = document.getElementById('quantity').value;
        const productId = this.getAttribute('data-id');
        addToCart(productId, quantity);
    }

    function quantityBtnHandler(event) {
        productId = this.getAttribute('data-id');
        $('#quantity-modal').modal('show');
    }

    function detailsBtnHandler(event) {
        const productId = this.getAttribute('data-id');
        showProductDetails(productId);
    }

    buyButton.addEventListener('click', buy);

    window.addEventListener('load', getWalletAmount);
    setupSort();
});
