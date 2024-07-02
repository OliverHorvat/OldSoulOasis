<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "oldsouloasis";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT email FROM users WHERE id = :user_id");
    $stmt->bindParam(':user_id', $_SESSION['id']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $email = $user['email'];
    } else {
        echo "User not found.";
        exit;
    }

    $stmt = $conn->prepare("
        SELECT th.transaction_id, 
               GROUP_CONCAT(pr.name SEPARATOR ', ') AS products,
               GROUP_CONCAT(th.quantity SEPARATOR ', ') AS quantities,
               GROUP_CONCAT(pr.price SEPARATOR ', ') AS prices,
               SUM(pr.price * th.quantity) AS total_price,
               th.transaction_date
        FROM transaction_history th
        INNER JOIN products_archive pr ON th.product_id = pr.id
        WHERE th.user_id = :user_id
        GROUP BY th.transaction_id
        ORDER BY th.transaction_date DESC
    ");
    $stmt->bindParam(':user_id', $_SESSION['id']);
    $stmt->execute();
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit;
}
?>