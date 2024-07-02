<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "OldSoulOasis";

// Check if product_id is received from the POST request
if (isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];

    try {
        // Establish database connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL statement
        $stmt = $conn->prepare("DELETE FROM products WHERE id = :product_id");
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();

        // Check if the delete operation was successful
        $success = $stmt->rowCount() > 0;

        // Return response indicating success or failure
        echo json_encode(array(
            'success' => $success,
            'message' => $success ? 'Product deleted successfully.' : 'Failed to delete product.'
        ));
    } catch (PDOException $e) {
        // Return response in case of database error
        echo json_encode(array(
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ));
    }

    // Close database connection
    $conn = null;
} else {
    // Return response if product_id is not provided
    echo json_encode(array(
        'success' => false,
        'message' => 'No product_id provided'
    ));
}
?>
