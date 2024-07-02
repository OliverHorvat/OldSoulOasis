<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "OldSoulOasis";

if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
} else {
    echo json_encode([
        'success' => false,
        'message' => 'User is not logged in'
    ]);
    exit;
}

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT cart.product_id, products.name, products.price, cart.quantity 
                          FROM cart 
                          JOIN products ON cart.product_id = products.id 
                          WHERE cart.user_id = :user_id");
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    $cartContents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($cartContents);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>