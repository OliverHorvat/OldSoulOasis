<?php
session_start();

// Check if all required POST data is sent
if (isset($_POST['product_id'], $_POST['quantity'])) {
    // Check if the user is logged in
    if (isset($_SESSION['id'])) {
        $userId = $_SESSION['id']; // Get the ID of the logged-in user
    } else {
        // If the user is not logged in, return an appropriate error message
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

        // Connect to the database
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the product already exists in the user's cart
        $stmt_check = $pdo->prepare("SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id");
        $stmt_check->bindParam(':user_id', $userId);
        $stmt_check->bindParam(':product_id', $productId);
        $stmt_check->execute();

        if ($stmt_check->rowCount() > 0) {
            // If the product already exists in the cart, update the quantity
            $stmt_update = $pdo->prepare("UPDATE cart SET quantity = quantity + :quantity WHERE user_id = :user_id AND product_id = :product_id");
            $stmt_update->bindParam(':quantity', $quantity);
            $stmt_update->bindParam(':user_id', $userId);
            $stmt_update->bindParam(':product_id', $productId);
            $stmt_update->execute();
        } else {
            // If the product is not in the cart, add a new record
            $stmt_insert = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
            $stmt_insert->bindParam(':user_id', $userId);
            $stmt_insert->bindParam(':product_id', $productId);
            $stmt_insert->bindParam(':quantity', $quantity);
            $stmt_insert->execute();
        }

        // Return a successful response
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        // If there is an error connecting to the database, show an error message
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    // If not all required data is sent, return an appropriate error message
    echo json_encode(['success' => false, 'message' => 'Missing required data']);
}
?>
