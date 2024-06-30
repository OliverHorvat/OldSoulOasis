<?php
session_start(); // Start the session to ensure it's initiated

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "OldSoulOasis";

// Check if user ID is provided
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];

    try {
        // Establish database connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL query to delete cart items for a specific user
        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        // Return successful response
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        // Return error if there's an issue with the database
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    // Return error if user ID is not provided
    echo json_encode(['success' => false, 'error' => 'User ID not provided']);
}
?>
