document.addEventListener('DOMContentLoaded', function() {
    
    updateCartBadge();

    const cartButton = document.querySelector('.cart-button');
    const cartBadge = document.querySelector('.cart-badge');
    const modal = document.querySelector('.modal');
    const modalClose = document.querySelector('.close');
    const buyButton = document.querySelector('.buy-btn');
    const cartItemsList = document.querySelector('.cart-items');
    const filter = document.querySelector('.filter');
    const wallet = document.querySelector('.wallet');
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    const items = document.querySelectorAll('.item');
    
    setupFilter();

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = button.dataset.id;
            const quantity = 1;
            addToCart(productId, quantity);
        });
    });

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
                cartBadge.textContent = totalItems;
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
                        let message = "<p>Items in your cart:</p>";
                        let totalPrice = 0;
                        cartContents.forEach(item => {
                            totalPrice += item.price * item.quantity;
                            message += `
                                <p class="item-name">${item.name}: ${item.quantity}</p>
                                <button class="remove-btn" data-id="${item.product_id}">Remove</button>
                            `;
                        });
                        message += `<p>Total price: $${totalPrice.toFixed(2)}</p>`;
                        cartItemsList.innerHTML = message;
                        buyButton.style.display = 'block';
                    } else {
                        cartItemsList.innerHTML = "<p>Cart is empty!</p>";
                        buyButton.style.display = 'none';
                    }
                    document.querySelectorAll('.remove-btn').forEach(button => {
                        button.addEventListener('click', function() {
                            const productId = this.getAttribute('data-id');
                            removeFromCart(productId);
                            removeProductFromCart(productId);
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

    function removeFromCart(productId) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'remove_from_cart.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        updateCartBadge()
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
        xhr.send(`product_id=${productId}`);
    }

    function clearCart() {
        cart = {};
        cartItemsCount = 0;
        cartBadge.textContent = 0;

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

    function clearCart() {
        cart = {};
        cartItemsCount = 0;
        cartBadge.textContent = 0;

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

                                        alert("Purchase successful!");
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

    function getWalletAmount() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_wallet_amount.php');
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.amount !== undefined) {
                        wallet.textContent = 'Wallet: $' + response.amount;
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
        wallet.textContent = `Wallet: $${amount.toFixed(2)}`;
    }

    function toggleModal() {
        modal.classList.toggle('show-modal');
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

    cartButton.addEventListener('click', function() {
        checkCart();
        toggleModal();
    });

    modalClose.addEventListener('click', toggleModal);

    buyButton.addEventListener('click', buy);

    window.addEventListener('load', getWalletAmount);
});
