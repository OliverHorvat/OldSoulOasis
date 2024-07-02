<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "OldSoulOasis";

if (isset($_POST['product_id'], $_POST['quantity'])) {
    if (isset($_SESSION['id'])) {
        $userId = $_SESSION['id'];
    } else {
        echo json_encode(['success' => false, 'message' => 'User is not logged in']);
        exit;
    }

    try {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "OldSoulOasis";

        $productId = $_POST['product_id'];
        $quantity = $_POST['quantity'];

        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt_check = $pdo->prepare("SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id");
        $stmt_check->bindParam(':user_id', $userId);
        $stmt_check->bindParam(':product_id', $productId);
        $stmt_check->execute();

        if ($stmt_check->rowCount() > 0) {
            $stmt_update = $pdo->prepare("UPDATE cart SET quantity = quantity + :quantity WHERE user_id = :user_id AND product_id = :product_id");
            $stmt_update->bindParam(':quantity', $quantity);
            $stmt_update->bindParam(':user_id', $userId);
            $stmt_update->bindParam(':product_id', $productId);
            $stmt_update->execute();
        } else {
            $stmt_insert = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
            $stmt_insert->bindParam(':user_id', $userId);
            $stmt_insert->bindParam(':product_id', $productId);
            $stmt_insert->bindParam(':quantity', $quantity);
            $stmt_insert->execute();
        }

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing required data']);
}
?>