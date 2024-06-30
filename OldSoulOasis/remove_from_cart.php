<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "OldSoulOasis";

// Check if product_id is received from the POST request
if (isset($_POST['product_id'])) {
    // Get product_id from the POST request
    $productId = $_POST['product_id'];

    try {
        // Establish database connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL query to delete product from the cart
        $stmt = $conn->prepare("DELETE FROM cart WHERE product_id = :product_id");
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();

        // Return response indicating successful product removal
        echo json_encode(array(
            'success' => true,
            'message' => 'Product successfully removed from cart'
        ));
    } catch (PDOException $e) {
        // Return response in case of database error
        echo json_encode(array(
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ));
    }
} else {
    // Return response if product_id is not provided
    echo json_encode(array(
        'success' => false,
        'message' => 'No product_id provided'
    ));
}
?>
