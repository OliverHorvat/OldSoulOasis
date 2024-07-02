<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "OldSoulOasis";

if (isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("DELETE FROM products WHERE id = :product_id");
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();

        $success = $stmt->rowCount() > 0;

        echo json_encode(array(
            'success' => $success,
            'message' => $success ? 'Product deleted successfully.' : 'Failed to delete product.'
        ));
    } catch (PDOException $e) {
        echo json_encode(array(
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ));
    }
    $conn = null;
} else {
    echo json_encode(array(
        'success' => false,
        'message' => 'No product_id provided'
    ));
}
?>