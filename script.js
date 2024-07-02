document.addEventListener('DOMContentLoaded', function() {

    const cartLink = document.getElementById('cart-link');
    const cartBadge = document.querySelector('.cart-badge');
    const buyButton = document.querySelector('.buy-btn');
    const cartItemsList = document.querySelector('.cart-items');
    const wallet = document.querySelector('.wallet');
    const items = document.querySelectorAll('.item');
    const loginForm = document.getElementById('login-form');
    const loginMessage = document.getElementById('login-message');
    const registerForm = document.getElementById('register-form');
    const registerMessage = document.getElementById('register-message');
    let productId = -1;

    setupSort();
    updateCartBadge();

    if (localStorage.getItem('addSuccess')) {
        showToast("Product has been successfully added to shop.", "success");
        localStorage.removeItem('addSuccess');
    }
 
    if (localStorage.getItem('purchaseSuccess')) {
        showToast("Purchase successful!", "success");
        localStorage.removeItem('purchaseSuccess');
    }


    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(loginForm);
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'login.php');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            loginMessage.innerHTML = '<div class="alert alert-success mt-3" role="alert">You have successfully logged in!</div>';
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else {
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
            e.preventDefault();
            const formData = new FormData(registerForm);
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'register.php');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            registerMessage.innerHTML = '<div class="alert alert-success mt-3" role="alert">Registration successful!</div>';
                            setTimeout(function() {
                                $('#register-modal').modal('hide');
                                registerMessage.innerHTML = '';
                                registerForm.reset();
                                location.reload();
                            }, 2000);
                        } else {
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

    buyButton.addEventListener('click', buy);

    window.addEventListener('load', getWalletAmount);

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

    document.querySelectorAll('.admin-delete-btn').forEach(button => {
        button.addEventListener('click', deleteProductHandler);
    });

    function showProductDetails(productId) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `get_product_details.php?id=${productId}`, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const product = JSON.parse(xhr.responseText);
                document.getElementById('product-details-modal-label').textContent = product.name;
                const formattedDescription = product.description.replace(/\\n/g, '<br>');
                document.getElementById('product-description').innerHTML = formattedDescription;
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

    function addToCart(productId, quantity) {
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
                        showToast("Product successfully added to cart.", "success");
                    } else {
                        showToast(response.message, "danger");
                    }
                } catch (error) {
                    console.error("Error parsing JSON response:", error);
                    console.error("Response:", xhr.responseText);
                }
            } else {
                showToast('An error occurred while processing the request.', "danger");
            }
        };
        xhr.onerror = function() {
            showToast('An error occurred while processing the request.', "danger");
        };
        xhr.send(`product_id=${productId}&quantity=${quantity}`);
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
                showToast("Failed to fetch cart contents.", "danger");
            }
        };
        xhr.onerror = function() {
           showToast("Error fetching cart contents", "danger");
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
                        showToast(response.message, 'danger');
                    }
                } catch (error) {
                    console.error("Error parsing JSON response:", error);
                    console.error("Response:", xhr.responseText);
                }
            } else {
                showToast('Failed to remove product from cart.', 'danger');
            }
        };
        xhr.onerror = function() {
            showToast('Error removing product from cart.', 'danger');
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
                        showToast('Error clearing cart: ' + response.error, 'danger');
                    }
                } catch (error) {
                    console.error("Error parsing JSON response:", error);
                    console.error("Response:", xhr.responseText);
                }
            } else {
                showToast('Failed to clear cart: ' + response.error, 'danger');
            }
        };
        xhr.onerror = function() {
            showToast('Error clearing cart: ' + response.error, 'danger');
        };
        xhr.send();
    }

    function buy() {
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
                                        clearCart();
                                        updateCartBadge();
                                        $('#cart-modal').modal('hide');
                                        saveTransaction(cartContents);
                                        localStorage.setItem('purchaseSuccess', 'true');
                                        window.location.href = "profile.php";
                                    } else {
                                        showToast("Not enough money!", "danger");
                                    }
                                } catch (error) {
                                    console.error("Error parsing JSON response:", error);
                                    console.error("Response:", xhrWallet.responseText);
                                }
                            } else {
                                showToast('Failed to fetch wallet amount.', 'danger');
                            }
                        };
                        xhrWallet.onerror = function() {
                            showToast('Error fetching wallet amount.', 'danger');
                        };
                        xhrWallet.send();
                    } else {
                        showToast("Your cart is empty!", "danger");
                    }
                } catch (error) {
                    console.error("Error parsing JSON response:", error);
                    console.error("Response:", xhrCart.responseText);
                }
            } else {
                showToast("Failed to fetch cart contents.", "danger");
            }
        };
        xhrCart.onerror = function() {
            showToast("Error fetching cart contents.", "danger");
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
                        showToast(response.message, "danger");
                    }
                } catch (error) {
                    console.error("Error parsing JSON response:", error);
                    console.error("Response:", xhr.responseText);
                }
            } else {
                showToast('Failed to save transaction.', 'danger');
            }
        };
        xhr.onerror = function() {
            showToast('Error saving transaction.', 'danger');
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

    function deleteProduct(productId) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_product.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        showToast('Product deleted successfully.', 'success');
                        const productElement = document.getElementById('product-' + productId);
                        if (productElement) {
                            productElement.remove();
                        } else {
                            console.error('Element not found for product ID:', productId);
                        }
                    } else {
                        showToast('Failed to delete product: ' + response.message, 'danger');
                    }
                } catch (error) {
                    console.error('Error parsing JSON response:', error);
                }
            } else {
                showToast('Failed to delete product. Status: '+ xhr.status, "danger");
            }
        };
        xhr.onerror = function() {
            showToast('Error deleting product. Network error.', 'danger');
        };
        xhr.send(`product_id=${productId}`);
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

    function showToast(message, type) {
        const toast = document.createElement('div');
        toast.classList.add('toast', `bg-${type}`, 'text-white', 'custom-toast');
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        if (type == "danger"){
            type = "Warning";
        }
        if (type == "success"){
            type = "Success";
        }
        toast.innerHTML = 
        `
            <div class="toast-header">
                <strong class="mr-auto">${type.charAt(0).toUpperCase() + type.slice(1)}</strong>
                <button type="button" class="ml-4 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        `;
        document.getElementById('toast-container').appendChild(toast);
        $(toast).toast({ delay: 3000 });
        $(toast).toast('show');
        $(toast).on('hidden.bs.toast', function() {
            toast.remove();
        });
    }

    function addToCartHandler(event) {
        event.preventDefault();
        const quantity = document.getElementById('quantity').value;
        const productId = this.getAttribute('data-id');
        addToCart(productId, quantity);
    }

    function deleteProductHandler(event) {
        event.preventDefault();
        const productId = this.getAttribute('data-id');
        deleteProduct(productId);
    }

    function quantityBtnHandler(event) {
        productId = this.getAttribute('data-id');
        $('#quantity-modal').modal('show');
    }

    function detailsBtnHandler(event) {
        const productId = this.getAttribute('data-id');
       
        showProductDetails(productId);
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
        
        document.querySelectorAll('.admin-delete-btn').forEach(button => {
            button.removeEventListener('click', deleteProductHandler);
            button.addEventListener('click', deleteProductHandler);
        });
    }
});
