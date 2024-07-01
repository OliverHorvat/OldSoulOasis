<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "OldSoulOasis";

// Check if product_id and quantity are received from the POST request
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    // Get product_id and quantity from the POST request
    $productId = $_POST['product_id'];
    $quantityToRemove = intval($_POST['quantity']);

    try {
        // Establish database connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check the current quantity of the product in the cart
        $stmt = $conn->prepare("SELECT quantity FROM cart WHERE product_id = :product_id");
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();
        $currentQuantity = $stmt->fetchColumn();

        if ($currentQuantity !== false) {
            if ($quantityToRemove >= $currentQuantity) {
                // Remove the product from the cart if the quantity to remove is greater or equal
                $stmt = $conn->prepare("DELETE FROM cart WHERE product_id = :product_id");
            } else {
                // Update the quantity in the cart
                $newQuantity = $currentQuantity - $quantityToRemove;
                $stmt = $conn->prepare("UPDATE cart SET quantity = :quantity WHERE product_id = :product_id");
                $stmt->bindParam(':quantity', $newQuantity);
            }
            $stmt->bindParam(':product_id', $productId);
            $stmt->execute();

            // Return response indicating successful product removal
            echo json_encode(array(
                'success' => true,
                'message' => 'Product quantity updated successfully'
            ));
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => 'Product not found in cart'
            ));
        }
    } catch (PDOException $e) {
        // Return response in case of database error
        echo json_encode(array(
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ));
    }
} else {
    // Return response if product_id or quantity is not provided
    echo json_encode(array(
        'success' => false,
        'message' => 'No product_id or quantity provided'
    ));
}
?>
