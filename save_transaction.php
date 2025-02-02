<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "OldSoulOasis";

if (!isset($_SESSION['id'])) {
    echo json_encode(array('success' => false, 'message' => 'User is not logged in.'));
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['cart_contents']) || !is_array($data['cart_contents'])) {
    echo json_encode(array('success' => false, 'message' => 'Invalid cart contents.'));
    exit;
}

$user_id = $_SESSION['id'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query("SELECT MAX(transaction_id) AS max_id FROM transaction_history");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $max_transaction_id = ($row['max_id'] === null) ? 0 : intval($row['max_id']);
    $next_transaction_id = $max_transaction_id + 1;

    $stmt = $conn->prepare("INSERT INTO transaction_history (transaction_id, user_id, product_id, quantity) VALUES (:transaction_id, :user_id, :product_id, :quantity)");

    foreach ($data['cart_contents'] as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $stmt->bindParam(':transaction_id', $next_transaction_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->execute();
    }
    echo json_encode(array('success' => true, 'message' => 'Transaction saved successfully.'));
} catch (PDOException $e) {
    echo json_encode(array('success' => false, 'message' => 'Database error: ' . $e->getMessage()));
}
?>