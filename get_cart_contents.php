<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "OldSoulOasis";

session_start(); // Start the session to get the user_id of the current user
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id']; // Get the ID of the logged-in user
} else {
    // If the user is not logged in, display an appropriate message
    echo json_encode([
        'success' => false,
        'message' => 'User is not logged in'
    ]);
    exit; // Stop further script execution
}

try {
    // Establish database connection
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Execute SQL query to retrieve cart contents for the current user
    $stmt = $pdo->prepare("SELECT cart.product_id, products.name, products.price, cart.quantity 
                          FROM cart 
                          JOIN products ON cart.product_id = products.id 
                          WHERE cart.user_id = :user_id");
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    $cartContents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return cart contents in JSON format
    header('Content-Type: application/json');
    echo json_encode($cartContents);
} catch (PDOException $e) {
    // If there's an error with the database connection, display an error message
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>
