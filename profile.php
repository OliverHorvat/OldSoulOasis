<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Old Soul Oasis</title>
    <link rel="icon" href="images/logo.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<?php include 'header.php'; ?>
<?php
if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit();
}
?>
<div aria-live="polite" aria-atomic="true" style="position: relative; z-index: 1050;">
    <div id="toast-container" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1050;"></div>
</div>
<?php include 'fetch_user_data.php'; ?>

<main>
    <div class="container mt-4">
        <h1>User Profile</h1>
        <div class="profile-info">
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
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
                                    $products = explode(', ', $transaction['products']);
                                    $quantities = explode(', ', $transaction['quantities']);
                                    $prices = explode(', ', $transaction['prices']);
                                    ?>
                                    <?php for ($i = 0; $i < count($products); $i++): ?>
                                        <div class="column justify-content-center">
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