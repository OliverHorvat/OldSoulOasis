<?php
// Start session
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "OldSoulOasis";

// Check if user ID is received
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id']; // Get the user ID

    try {
        // Establish database connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL query to retrieve wallet amount for the specified user
        $stmt = $conn->prepare("SELECT wallet FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->execute();

        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $walletAmount = $result['wallet'];

        // Return wallet amount in JSON format
        echo json_encode(['amount' => $walletAmount]);
    } catch (PDOException $e) {
        // Return error if there's an issue with the database
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    // Return error if the user ID is not provided
    echo json_encode(['error' => 'User ID not provided']);
}
?>
