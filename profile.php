<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Custom styles specific to this page */
        .profile-info{
            font-size: 1.8rem; /* Udvostručeno */
        }
        .transaction-list {
            margin-top: 20px;
        }

        .transaction {
            background-color: rgb(246, 204, 155);
            border: 1px solid rgb(201, 146, 82);
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .transaction-date {
            font-size: 1.8rem; /* Udvostručeno */
            text-align: center; /* Centriranje teksta */
            
            margin-bottom: 10px;
        }

        .transaction-details {
            margin-bottom: 10px;
        }

        .product-name,
        .product-price {
            font-size: 1.6rem; /* Povećano */
            margin-bottom: 5px; /* Manji razmak između proizvoda i cijene */
            text-align: center; /* Centriranje teksta */
        }

        .total-price {
            font-weight: bold;
            font-size: 1.8rem; /* Udvostručeno */
            margin-top: 10px; /* Dodatni razmak između transakcija */
            text-align: center; /* Centriranje teksta */
        }

        .transaction-details ul {
            padding-left: 0;
        }

        .transaction-details li {
            list-style-type: none;
            margin-bottom: 10px; /* Razmak između stavki u listi */
            font-size: 1.4rem; /* Veličina fonta za stavke u listi */
        }

        @media (max-width: 768px) {
            .transaction {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>
<?php include 'fetch_user_data.php'; ?>

<main>
    <div class="container mt-4">
        <h1>User Profile</h1>
        <div class="profile-info">
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <!-- Dodajte dodatne informacije o korisniku ako su dostupne -->
        </div>
    </div>

    <div class="container mt-4">
            <div class="transactions">
                <h1>Transaction History</h1>
                <div class="transaction-list">
                    <?php if ($transactions && count($transactions) > 0): ?>
                        <?php foreach ($transactions as $transaction): ?>
                            <div class="transaction">
                                <p class="transaction-date">Transaction date: <?php echo date('Y-m-d H:i:s', strtotime($transaction['transaction_date'])); ?></p>
                                <div class="transaction-details">
                                    <?php
                                    // Razdvajamo produkte, količine i cijene u nizove
                                    $products = explode(', ', $transaction['products']);
                                    $quantities = explode(', ', $transaction['quantities']);
                                    $prices = explode(', ', $transaction['prices']);
                                    ?>
                                    <?php for ($i = 0; $i < count($products); $i++): ?>
                                        <div class="column justify-content-center"> <!-- Centriranje sadržaja -->
                                            <div>
                                                <p class="product-name"><strong><?php echo $quantities[$i]; ?>x <?php echo $products[$i]; ?></strong></p>
                                            </div>
                                            <div>
                                                <p class="product-price">$<?php echo $prices[$i]; ?></p>
                                            </div>
                                        </div>
                                    <?php endfor; ?>
                                    <p class="total-price">Total price: $<?php echo $transaction['total_price']; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No transactions found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</main>

<?php include 'footer.php'; ?>
<?php include 'modals.php'; ?>
<?php include 'scripts.php'; ?>

</body>
</html>
