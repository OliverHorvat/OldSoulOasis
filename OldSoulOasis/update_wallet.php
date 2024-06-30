<?php
// Start the session
session_start();

// Check if user ID and new amount are provided via POST request
if (isset($_SESSION['id']) && isset($_POST['new_amount'])) {
    // Get user ID and new amount from POST request
    $userId = $_SESSION['id'];
    $newAmount = $_POST['new_amount'];

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "OldSoulOasis";

    // Create a new MySQLi connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if the connection was successful
    if ($conn->connect_error) {
        // If connection fails, terminate script execution and display error message
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL statement to update user's wallet amount
    $sql = "UPDATE users SET wallet = ? WHERE id = ?";
    
    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind parameters to the SQL statement
    $stmt->bind_param("di", $newAmount, $userId);

    // Execute the SQL statement
    if ($stmt->execute()) {
        // If update is successful, return success message as JSON and terminate script
        echo json_encode(['success' => true]);
        exit;
    } else {
        // If update fails, return error message as JSON and terminate script
        echo json_encode(['success' => false, 'error' => 'Failed to update wallet amount.']);
        exit;
    }

    // Close the prepared statement
    $stmt->close();

    // Close the database connection
    $conn->close();
} else {
    // If user ID or new amount is not provided, return error message as JSON and terminate script
    echo json_encode(['success' => false, 'error' => 'User ID or new amount not provided.']);
    exit;
}
?>
