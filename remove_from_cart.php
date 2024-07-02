<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "OldSoulOasis";

if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $productId = $_POST['product_id'];
    $quantityToRemove = intval($_POST['quantity']);

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT quantity FROM cart WHERE product_id = :product_id");
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();
        $currentQuantity = $stmt->fetchColumn();

        if ($currentQuantity !== false) {
            if ($quantityToRemove >= $currentQuantity) {
                $stmt = $conn->prepare("DELETE FROM cart WHERE product_id = :product_id");
            } else {
                $newQuantity = $currentQuantity - $quantityToRemove;
                $stmt = $conn->prepare("UPDATE cart SET quantity = :quantity WHERE product_id = :product_id");
                $stmt->bindParam(':quantity', $newQuantity);
            }
            $stmt->bindParam(':product_id', $productId);
            $stmt->execute();

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
        echo json_encode(array(
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ));
    }
} else {
    echo json_encode(array(
        'success' => false,
        'message' => 'No product_id or quantity provided'
    ));
}
?>